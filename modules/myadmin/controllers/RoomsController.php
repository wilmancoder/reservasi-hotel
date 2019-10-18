<?php

namespace app\modules\myadmin\controllers;

use Yii;
use app\models\Users;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use app\models\TTamu;
use app\components\Logic;
use app\models\TPetugas;
use app\models\BiodataTamu;
use app\models\MMappingKamar;
use app\models\MMetodePembayaran;
use app\models\MJenisPembayaran;
use app\models\MMappingPembayaran;
use app\models\SummaryTtamu;

class RoomsController extends \yii\web\Controller
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

    // public function beforeAction($action)
    // {
    //     $this->enableCsrfValidation = false;
    //     return parent::beforeAction($action);
    // }

    public function actionIndex()
    {
        $idharga = !empty($_GET['idharga']) ? $_GET['idharga'] : 1;



        $status = "tersedia";
        $ambilDatakamar = Logic::dataKamar($idharga,$status);
        // var_dump($ambilDatakamar);exit;
        return $this->render('index', [
            'model' => $ambilDatakamar,
            'idharga' => $idharga
        ]);
    }

    public function actionCreate($id) {
        // var_dump(Yii::$app->request->post());exit;
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $harga = (new \yii\db\Query())
                ->select(['a.id', 'a.nomor_kamar', 'a.status', 'b.harga'])
                ->from('m_mapping_kamar a')
                ->join('INNER JOIN', 'm_mapping_harga b', 'b.id=a.id_mapping_harga')
                ->where(['a.id' => $id])
                ->one();
            $ambilharga = $harga['harga'];
            $nomorkamar = $harga['nomor_kamar'];
            $model = new TTamu();
            $model2 = new SummaryTtamu();
            if (Yii::$app->request->post()) {
                // $postkamar = $_POST['kamarterpilih'];
                // $expPostkamar = explode(",",$postkamar);

                // $ceknokamar = $model = (new \yii\db\Query())
                //     ->select('a.*')
                //     ->from('m_mapping_kamar a')
                //     ->where('a.nomor_kamar IN('.$postkamar.')')
                //     ->all();
                // foreach ($ceknokamar as $key => $valueckkamar) {
                //     $res_cekkamar[] = $valueckkamar['nomor_kamar'];
                //     $res_idkamar[] = $valueckkamar['id'];
                // }

                // $postharga = $_POST['hargaterpilih'];
                // $expPostharga = explode(",",$postharga);
                // var_dump($res_idkamar);exit;


                // echo"<pre>";
                // print_r($expPostkamar);exit;
                $jenisPembayaran = $_POST['TTamu']['radio'];
                $metodePembayaran = $_POST['TTamu']['radionm'];
                $bayar = $_POST['SummaryTtamu']['total_bayar'];
                $dp = $_POST['SummaryTtamu']['dp'];
                $sisa = $_POST['SummaryTtamu']['sisa'];
                $totalharga = $_POST['SummaryTtamu']['total_harga'];
                $durasi = $_POST['TTamu']['durasi'];
                $nokartudebit = $_POST['TTamu']['no_kartu_debit'];

                $modelJenisPembayaran = MJenisPembayaran::find()->where(['jenis' => $jenisPembayaran])->one();
                $modelMetodePembayaran = MMetodePembayaran::find()->where(['metode' => $metodePembayaran])->one();

                $modelMappingPembayaran = MMappingPembayaran::find()->where(['id_metode_pembayaran' => $modelMetodePembayaran->id, 'id_jenis_pembayaran' => $modelJenisPembayaran->id])->one();


                $modelBiodatatamu = new BiodataTamu();
                $modelBiodatatamu->nama = $_POST['TTamu']['namatamu'];
                $modelBiodatatamu->identitas = $_POST['TTamu']['identitas'];
                $modelBiodatatamu->nomor_identitas = $_POST['TTamu']['nomor_identitas'];
                $modelBiodatatamu->alamat = $_POST['TTamu']['alamat'];
                $modelBiodatatamu->nomor_kontak = $_POST['TTamu']['nomor_kontak'];
                if($modelBiodatatamu->save(false)){
                    $modelSummaryttamu = new SummaryTtamu();
                    $modelSummaryttamu->id_transaksi_tamu = $modelBiodatatamu->id;
                    if($jenisPembayaran == "sebagian") {
                        $modelSummaryttamu->dp = Logic::removeKoma($dp);
                        $modelSummaryttamu->sisa = Logic::removeKoma($sisa);
                        $modelSummaryttamu->total_bayar = null;
                    } else {
                        $modelSummaryttamu->dp = null;
                        $modelSummaryttamu->sisa = null;
                        $modelSummaryttamu->total_bayar = Logic::removeKoma($bayar);
                    }
                    $modelSummaryttamu->id_petugas = Yii::$app->user->identity->id_petugas;
                    $modelSummaryttamu->total_harga = Logic::removeKoma($totalharga);
                    $modelSummaryttamu->save(false);
                }
                // var_dump($_POST['TTamu']['no_kartu_debit']);exit;
                $modelPengunjung = new TTamu();
                $modelPengunjung->id_biodata_tamu = $modelBiodatatamu->id;
                $modelPengunjung->id_mapping_kamar = $_POST['TTamu']['list_kamar'];
                $modelPengunjung->id_mapping_pembayaran = $modelMappingPembayaran->id;
                $modelPengunjung->checkin = $_POST['TTamu']['checkin'];
                $modelPengunjung->checkout = $_POST['TTamu']['checkout'];
                $modelPengunjung->harga = $_POST['TTamu']['subtotalkamar'];
                $modelPengunjung->status = 1;
                $modelPengunjung->durasi = str_replace('Hari', '',$durasi);
                $modelPengunjung->no_kartu_debit =$_POST['TTamu']['no_kartu_debit'];
                $modelPengunjung->created_date_cekin = date('Y-m-d H:i:s');
                $modelPengunjung->created_by_cekin = \Yii::$app->user->identity->nama;

                if($modelPengunjung->save()){
                    MMappingKamar::updateAll(['status' => 'terisi', ], ['nomor_kamar' => $_POST['TTamu']['nomor_kamar']]);
                }
                if(!empty($_POST['kamar'])){
                    foreach ($_POST['kamar'] as $key => $value) {
                        $durasi = $value['durasi'];
                        $modelPengunjung = new TTamu();
                        $modelPengunjung->id_biodata_tamu = $modelBiodatatamu->id;
                        $modelPengunjung->id_mapping_kamar = $value['list_kamar'];
                        $modelPengunjung->id_mapping_pembayaran = $modelMappingPembayaran->id;
                        $modelPengunjung->checkin = $value['checkin'];
                        $modelPengunjung->checkout = $value['checkout'];
                        $modelPengunjung->harga = $value['subtotalkamar'];
                        $modelPengunjung->status = 1;
                        $modelPengunjung->durasi = str_replace('Hari', '',$durasi);
                        $modelPengunjung->no_kartu_debit =$_POST['TTamu']['no_kartu_debit'];
                        $modelPengunjung->created_date_cekin = date('Y-m-d H:i:s');
                        $modelPengunjung->created_by_cekin = \Yii::$app->user->identity->nama;

                        if($modelPengunjung->save()){
                            MMappingKamar::updateAll(['status' => 'terisi', ], ['nomor_kamar' => $value['nomor_kamar']]);  
                        }
                    }
                }
                
                $hasil = array(
                    'status' => "success",
                    'header' => "Berhasil",
                    'message' => "Checkin Berhasil Diproses !",
                );
                echo json_encode($hasil);
                die();
            }
        $transaction->commit();
        } catch (Exception $e) {
            $transaction->rollBack();
            echo 'Message: ' . $e->getMessage();
        }

        $listkamar = (new \yii\db\Query())
            ->select(['a.id', 'a.nomor_kamar', 'a.status', 'c.type', 'd.kategori_harga', 'b.harga'])
            ->from('m_mapping_kamar a')
            ->join('INNER JOIN', 'm_mapping_harga b', 'b.id=a.id_mapping_harga')
            ->join('INNER JOIN', 'm_type c', 'c.id = b.id_type')
            ->join('INNER JOIN', 'm_kategori_harga d', 'd.id = b.id_kategori_harga')
            ->andWhere(['<>', 'a.status', 'terisi'])
            ->groupBy('a.nomor_kamar')
            ->orderBy(['a.nomor_kamar' => SORT_ASC])
            ->all();
        // var_dump($listkamar);exit;

        return $this->renderPartial('create', [
            'model' => $model,
            'model2' => $model2,
            'id' => $id,
            'ambilharga' => $ambilharga,
            'nomorkamar' => $nomorkamar,
            'listkamar' => $listkamar
        ]);
    }

    public function actionHitungharga($hasil,$jmlkamar) {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        if (Yii::$app->request->get()){
            // $expjmlkamar = explode(',',$jmlkamar);
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
                ->where(['a.id' => $jmlkamar])
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
                    'jmlkamar' => $jmlkamar
                ];

            echo json_encode($arrHasil);
            die();

        }
    }

    public function actionListkamar($id)
    {
        return $this->renderPartial('listkamarnew', [
            'id' => $id
        ]);
    }

    public function actionGetlistkamar($id) {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $model = (new \yii\db\Query())
            ->select(['a.id', 'a.nomor_kamar', 'a.status', 'c.type', 'd.kategori_harga', 'b.harga'])
            ->from('m_mapping_kamar a')
            ->join('INNER JOIN', 'm_mapping_harga b', 'b.id=a.id_mapping_harga')
            ->join('INNER JOIN', 'm_type c', 'c.id = b.id_type')
            ->join('INNER JOIN', 'm_kategori_harga d', 'd.id = b.id_kategori_harga')
            ->where('a.id NOT IN('.$id.')')
            ->orderBy(['a.nomor_kamar' => SORT_ASC])
            ->all();

        // var_dump($model);exit;
        $row = array();
        $i = 0;
        $no = 1;
        foreach ($model as $idx => $value) {
            //Asiign All Value To Row
            foreach ($value as $key => $val) {
                $row[$i][$key] = $val;
            }
            $row[$i]['id'] = $value['id'];
            $row[$i]['no'] = $no;
            $row[$i]['nomor_kamar'] = "Kamar Nomor " .$value['nomor_kamar'];
            $row[$i]['type'] = $value['type'];
            $row[$i]['harga'] = $value['harga'];

            $row[$i]['fungsi'] = "
            <input type='checkbox' name='nmpilih[]' class='clpilih-".$value['id']."' onclick='checkKamar(".$value['id'].")' value='" . $value['id'] . "'>
            ";

            // $row[$i]['fungsi'] = "
            // <button onclick='updatekontrak(\"" . $value['id'] . "\")' type='button' rel='tooltip' data-toggle='tooltip' title='Edit Kontrak' class='btn btn-sm btn-warning btn-flat'><i class='fa fa-edit'></i></button>
            // <button onclick='deletekontrak(\"" . $value['id'] . "\")' type='button' rel='tooltip' data-toggle='tooltip' title='Hapus Kontrak' class='btn btn-sm btn-danger btn-flat'><i class='fa fa-trash'></i></button>
            // ";

            $i++;
            $no++;
        }
        $hasil['data'] = $row;
            // var_dump($hasil);exit();
        return $hasil;
    }

    public function actionNotifterpilih(){
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $request = Yii::$app->request;
        $post = $request->post();
        $terpilih = $post['data'];
        // var_dump($post['data']);exit;
        if ($post){
            $hasil = [
                'result' =>$terpilih,
                'status' => "success",
                'title' => "Berhasil",
                'msg' => "Anda Telah Memilih Kamar Nomor '".$terpilih."' "
            ];

            echo json_encode($hasil);
            die();
        }
    }

    public function actionCreatedone($idttamu){
        $que1 = MMappingKamar::find()->where(['id'=>$idttamu])->asArray()->one();
        $quetamu = TTamu::find()->where(['id_mapping_kamar' => $que1['id'], 'status' => 1])->asArray()->one();
        if($quetamu > 0) {
            $que2 = MMappingKamar::find()->where(['nomor_kamar'=>$que1['nomor_kamar']])->andWhere(['id' => $quetamu['id_mapping_kamar']])->andWhere(['status' => 'terisi'])->asArray()->one();
        } else {
            $que2 = MMappingKamar::find()->where(['nomor_kamar'=>$que1['nomor_kamar']])->andWhere(['<>', 'id', $idttamu])->andWhere(['status' => 'terisi'])->asArray()->one();
        }
        // var_dump($que2);exit;
        $cekbiodatatamu = TTamu::find()->where(['id_mapping_kamar'=>$que2['id'],'status'=> 1])->asArray()->one();
        // $cekbiodatatamu = TTamu::find()->where(['id'=>$idttamu])->asArray()->one();
        $idbiodata = $cekbiodatatamu['id_biodata_tamu'];
        $ambilDatatamu = Logic::dataTamu($idbiodata);
        // var_dump($ambilDatatamu);exit;
        return $this->renderPartial('createdone', [
            'ambilDatatamu' => $ambilDatatamu,
            'idbiodata' => $idbiodata
        ]);
    }
     public function actionSimpancekout($idbiodata)
     {
         $transaction = Yii::$app->db->beginTransaction();
         try {
             if (Yii::$app->request->post()) {
                 // $getid = $_GET;
                 $post = @$_POST['bayarpelunasan'];
                //  var_dump($_POST);exit;

                 $cekbiodatatamu =  TTamu::find()->where(['id_biodata_tamu' => $idbiodata])->asArray()->all();
                //  var_dump($_POST);
                 if(!(empty($_POST['id_tamu']))){
                    foreach ($_POST['id_tamu'] as $key ) {
                        // var_dump($key);
                        $modelTransaksitamu =  TTamu::find()->where(['id' => $key])->one();
                        $modelTransaksitamu['status'] = "0";
                        $modelTransaksitamu['created_date_cekout'] = date('Y-m-d H:i:s');
                        $modelTransaksitamu->save();
                    }
                 }
                 if(!(empty($_POST['nomor_kamar']))){
                    foreach ($_POST['nomor_kamar'] as $key ) {
                        // var_dump($key);
                        $modelStatuskamar =  MMappingKamar::find()->where(['nomor_kamar' => $key])->one();
                        $modelStatuskamar['status'] = "tersedia";
                        $modelStatuskamar->save(false);
                    }
                 }
                 if(!empty($_POST['bayarpelunasan'])){
                     $modelSummaryttamu = SummaryTtamu::find()->where(['id_transaksi_tamu' => $_POST['id_biodata_tamu']])->one();
                     $modelSummaryttamu->total_bayar = $_POST['bayarpelunasan'];
                     $modelSummaryttamu->sisa = 0;
                     $modelSummaryttamu->save(false);
                 }
                //  foreach ($cekbiodatatamu as $key => $value) {
                //      $modelTransaksitamu =  TTamu::find()->where(['id' => $value['id']])->one();
                //      $modelTransaksitamu['status'] = "0";
                //      $modelTransaksitamu['created_date_cekout'] = date('Y-m-d H:i:s');
                //      if($modelTransaksitamu->save(false)) {
                //          $modelStatuskamar =  MMappingKamar::find()->where(['id' => $value['id_mapping_kamar']])->one();
                //          $modelStatuskamar['status'] = "tersedia";
                //          if($modelStatuskamar->save(false)) {
                //              $modelSummaryttamu = SummaryTtamu::find()->where(['id_transaksi_tamu' => $value['id_biodata_tamu']])->one();
                //              $modelSummaryttamu->total_bayar = $_POST['bayarpelunasan'];
                //             if($modelSummaryttamu->save(false)) {
                //                  $hasil = array(
                //                      'status' => "success",
                //                      'header' => "Berhasil",
                //                      'message' => "Checkout Berhasil Diproses !",
                //                  );
                //             }
                //          }
                //      }
                //  }
                 $hasil = array(
                    'status' => "success",
                    'header' => "Berhasil",
                    'message' => "Checkout Berhasil Diproses !",
                );
                
                //  var_dump($cekbiodatatamu);exit;
                 echo json_encode($hasil);
                 die();

             }
         $transaction->commit();
         } catch (Exception $e) {
             $transaction->rollBack();
             echo 'Message: ' . $e->getMessage();
         }
     }

     public function actionJamkerja($ambiljamker){
         \Yii::$app->response->format = Response::FORMAT_JSON;
         if (Yii::$app->request->get()){
         // var_dump($ambiljamker);exit;
        }
        echo json_encode($ambiljamker);
        die();
     }
}
