<?php

namespace app\modules\myadmin\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use app\models\Users;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use app\components\Logic;
use app\models\TPetugas;
use app\models\MShift;
use app\models\TPengeluaranPetugas;
use app\models\SummaryTtamu;

class ReportController extends \yii\web\Controller
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
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $sumSummarytamu = 0;
        $petugas = Yii::$app->user->identity->id_petugas;
        $idshift = Yii::$app->user->identity->id_shift;
        $iduser = Yii::$app->user->identity->id_user;
        $modelShift = MShift::find()->where(['id'=>$idshift])->asArray()->one();
        $Summarytamupendapatan = Logic::grandtotalPendapatan($petugas);
        $Summarytamupengeluaran = Logic::grandtotalPengeluaran($petugas);
        $resultGrandtotal = $Summarytamupendapatan - $Summarytamupengeluaran;
        $namapetugas = TPetugas::find()->where(['id_user' => $iduser])->orderBy(['id' => SORT_DESC])->asArray()->one();
        $user = Users::find()->where(['id' => $namapetugas['id_user']])->asArray()->one();
        // var_dump($user['nama']);exit;
        return $this->render('index', [
            'idpetugas' => $petugas,
            'modelShift' => $modelShift,
            'Summarytamupendapatan' => $Summarytamupendapatan,
            'Summarytamupengeluaran' => $Summarytamupengeluaran,
            'resultGrandtotal' => $resultGrandtotal,
            'user' => $user
        ]);
    }

    public function actionGetdatapendapatan($idpetugas) {
        // var_dump($idpetugas);exit;
        if(Yii::$app->request->isAjax)
        {
            \Yii::$app->response->format = Response::FORMAT_JSON;
            $data = \app\components\Logic::reportFo($idpetugas);
            $row = array();
            $i = 0;
            $no = 1;
            foreach ($data as $idx => $value) {
                //Asiign All Value To Row
                foreach ($value as $key => $val) {
                    $row[$i][$key] = $val;
                }
                $row[$i]['no'] = $no++;
                $row[$i]['type'] = $value['type'];
                $row[$i]['jenis_pembayaran'] = $value['jenis_pembayaran'];
                $row[$i]['metode_pembayaran'] = $value['metode_pembayaran'];
                $row[$i]['no_kartu_debit'] = $value['no_kartu_debit'];
                $row[$i]['subtotal'] = \app\components\Logic::formatNumber($value['subtotal'], 0);

                $row[$i]['fungsi'] = "
                <button onclick='detail(\"" . $value['id_transaksi_tamu'] . "\")' type='button' rel='tooltip' data-toggle='tooltip' title='Detail Subtotal' class='btn btn-sm btn-primary'><i class='fa fa-list'></i></button>
                ";

                $i++;
                // $no++;
            }
            $hasil['data'] = $row;
                // var_dump($hasil);exit();
            return $hasil;
        }
    }

    public function actionGetdatapengeluaran($idpetugas) {
        // var_dump($idpetugas);exit;
        if(Yii::$app->request->isAjax)
        {
            \Yii::$app->response->format = Response::FORMAT_JSON;
            $data = TPengeluaranPetugas::find()->where(['id_petugas' => $idpetugas])->asArray()->all();
            $row = array();
            $i = 0;
            $no = 1;
            foreach ($data as $idx => $value) {
                //Asiign All Value To Row
                foreach ($value as $key => $val) {
                    $row[$i][$key] = $val;
                }
                $row[$i]['no'] = $no++;
                $row[$i]['item'] = $value['item'];
                $row[$i]['qty'] = $value['qty'];
                $row[$i]['harga_per_item'] = \app\components\Logic::formatNumber($value['harga_per_item'], 0);
                $row[$i]['total_harga_item'] = \app\components\Logic::formatNumber($value['total_harga_item'], 0);

                $i++;
                // $no++;
            }
            $hasil['data'] = $row;
                // var_dump($hasil);exit();
            return $hasil;
        }
    }

    public function actionDetsubtotal($idtranstamu) {
        return $this->renderPartial('detailsubtotal', [
        'idtranstamu' => $idtranstamu
        ]);
    }
    public function actionCreatepengeluaran($idpetugas) {
        $transaction = Yii::$app->db->beginTransaction();
        $model = new TPengeluaranPetugas();
            try {

                if ($model->load(Yii::$app->request->post())) {
                    $post = $_POST['TPengeluaranPetugas'];

                    for($i=0; $i<count($post['item']); $i++)
					{
                        $qty = $post['qty'][$i];
                        $hargaperitem = $post['harga_per_item'][$i];
                        $conv_hargaitem = Logic::removeKoma($hargaperitem);
                        $total = $qty * $conv_hargaitem;
                        $conv_total = Logic::removeKoma($total);

                        $modelPengeluaran = new TPengeluaranPetugas();
                        $modelPengeluaran->id_petugas = $idpetugas;
                        $modelPengeluaran->item = $post['item'][$i];
                        $modelPengeluaran->qty = $qty;
                        $modelPengeluaran->harga_per_item = $conv_hargaitem;
                        $modelPengeluaran->total_harga_item = $conv_total;

                        if($modelPengeluaran->save(false)) {
                            $hasil = array(
                                'status' => "success",
                                'header' => "Berhasil",
                                'message' => "Pengeluaran Berhasil Ditambahkan !",
                            );
                        }
                    }
                    echo json_encode($hasil);
                    die();
                }

            $transaction->commit();
            } catch (Exception $e) {
                $transaction->rollBack();
                echo 'Message: ' . $e->getMessage();
            }
        return $this->renderPartial('_formpengeluaran', [
        'model' => $model,
        'idpetugas' => $idpetugas
        ]);
    }

    public function actionGeneratedetailsubtotal($idtranstamu) {
        if(Yii::$app->request->isAjax)
        {
            \Yii::$app->response->format = Response::FORMAT_JSON;
            $data = \app\components\Logic::detailreportFo($idtranstamu);
            // var_dump($data);exit;
            $row = array();
            $i = 0;
            foreach ($data as $idx => $value) {
                //Asiign All Value To Row
                foreach ($value as $key => $val) {
                    $row[$i][$key] = $val;
                }
                $row[$i]['checkin'] = $value['checkin'];
                $row[$i]['checkout'] = $value['checkout'];
                $row[$i]['durasi'] = $value['durasi'];
                $row[$i]['type'] = $value['type'];
                $row[$i]['harga_kamar'] = \app\components\Logic::formatNumber($value['harga_kamar'], 0);
                $row[$i]['biaya_sewa_perkamar'] = \app\components\Logic::formatNumber($value['biaya_sewa_perkamar'], 0);;


                $i++;
            }
            $hasil['data'] = $row;
            return $hasil;
        }
    }
}
