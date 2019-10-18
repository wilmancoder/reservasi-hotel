<?php

namespace app\modules\myadmin\controllers;

use Yii;
use app\models\Users;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\helpers\ArrayHelper;
use app\components\Logic;
use app\models\MMappingHarga;
use app\models\MKategoriHarga;
use app\models\MType;

class PricesettingController extends \yii\web\Controller
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
        $model = new MMappingHarga();
        if ($model->load(Yii::$app->request->post())) {
            $harga = $_POST['MMappingHarga']['harga'];
            $model->id_type = $_POST['MMappingHarga']['id_type'];
            $model->id_kategori_harga = $_POST['MMappingHarga']['id_kategori_harga'];
            $model->harga = Logic::removeKoma($harga);

            $model->created_date = date('Y-m-d H:i:s');
            $model->created_by = Yii::$app->user->identity->nama;
            if ($model->save()) {
                $hasil = array(
                    'status' => "success",
                    'header' => "Berhasil",
                    'message' => "Setting Harga Berhasil Di input !",
                );
                echo json_encode($hasil);
                die();
            }
        }
        $kategoriharga=MKategoriHarga::find()->all();
        $listDataharga=ArrayHelper::map($kategoriharga,'id','kategori_harga');
        $typekamar=MType::find()->all();
        $listDatatype=ArrayHelper::map($typekamar,'id','type');
        return $this->renderPartial('create', [
            'model' => $model,
            'listDataharga' => $listDataharga,
            'listDatatype' => $listDatatype
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post())) {
            $model->id_type = $_POST['MMappingHarga']['id_type'];
            $model->id_kategori_harga = $_POST['MMappingHarga']['id_kategori_harga'];
            $model->created_date = date('Y-m-d H:i:s');
            $model->created_by = Yii::$app->user->identity->nama;
            if ($model->save()) {
                $hasil = array(
                    'status' => "success",
                    'header' => "Berhasil",
                    'message' => "Kategori Harga Berhasil Di Update !",
                );
                echo json_encode($hasil);
                die();
            }
        }
        $kategoriharga=MKategoriHarga::find()->all();
        $listDataharga=ArrayHelper::map($kategoriharga,'id','kategori_harga');
        $typekamar=MType::find()->all();
        $listDatatype=ArrayHelper::map($typekamar,'id','type');
        return $this->renderPartial('update', [
            'model' => $model,
            'id' => $id,
            'listDataharga' => $listDataharga,
            'listDatatype' => $listDatatype
        ]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        $hasil = array(
            'status' => "success",
            'header' => "Berhasil",
            'message' => "Kategori Harga Berhasil Di Hapus !",
        );
        echo json_encode($hasil);
        die();
        // return $this->redirect(['adm/artikel']);
    }

    public function actionGetdatapricesetting()
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $model = Logic::mappingPrice();

        // var_dump($model);exit;
        $row = array();
        $i = 0;
        // $no = 1;
        foreach ($model as $idx => $value) {
            //Asiign All Value To Row
            foreach ($value as $key => $val) {
                $row[$i][$key] = $val;
            }

            $row[$i]['kategoriharga'] = $value['kategori_harga'];
            $row[$i]['type'] = $value['type'];
            $row[$i]['harga'] = "Rp. " . \app\components\Logic::formatNumber($value['harga'], 0);
            $row[$i]['created_date'] = $value['created_date'];
            $row[$i]['created_by'] = $value['created_by'];

            $row[$i]['fungsi'] = "
            <button onclick='updatepricesetting(\"" . $value['id'] . "\")' type='button' rel='tooltip' data-toggle='tooltip' title='Edit Room' class='btn btn-sm btn-warning btn-flat'><i class='fa fa-edit'></i></button>
            <button onclick='deletepricesetting(\"" . $value['id'] . "\")' type='button' rel='tooltip' data-toggle='tooltip' title='Hapus Room' class='btn btn-sm btn-danger btn-flat'><i class='fa fa-trash'></i></button>
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
        if (($model = MMappingHarga::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
