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
use app\models\TTamu;
use yii\helpers\ArrayHelper;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Border;
use app\models\TBed;
use app\models\MMappingHarga;

class ReportController extends \yii\web\Controller
{
    public $user = null;
    public $notLogin = false;
    public $enableCsrfValidation = false;

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
        $model = new TTamu();
        $idharga = !empty($_GET['idharga']) ? $_GET['idharga'] : 1;
        $session = Yii::$app->session;
        $session->set('idharga', $idharga);
        $getsessionharga = $session->get('idharga');
        // var_dump($getsessionharga);exit;
        $sumSummarytamu = 0;
        $petugas = Yii::$app->user->identity->id_petugas;
        $idshift = Yii::$app->user->identity->id_shift;
        $iduser = Yii::$app->user->identity->id_user;
        $roleuser = Yii::$app->user->identity->role;

        $modelShift = MShift::find()->where(['id'=>$idshift])->asArray()->one();
        $Summarytamupendapatan = Logic::grandtotalPendapatan($petugas);
        $Summarytamupengeluaran = Logic::grandtotalPengeluaran($petugas);
        $resultGrandtotal = $Summarytamupendapatan - $Summarytamupengeluaran;
        $namapetugas = TPetugas::find()->where(['id_user' => $iduser])->orderBy(['id' => SORT_DESC])->asArray()->one();
        $user = Users::find()->where(['id' => $namapetugas['id_user']])->asArray()->one();

