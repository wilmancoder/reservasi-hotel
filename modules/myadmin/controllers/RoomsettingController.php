<?php

namespace app\modules\myadmin\controllers;

use Yii;
use app\models\Users;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use app\components\Logic;
use app\models\MMappingKamar;

class RoomsettingController extends \yii\web\Controller
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
        $model = new MMappingKamar();
        $typekamar = $model->typeKamar;
        $kategoriharga = $model->kategoriHarga;
        $mappingharga = $model->mappingHarga;
        if ($model->load(Yii::$app->request->post())) {
            $model->nomor_kamar = $_POST['MMappingKamar']['nomor_kamar'];
            $model->id_mapping_harga = $_POST['MMappingKamar']['id_mapping_harga'];
            $model->status = 'tersedia';
            $model->created_date = date('Y-m-d H:i:s');
            $model->created_by = Yii::$app->user->identity->nama;
            if ($model->save()) {
                $hasil = array(
                    'status' => "success",
                    'header' => "Berhasil",
                    'message' => "Setting Kamar Berhasil Di input !",
                );
                echo json_encode($hasil);
                die();
            }
        }

        return $this->renderPartial('create', [
            'model' => $model,
            'mode' => 'create'
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $typekamar = $model->typeKamar;
        $kategoriharga = $model->kategoriHarga;
        $mappingharga = $model->mappingHarga;

        if ($model->load(Yii::$app->request->post())) {
            $model->nomor_kamar = $_POST['MMappingKamar']['nomor_kamar'];
            $model->id_mapping_harga = $_POST['MMappingKamar']['id_mapping_harga'];
            $model->created_date = date('Y-m-d H:i:s');
            $model->created_by = Yii::$app->user->identity->nama;
            if ($model->save()) {
                $hasil = array(
                    'status' => "success",
                    'header' => "Berhasil",
                    'message' => "Setting Kamar Berhasil Di Update !",
                );
                echo json_encode($hasil);
                die();
            }
        }

        return $this->renderPartial('update', [
            'model' => $model,
            'mode' => 'update',
            'typekamar' => $typekamar,
            'kategoriharga' => $kategoriharga,
            'mappingharga' => $mappingharga,
            'id' => $id
        ]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        $hasil = array(
            'status' => "success",
            'header' => "Berhasil",
            'message' => "Setting Kamar Berhasil Di Hapus !",
        );
        echo json_encode($hasil);
        die();
        // return $this->redirect(['adm/artikel']);
    }

    public function actionGetdataroomsetting()
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $model = Logic::mappingKamar();

        // var_dump($model);exit;
        $row = array();
        $i = 0;
        $no = 1;
        foreach ($model as $idx => $value) {
            //Asiign All Value To Row
            foreach ($value as $key => $val) {
                $row[$i][$key] = $val;
            }

            $row[$i]['nomorkamar'] = "Kamar Nomor " .$value['nomor_kamar'];
            $row[$i]['type'] = $value['type'];
            $row[$i]['kategoriharga'] = $value['kategori_harga'];
            $row[$i]['harga'] = "Rp. " . \app\components\Logic::formatNumber($value['harga'], 0);
            $row[$i]['created_date'] = $value['created_date'];
            $row[$i]['created_by'] = $value['created_by'];

            $row[$i]['fungsi'] = "
            <button onclick='updateroomsetting(\"" . $value['id'] . "\")' type='button' rel='tooltip' data-toggle='tooltip' title='Edit Room' class='btn btn-sm btn-warning btn-flat'><i class='fa fa-edit'></i></button>
            <button onclick='deleteroomsetting(\"" . $value['id'] . "\")' type='button' rel='tooltip' data-toggle='tooltip' title='Hapus Room' class='btn btn-sm btn-danger btn-flat'><i class='fa fa-trash'></i></button>
            ";

            $i++;
            $no++;
        }
        $hasil['data'] = $row;
            // var_dump($hasil);exit();
        return $hasil;
    }

    public function actionCeksettingharga($mode)
    {
        return $this->renderPartial('_modal_setting_harga', [
            'mode' => $mode
        ]);
    }

    public function actionGetceksettingharga()
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $model = (new \yii\db\Query())
            ->select(['a.id', 'a.id_type', 'a.id_kategori_harga', 'a.harga', 'b.type', 'c.kategori_harga'])
            ->from('m_mapping_harga a')
            ->join('INNER JOIN', 'm_type b', 'b.id = a.id_type')
            ->join('INNER JOIN', 'm_kategori_harga c', 'c.id = a.id_kategori_harga')
            ->orderBy(['a.id' => SORT_ASC])
            ->all();

        // var_dump($model);exit;
        $row = array();
        $i = 0;
        // $no = 1;
        foreach ($model as $idx => $value) {
            //Asiign All Value To Row
            foreach ($value as $key => $val) {
                $row[$i][$key] = $val;
            }
            $row[$i]['type'] = $value['type'];
            $row[$i]['kategoriharga'] = $value['kategori_harga'];
            $row[$i]['harga'] = $value['harga'];

            $row[$i]['fungsi'] = "
            <input type='radio' name='nmradio' class='radioid' onclick='terpilih(".$value['id'].")'>
            ";

            // $row[$i]['fungsi'] = "
            // <button onclick='updatekontrak(\"" . $value['id'] . "\")' type='button' rel='tooltip' data-toggle='tooltip' title='Edit Kontrak' class='btn btn-sm btn-warning btn-flat'><i class='fa fa-edit'></i></button>
            // <button onclick='deletekontrak(\"" . $value['id'] . "\")' type='button' rel='tooltip' data-toggle='tooltip' title='Hapus Kontrak' class='btn btn-sm btn-danger btn-flat'><i class='fa fa-trash'></i></button>
            // ";

            $i++;
            // $no++;
        }
        $hasil['data'] = $row;
            // var_dump($hasil);exit();
        return $hasil;
    }

    public function actionGetpropsettingharga($id,$mode)
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $cek_settingharga = (new \yii\db\Query())
            ->select(['a.id', 'a.id_type', 'a.id_kategori_harga', 'a.harga', 'b.type', 'c.kategori_harga'])
            ->from('m_mapping_harga a')
            ->join('INNER JOIN', 'm_type b', 'b.id = a.id_type')
            ->join('INNER JOIN', 'm_kategori_harga c', 'c.id = a.id_kategori_harga')
            ->where(['a.id' => $id])
            ->orderBy(['a.id' => SORT_ASC])
            ->one();
        $hasil = array(
            'id' => $cek_settingharga['id'],
            'kategoriharga' => $cek_settingharga['kategori_harga'],
            'type' => $cek_settingharga['type'],
            'harga' => $cek_settingharga['harga'],
            'mode' => $mode
        );
        echo json_encode($hasil);
        die();
    }

    protected function findModel($id)
    {
        if (($model = MMappingKamar::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
