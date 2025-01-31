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
use app\models\MMappingHarga;
use app\models\HistoriSummarytamu;
use app\models\TBed;
use app\models\MKategoriHarga;

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
        $kategoriHarga = \Yii::$app->user->identity->id_kategori_harga;
        if($_GET['idharga'] == $kategoriHarga){
            $idharga = !empty($_GET['idharga']) ? $_GET['idharga'] : $kategoriHarga;
        } else {
            $idharga = !empty($_GET['idharga']) ? $kategoriHarga : $kategoriHarga;
        }
        $status = "tersedia";
        $ambilDatakamar = Logic::dataKamar($idharga,$status);
        // $session = Yii::$app->session;
        // $session->set('idharga', $idharga);
        // $getsessionharga = $session->get('idharga');
        // var_dump($getsessionharga);exit;


        return $this->render('index', [
            'model' => $ambilDatakamar,
            'idharga' => $idharga
        ]);
    }

    public function actionCreate($id) {
        $exp = explode(",",$id);
        // $session = Yii::$app->session;
        // $getsessionharga = $session->get('idharga');
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $harga = (new \yii\db\Query())
                ->select(['a.id', 'a.nomor_kamar', 'a.status', 'b.harga'])
                ->from('m_mapping_kamar a')
                ->join('INNER JOIN', 'm_mapping_harga b', 'b.id=a.id_mapping_harga')
                ->where(['a.id' => $exp[0]])
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

                $jenisPembayaran = $_POST['TTamu']['radio'];
                if($jenisPembayaran == "belumbayar"){
                    $metodePembayaran = "unknown";
                } else {
                    $metodePembayaran = $_POST['TTamu']['radionm'];
                }

                // echo"<pre>";
                // print_r($expPostkamar);exit;
                $jenisPembayaran = $_POST['TTamu']['radio'];
                // $metodePembayaran = $_POST['TTamu']['radionm'];
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
                        $modelSummaryttamu->total_bayar = 0;
                    } else if($jenisPembayaran == "lunas"){
                        $modelSummaryttamu->dp = 0;
                        $modelSummaryttamu->sisa = 0;
                        $modelSummaryttamu->total_bayar = Logic::removeKoma($bayar);
                    } else {
                        $modelSummaryttamu->dp = 0;
                        $modelSummaryttamu->sisa = Logic::removeKoma($sisa);
                        $modelSummaryttamu->total_bayar = 0;
                    }
                    $modelSummaryttamu->id_petugas = Yii::$app->user->identity->id_petugas;
                    $modelSummaryttamu->total_harga = Logic::removeKoma($totalharga);
                    $modelSummaryttamu->save(false);

                    $modelHistoriSummaryttamu = new HistoriSummarytamu();
                    $modelHistoriSummaryttamu->id_transaksi_tamu = $modelBiodatatamu->id;
                    $modelHistoriSummaryttamu->id_petugas = Yii::$app->user->identity->id_petugas;
                    $modelHistoriSummaryttamu->id_user = Yii::$app->user->identity->id_user;
                    if($dp != 0 && $sisa != 0){
                        $modelHistoriSummaryttamu->pembayaran = "DP";
                        $modelHistoriSummaryttamu->status_pembayaran = "BELUM LUNAS";
                        $modelHistoriSummaryttamu->jml_uangmasuk = Logic::removeKoma($dp);
                    } else if($dp == 0 && $sisa == 0){
                        $modelHistoriSummaryttamu->pembayaran = "PENUH";
                        $modelHistoriSummaryttamu->status_pembayaran = "LUNAS";
                        $modelHistoriSummaryttamu->jml_uangmasuk = Logic::removeKoma($bayar);
                    }
                    $modelHistoriSummaryttamu->tgl_uangmasuk = date('Y-m-d');
                    if($dp != 0 || $bayar != 0) {
                        $modelHistoriSummaryttamu->save(false);
                    }

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
                    // 'setharga' => $getsessionharga,
                    'joinid' => $id

                );
                echo json_encode($hasil);
                die();
            }
        $transaction->commit();
        } catch (Exception $e) {
            $transaction->rollBack();
            echo 'Message: ' . $e->getMessage();
        }

        $getkategorikamar = MMappingHarga::find()->where(['id_kategori_harga' => $exp[1]])->asArray()->all();
        // $que1 = MMappingKamar::find()->where(['id'=>$idttamu])->asArray()->one();
        foreach ($getkategorikamar as $key => $valueKategori) {
            $resultKategori[] = $valueKategori['id'];
        }
        $imp = implode(",",$resultKategori);
        // var_dump($imp);exit;

        $listkamar = (new \yii\db\Query())
            ->select(['a.id', 'a.nomor_kamar', 'a.status', 'c.type', 'd.kategori_harga', 'b.harga'])
            ->from('m_mapping_kamar a')
            ->join('INNER JOIN', 'm_mapping_harga b', 'b.id=a.id_mapping_harga')
            ->join('INNER JOIN', 'm_type c', 'c.id = b.id_type')
            ->join('INNER JOIN', 'm_kategori_harga d', 'd.id = b.id_kategori_harga')
            ->where('a.id_mapping_harga IN('.$imp.')')
            ->andWhere(['<>', 'a.status', 'terisi'])
            ->groupBy('a.nomor_kamar')
            ->orderBy(['a.nomor_kamar' => SORT_ASC])
            ->all();
        // var_dump($listkamar);exit;

        return $this->renderPartial('create', [
            'model' => $model,
            'model2' => $model2,
            'id' => $exp[0],
            'ambilharga' => $ambilharga,
            'nomorkamar' => $nomorkamar,
            'listkamar' => $listkamar,
            'joinid' => $id
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
        // var_dump($idttamu);exit;
        // $session = Yii::$app->session;
        // $getsessionharga = $session->get('idharga');
        $model = new HistoriSummarytamu();
        $exp = explode(",",$idttamu);
        $que1 = MMappingKamar::find()->where(['id'=>$exp[0]])->asArray()->one();
        // var_dump($que1);exit;
        $quetamu = TTamu::find()->where(['id_mapping_kamar' => $que1['id'], 'status' => 1])->asArray()->one();
        if($quetamu > 0) {
            $que2 = MMappingKamar::find()->where(['nomor_kamar'=>$que1['nomor_kamar']])->andWhere(['id' => $quetamu['id_mapping_kamar']])->andWhere(['status' => 'terisi'])->asArray()->one();
        } else {
            $que2 = MMappingKamar::find()->where(['nomor_kamar'=>$que1['nomor_kamar']])->andWhere(['<>', 'id', $exp[0]])->andWhere(['status' => 'terisi'])->asArray()->one();
        }
        $cekbiodatatamu = TTamu::find()->where(['id_mapping_kamar'=>$que2['id'],'status'=> 1])->asArray()->one();
        // $cekbiodatatamu = TTamu::find()->where(['id'=>$idttamu])->asArray()->one();
        $idbiodata = $cekbiodatatamu['id_biodata_tamu'];
        $ambilDatatamu = Logic::dataTamu($idbiodata);
        $ambilDatatamusatuan = Logic::dataTamusatuan($idbiodata);
        // echo"<pre>";
        // print_r($ambilDatatamusatuan);exit;
        $cekKatHarga = MKategoriHarga::find()->where(['id' => $exp[1]])->asArray()->one();
        $hargabed = MMappingHarga::find()->where(['id_kategori_harga' => $cekKatHarga['id'], 'id_type' => 5])->asArray()->one();
        $resultbed = $hargabed['harga'];

        $cektbed = TBed::find()->where([
            'id_biodata_tamu' => $idbiodata
        ])
        ->asArray()
        ->one();
        return $this->renderPartial('createdone', [
            'ambilDatatamu' => $ambilDatatamu,
            'ambilDatatamusatuan' => $ambilDatatamusatuan,
            'idbiodata' => $idbiodata,
            'idkamar' =>$exp[0],
            'tipe' => $exp[1],
            'cektbed' => $cektbed,
            'resultbed' => $resultbed,
            'model' => $model,
            // 'getsessionharga' => $getsessionharga
        ]);
    }
     public function actionSimpancekout($idbiodata,$tipe)
     {
         // $session = Yii::$app->session;
         // $getsessionharga = $session->get('idharga');
         $transaction = Yii::$app->db->beginTransaction();
         try {
             if (Yii::$app->request->post()) {
                 $request = Yii::$app->request;
                 $postpelunasan = $request->post();
                 $byrlunas = $postpelunasan['bayarpelunasan'];
                 $hisKet = $postpelunasan['HistoriSummarytamu']['keterangan'];

                $cekbiodatatamu =  TTamu::find()->where(['id_biodata_tamu' => $idbiodata])->asArray()->one();
                $cektamu = TTamu::find()->where(['id_biodata_tamu' => $idbiodata])->asArray()->all();
                $cekhistoryTamu = HistoriSummarytamu::find()->where(['id_transaksi_tamu' => $idbiodata])->asArray()->one();
                // var_dump($cekhistoryTamu);exit;
                $ceksummaryTamu = SummaryTtamu::find()->where(['id_transaksi_tamu' => $idbiodata])->one();
                $resCeksummaryTamu = $ceksummaryTamu['sisa'];
                // var_dump($resCeksummaryTamu);exit;
                if(!empty($cektamu)) {
                    foreach ($cektamu as $value) {
                        $modelTtamu = TTamu::find()->where(['id' => $value['id']])->one();
                        $modelTtamu->id_mapping_pembayaran = 1;
                        // $modelTtamu->created_date_cekout = date('Y-m-d H:i:s');
                        $modelTtamu->save(false);
                    }
                }
                if(!(empty($_POST['id_tamu']))){
                    foreach ($_POST['id_tamu'] as $key ) {
                        // var_dump($key);
                        $modelTransaksitamu =  TTamu::find()->where(['id' => $key])->one();
                        $modelTransaksitamu['status'] = 0;
                        $modelTransaksitamu['id_mapping_pembayaran'] = 1;
                        $modelTransaksitamu['created_date_cekout'] = date('Y-m-d H:i:s');
                        $modelTransaksitamu->save();
                    }
                 }
                if(!(empty($_POST['nomor_kamar']))){
                    foreach ($_POST['nomor_kamar'] as $key ) {
                        $modelStatuskamar =  MMappingKamar::find()->where(['nomor_kamar' => $key])->all();
                        foreach ($modelStatuskamar as $idx => $valstatkamar) {
                            $modStatuskamar =  MMappingKamar::find()->where(['id' => $valstatkamar['id']])->one();
                            $modStatuskamar['status'] = "tersedia";
                            $modStatuskamar->save(false);
                        }
                    }
                }
                if($cekhistoryTamu > 0){
                    // echo"test1";exit;
                    if($resCeksummaryTamu != 0){
                        // echo"masuk1";exit;
                        $modelSummaryttamu = SummaryTtamu::find()->where(['id_transaksi_tamu' => $_POST['id_biodata_tamu']])->one();
                        $modelSummaryttamu->total_bayar = $byrlunas;
                        $modelSummaryttamu->sisa = 0;
                        $modelSummaryttamu->dp = 0;
                        $modelSummaryttamu->save(false);

                        $modelHistoriSummaryttamu = new HistoriSummarytamu();
                        $modelHistoriSummaryttamu->id_transaksi_tamu = $cekbiodatatamu['id_biodata_tamu'];
                        $modelHistoriSummaryttamu->id_petugas = Yii::$app->user->identity->id_petugas;
                        $modelHistoriSummaryttamu->id_user = Yii::$app->user->identity->id_user;
                        if( (!empty($_POST['dp']) && !empty($_POST['sisa'])) ){
                            $modelHistoriSummaryttamu->pembayaran = "SISA";
                            $modelHistoriSummaryttamu->status_pembayaran = "LUNAS";
                        } else {
                            $modelHistoriSummaryttamu->pembayaran = "PENUH";
                            $modelHistoriSummaryttamu->status_pembayaran = "LUNAS";
                        }
                        $modelHistoriSummaryttamu->tgl_uangmasuk = date('Y-m-d');
                        $modelHistoriSummaryttamu->jml_uangmasuk = Logic::removeRpTitik($_POST['sisa']);
                        $modelHistoriSummaryttamu->keterangan = $hisKet;
                        $modelHistoriSummaryttamu->save(false);
                    } else {
                        // echo"masuk2";exit;
                        $modelSummaryttamu = SummaryTtamu::find()->where(['id_transaksi_tamu' => $_POST['id_biodata_tamu']])->one();
                        $modelSummaryttamu->total_bayar = $byrlunas;
                        $modelSummaryttamu->sisa = 0;
                        $modelSummaryttamu->dp = 0;
                        $modelSummaryttamu->save(false);

                       $modelHistoriSummaryttamu = HistoriSummarytamu::find()->where(['id_transaksi_tamu' => $_POST['id_biodata_tamu']])->one();
                       $modelHistoriSummaryttamu->keterangan = $hisKet;
                       $modelHistoriSummaryttamu->save(false);
                    }

                }
                // else {
                //     // echo"test2";exit;
                //     $modelSummaryttamu = SummaryTtamu::find()->where(['id_transaksi_tamu' => $_POST['id_biodata_tamu']])->one();
                //     $modelSummaryttamu->total_bayar = $byrlunas;
                //     $modelSummaryttamu->sisa = 0;
                //     $modelSummaryttamu->dp = 0;
                //     $modelSummaryttamu->save(false);
                //
                //    $modelHistoriSummaryttamu = HistoriSummarytamu::find()->where(['id_transaksi_tamu' => $_POST['id_biodata_tamu']])->one();
                //    $modelHistoriSummaryttamu->keterangan = $hisKet;
                //    $modelHistoriSummaryttamu->save(false);
                // }


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
                    'setharga' => $tipe
                );

                //  var_dump($cekbiodatatamu);exit;
                 echo json_encode($hasil);
                 // die();

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

    public function actionSetkamar($id,$idkamar,$tipe)
    {
        $model = new TTamu();
        $model->checkin = date('Y-m-d');
        $getkategorikamar = MMappingHarga::find()->where(['id_kategori_harga' => $tipe])->asArray()->all();
        // $que1 = MMappingKamar::find()->where(['id'=>$idttamu])->asArray()->one();
        foreach ($getkategorikamar as $key => $valueKategori) {
            $resultKategori[] = $valueKategori['id'];
        }
        $imp = implode(",",$resultKategori);
        $ambilDatatamu = Logic::dataTamuOne($id);
        $model2 = new SummaryTtamu();

        $listkamar = (new \yii\db\Query())
            ->select(['a.id', 'a.nomor_kamar', 'a.status', 'c.type', 'd.kategori_harga', 'b.harga'])
            ->from('m_mapping_kamar a')
            ->join('INNER JOIN', 'm_mapping_harga b', 'b.id=a.id_mapping_harga')
            ->join('INNER JOIN', 'm_type c', 'c.id = b.id_type')
            ->join('INNER JOIN', 'm_kategori_harga d', 'd.id = b.id_kategori_harga')
            ->where('a.id_mapping_harga IN('.$imp.')')
            ->andWhere(['<>', 'a.status', 'terisi'])
            ->groupBy('a.nomor_kamar')
            ->orderBy(['a.nomor_kamar' => SORT_ASC])
            ->all();

        return $this->renderPartial('_edit_kamar', [
            'ambilDatatamu' => $ambilDatatamu,
            'id' => $id,
            'idkamar' => $idkamar,
            'tipe' => $tipe,
            'listkamar' => $listkamar,
            'model' => $model,
            'model2' => $model2,
            'status' => "success"
        ]);

    }

    public function actionGantikategoriharga($id,$tipe)
    {

        $model = new TTamu();
        $model->checkin = date('Y-m-d');
        $getkategorikamar = MMappingHarga::find()->where(['id_kategori_harga' => $tipe])->asArray()->all();
        // $que1 = MMappingKamar::find()->where(['id'=>$idttamu])->asArray()->one();
        foreach ($getkategorikamar as $key => $valueKategori) {
            $resultKategori[] = $valueKategori['id'];
        }
        $imp = implode(",",$resultKategori);
        // $ambilDatatamu = Logic::dataTamuOne($id);
        // $model2 = new SummaryTtamu();

        $listkamar = (new \yii\db\Query())
            ->select(['a.id', 'a.nomor_kamar', 'c.type', 'b.harga'])
            ->from('m_mapping_kamar a')
            ->join('INNER JOIN', 'm_mapping_harga b', 'b.id=a.id_mapping_harga')
            ->join('INNER JOIN', 'm_type c', 'c.id = b.id_type')
            ->join('INNER JOIN', 'm_kategori_harga d', 'd.id = b.id_kategori_harga')
            ->where('a.id_mapping_harga IN('.$imp.')')
            ->andWhere(['<>', 'a.status', 'terisi'])
            ->groupBy('a.nomor_kamar')
            ->orderBy(['a.nomor_kamar' => SORT_ASC])
            ->all();

        // var_dump($listkamar);exit;
        $hasil = [
            // 'status' => "success",
            'listkamar' => $listkamar

        ];
        echo json_encode($hasil);
    }

    public function actionTambahdurasi($id,$tipe,$hari=0,$katharga='',$flag,$idkamar)
    {
        $ambilDatatamu = Logic::dataTamuOne($id);


        // var_dump($hasilcek);exit;

        $idbio = $ambilDatatamu[0]['id_biodata_tamu'];
        $idttamu = $idkamar.",".$tipe;
        // $mapPembayaran = MMappingPembayaran::find()->where(['id_metode_pembayaran' => $tipe, 'id_jenis_pembayaran' => $hasilcek])->one();
        // var_dump($mapPembayaran);exit;

        $request = Yii::$app->request;
        if ($request->isAjax) {
            if($flag == 'normalhari') {
                $harga_tambahan = $ambilDatatamu[0]['harga'] * $hari;
                $model2 = SummaryTtamu::find()->where(['id_transaksi_tamu' => $ambilDatatamu[0]['id_biodata_tamu']])->one();
                if($ambilDatatamu[0]['jenis'] == 'lunas'){
                    $model2->dp = $model2->total_harga;
                    $model2->total_harga =  (string)($model2->total_harga + $harga_tambahan);
                    $model2->sisa = (string)($model2->total_harga - $model2->dp);
                }
                else{
                    $model2->total_harga =  (string)($model2->total_harga + $harga_tambahan);
                    $model2->sisa = (string)($model2->total_harga - $model2->dp);
                }

                if($model2->save()){
                    $model = TTamu::find()->where(['id' => $id])->one();
                    // Pengecekan ke sisa di tbl summary tamu
                    $ceksummaryTamu = SummaryTtamu::find()->where(['id_transaksi_tamu' => $ambilDatatamu[0]['id_biodata_tamu']])->one();
                    $resCeksummaryTamu = $ceksummaryTamu['sisa'];
                    if($resCeksummaryTamu == 0){
                        $cekjenispembayaran = TTamu::find()->where(['id' => $id])->asArray()->one();
                        $hasilcek = intval($cekjenispembayaran['id_mapping_pembayaran']);
                    } else {
                        $hasilcek = 3;
                    }

                    // $mapPembayaran = MMappingPembayaran::find()->where(['id_metode_pembayaran' => $tipe, 'id_jenis_pembayaran' => $hasilcek])->one();
                    $model->id_mapping_pembayaran = $hasilcek;
                    $model->checkout = date('Y-m-d', strtotime($model->checkout . ' +'.$hari.' day'));
                    $model->durasi = (string)($model->durasi + $hari);
                    $model->harga =  (string)($model->harga + $harga_tambahan);
                    // $que1 = MMappingKamar::find()->where(['id'=>$idttamu])->asArray()->one();
                    $model->save();
                }
            } else if($flag == 'setengahhari') {
                $hargasetengah = $katharga/2;
                $durasisetengah = 0.5;
                $model = TTamu::find()->where(['id' => $id])->one();
                $model2 = SummaryTtamu::find()->where(['id_transaksi_tamu' => $ambilDatatamu[0]['id_biodata_tamu']])->one();
                // $model2 = SummaryTtamu::find()->where(['id_transaksi_tamu' => $ambilDatatamu[0]['id_biodata_tamu']])->one();
                if($ambilDatatamu[0]['jenis'] == 'lunas'){
                    $model2->dp = $model2->total_harga;
                    $model2->total_harga =  (string)($model2->total_harga + $hargasetengah);
                    $model2->sisa = (string)($model2->total_harga - $model2->dp);
                }
                else{
                    $model2->total_harga =  (string)($model2->total_harga + $hargasetengah);
                    $model2->sisa = (string)($model2->total_harga - $model2->dp);
                }
                // $model2->save();

                if($model2->save()){
                    $model = TTamu::find()->where(['id' => $id])->one();
                    // Pengecekan ke sisa di tbl summary tamu
                    $ceksummaryTamu = SummaryTtamu::find()->where(['id_transaksi_tamu' => $ambilDatatamu[0]['id_biodata_tamu']])->one();
                    $resCeksummaryTamu = $ceksummaryTamu['sisa'];
                    if($resCeksummaryTamu == 0){
                        $cekjenispembayaran = TTamu::find()->where(['id' => $id])->asArray()->one();
                        $hasilcek = intval($cekjenispembayaran['id_mapping_pembayaran']);
                    } else {
                        $hasilcek = 3;
                    }

                    $model->id_mapping_pembayaran = $hasilcek;
                    $model->checkout = $model->checkout;
                    $model->durasi = (string)($model->durasi + $durasisetengah);
                    $model->harga =  (string)($model->harga + $hargasetengah);
                    $model->save();
                }

                // $que1 = MMappingKamar::find()->where(['id'=>$idttamu])->asArray()->one();
                // if($model->save()){
                //
                // }
            }
        }
        TTamu::updateAll(['id_mapping_pembayaran' => $hasilcek], ['id_biodata_tamu' => $ambilDatatamu[0]['id_biodata_tamu']]);
        $hasil = array(
            'status' => "success",
            'header' => "Berhasil",
            'message' => "Checkin Berhasil Diproses !",
            'idttamu' => $idttamu,
            'cek1' => $model->getErrors(),
            'cek2' => @$model2->getErrors()

        );
        echo json_encode($hasil);
    }


    public function actionGantikamar($id,$idkamar,$tipe,$newkamar)
    {
        // var_dump($newkamar);exit;
        date_default_timezone_set('Asia/Jakarta');
        $ambilDatatamu = Logic::dataTamuOne($id);
        $cekjenispembayaran = TTamu::find()->where(['id' => $id])->asArray()->one();
        $hasilcek = $cekjenispembayaran['id_mapping_pembayaran'];

        $idbio = $ambilDatatamu[0]['id_biodata_tamu'];
        $idttamu = $newkamar.",".$tipe;
        // $mapPembayaran = MMappingPembayaran::find()->where(['id_metode_pembayaran' => $tipe, 'id_jenis_pembayaran' => 2])->one();

        if(Yii::$app->request->isAjax){
            $model = TTamu::find()->where(['id' => $id])->one();

            $current = date('Y-m-d');
            $waktuawal  = date_create($current); //waktu di setting
            $waktuakhir = date_create($model->checkout); //2019-02-21 09:35 waktu sekarang
            // var_dump($waktuawal);
            $diff  = date_diff($waktuawal, $waktuakhir);
            $sisa_hari = ((int)$diff->y * 365) + ((int)$diff->m * 30) + (int)$diff->d;

            $model->id_mapping_pembayaran = $hasilcek;
            $model->checkout = date('Y-m-d');
            $model->durasi = (string)($model->durasi-$sisa_hari);
            $model->harga =  (string)($ambilDatatamu[0]['harga'] * $model->durasi);
            $model->status = 0;
            // $que1 = MMappingKamar::find()->where(['id'=>$idttamu])->asArray()->one();
            ///

            $kembalian = $ambilDatatamu[0]['harga'] * $sisa_hari;

            $durasi = $_POST['TTamu']['durasi'];
            $modelPengunjung = new TTamu();
            $modelPengunjung->id_biodata_tamu = $ambilDatatamu[0]['id_biodata_tamu'];
            $modelPengunjung->id_mapping_kamar = $_POST['TTamu']['list_kamar'];
            $modelPengunjung->id_mapping_pembayaran = $hasilcek;
            $modelPengunjung->checkin = $_POST['TTamu']['checkin'];
            $modelPengunjung->checkout = $_POST['TTamu']['checkout'];
            $modelPengunjung->harga = $_POST['TTamu']['subtotalkamar'];
            $modelPengunjung->status = 1;
            $modelPengunjung->durasi = str_replace('Hari', '',$durasi);
            $modelPengunjung->no_kartu_debit = $model->no_kartu_debit;
            $modelPengunjung->created_date_cekin = date('Y-m-d H:i:s');
            $modelPengunjung->created_by_cekin = \Yii::$app->user->identity->nama;
            // var_dump($kembalian);exit;
            if($modelPengunjung->save()){
                MMappingKamar::updateAll(['status' => 'terisi', ], ['nomor_kamar' => $_POST['TTamu']['nomor_kamar']]);
            }
            if($model->save()){
                $model2 = SummaryTtamu::find()->where(['id_transaksi_tamu' => $ambilDatatamu[0]['id_biodata_tamu']])->one();
                if($ambilDatatamu[0]['jenis'] == 'lunas'){
                    $model2->total_bayar = $model2->total_harga;
                    $model2->dp = $model2->total_harga;
                    // $model2->dp = (string)((int)$model2->total_harga+$kembalian);
                }
                $model2->total_harga =  (string)(((int)$model2->total_harga + $_POST['TTamu']['subtotalkamar'])- $model->harga);
                $model2->sisa = (string)((int)$model2->total_harga - $model2->dp);
                if($model2->save()){
                    if( (empty($model2->sisa)) && ($model2->total_bayar == $model2->total_harga) ){
                        // echo"masuk1";exit;
                        TTamu::updateAll(['id_mapping_pembayaran' => '1' ], ['id_biodata_tamu' => $idbio]);
                    } else {
                        // echo"masuk2";exit;
                        TTamu::updateAll(['id_mapping_pembayaran' => $hasilcek ], ['id_biodata_tamu' => $idbio]);
                    }
                }
            }
            MMappingKamar::updateAll(['status' => 'tersedia', ], ['nomor_kamar' => $ambilDatatamu[0]['nomor_kamar']]);
            $hasil = array(
                'status' => "success",
                'header' => "Berhasil",
                'message' => "Checkin Berhasil Diproses !",
                'idttamu' => $idttamu,
                'cek1' => $model->getErrors(),
                'cek2' => @$model2->getErrors()

            );
            echo json_encode($hasil);
        }
    }

    public function actionSimpanbed()
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;

        $request = Yii::$app->request;
        $get = $request->get();
        if ($get) {
            $idbiodata = $get['idbiodata'];
            $idkamar = $get['idkamar'];
            $tipe = $get['tipe'];
            $hasilsisa = $get['hasilsisa'];
            $hasiltotharga = $get['hasiltotharga'];

            $idttamu = $idkamar.','.$tipe;
            $cekbiodatatamu =  TTamu::find()->where(['id_biodata_tamu' => $idbiodata])->asArray()->one();

            $hargabed = MMappingHarga::find()->where(['id_kategori_harga' => $tipe, 'id_type' => 5])->asArray()->one();
            $resultbed = $hargabed['id'];

            $modelTbed = new TBed();
            $modelTbed->id_biodata_tamu = $cekbiodatatamu['id_biodata_tamu'];
            $modelTbed->id_petugas = Yii::$app->user->identity->id_petugas;
            $modelTbed->id_mapping_harga = $resultbed;
            $modelTbed->qty_bed = $get['nmjmlbed'];
            $modelTbed->harga_bed = $get['hargabed'];

            if($modelTbed->save()) {
                $cekSummarytamu = SummaryTtamu::find()->where(['id_transaksi_tamu' => $idbiodata])->asArray()->one();
                $ceksisa = $cekSummarytamu['sisa'];
                $cekTotBayar = $cekSummarytamu['total_bayar'];

                $cektamu = TTamu::find()->where(['id_biodata_tamu' => $idbiodata])->asArray()->all();

                if($hasilsisa != $ceksisa) {
                    $modelSummaryttamu = SummaryTtamu::find()->where(['id_transaksi_tamu' => $idbiodata])->one();
                    $modelSummaryttamu->total_bayar = 0;
                    $modelSummaryttamu->dp = $hasiltotharga - $hasilsisa;
                    $modelSummaryttamu->total_harga = $hasiltotharga;
                    $modelSummaryttamu->sisa = $hasilsisa;
                    // $modelSummaryttamu->dp = $cekTotBayar;
                    $modelSummaryttamu->save(false);

                    foreach ($cektamu as $value) {
                        $modelTtamu = TTamu::find()->where(['id' => $value['id']])->one();
                        $modelTtamu->id_mapping_pembayaran = 3;
                        $modelTtamu->save(false);
                    }
                }



                $hasil = array(
                    'status' => "success",
                    'header' => "Berhasil",
                    'message' => "Extrabed Berhasil Diproses !",
                    'setharga' => $tipe,
                    'idttamu' => $idttamu,
                    'flag' => 'preview'
                );

                //  var_dump($cekbiodatatamu);exit;
                echo json_encode($hasil);
                die();
            } else {
                $modelTbed->errors();
            }

        }
    }

}
