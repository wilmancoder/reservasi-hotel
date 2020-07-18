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
use app\models\MShift;

class UsersettingController extends \yii\web\Controller
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

    public function actionCreate($action)
    {
        $model = new Users();
        if ($model->load(Yii::$app->request->post())) {
            $model->username = $_POST['Users']['username'];
            $model->nama = $_POST['Users']['nama'];
            $model->email = $_POST['Users']['email'];
            $model->role = $_POST['Users']['role'];
            // $model->id_shift = $_POST['Users']['id_shift'];
            $model->password = sha1($_POST['Users']['password']);
            $model->created_at = date('Y-m-d H:i:s');
            if ($model->save()) {
                $hasil = array(
                    'status' => "success",
                    'header' => "Berhasil",
                    'message' => "Setting User Berhasil Di input !",
                );
                echo json_encode($hasil);
                die();
            }
        }
        $modelShift=MShift::find()->all();
        $listShift=ArrayHelper::map($modelShift,'id','nm_shift');

        return $this->renderPartial('create', [
            'model' => $model,
            'listShift' => $listShift,
            'action' => $action
        ]);
    }

    public function actionUpdate($id,$action)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post())) {
            $passForm = isset($_POST['Users']['password']) ? $_POST['Users']['password'] : "";

            $model->username = $_POST['Users']['username'];
            $model->nama = $_POST['Users']['nama'];
            $model->email = $_POST['Users']['email'];
            $model->role = $_POST['Users']['role'];
            if($passForm){
                $passForm = $_POST['Users']['password'];
                $model->password = sha1($passForm);
            }
            // $model->id_shift = $_POST['Users']['id_shift'];

            // $model->password = sha1($_POST['Users']['password']);
            $model->updated_at = date('Y-m-d H:i:s');
            if ($model->save()) {
                $hasil = array(
                    'status' => "success",
                    'header' => "Berhasil",
                    'message' => "Setting User Berhasil Di Update !",
                );
                echo json_encode($hasil);
                die();
            }
        }
        $modelShift=MShift::find()->all();
        $listShift=ArrayHelper::map($modelShift,'id','nm_shift');

        return $this->renderPartial('update', [
            'model' => $model,
            'id' => $id,
            'listShift' => $listShift,
            'action' => $action
        ]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        $hasil = array(
            'status' => "success",
            'header' => "Berhasil",
            'message' => "Setting User Berhasil Di Hapus !",
        );
        echo json_encode($hasil);
        die();
        // return $this->redirect(['adm/artikel']);
    }

    public function actionGetdatausersetting()
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $model = Logic::mappingUser();

        // var_dump($model);exit;
        $row = array();
        $i = 0;
        // $no = 1;
        foreach ($model as $idx => $value) {
            //Asiign All Value To Row
            foreach ($value as $key => $val) {
                $row[$i][$key] = $val;
            }

            $row[$i]['username'] = $value['username'];
            $row[$i]['nama'] = $value['nama'];
            $row[$i]['email'] = $value['email'];
            $row[$i]['role'] = $value['role'];
            // $row[$i]['nm_shift'] = $value['nm_shift'];
            $row[$i]['updated_at'] = $value['updated_at'];

            $row[$i]['fungsi'] = "
            <button onclick='updateusersetting(\"" . $value['id'] . "\",\"update\")' type='button' rel='tooltip' data-toggle='tooltip' title='Edit User' class='btn btn-sm btn-warning btn-flat'><i class='fa fa-edit'></i></button>
            <button onclick='deleteusersetting(\"" . $value['id'] . "\")' type='button' rel='tooltip' data-toggle='tooltip' title='Hapus User' class='btn btn-sm btn-danger btn-flat'><i class='fa fa-trash'></i></button>
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
        if (($model = Users::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