        $mShift=MShift::find()->where('id NOT IN(4)')->all();
        $listShift=ArrayHelper::map($mShift,'id','nm_shift');
        // var_dump($user['nama']);exit;
        return $this->render('index', [
            'idpetugas' => $petugas,
            'modelShift' => $modelShift,
            'Summarytamupendapatan' => $Summarytamupendapatan,
            'Summarytamupengeluaran' => $Summarytamupengeluaran,
            'resultGrandtotal' => $resultGrandtotal,
            'user' => $user,
            'model' => $model,
            'getsessionharga' => $getsessionharga,
            'roleuser' => $roleuser,
            'listShift' => $listShift
        ]);
    }

    public function actionIndexall()
    {
        $model = new TTamu();
        $idharga = !empty($_GET['idharga']) ? $_GET['idharga'] : 1;
        $session = Yii::$app->session;
        $session->set('idharga', $idharga);
        $getsessionharga = $session->get('idharga');

        $petugas = '';

        $Summarytamupendapatan = Logic::grandtotalPendapatan($petugas);
        $Summarytamupengeluaran = Logic::grandtotalPengeluaran($petugas);
        $resultGrandtotal = $Summarytamupendapatan - $Summarytamupengeluaran;

        return $this->render('indexAll', [
            'model' => $model,
            'posting'=>'all',
            'getsessionharga' => $getsessionharga,
            'Summarytamupendapatan' => $Summarytamupendapatan,
            'Summarytamupengeluaran' => $Summarytamupengeluaran,
            'resultGrandtotal' => $resultGrandtotal
        ]);
    }

    public function actionListreportall()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $post = Yii::$app->request->post();
        $ambilPosting = $post['TTamu'];
        $poststartdate = $ambilPosting['startdate'];
        $postenddate = $ambilPosting['enddate'];
        if( !empty($poststartdate) && !empty($postenddate) ){
            $joinposting = $poststartdate.','.$postenddate;
        } else {
            $joinposting = 'all';
        }

        if(!empty($joinposting)){

            $hasil = array(
                'status' => "success",
                'joinposting' => $joinposting
            );
        }
        echo json_encode($hasil);
        die();
    }

    public function actionListreportfo()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $post = Yii::$app->request->post();
        // var_dump($post);exit;
        $ambilPosting = $post['TTamu'];

        $poststartdate = $ambilPosting['startdate'];
        $date1=date_create($poststartdate);
        $resStartdate = date_format($date1,"d-m-Y");

        $postenddate = $ambilPosting['enddate'];
        $date2=date_create($postenddate);
        $resEnddate = date_format($date2,"d-m-Y");

        $pilihshift = !empty($ambilPosting['id_shift']) ? $ambilPosting['id_shift'] : "";
        $modShift = MShift::find()->where(['id' => $pilihshift])->asArray()->one();
        $resNmshift = $modShift['nm_shift'];
        $resStartshift = $modShift['start_date'];
        $resEndshift = $modShift['end_date'];

        if( !empty($poststartdate) && !empty($postenddate) ){
            if(!empty($pilihshift)) {
                $joinposting = $poststartdate.','.$postenddate.','.$pilihshift;
            } else {
                $joinposting = $poststartdate.','.$postenddate;
            }
        } else {
            $joinposting = 'all';
        }

        if(!empty($joinposting)){

            $hasil = array(
                'status' => "success",
                'joinposting' => $joinposting,
                'resStartdate' => $resStartdate,
                'resEnddate' => $resEnddate,
                'pilihshift' => $pilihshift,
                'resNmshift' => $resNmshift,
                'resStartshift' => $resStartshift,
                'resEndshift' => $resEndshift
            );
        }
        echo json_encode($hasil);
        die();
    }

    public function actionGetdatareportall() {
        if(Yii::$app->request->isAjax)
        {
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $get = Yii::$app->request->get();
            $getPosting = $get['posting'];

            $data = \app\components\Logic::reportAll($getPosting);
            // var_dump($data);exit;
            $row = array();
            $i = 0;
            $no = 1;
            foreach ($data as $idx => $value) {
                //Asiign All Value To Row
                foreach ($value as $key => $val) {
                    $row[$i][$key] = $val;
                }
                $row[$i]['no'] = $no++;
                $row[$i]['nama_petugas'] = $value['nama_petugas'];
                $row[$i]['pembayaran'] = $value['pembayaran'];
                $row[$i]['status_pembayaran'] = $value['status_pembayaran'];
                $row[$i]['tgl_uangmasuk'] = $value['tgl_uangmasuk'];
                $row[$i]['jml_uangmasuk'] = \app\components\Logic::formatNumber($value['jml_uangmasuk'], 0);


                $i++;
                // $no++;
            }
            $hasil['data'] = $row;
                // var_dump($hasil);exit();
            return $hasil;
        }
    }

    public function actionGetdatareportfo() {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $get = Yii::$app->request->get();
        $getPosting = $get['posting'];
        $getidpetugas = \Yii::$app->user->identity->id_petugas;
        $getiduser = \Yii::$app->user->identity->id_user;

        $data = \app\components\Logic::reportPetugas($getPosting,$getidpetugas,$getiduser);

        $row = array();
        $i = 0;
        $no = 1;
        foreach ($data as $idx => $value) {
            foreach ($value as $key => $val) {
                $row[$i][$key] = $val;
            }
            $row[$i]['no'] = $no++;
            $row[$i]['nama_tamu'] = $value['nama_tamu'];
            $row[$i]['jenis_pembayaran'] = $value['jenis_pembayaran'];
            $row[$i]['metode_pembayaran'] = $value['metode_pembayaran'];
            $row[$i]['jml_uangmasuk'] = \app\components\Logic::formatNumber($value['jml_uangmasuk'], 0);

            $row[$i]['fungsi'] = "
            <button onclick='detail(\"" . $value['id_transaksi_tamu'] . "\")' type='button' rel='tooltip' data-toggle='tooltip' title='Detail Data Tamu' class='btn btn-sm btn-primary'><i class='fa fa-list'></i></button>
            ";


            $i++;
        }
        $hasil['data'] = $row;
        return $hasil;
    }

    public function actionGetdatareportfopengeluaran() {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $get = Yii::$app->request->get();
        $getPosting = $get['posting'];
        $getidpetugas = \Yii::$app->user->identity->id_petugas;
        $getiduser = \Yii::$app->user->identity->id_user;

        $data = \app\components\Logic::reportPetugaspengeluaran($getPosting,$getidpetugas,$getiduser);
        // var_dump($data);exit;
        $row = array();
        $i = 0;
        $no = 1;
        foreach ($data as $idx => $value) {
            foreach ($value as $key => $val) {
                $row[$i][$key] = $val;
            }
            $row[$i]['no'] = $no++;
            $row[$i]['item'] = $value['item'];
            $row[$i]['qty'] = $value['qty'];
            $row[$i]['harga_per_item'] = \app\components\Logic::formatNumber($value['harga_per_item'], 0);
            $row[$i]['total_harga_item'] = \app\components\Logic::formatNumber($value['total_harga_item'], 0);

            $i++;
        }
        $hasil['data'] = $row;
        return $hasil;
    }

    public function actionGetdatareportfopengeluaranspec() {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $get = Yii::$app->request->get();
        $getPosting = $get['posting'];

        $data = \app\components\Logic::reportPetugaspengeluaranspec($getPosting);
        // var_dump($data);exit;
        $row = array();
        $i = 0;
        $no = 1;
        foreach ($data as $idx => $value) {
            foreach ($value as $key => $val) {
                $row[$i][$key] = $val;
            }
            $row[$i]['no'] = $no++;
            $row[$i]['item'] = $value['item'];
            $row[$i]['qty'] = $value['qty'];
            $row[$i]['harga_per_item'] = \app\components\Logic::formatNumber($value['harga_per_item'], 0);
            $row[$i]['total_harga_item'] = \app\components\Logic::formatNumber($value['total_harga_item'], 0);

            $i++;
        }
        $hasil['data'] = $row;
        return $hasil;
    }

    public function actionGetdatapendapatan($idpetugas,$idharga) {
        if(Yii::$app->request->isAjax)
        {
            \Yii::$app->response->format = Response::FORMAT_JSON;
            $param1 = date('Y-m-d');
            $param2 = date('Y-m-d');
            $data = \app\components\Logic::reportFo($idpetugas,$param1,$param2);
            $row = array();
            $i = 0;
            $no = 1;
            foreach ($data as $idx => $value) {
                //Asiign All Value To Row
                foreach ($value as $key => $val) {
                    $row[$i][$key] = $val;
                }
                $row[$i]['no'] = $no++;
                $row[$i]['nama_tamu'] = $value['nama_tamu'];
                $row[$i]['jenis_pembayaran'] = $value['jenis_pembayaran'];
                $row[$i]['metode_pembayaran'] = $value['metode_pembayaran'];
                $row[$i]['tgl_uangmasuk'] = $value['tgl_uangmasuk'];
                $row[$i]['jml_uangmasuk'] = \app\components\Logic::formatNumber($value['jml_uangmasuk'], 0);

                $row[$i]['fungsi'] = "
                <button onclick='detail(\"" . $value['id_transaksi_tamu'] . "\",\"".$idharga."\")' type='button' rel='tooltip' data-toggle='tooltip' title='Detail Data Tamu' class='btn btn-sm btn-primary'><i class='fa fa-list'></i></button>
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
            $param1 = !empty(date('Y-m-d')) ? date('Y-m-d') : '';
            $param2 = !empty(date('Y-m-d')) ? date('Y-m-d') : '';
            $data = \app\components\Logic::reportFopengeluaran($idpetugas,$param1,$param2);
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
                $row[$i]['tgl_uangkeluar'] = $value['tgl_uangkeluar'];
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

    public function actionDetsubtotal($idtranstamu,$idharga) {
        $hargabed = MMappingHarga::find()->where(['id_kategori_harga' => $idharga, 'id_type' => 5])->asArray()->one();
        $resultbed = $hargabed['harga'];

        $cektbed = TBed::find()->where([
            'id_biodata_tamu' => $idtranstamu
        ])
        ->asArray()
        ->one();

        return $this->renderPartial('detailsubtotal', [
        'idtranstamu' => $idtranstamu,
        'cektbed' => $cektbed,
        'resultbed' => $resultbed
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
                        $modelPengeluaran->id_user = \Yii::$app->user->identity->id_user;
                        $modelPengeluaran->tgl_uangkeluar = date('Y-m-d');
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
                $row[$i]['durasi'] = $value['durasi']." Hari";
                $row[$i]['nomor_kamar'] = $value['nomor_kamar'];
                $row[$i]['type'] = $value['type'];
                $row[$i]['harga_kamar'] = \app\components\Logic::formatNumber($value['harga_kamar'], 0);
                $row[$i]['biaya_sewa_perkamar'] = \app\components\Logic::formatNumber($value['biaya_sewa_perkamar'], 0);;


                $i++;
            }
            $hasil['data'] = $row;
            return $hasil;
        }
    }

    public function actionDownloadreportall()
    {
        $path = Yii::getAlias('@app') .
                DIRECTORY_SEPARATOR .
                'web' .
                DIRECTORY_SEPARATOR .
                'download' .
                DIRECTORY_SEPARATOR;

        $filename = 'report_all-' . date('Y-m-d') . '.xls';

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $roleuser = Yii::$app->user->identity->role;
        $post = Yii::$app->request->post();
        $poststartdate = $post['start'];
        $date1=date_create($poststartdate);
        $resStartdate = date_format($date1,"d-m-Y");

        $postenddate = $post['end'];
        $date2=date_create($postenddate);
        $resEnddate = date_format($date2,"d-m-Y");

        if( !empty($poststartdate) && !empty($postenddate) ){
            if(!empty($pilihshift)) {
                $getPosting = $poststartdate.','.$postenddate.','.$pilihshift;
            } else {
                $getPosting = $poststartdate.','.$postenddate;
            }
        } else {
            $getPosting = 'all';
        }
        $getidpetugas = \Yii::$app->user->identity->id_petugas;
        $getiduser = \Yii::$app->user->identity->id_user;
        // var_dump($getPosting);exit;

        $data = \app\components\Logic::reportAll($getPosting);
        $data3 = \app\components\Logic::reportPetugaspengeluaranspec($getPosting);

        if($roleuser == '2') {
            $htmlDetail ='
            <table>
            <tr>
                <td colspan=6 style="text-align: center;"><h3><strong>LAPORAN PENDAPATAN DAN PENGELUARAN. TANGGAL '.$resStartdate.' s/d '.$resEnddate.'</strong></h3></td>
            </tr>
            <tr>
                <td colspan=6 style="text-align: center;"></td>
            </tr>
            </table>
            ';

            $htmlPendapatan = '
            <table>
                <tr>
                    <td colspan=6 style="text-align: center;"><h3><strong>LAPORAN PENDAPATAN</strong></h3></td>
                </tr>
                <tr>
                    <td colspan=6 style="text-align: center;"></td>
                </tr>
            </table>
            <table border=1px>
                <thead>
                    <tr>
                        <td style="width: 5px; text-align: center;">NO</td>
                        <td style="width: 25px; text-align: center;">NAMA PETUGAS</td>
                        <td style="width: 10px; text-align: center;">JENIS PEMBAYARAN</td>
                        <td style="width: 10px; text-align: center;">STATUS PEMBAYARAN</td>
                        <td style="width: 20px; text-align: center;">TGL.UANG MASUK</td>
                        <td style="width: 20px; text-align: center;">JML.UANG MASUK</td>
                    </tr>
                </thead>
                <tbody>';
                $no=1;
                $totaluangmasuk=0;
                foreach ($data as $key => $val) {
                $htmlPendapatan .='<tr>
                        <td>'.$no.'</td>
                        <td>'.$val['nama_petugas'].'</td>
                        <td>'.$val['pembayaran'].'</td>
                        <td>'.$val['status_pembayaran'].'</td>
                        <td>'.$val['tgl_uangmasuk'].'</td>
                        <td>'.$val['jml_uangmasuk'].'</td>
                    </tr>';
                    $no++;

                    $totaluangmasuk += $val['jml_uangmasuk'];
                }
            $htmlPendapatan .= '
                </tbody>
                    <tr>
                        <td colspan=5 style="text-align: right;"><h3><strong>Total Uang Masuk :</strong></h3></td>
                        <td style="text-align: right;"><h3><strong>'.$totaluangmasuk.'</strong></h3></td>
                    </tr>
                    <tr>
                        <td></td>
                    </tr>
            </table>';

            $htmlPengeluaran = '
            <table>
                <tr>
                    <td colspan=6 style="text-align: center;"><h3><strong>LAPORAN PENGELUARAN</strong></h3></td>
                </tr>
                <tr>
                    <td colspan=6 style="text-align: center;"></td>
                </tr>
            </table>
            <table border=1px>
                <thead>
                    <tr>
                        <td style="width: 5px; text-align: center;">NO</td>
                        <td style="width: 25px; text-align: center;">NAMA ITEM</td>
                        <td style="width: 20px; text-align: center;">TGL.UANG KELUAR</td>
                        <td style="width: 20px; text-align: center;">QUANTITY</td>
                        <td style="width: 10px; text-align: center;">HARGA PER ITEM</td>
                        <td style="width: 20px; text-align: center;">TOTAL HARGA ITEM</td>
                    </tr>
                </thead>
                <tbody>';
                $no=1;
                $totaluangkeluar=0;
                foreach ($data3 as $key => $valu) {
                $htmlPengeluaran .='<tr>
                        <td>'.$no.'</td>
                        <td>'.$valu['item'].'</td>
                        <td>'.$valu['tgl_uangkeluar'].'</td>
                        <td>'.$valu['qty'].'</td>
                        <td>'.$valu['harga_per_item'].'</td>
                        <td>'.$valu['total_harga_item'].'</td>
                    </tr>';
                    $no++;

                    $totaluangkeluar += $valu['total_harga_item'];
                }
            $htmlPengeluaran .= '
                </tbody>
                    <tr>
                        <td colspan=5 style="text-align: right;"><h3><strong>Total Uang Keluar :</strong></h3></td>
                        <td style="text-align: right;"><h3><strong>'.$totaluangkeluar.'</strong></h3></td>
                    </tr>
            </table>';
            $totalsisa=0;
            $totalsisa = $totaluangmasuk - $totaluangkeluar;

            $htmlFooter = '
            <table>
                <tr>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                </tr>
            </table>
            <table border=1px>
                <tr>
                    <td></td>
                    <td>Jumlah Total Pendapatan</td>
                    <td>Rp. '.$totaluangmasuk.'</td>
                    <td></td>
                    <td></td>
                    <td style="text-align: center;"></td>
                </tr>
                <tr>
                    <td></td>
                    <td>Jumlah Total Pengeluaran</td>
                    <td>Rp. '.$totaluangkeluar.'</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td><strong>Total Bersih</strong></td>
                    <td><strong>Rp. '.$totalsisa.'</strong></td>
                    <td></td>
                    <td></td>
                    <td style="text-align: center;">Back Office</td>
                </tr>
            </table>';



            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Html();
            libxml_use_internal_errors(true);
            $spreadsheet = $reader->loadFromString($htmlDetail.$htmlPendapatan.$htmlPengeluaran.$htmlFooter);
            // var_dump($spreadsheet);exit;

            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xls');
            $writer->save($path.$filename);


            return [
                'success' => true,
                'message' => 'Report excel berhasil digenerate',
                'filename' => $filename
            ];
            exit;
        }
    }

    public function actionDownloadreportfo()
    {

        $path = Yii::getAlias('@app') .
                DIRECTORY_SEPARATOR .
                'web' .
                DIRECTORY_SEPARATOR .
                'download' .
                DIRECTORY_SEPARATOR;

        $filename = 'report_shift_fo-' . date('Y-m-d') . '.xls';

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $roleuser = Yii::$app->user->identity->role;
        $post = Yii::$app->request->post();
        // var_dump($post);exit;
        $poststartdate = $post['start'];
        $date1=date_create($poststartdate);
        $resStartdate = date_format($date1,"d-m-Y");

        $postenddate = $post['end'];
        $date2=date_create($postenddate);
        $resEnddate = date_format($date2,"d-m-Y");

        $postshift = !empty($post['shift']) ? $post['shift'] : "";

        $pilihshift = !empty($postshift) ? $postshift : "";
        $modShift = MShift::find()->where(['id' => $pilihshift])->asArray()->one();
        $resNmshift = !empty($modShift['nm_shift']) ? $modShift['nm_shift'] : "";
        $resStartshift = !empty($modShift['start_date']) ? $modShift['start_date'] : "00:00:00";
        $resEndshift = !empty($modShift['end_date']) ? $modShift['end_date'] : "00:00:00";
        $formattimestart = date('H:i:s', strtotime($resStartshift));
        $resFormattimestart = !empty($formattimestart) ? $formattimestart : "00:00:00";
        $formattimeend = date('H:i:s', strtotime($resEndshift));
        $resFormattimeend = !empty($formattimeend) ? $formattimeend : "00:00:00";

        if( !empty($poststartdate) && !empty($postenddate) ){
            if(!empty($pilihshift)) {
                $getPosting = $poststartdate.','.$postenddate.','.$pilihshift;
            } else {
                $getPosting = $poststartdate.','.$postenddate;
            }
        } else {
            $getPosting = 'all';
        }

        $getidpetugas = \Yii::$app->user->identity->id_petugas;
        $getiduser = \Yii::$app->user->identity->id_user;
        $getnmfo = \Yii::$app->user->identity->nama;


        $getshift = \Yii::$app->user->identity->nm_shift;
        $getstartdate = \Yii::$app->user->identity->start_date;
        $getenddate = \Yii::$app->user->identity->end_date;


        $data = \app\components\Logic::downloadReportpetugas($getPosting,$getidpetugas,$getiduser);
        $data2 = \app\components\Logic::reportPetugasnew($getPosting,$getidpetugas,$getiduser);
        $data3 = \app\components\Logic::reportPetugaspengeluaran($getPosting,$getidpetugas,$getiduser);
        // var_dump($data2);exit;

        if($roleuser == '1') {
            if($getPosting == 'all') {
                $htmlDetail = '
                    <table>
                    <tr>
                        <td colspan=11 style="text-align: center;"><h3><strong>LAPORAN PENDAPATAN DAN PENGELUARAN. TANGGAL '.date('d-m-Y').'</strong></h3></td>
                    </tr>
                    <tr>
                        <td colspan=11 style="text-align: center;"><h5>'.$getshift.' ('.$getstartdate.' - '.$getenddate.')</h5></td>
                    </tr>
                    </table>
                    ';
            } else {
                $htmlDetail ='
                    <table>
                    <tr>
                        <td colspan=11 style="text-align: center;"><h3><strong>LAPORAN PENDAPATAN DAN PENGELUARAN. TANGGAL '.date('d-m-Y').'</strong></h3></td>
                    </tr>
                    <tr>
                        <td colspan=11 style="text-align: center;"><h5>'.$resNmshift.' ('.$resFormattimestart.' - '.$resFormattimeend.')</h5></td>
                    </tr>
                    </table>
                    ';
                }
        } else {
            $htmlDetail ='
            <table>
            <tr>
                <td colspan=11 style="text-align: center;"><h3><strong>LAPORAN PENDAPATAN DAN PENGELUARAN. TANGGAL '.$resStartdate.' s/d '.$resEnddate.'</strong></h3></td>
            </tr>
            <tr>
                <td colspan=11 style="text-align: center;"><h5>'.$resNmshift.' ('.$formattimestart.' - '.$formattimeend.')</h5></td>
            </tr>
            </table>
            ';
        }

            // if($getPosting != 'all') {
            //     $htmlDetail .= '
            //     <tr>
            //         <td colspan=11 style="text-align: center;"></td>
            //     </tr>';
            // } else {
            //     $htmlDetail .= '
            //     <tr>
            //         <td colspan=11 style="text-align: center;"><h5>'.$resNmshift.' ('.$formattimestart.' - '.$formattimeend.')</h5></td>
            //     </tr>';
            // }
        $htmlDetail .= '
        <table border=1px>
            <thead>
                <tr>
                    <td style="width: 5px; text-align: center;" rowspan=2>NO</td>
                    <td style="width: 25px; text-align: center;" rowspan=2>NAMA TAMU</td>
                    <td style="width: 20px; text-align: center;" rowspan=2>CHECKIN</td>
                    <td style="width: 20px; text-align: center;" rowspan=2>CHECKOUT</td>
                    <td style="width: 10px; text-align: center;" rowspan=2>DURASI</td>
                    <td colspan=3 style="text-align: center;">KAMAR TERJUAL</td>
                    <td style="width: 28px; text-align: center;" rowspan=2>TOTAL PERKAMAR</td>
                    <td style="width: 20px; text-align: center;" rowspan=2>STATUS PEMBAYARAN</td>
                    <td style="width: 15px; text-align: center;" rowspan=2>KETERANGAN</td>
                </tr>
                <tr>
                    <td style="width: 10px; text-align: center;">NO.KAMAR</td>
                    <td style="width: 25px; text-align: center;">TYPE</td>
                    <td style="width: 25px; text-align: center;">HARGA</td>
                </tr>
            </thead>
            <tbody>';
                $no=1;
                foreach ($data as $key => $value) {
                $htmlDetail .='<tr>
                        <td>'.$no.'</td>
                        <td>'.$value['nama_tamu'].'</td>
                        <td>'.$value['checkin'].'</td>
                        <td>'.$value['checkout'].'</td>
                        <td>'.$value['durasi'].'</td>
                        <td>'.$value['nomor_kamar'].'</td>
                        <td>'.$value['type'].'</td>
                        <td>'.$value['harga_kamar'].'</td>
                        <td>'.$value['biaya_sewa_perkamar'].'</td>
                        <td>'.$value['status_pembayaran'].'</td>
                        <td>'.$value['metode_pembayaran'].'</td>
                    </tr>';
                    $no++;

                }
            $htmlDetail .= '</tbody>
        </table>
        <table>
            <tr>
                <td colspan=11 style="text-align: center;"></td>
            </tr>
        </table>';




        $htmlPendapatan = '
        <table>
            <tr>
                <td colspan=11 style="text-align: center;"><h3><strong>LAPORAN PENDAPATAN</strong></h3></td>
            </tr>
            <tr>
                <td colspan=11 style="text-align: center;"></td>
            </tr>
        </table>
        <table border=1px>
            <thead>
                <tr>
                    <td style="width: 5px; text-align: center;" rowspan=2>NO</td>
                    <td style="width: 25px; text-align: center;" rowspan=2>NAMA TAMU</td>
                    <td style="width: 10px; text-align: center;" rowspan=2>PEMBAYARAN</td>
                    <td style="width: 10px; text-align: center;" rowspan=2>STS.PEMBAYARAN</td>
                    <td colspan=3 style="text-align: center;">DETAIL RINCIAN TAGIHAN</td>
                    <td colspan=2 style="text-align: center;">DETAIL PEMBAYARAN</td>
                    <td style="width: 20px; text-align: center;" rowspan=2>TGL.UANG DITERIMA</td>
                    <td style="width: 20px; text-align: center;" rowspan=2>JML.UANG DITERIMA</td>
                </tr>
                <tr>
                    <td style="width: 10px; text-align: center;">TTL.KAMAR</td>
                    <td style="width: 25px; text-align: center;">TTL.EXTRABED</td>
                    <td style="width: 25px; text-align: center;">TTL.KESELURUHAN</td>
                    <td style="width: 10px; text-align: center;">BAYAR TAGIHAN</td>
                    <td style="width: 10px; text-align: center;">SISA TAGIHAN</td>
                </tr>
            </thead>
            <tbody>';
            $no=1;
            $totaluangmasuk=0;
            foreach ($data2 as $key => $val) {
            $htmlPendapatan .='<tr>
                    <td>'.$no.'</td>
                    <td>'.$val['nama_tamu'].'</td>
                    <td>'.$val['pembayaran'].'</td>
                    <td>'.$val['status_pembayaran'].'</td>
                    <td>'.$val['total_sewakamar'].'</td>
                    <td>'.$val['total_hargabed'].'</td>
                    <td>'.$val['total_keseluruhan'].'</td>
                    <td>'.$val['pembayaran_tagihan'].'</td>
                    <td>'.$val['sisa_tagihan'].'</td>
                    <td>'.$val['tgl_uang_diterima'].'</td>
                    <td>'.$val['jml_uang_diterima'].'</td>
                </tr>';
                $no++;

                $totaluangmasuk += $val['jml_uang_diterima'];
            }
        $htmlPendapatan .= '
            </tbody>
                <tr>
                    <td colspan=10 style="text-align: right;"><h3><strong>Total Uang Masuk :</strong></h3></td>
                    <td style="text-align: right;"><h3><strong>'.$totaluangmasuk.'</strong></h3></td>
                </tr>
                <tr>
                    <td></td>
                </tr>
        </table>';

        $htmlPengeluaran = '
        <table>
            <tr>
                <td colspan=11 style="text-align: center;"><h3><strong>LAPORAN PENGELUARAN</strong></h3></td>
            </tr>
            <tr>
                <td colspan=11 style="text-align: center;"></td>
            </tr>
        </table>
        <table border=1px>
            <thead>
                <tr>
                    <td style="width: 5px; text-align: center;">NO</td>
                    <td style="width: 25px; text-align: center;">NAMA ITEM</td>
                    <td style="width: 20px; text-align: center;" colspan=3>TGL.UANG KELUAR</td>
                    <td style="width: 20px; text-align: center;" colspan=2>QUANTITY</td>
                    <td style="width: 10px; text-align: center;" colspan=2>HARGA PER ITEM</td>
                    <td style="width: 20px; text-align: center;" colspan=2>TOTAL HARGA ITEM</td>
                </tr>
            </thead>
            <tbody>';
            $no=1;
            $totaluangkeluar=0;
            foreach ($data3 as $key => $valu) {
            $htmlPengeluaran .='<tr>
                    <td>'.$no.'</td>
                    <td>'.$valu['item'].'</td>
                    <td colspan=3>'.$valu['tgl_uangkeluar'].'</td>
                    <td colspan=2>'.$valu['qty'].'</td>
                    <td colspan=2>'.$valu['harga_per_item'].'</td>
                    <td colspan=2>'.$valu['total_harga_item'].'</td>
                </tr>';
                $no++;

                $totaluangkeluar += $valu['total_harga_item'];
            }
        $htmlPengeluaran .= '
            </tbody>
                <tr>
                    <td colspan=10 style="text-align: right;"><h3><strong>Total Uang Keluar :</strong></h3></td>
                    <td style="text-align: right;"><h3><strong>'.$totaluangkeluar.'</strong></h3></td>
                </tr>
        </table>';
        $totalsisa=0;
        $totalsisa = $totaluangmasuk - $totaluangkeluar;

        $htmlFooter = '
        <table>
            <tr>
                <td></td>
            </tr>
            <tr>
                <td></td>
            </tr>
            <tr>
                <td></td>
            </tr>
        </table>
        <table border=1px>
            <tr>
                <td></td>
                <td>Jumlah Total Pendapatan</td>
                <td>Rp. '.$totaluangmasuk.'</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td colspan=2 style="text-align: center;">'.$getnmfo.'</td>
            </tr>
            <tr>
                <td></td>
                <td>Jumlah Total Pengeluaran</td>
                <td>Rp. '.$totaluangkeluar.'</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td><strong>Jumlah Disetor</strong></td>
                <td><strong>Rp. '.$totalsisa.'</strong></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td colspan=2 style="text-align: center;">Petugas FO</td>
            </tr>
        </table>';



        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Html();
        libxml_use_internal_errors(true);
        $spreadsheet = $reader->loadFromString($htmlDetail.$htmlPendapatan.$htmlPengeluaran.$htmlFooter);
        // var_dump($spreadsheet);exit;

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xls');
        $writer->save($path.$filename);


        return [
            'success' => true,
            'message' => 'Report excel berhasil digenerate',
            'filename' => $filename
        ];
        exit;

        // var_dump($data);exit;
        // $spreadsheet = new Spreadsheet();
		// $spreadsheet->getProperties()
		// 	->setCreator('Hotel Millenia')
		// 	->setLastModifiedBy('Hotel Millenia')
		// 	->setTitle('Office 2007 XLSX Talent')
		// 	->setSubject('Office 2007 XLSX Talent')
		// 	->setDescription('')
		// 	->setKeywords('')
		// 	->setCategory('');
        //
        //
        //
        // // no
		// $spreadsheet->setActiveSheetIndex(0)->getColumnDimension('A')->setWidth(7);
        //
        // // namatamu
        // $spreadsheet->setActiveSheetIndex(0)->getColumnDimension('B')->setWidth(25);
        //
        // // cekin,cekout,durasi
        // $spreadsheet->setActiveSheetIndex(0)->getColumnDimension('C')->setWidth(15);
        // $spreadsheet->setActiveSheetIndex(0)->getColumnDimension('D')->setWidth(15);
        // $spreadsheet->setActiveSheetIndex(0)->getColumnDimension('E')->setWidth(12);
        //
        // // kamar terjual
        // $spreadsheet->setActiveSheetIndex(0)->getColumnDimension('F')->setWidth(15);
		// $spreadsheet->setActiveSheetIndex(0)->getColumnDimension('G')->setWidth(15);
		// $spreadsheet->setActiveSheetIndex(0)->getColumnDimension('H')->setWidth(15);
        //
        // // subtotal
        // $spreadsheet->setActiveSheetIndex(0)->getColumnDimension('I')->setWidth(23);
        //
        // // sts pembayaran
		// $spreadsheet->setActiveSheetIndex(0)->getColumnDimension('J')->setWidth(23);
        //
        // // keterangan
        // $spreadsheet->setActiveSheetIndex(0)->getColumnDimension('K')->setWidth(25);
        //
        // $spreadsheet->getActiveSheet()->getStyle("A3:K3")->getFont()->setBold(true);
        // $spreadsheet->getActiveSheet()->getStyle("A4:K4")->getFont()->setBold(true);
        //
        // $spreadsheet->setActiveSheetIndex(0)
        // ->setCellValue('A1', 'LAPORAN PENDAPATAN DAN PENGELUARAN. TANGGAL '  .$poststartdate.' s/d '.$postenddate);
        // $spreadsheet->setActiveSheetIndex(0)
        // ->setCellValue('A2',$getshift. ' (' .$getstartdate. ' - ' .$getenddate. ')');
        // $spreadsheet->setActiveSheetIndex(0)
		// 	->setCellValue('A3', 'NO')
		// 	->setCellValue('B3', 'NAMA TAMU')
		// 	->setCellValue('C3', 'CHECKIN')
		// 	->setCellValue('D3', 'CHECKOUT')
		// 	->setCellValue('E3', 'DURASI')
        //     ->setCellValue('F3', 'KAMAR TERJUAL')
        //     ->setCellValue('G3', '')
        //     ->setCellValue('H3', '')
        //     ->setCellValue('I3', 'TOTAL PERKAMAR')
        //     ->setCellValue('J3', 'STATUS PEMBAYARAN')
        //     ->setCellValue('K3', 'KETERANGAN');
        //
        // $spreadsheet->setActiveSheetIndex(0)
		// 	->setCellValue('A4', '')
		// 	->setCellValue('B4', '')
		// 	->setCellValue('C4', '')
		// 	->setCellValue('D4', '')
		// 	->setCellValue('E4', '')
        //     ->setCellValue('F4', 'NOMOR KAMAR')
        //     ->setCellValue('G4', 'TYPE KAMAR')
        //     ->setCellValue('H4', 'HARGA KAMAR')
        //     ->setCellValue('I4', '')
        //     ->setCellValue('J4', '')
        //     ->setCellValue('K4', '');
        //
        //     $row_start = 5;
        //     $count = 1;
        //
        //     $style = array(
        //         'borders' => array(
        //             'top' => array(
        //                 'borderStyle' => Border::BORDER_THIN,
        //                 'color' => array('argb' => 'FF000000'),
        //             ),
        //             'right' => array(
        //                 'borderStyle' => Border::BORDER_THIN,
        //                 'color' => array('argb' => 'FF000000'),
        //             ),
        //             'bottom' => array(
        //                 'borderStyle' => Border::BORDER_THIN,
        //                 'color' => array('argb' => 'FF000000'),
        //             ),
        //             'left' => array(
        //                 'borderStyle' => Border::BORDER_THIN,
        //                 'color' => array('argb' => 'FF000000'),
        //             ),
        //         ),
        //     );
        //
        //
        //
        // $spreadsheet->getActiveSheet()->getStyle('A3')->applyFromArray($style);
        // $spreadsheet->getActiveSheet()->getStyle('B3')->applyFromArray($style);
        // $spreadsheet->getActiveSheet()->getStyle('C3')->applyFromArray($style);
        // $spreadsheet->getActiveSheet()->getStyle('D3')->applyFromArray($style);
        // $spreadsheet->getActiveSheet()->getStyle('E3')->applyFromArray($style);
        // $spreadsheet->getActiveSheet()->getStyle('F3')->applyFromArray($style);
        // $spreadsheet->getActiveSheet()->getStyle('G3')->applyFromArray($style);
        // $spreadsheet->getActiveSheet()->getStyle('H3')->applyFromArray($style);
        // $spreadsheet->getActiveSheet()->getStyle('I3')->applyFromArray($style);
        // $spreadsheet->getActiveSheet()->getStyle('J3')->applyFromArray($style);
        // $spreadsheet->getActiveSheet()->getStyle('K3')->applyFromArray($style);
        //
        // $spreadsheet->getActiveSheet()->getStyle('A4')->applyFromArray($style);
        // $spreadsheet->getActiveSheet()->getStyle('B4')->applyFromArray($style);
        // $spreadsheet->getActiveSheet()->getStyle('C4')->applyFromArray($style);
        // $spreadsheet->getActiveSheet()->getStyle('D4')->applyFromArray($style);
        // $spreadsheet->getActiveSheet()->getStyle('E4')->applyFromArray($style);
        // $spreadsheet->getActiveSheet()->getStyle('F4')->applyFromArray($style);
        // $spreadsheet->getActiveSheet()->getStyle('G4')->applyFromArray($style);
        // $spreadsheet->getActiveSheet()->getStyle('H4')->applyFromArray($style);
        // $spreadsheet->getActiveSheet()->getStyle('I4')->applyFromArray($style);
        // $spreadsheet->getActiveSheet()->getStyle('J4')->applyFromArray($style);
        // $spreadsheet->getActiveSheet()->getStyle('K4')->applyFromArray($style);
        //
        // $spreadsheet->getActiveSheet()->mergeCells("A1:K1");
        // $spreadsheet->getActiveSheet()->getStyle('A1:K1')->getAlignment()->setHorizontal('center');
        //
        // $spreadsheet->getActiveSheet()->mergeCells("A2:K2");
        // $spreadsheet->getActiveSheet()->getStyle('A2:K2')->getAlignment()->setHorizontal('center');
        //
        // $spreadsheet->getActiveSheet()->mergeCells("A3:A4");
        // $spreadsheet->getActiveSheet()->getStyle('A3:A4')->getAlignment()->setVertical('center');
        // $spreadsheet->getActiveSheet()->getStyle('A3:A4')->getAlignment()->setHorizontal('center');
        // $spreadsheet->getActiveSheet()->mergeCells("B3:B4");
        // $spreadsheet->getActiveSheet()->getStyle('B3:B4')->getAlignment()->setVertical('center');
        // $spreadsheet->getActiveSheet()->getStyle('B3:B4')->getAlignment()->setHorizontal('center');
        // $spreadsheet->getActiveSheet()->mergeCells("C3:C4");
        // $spreadsheet->getActiveSheet()->getStyle('C3:C4')->getAlignment()->setVertical('center');
        // $spreadsheet->getActiveSheet()->getStyle('C3:C4')->getAlignment()->setHorizontal('center');
        // $spreadsheet->getActiveSheet()->mergeCells("D3:D4");
        // $spreadsheet->getActiveSheet()->getStyle('D3:D4')->getAlignment()->setVertical('center');
        // $spreadsheet->getActiveSheet()->getStyle('D3:D4')->getAlignment()->setHorizontal('center');
        // $spreadsheet->getActiveSheet()->mergeCells("E3:E4");
        // $spreadsheet->getActiveSheet()->getStyle('E3:E4')->getAlignment()->setVertical('center');
        // $spreadsheet->getActiveSheet()->getStyle('E3:E4')->getAlignment()->setHorizontal('center');
        // $spreadsheet->getActiveSheet()->mergeCells("F3:H3");
        // $spreadsheet->getActiveSheet()->getStyle('F3:H3')->getAlignment()->setHorizontal('center');
        //
        // $spreadsheet->getActiveSheet()->mergeCells("I3:I4");
        // $spreadsheet->getActiveSheet()->getStyle('I3:I4')->getAlignment()->setVertical('center');
        // $spreadsheet->getActiveSheet()->getStyle('I3:I4')->getAlignment()->setHorizontal('center');
        // $spreadsheet->getActiveSheet()->mergeCells("J3:J4");
        // $spreadsheet->getActiveSheet()->getStyle('J3:J4')->getAlignment()->setVertical('center');
        // $spreadsheet->getActiveSheet()->getStyle('J3:J4')->getAlignment()->setHorizontal('center');
        // $spreadsheet->getActiveSheet()->mergeCells("K3:K4");
        // $spreadsheet->getActiveSheet()->getStyle('K3:K4')->getAlignment()->setVertical('center');
        // $spreadsheet->getActiveSheet()->getStyle('K3:K4')->getAlignment()->setHorizontal('center');
        //
        //
        // foreach($data as $val) {
		// 	$spreadsheet->setActiveSheetIndex(0)
		// 	->setCellValue('A' . $row_start, $count)
		// 	->setCellValue('B' . $row_start, $val['nama_tamu'])
        //     ->setCellValue('C' . $row_start, $val['checkin'])
        //     ->setCellValue('D' . $row_start, $val['checkout'])
        //     ->setCellValue('E' . $row_start, $val['durasi'])
        //     ->setCellValue('F' . $row_start, $val['nomor_kamar'])
		// 	->setCellValue('G' . $row_start, $val['type'])
		// 	->setCellValue('H' . $row_start, $val['harga_kamar'])
        //     ->setCellValue('I' . $row_start, $val['biaya_sewa_perkamar'])
		// 	->setCellValue('J' . $row_start, $val['status_pembayaran'])
        //     ->setCellValue('K' . $row_start, $val['metode_pembayaran']);
        //
		// 	$spreadsheet->getActiveSheet()->getStyle('A' . $row_start)->applyFromArray($style);
		// 	$spreadsheet->getActiveSheet()->getStyle('B' . $row_start)->applyFromArray($style);
		// 	$spreadsheet->getActiveSheet()->getStyle('C' . $row_start)->applyFromArray($style);
		// 	$spreadsheet->getActiveSheet()->getStyle('D' . $row_start)->applyFromArray($style);
		// 	$spreadsheet->getActiveSheet()->getStyle('E' . $row_start)->applyFromArray($style);
        //     $spreadsheet->getActiveSheet()->getStyle('F' . $row_start)->applyFromArray($style);
        //     $spreadsheet->getActiveSheet()->getStyle('G' . $row_start)->applyFromArray($style);
        //     $spreadsheet->getActiveSheet()->getStyle('H' . $row_start)->applyFromArray($style);
        //     $spreadsheet->getActiveSheet()->getStyle('I' . $row_start)->applyFromArray($style);
        //     $spreadsheet->getActiveSheet()->getStyle('J' . $row_start)->applyFromArray($style);
        //     $spreadsheet->getActiveSheet()->getStyle('K' . $row_start)->applyFromArray($style);
		// 	$row_start++;
		// 	$count++;
		// }
        //
        // $spreadsheet->getActiveSheet()->setTitle('Detail Penjualan Kamar ');
		// $spreadsheet->setActiveSheetIndex(0);
        //
        //
        // // Sheet Laporan Pendapatan
        // $myWorkSheet = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, 'LAPORAN PENDAPATAN');
        // $spreadsheet->addSheet($myWorkSheet, 0);
        // $spreadsheet->getSheetByName('LAPORAN PENDAPATAN');
        //
		// $spreadsheet->setActiveSheetIndex(0)->getColumnDimension('A')->setWidth(7);
        // $spreadsheet->setActiveSheetIndex(0)->getColumnDimension('B')->setWidth(25);
        // $spreadsheet->setActiveSheetIndex(0)->getColumnDimension('C')->setWidth(25);
        // $spreadsheet->setActiveSheetIndex(0)->getColumnDimension('D')->setWidth(25);
        // $spreadsheet->setActiveSheetIndex(0)->getColumnDimension('E')->setWidth(25);
        // $spreadsheet->setActiveSheetIndex(0)->getColumnDimension('F')->setWidth(25);
        // $spreadsheet->getActiveSheet()->getStyle("A3:F3")->getFont()->setBold(true);
        //
        // $spreadsheet->setActiveSheetIndex(0)
        // ->setCellValue('A2', 'LAPORAN PENDAPATAN');
        //
        // $spreadsheet->setActiveSheetIndex(0)
		// 	->setCellValue('A3', 'NO')
		// 	->setCellValue('B3', 'NAMA TAMU')
		// 	->setCellValue('C3', 'KATEGORI PEMBAYARAN')
		// 	->setCellValue('D3', 'STATUS PEMBAYARAN')
		// 	->setCellValue('E3', 'TOTAL TAGIHAN')
        //     ->setCellValue('F3', 'JML.UANG DITERIMA');
        //
        //     $row_startz = 4;
        //     $countz = 1;
        //
        //     $style = array(
        //         'borders' => array(
        //             'top' => array(
        //                 'borderStyle' => Border::BORDER_THIN,
        //                 'color' => array('argb' => 'FF000000'),
        //             ),
        //             'right' => array(
        //                 'borderStyle' => Border::BORDER_THIN,
        //                 'color' => array('argb' => 'FF000000'),
        //             ),
        //             'bottom' => array(
        //                 'borderStyle' => Border::BORDER_THIN,
        //                 'color' => array('argb' => 'FF000000'),
        //             ),
        //             'left' => array(
        //                 'borderStyle' => Border::BORDER_THIN,
        //                 'color' => array('argb' => 'FF000000'),
        //             ),
        //         ),
        //     );
        //
        // $spreadsheet->getActiveSheet()->getStyle('A3')->applyFromArray($style);
        // $spreadsheet->getActiveSheet()->getStyle('B3')->applyFromArray($style);
        // $spreadsheet->getActiveSheet()->getStyle('C3')->applyFromArray($style);
        // $spreadsheet->getActiveSheet()->getStyle('D3')->applyFromArray($style);
        // $spreadsheet->getActiveSheet()->getStyle('E3')->applyFromArray($style);
        // $spreadsheet->getActiveSheet()->getStyle('F3')->applyFromArray($style);
        //
        // $spreadsheet->getActiveSheet()->mergeCells("A2:F2");
        // $spreadsheet->getActiveSheet()->getStyle('A2:F2')->getAlignment()->setHorizontal('center');
        //
        // foreach($data2 as $value) {
		// 	$spreadsheet->setActiveSheetIndex(0)
		// 	->setCellValue('A' . $row_startz, $countz)
		// 	->setCellValue('B' . $row_startz, $value['nama_tamu'])
        //     ->setCellValue('C' . $row_startz, $value['pembayaran'])
        //     ->setCellValue('D' . $row_startz, $value['status_pembayaran'])
        //     ->setCellValue('E' . $row_startz, $value['subtotal'])
        //     ->setCellValue('F' . $row_startz, $value['jml_uangmasuk']);
        //
        //     $spreadsheet->getActiveSheet()->getStyle('A' . $row_startz)->applyFromArray($style);
		// 	$spreadsheet->getActiveSheet()->getStyle('B' . $row_startz)->applyFromArray($style);
		// 	$spreadsheet->getActiveSheet()->getStyle('C' . $row_startz)->applyFromArray($style);
		// 	$spreadsheet->getActiveSheet()->getStyle('D' . $row_startz)->applyFromArray($style);
		// 	$spreadsheet->getActiveSheet()->getStyle('E' . $row_startz)->applyFromArray($style);
        //     $spreadsheet->getActiveSheet()->getStyle('F' . $row_startz)->applyFromArray($style);
		// 	$row_startz++;
		// 	$countz++;
		// }
        //
        //
        // // Sheet Laporan Pengeluaran
        // $myWorkSheet = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, 'LAPORAN PENGELUARAN');
        // $spreadsheet->addSheet($myWorkSheet, 0);
        // $spreadsheet->getSheetByName('LAPORAN PENGELUARAN');
        //
		// $spreadsheet->setActiveSheetIndex(0)->getColumnDimension('A')->setWidth(7);
        // $spreadsheet->setActiveSheetIndex(0)->getColumnDimension('B')->setWidth(25);
        // $spreadsheet->setActiveSheetIndex(0)->getColumnDimension('C')->setWidth(25);
        // $spreadsheet->setActiveSheetIndex(0)->getColumnDimension('D')->setWidth(25);
        // $spreadsheet->setActiveSheetIndex(0)->getColumnDimension('E')->setWidth(25);
        // $spreadsheet->setActiveSheetIndex(0)->getColumnDimension('F')->setWidth(25);
        // $spreadsheet->getActiveSheet()->getStyle("A3:F3")->getFont()->setBold(true);
        //
        // $spreadsheet->setActiveSheetIndex(0)
        // ->setCellValue('A2', 'LAPORAN PENGELUARAN');
        //
        // $spreadsheet->setActiveSheetIndex(0)
		// 	->setCellValue('A3', 'NO')
		// 	->setCellValue('B3', 'NAMA ITEM')
		// 	->setCellValue('C3', 'TGL.UANGKELUAR')
		// 	->setCellValue('D3', 'QUANTITY')
		// 	->setCellValue('E3', 'HARGA PER ITEM')
        //     ->setCellValue('F3', 'TOTAL HARGA ITEM');
        //
        //     $row_startx = 4;
        //     $countx = 1;
        //
        //     $style = array(
        //         'borders' => array(
        //             'top' => array(
        //                 'borderStyle' => Border::BORDER_THIN,
        //                 'color' => array('argb' => 'FF000000'),
        //             ),
        //             'right' => array(
        //                 'borderStyle' => Border::BORDER_THIN,
        //                 'color' => array('argb' => 'FF000000'),
        //             ),
        //             'bottom' => array(
        //                 'borderStyle' => Border::BORDER_THIN,
        //                 'color' => array('argb' => 'FF000000'),
        //             ),
        //             'left' => array(
        //                 'borderStyle' => Border::BORDER_THIN,
        //                 'color' => array('argb' => 'FF000000'),
        //             ),
        //         ),
        //     );
        //
        // $spreadsheet->getActiveSheet()->getStyle('A3')->applyFromArray($style);
        // $spreadsheet->getActiveSheet()->getStyle('B3')->applyFromArray($style);
        // $spreadsheet->getActiveSheet()->getStyle('C3')->applyFromArray($style);
        // $spreadsheet->getActiveSheet()->getStyle('D3')->applyFromArray($style);
        // $spreadsheet->getActiveSheet()->getStyle('E3')->applyFromArray($style);
        // $spreadsheet->getActiveSheet()->getStyle('F3')->applyFromArray($style);
        //
        // $spreadsheet->getActiveSheet()->mergeCells("A2:F2");
        // $spreadsheet->getActiveSheet()->getStyle('A2:F2')->getAlignment()->setHorizontal('center');
        //
        // foreach($data3 as $valu) {
		// 	$spreadsheet->setActiveSheetIndex(0)
		// 	->setCellValue('A' . $row_startx, $countx)
		// 	->setCellValue('B' . $row_startx, $valu['item'])
        //     ->setCellValue('C' . $row_startx, $valu['tgl_uangkeluar'])
        //     ->setCellValue('D' . $row_startx, $valu['qty'])
        //     ->setCellValue('E' . $row_startx, $valu['harga_per_item'])
        //     ->setCellValue('F' . $row_startx, $valu['total_harga_item']);
        //
        //     $spreadsheet->getActiveSheet()->getStyle('A' . $row_startx)->applyFromArray($style);
		// 	$spreadsheet->getActiveSheet()->getStyle('B' . $row_startx)->applyFromArray($style);
		// 	$spreadsheet->getActiveSheet()->getStyle('C' . $row_startx)->applyFromArray($style);
		// 	$spreadsheet->getActiveSheet()->getStyle('D' . $row_startx)->applyFromArray($style);
		// 	$spreadsheet->getActiveSheet()->getStyle('E' . $row_startx)->applyFromArray($style);
        //     $spreadsheet->getActiveSheet()->getStyle('F' . $row_startx)->applyFromArray($style);
		// 	$row_startx++;
		// 	$countx++;
		// }
        //
        //
		// header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		// header('Content-Disposition: attachment;filename="Laporan Shift FO.xlsx"');
		// header('Cache-Control: max-age=0');
		// header('Cache-Control: max-age=1');
		// header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
		// header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
		// header('Cache-Control: cache, must-revalidate');
		// header('Pragma: public');
        //
		// $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
		// $writer->save('php://output');
		// exit;
    }
}
