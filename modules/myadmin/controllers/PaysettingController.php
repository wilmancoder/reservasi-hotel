<?php

namespace app\modules\myadmin\controllers;

use Yii;
use app\models\Users;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use app\components\Logic;
use yii\helpers\ArrayHelper;
use app\models\MMappingPembayaran;
use app\models\MMetodePembayaran;
use app\models\MjenisPembayaran;

class PaysettingController extends \yii\web\Controller
{
    public $user = null;
    public $notLogin = false;

    public function init()
    {
        if (is_null(Yii::$app->user->identity))
            $this->notLogin = true;
        else
            $this->user = Users::findOne(['username' => Yii::$app->user->identity->username]);
    }

    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }

        if ($this->notLogin) {
            $this->redirect(['/site/login']);
            return false;
        }

        return true;
    }

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['GET'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionCreate()
    {
        $model = new MMappingPembayaran();
        if ($model->load(Yii::$app->request->post())) {
            $model->id_metode_pembayaran = $_POST['MMappingPembayaran']['id_metode_pembayaran'];
            $model->id_jenis_pembayaran = $_POST['MMappingPembayaran']['id_jenis_pembayaran'];
            $model->created_date = date('Y-m-d H:i:s');
            $model->created_by = Yii::$app->user->identity->nama;
            if ($model->save()) {
                $hasil = array(
                    'status' => "success",
                    'header' => "Berhasil",
                    'message' => "Setting Pembayaran Berhasil Di input !",
                );
                echo json_encode($hasil);
                die();
            }
        }
        $metode=MMetodePembayaran::find()->all();
        $listDatametode=ArrayHelper::map($metode,'id','metode');
        $jenis=MJenisPembayaran::find()->all();
        $listDatajenis=ArrayHelper::map($jenis,'id','jenis');
        return $this->renderPartial('create', [
            'model' => $model,
            'listDatametode' => $listDatametode,
            'listDatajenis' => $listDatajenis
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post())) {
            $model->id_metode_pembayaran = $_POST['MMappingPembayaran']['id_metode_pembayaran'];
            $model->id_jenis_pembayaran = $_POST['MMappingPembayaran']['id_jenis_pembayaran'];
            $model->created_date = date('Y-m-d H:i:s');
            $model->created_by = Yii::$app->user->identity->nama;
            if ($model->save()) {
                $hasil = array(
                    'status' => "success",
                    'header' => "Berhasil",
                    'message' => "Setting Pembayaran Berhasil Di Update !",
                );
                echo json_encode($hasil);
                die();
            }
        }
        $metode=MMetodePembayaran::find()->all();
        $listDatametode=ArrayHelper::map($metode,'id','metode');
        $jenis=MJenisPembayaran::find()->all();
        $listDatajenis=ArrayHelper::map($jenis,'id','jenis');
        return $this->renderPartial('update', [
            'model' => $model,
            'id' => $id,
            'listDatametode' => $listDatametode,
            'listDatajenis' => $listDatajenis
        ]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        $hasil = array(
            'status' => "success",
            'header' => "Berhasil",
            'message' => "Setting Pembayaran Berhasil Di Hapus !",
        );
        echo json_encode($hasil);
        die();
        // return $this->redirect(['adm/artikel']);
    }

    public function actionGetdatapaysetting()
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $model = Logic::mappingPay();

        // var_dump($model);exit;
        $row = array();
        $i = 0;
        // $no = 1;
        foreach ($model as $idx => $value) {
            //Asiign All Value To Row
            foreach ($value as $key => $val) {
                $row[$i][$key] = $val;
            }

            $row[$i]['metodepembayaran'] = $value['metode'];
            $row[$i]['jenispembayaran'] = $value['jenis'];
            $row[$i]['created_date'] = $value['created_date'];
            $row[$i]['created_by'] = $value['created_by'];

            $row[$i]['fungsi'] = "
            <button onclick='updatepaysetting(\"" . $value['id'] . "\")' type='button' rel='tooltip' data-toggle='tooltip' title='Edit Pembayaran' class='btn btn-sm btn-warning btn-flat'><i class='fa fa-edit'></i></button>
            <button onclick='deletepaysetting(\"" . $value['id'] . "\")' type='button' rel='tooltip' data-toggle='tooltip' title='Hapus Pembayaran' class='btn btn-sm btn-danger btn-flat'><i class='fa fa-trash'></i></button>
            ";

            $i++;
            // $no++;
        }
        $hasil['data'] = $row;
            // var_dump($hasil);exit();
        return $hasil;
    }

    protected function findModel($id)
    {
        if (($model = MMappingPembayaran::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
