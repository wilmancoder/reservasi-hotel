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
use app\models\TBooking;
use app\models\BiodataTamuBooking;
use app\models\MMappingKamar;
use app\models\MMetodePembayaran;
use app\models\MJenisPembayaran;
use app\models\MMappingPembayaran;
use app\models\SummaryBooking;

class BookingController extends \yii\web\Controller
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
        $petugas = Yii::$app->user->identity->id_petugas;
        return $this->render('index', [
            'idpetugas' => $petugas
        ]);
    }

    public function actionGetdatabooking($idpetugas) {
        // var_dump($idpetugas);exit;
        if(Yii::$app->request->isAjax)
        {
            \Yii::$app->response->format = Response::FORMAT_JSON;
            $data = \app\components\Logic::reportBooking($idpetugas);
            $row = array();
            $i = 0;
            $no = 1;
            foreach ($data as $idx => $value) {
                //Asiign All Value To Row
                foreach ($value as $key => $val) {
                    $row[$i][$key] = $val;
                }
                $row[$i]['no'] = $no++;
                $row[$i]['namatamu'] = $value['namatamu'];
                $row[$i]['identitas'] = $value['identitas']."/".$value['nomor_identitas'];
                $row[$i]['nomor_kontak'] = $value['nomor_kontak'];
                $row[$i]['created_date'] = $value['created_date'];
                $row[$i]['created_by'] = $value['created_by'];
                $row[$i]['subtotal'] = \app\components\Logic::formatNumber($value['subtotal'], 0);

                $row[$i]['fungsi'] = "
                <button onclick='detailBooking(\"" . $value['id_transaksi_tamu'] . "\")' type='button' rel='tooltip' data-toggle='tooltip' title='Detail Subtotal' class='btn btn-sm btn-primary'><i class='fa fa-list'></i></button>
                ";

                $i++;
                // $no++;
            }
            $hasil['data'] = $row;
                // var_dump($hasil);exit();
            return $hasil;
        }
    }

    public function actionCreate() {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            // $harga = (new \yii\db\Query())
            //     ->select(['a.id', 'a.nomor_kamar', 'a.status', 'b.harga'])
            //     ->from('m_mapping_kamar a')
            //     ->join('INNER JOIN', 'm_mapping_harga b', 'b.id=a.id_mapping_harga')
            //     ->one();
            // $ambilharga = $harga['harga'];
            // $nomorkamar = $harga['nomor_kamar'];
            $model = new TBooking();
            $model2 = new SummaryBooking();
            if ($model->load(Yii::$app->request->post())) {
                $postkamar = $_POST['kamarterpilih'];
                $expPostkamar = explode(",",$postkamar);

                $postharga = $_POST['hargaterpilih'];
                $expPostharga = explode(",",$postharga);


                // echo"<pre>";
                // print_r($expPostkamar);exit;
                $jenisPembayaran = $_POST['TBooking']['radio'];
                if($jenisPembayaran == "belumbayar"){
                    $metodePembayaran = "unknown";
                } else {
                    $metodePembayaran = $_POST['TBooking']['radionm'];
                }
                $bayar = $_POST['SummaryBooking']['total_bayar'];
                $dp = $_POST['SummaryBooking']['dp'];
                $sisa = $_POST['SummaryBooking']['sisa'];
                $totalharga = $_POST['SummaryBooking']['total_harga'];
                $durasi = $_POST['TBooking']['durasi'];
                $nokartudebit = $_POST['TBooking']['no_kartu_debit'];

                $modelJenisPembayaran = MJenisPembayaran::find()->where(['jenis' => $jenisPembayaran])->one();
                $modelMetodePembayaran = MMetodePembayaran::find()->where(['metode' => $metodePembayaran])->one();

                $modelMappingPembayaran = MMappingPembayaran::find()->where(['id_metode_pembayaran' => $modelMetodePembayaran->id, 'id_jenis_pembayaran' => $modelJenisPembayaran->id])->one();
                // var_dump($modelMappingPembayaran);exit;


                $modelBiodatatamu = new BiodataTamuBooking();
                $modelBiodatatamu->nama = $_POST['TBooking']['namatamu'];
                $modelBiodatatamu->identitas = $_POST['TBooking']['identitas'];
                $modelBiodatatamu->nomor_identitas = $_POST['TBooking']['nomor_identitas'];
                $modelBiodatatamu->alamat = $_POST['TBooking']['alamat'];
                $modelBiodatatamu->nomor_kontak = $_POST['TBooking']['nomor_kontak'];
                if($modelBiodatatamu->save(false)){
                    $modelSummaryttamu = new SummaryBooking();
                    $modelSummaryttamu->id_transaksi_tamu = $modelBiodatatamu->id;
                    if($jenisPembayaran == "sebagian") {
                        $modelSummaryttamu->dp = Logic::removeKoma($dp);
                        $modelSummaryttamu->sisa = Logic::removeKoma($sisa);
                        $modelSummaryttamu->total_bayar = null;
                    } else if($jenisPembayaran == "lunas"){
                        $modelSummaryttamu->dp = null;
                        $modelSummaryttamu->sisa = null;
                        $modelSummaryttamu->total_bayar = Logic::removeKoma($bayar);
                    } else {
                        $modelSummaryttamu->dp = null;
                        $modelSummaryttamu->sisa = null;
                        $modelSummaryttamu->total_bayar = null;
                    }
                    $modelSummaryttamu->id_petugas = Yii::$app->user->identity->id_petugas;
                    $modelSummaryttamu->total_harga = Logic::removeKoma($totalharga);
                    $modelSummaryttamu->save(false);
                }


                // simpan ke tabel mapping kamar
                foreach ($expPostkamar as $key => $value) {
                    // $jumlahkamar = $value;

                    // $modelStatuskamar =  MMappingKamar::find()->where(['id' => $value])->one();
                    // $modelStatuskamar->status = "terisi";
                    // if($modelStatuskamar->save(false)) {
                        $modelPengunjung = new TBooking();
                        $modelPengunjung->id_biodata_tamu = $modelBiodatatamu->id;
                        $modelPengunjung->id_mapping_kamar = $value;
                        $modelPengunjung->id_mapping_pembayaran = $modelMappingPembayaran['id'];
                        $modelPengunjung->checkin = $_POST['TBooking']['checkin'];
                        $modelPengunjung->checkout = $_POST['TBooking']['checkout'];
                        $modelPengunjung->harga = $expPostharga[$key];
                        $modelPengunjung->status = 1;
                        $modelPengunjung->durasi = str_replace('Hari', '',$durasi);
                        $modelPengunjung->no_kartu_debit = $nokartudebit;
                        $modelPengunjung->created_date = date('Y-m-d H:i:s');
                        $modelPengunjung->created_by = \Yii::$app->user->identity->nama;
                        // if($jenisPembayaran == "lunas") {
                        //     $modelPengunjung->bayar = Logic::removeKoma($bayar);
                        // } else {
                        //     $modelPengunjung->bayar = null;
                        // }

                        if($modelPengunjung->save(false)) {
                            $hasil = array(
                                'status' => "success",
                                'header' => "Berhasil",
                                'message' => "Checkin Berhasil Diproses !",
                            );
                        }
                    // }
                }
                echo json_encode($hasil);
                die();
            }
        $transaction->commit();
        } catch (Exception $e) {
            $transaction->rollBack();
            echo 'Message: ' . $e->getMessage();
        }
        return $this->renderPartial('create', [
            'model' => $model,
            'model2' => $model2
        ]);
    }

    public function actionHitungharga($hasil,$jmlkamar) {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        if (Yii::$app->request->get()){
            $expjmlkamar = explode(',',$jmlkamar);
            // array_push($expjmlkamar,$idterpilihresult);
            // echo"<pre>";
            // var_dump($expjmlkamar);
            // exit;
            // $getkamar = explode(",",$jmlkamar);
            $model = (new \yii\db\Query())
                ->select(['a.id', 'a.nomor_kamar', 'a.status', 'b.harga'])
                ->from('m_mapping_kamar a')
                ->join('INNER JOIN', 'm_mapping_harga b', 'b.id=a.id_mapping_harga')
                // ->join('INNER JOIN', 'm_type c', 'c.id = b.id_type')
                // ->join('INNER JOIN', 'm_kategori_harga d', 'd.id = b.id_kategori_harga')
                ->where(['a.id' => $expjmlkamar])
                // ->orderBy(['a.nomor_kamar' => SORT_ASC])
                ->all();

                foreach ($model as $key => $value) {
                    // $harga[] = $value['harga'];
                    $result[] = $value['harga'] * $hasil;
                }

                // var_dump($result);exit;

                $sumHarga = array_sum($result);
                $arrHasil = [
                    'hargaperkamar' => $result,
                    'sumharga' => $sumHarga,
                    'expjmlkamar' => $expjmlkamar
                ];

            echo json_encode($arrHasil);
            die();

        }
    }

    public function actionDetbooking($idtranstamu) {
        return $this->renderPartial('detailbooking', [
        'idtranstamu' => $idtranstamu
        ]);
    }

    public function actionGeneratedetailbooking($idtranstamu) {
        if(Yii::$app->request->isAjax)
        {
            \Yii::$app->response->format = Response::FORMAT_JSON;
            $data = \app\components\Logic::detailbookingtamu($idtranstamu);
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
