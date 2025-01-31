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
use app\models\MShift;
use yii\helpers\ArrayHelper;

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
        $rolebase = \Yii::$app->user->identity->role;
        if($rolebase == 1) {
            return $this->redirect(['site/chooseprice']);
        } else {
            return $this->redirect(['/myadmin/report/indexall']);
        }
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
        $idpetugas = \Yii::$app->user->identity->id_petugas;

        \Yii::$app->response->format = Response::FORMAT_JSON;
        if (Yii::$app->request->get()){
            $modelPetugas = $this->findModelLogout($idpetugas);
            $modelPetugas->id_kategori_harga = $idharga;
            if($modelPetugas->save(false)) {

                $hasil = [
                    'status' => "success",
                    'header' => "Berhasil",
                    'message' => "Harga Berhasil Di Setting !",
                    'idharga' => $modelPetugas->id_kategori_harga
                ];
                echo json_encode($hasil);
                die();
            }

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
            $post = Yii::$app->request->post();
            $modelPetugas = new TPetugas();
            $modelPetugas->id_user = Yii::$app->user->identity->id_user;
            $modelPetugas->id_shift = $post['LoginForm']['id_shift'];
            $modelPetugas->sign_in = date('Y-m-d H:i:s');
            if($modelPetugas->save(false)) {

                return $this->redirect(['site/index']);
            }
        }

        $modelShift=MShift::find()->all();
        $listShift=ArrayHelper::map($modelShift,'id','nm_shift');


        return $this->render('login', [
             'model' => $model,
             'listShift' => $listShift
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
