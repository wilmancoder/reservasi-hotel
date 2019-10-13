<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\TPetugas;
use app\models\MKategoriHarga;
use app\models\MMappingHarga;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            // 'verbs' => [
            //     'class' => VerbFilter::className(),
            //     'actions' => [
            //         'logout' => ['post'],
            //     ],
            // ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
     public function actionIndex()
     {
         if (Yii::$app->user->isGuest)
             return $this->redirect(['site/login']);

         return $this->redirect(['site/chooseprice']);
     }

    public function actionHome()
    {
        // var_dump($idharga);exit;
        return $this->redirect('../myadmin/rooms');
    }

    public function actionChooseprice()
    {
        $model = MKategoriHarga::find()
           ->where(['<>','id',3])
           ->asArray()
           ->all();

        return $this->render('chooseprice', [
            'model' => $model
        ]);
        // return $this->render('chooseprice');
    }

    public function actionGetchooseprice()
    {
        $model = MKategoriHarga::find()
           ->where(['<>','id',3])
           ->asArray()
           ->all();

        return $this->renderPartial('_formchooseprice', [
            'model' => $model
        ]);
    }

    public function actionGetsetharga($idharga)
    {
        // var_dump($idharga);exit;
        \Yii::$app->response->format = Response::FORMAT_JSON;
        if (Yii::$app->request->get()){
            // $getharga = MMappingHarga::find()->where(['id_kategori_harga' => $idharga])->asArray()->one();
            // $res_getharga = $getharga['id'];
            // var_dump($getharga['id']);exit;
            $hasil = [
                'status' => "success",
                'header' => "Berhasil",
                'message' => "Harga Berhasil Di Setting !",
                'idharga' => $idharga
            ];
            echo json_encode($hasil);
            die();
        }
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
     public function actionLogin()
     {
         $this->layout = 'login';

         if (!Yii::$app->user->isGuest)
             return $this->goHome();

         $model = new LoginForm();

         if ($model->load(Yii::$app->request->post()) && $model->login()) {

            $modelPetugas = new TPetugas();
            $modelPetugas->id_user = Yii::$app->user->identity->id_user;
            $modelPetugas->sign_in = date('Y-m-d H:i:s');
            if($modelPetugas->save(false)) {

                return $this->redirect(['site/index']);
            }
        }


        return $this->render('login', [
             'model' => $model,
        ]);
     }

    /**
     * Logout action.
     *
     * @return Response
     */
     public function actionLogout()
     {
        $idpetugas = Yii::$app->user->identity->id_petugas;
        Yii::$app->user->logout();
        $modelPetugas = $this->findModelLogout($idpetugas);
        $modelPetugas->sign_out = date('Y-m-d H:i:s');
        if($modelPetugas->save(false)) {
             return $this->goHome();
        }
     }

    protected function findModelLogout($idpetugas)
    {
        if (($model = TPetugas::findOne($idpetugas)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
