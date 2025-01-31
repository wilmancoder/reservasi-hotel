<?php namespace app\components;

use Yii;
use yii\base\Component;
use yii\helpers\Html;
use app\models\Users;
use app\models\SummaryTtamu;
use app\models\Ttamu;
use yii\web\Response;
use app\models\MShift;
use app\models\MMappingKamar;
use app\models\MKategoriHarga;
use app\models\MType;
use app\models\TBooking;
use app\models\TPetugas;
// use app\components\Query;

class Logic extends Component
{
    public static function arrKamar($id=null)
    {
        $model = [(new \yii\db\Query())]
            ->select(['a.id', 'a.nomor_kamar', 'a.status', 'c.type', 'd.kategori_harga', 'b.harga'])
            ->from('m_mapping_kamar a')
            ->join('INNER JOIN', 'm_mapping_harga b', 'b.id=a.id_mapping_harga')
            ->join('INNER JOIN', 'm_type c', 'c.id = b.id_type')
            ->join('INNER JOIN', 'm_kategori_harga d', 'd.id = b.id_kategori_harga')
            ->where('a.id NOT IN('.$id.')')
            ->andWhere(['<>', 'a.status', 'terisi'])
            ->groupBy('a.nomor_kamar')
            ->orderBy(['a.nomor_kamar' => SORT_ASC])
            ->all();

        $model2 = MMappingKamar::find()->where(['id' => $id])->asArray()->all();

        $data=[];
        foreach ($model as $key => $value) {
            foreach ($model2 as $idx => $val) {
                $data[$val['id']]="Kamar ".$val['nomor_kamar']. " / " .$value['type'];
            }
            $data[$value['id']]="Kamar ".$value['nomor_kamar']. " / " .$value['type'];
        }

        return $data;

    }

    // public static function arrKamar($id=null)
    // {
    //
    // }

    public static function arrKamarbooking()
    {
        $model = (new \yii\db\Query())
            ->select(['a.id', 'a.nomor_kamar', 'a.status', 'c.type', 'd.kategori_harga', 'b.harga', 'e.checkin', 'e.checkout'])
            ->from('m_mapping_kamar a')
            ->join('LEFT JOIN', 't_tamu e', 'e.id_mapping_kamar=a.id')
            ->join('INNER JOIN', 'm_mapping_harga b', 'b.id=a.id_mapping_harga')
            ->join('INNER JOIN', 'm_type c', 'c.id = b.id_type')
            ->join('INNER JOIN', 'm_kategori_harga d', 'd.id = b.id_kategori_harga')
            // ->andWhere(['<>', 'a.status', 'terisi'])
            ->groupBy('a.nomor_kamar')
            ->orderBy(['a.nomor_kamar' => SORT_ASC])
            ->all();

        $data=[];
        foreach ($model as $key => $value) {
            // $tgl = date('Y-m-d', strtotime($value['checkout']. ' + 1 days'));
            $tgl = !is_null($value['checkout']) ? $value['checkout'] : date("d-m-Y");
            $data[$value['id']]="Kamar ".$value['nomor_kamar']." / Tersedia Pada Tanggal : ".$tgl;
        }
        return $data;

    }

    public static function formatNumber($value, $dec = 0)
    {
        if(is_null($value) || empty($value)) return 0;
        return number_format($value,$dec,",",".");
    }

    public static function formatNumbertot($value, $dec = 0)
    {
        if(is_null($value) || empty($value)) return 0;
        return number_format($value,$dec,",",",");
    }

    public static function removeKoma($value)
    {
        return str_replace(",", "", $value);
    }

    public static function removeRpTitik($value)
    {
        $substring = substr($value,4);
        $stringreplace = str_replace(".", "", $substring);
        return $stringreplace;
    }

    public static function dataKamar($idharga=null,$status=null)
    {
        // if($status == "tersedia"){

            $model = (new \yii\db\Query())
            ->select(['a.id', 'a.status', 'a.nomor_kamar', 'c.type', 'b.id_kategori_harga', 'g.id_transaksi_tamu', 'e.id_mapping_kamar','e.checkout','e.checkin','f.nama','e.created_date_cekin'])
            ->from('m_mapping_kamar a')
            ->join('INNER JOIN', 'm_mapping_harga b', 'b.id=a.id_mapping_harga')
            ->join('INNER JOIN', 'm_type c', 'c.id = b.id_type')
            ->join('INNER JOIN', 'm_kategori_harga d', 'd.id = b.id_kategori_harga')
            ->join('INNER JOIN', 'm_mapping_kamar a2', 'a2.nomor_kamar = a.nomor_kamar and a2.id != a.id')
            ->join('LEFT JOIN', 't_tamu e', '(e.id_mapping_kamar = a.id OR e.id_mapping_kamar = a2.id) AND e.status = 1')
            ->join('LEFT JOIN', 'biodata_tamu f', 'f.id = e.id_biodata_tamu')
            ->join('LEFT JOIN', 'summary_ttamu g', 'g.id_transaksi_tamu = e.id_biodata_tamu')
            ->where('b.id_kategori_harga = :id_kategori_harga', [':id_kategori_harga' => $idharga])
            ->groupby(['a.nomor_kamar'])
            ->orderBy(['a.nomor_kamar' => SORT_ASC])
            ->all();

            // var_dump($model);exit;
        // } else {

            // $model2 = (new \yii\db\Query())
            // ->select(['b.id', 'b.status', 'b.nomor_kamar', 'd.type', 'c.id_kategori_harga', 'g.id_transaksi_tamu', 'a.id_mapping_kamar'])
            // ->from('t_tamu a')
            // ->join('INNER JOIN', 'm_mapping_kamar b', 'b.id=a.id_mapping_kamar')
            // ->join('INNER JOIN', 'm_mapping_harga c', 'c.id=b.id_mapping_harga')
            // ->join('INNER JOIN', 'm_type d', 'd.id = c.id_type')
            // // ->join('INNER JOIN', 'm_kategori_harga d', 'd.id = b.id_kategori_harga')
            // // ->join('LEFT JOIN', 't_tamu e', 'e.id_mapping_kamar = a.id')
            // // ->join('LEFT JOIN', 'biodata_tamu f', 'f.id = e.id_biodata_tamu')
            // ->where(['<>','c.id_kategori_harga',$idharga])
            // ->join('LEFT JOIN', 'summary_ttamu g', 'g.id_transaksi_tamu = a.id_biodata_tamu')
            // ->groupby(['b.nomor_kamar'])
            // ->orderBy(['b.nomor_kamar' => SORT_ASC])
            // ->all();
        // }

        // $hasil = array_merge($model,$model2);
        // var_dump($hasil);exit;

        return $model;
    }

    public static function dataTamu($idbiodata)
    {
        $model = (new \yii\db\Query())
            ->select(['a.id', 'a.id_mapping_kamar', 'a.id_biodata_tamu', 'a.checkin', 'a.checkout', 'a.durasi', 'a.harga as subtotal', 'a.no_kartu_debit', 'a.status', 'b.nama as namatamu', 'b.identitas', 'b.nomor_identitas', 'b.alamat', 'c.nomor_kamar', 'f.jenis', 'e.metode', 'g.harga', 'h.dp as summary_dp', 'h.sisa as summary_sisa', 'h.total_harga', 'h.total_bayar'])
            ->from('t_tamu a')
            ->join('LEFT JOIN', 'biodata_tamu b', 'b.id = a.id_biodata_tamu')
            ->join('INNER JOIN', 'm_mapping_kamar c', 'c.id = a.id_mapping_kamar')
            ->join('INNER JOIN', 'm_mapping_pembayaran d', 'd.id = a.id_mapping_pembayaran')
            ->join('INNER JOIN', 'm_metode_pembayaran e', 'e.id = d.id_metode_pembayaran')
            ->join('INNER JOIN', 'm_jenis_pembayaran f', 'f.id = d.id_jenis_pembayaran')
            ->join('LEFT JOIN', 'm_mapping_harga g', 'g.id = c.id_mapping_harga')
            ->join('LEFT JOIN', 'summary_ttamu h', 'h.id_transaksi_tamu = a.id_biodata_tamu')
            ->where(['a.id_biodata_tamu' => $idbiodata])
            ->all();

        return $model;
    }

    public static function dataTamusatuan($idbiodata)
    {
        $model = (new \yii\db\Query())
            ->select(['a.id', 'a.id_mapping_kamar', 'a.id_biodata_tamu', 'a.checkin', 'a.checkout', 'a.durasi', 'a.harga as subtotal', 'a.no_kartu_debit', 'a.status', 'b.nama as namatamu', 'b.identitas', 'b.nomor_identitas', 'b.alamat', 'c.nomor_kamar', 'f.jenis', 'e.metode', 'g.harga', 'h.dp as summary_dp', 'h.sisa as summary_sisa', 'h.total_harga', 'h.total_bayar'])
            ->from('t_tamu a')
            ->join('LEFT JOIN', 'biodata_tamu b', 'b.id = a.id_biodata_tamu')
            ->join('INNER JOIN', 'm_mapping_kamar c', 'c.id = a.id_mapping_kamar')
            ->join('INNER JOIN', 'm_mapping_pembayaran d', 'd.id = a.id_mapping_pembayaran')
            ->join('INNER JOIN', 'm_metode_pembayaran e', 'e.id = d.id_metode_pembayaran')
            ->join('INNER JOIN', 'm_jenis_pembayaran f', 'f.id = d.id_jenis_pembayaran')
            ->join('LEFT JOIN', 'm_mapping_harga g', 'g.id = c.id_mapping_harga')
            ->join('LEFT JOIN', 'summary_ttamu h', 'h.id_transaksi_tamu = a.id_biodata_tamu')
            ->where(['a.id_biodata_tamu' => $idbiodata])
            ->one();

        return $model;
    }


    public static function dataTamuOne($id)
    {
        $model = (new \yii\db\Query())
            ->select(['a.id', 'a.id_biodata_tamu', 'a.checkin', 'a.checkout', 'a.durasi', 'a.harga as subtotal', 'a.no_kartu_debit', 'a.status', 'b.nama as namatamu', 'b.identitas', 'b.nomor_identitas', 'b.alamat', 'c.nomor_kamar', 'f.jenis', 'e.metode', 'g.harga', 'h.dp as summary_dp', 'h.sisa as summary_sisa', 'h.total_harga', 'h.total_bayar'])
            ->from('t_tamu a')
            ->join('LEFT JOIN', 'biodata_tamu b', 'b.id = a.id_biodata_tamu')
            ->join('INNER JOIN', 'm_mapping_kamar c', 'c.id = a.id_mapping_kamar')
            ->join('INNER JOIN', 'm_mapping_pembayaran d', 'd.id = a.id_mapping_pembayaran')
            ->join('INNER JOIN', 'm_metode_pembayaran e', 'e.id = d.id_metode_pembayaran')
            ->join('INNER JOIN', 'm_jenis_pembayaran f', 'f.id = d.id_jenis_pembayaran')
            ->join('LEFT JOIN', 'm_mapping_harga g', 'g.id = c.id_mapping_harga')
            ->join('LEFT JOIN', 'summary_ttamu h', 'h.id_transaksi_tamu = a.id_biodata_tamu')
            ->where(['a.id' => $id])
            ->all();

        return $model;
    }

    public static function reportFo($idpetugas,$param1,$param2)
    {
        $model = (new \yii\db\Query())
        ->select(['a.tgl_uangmasuk', 'c.nomor_kamar', 'j.nama as nama_tamu', 'a.id_transaksi_tamu', 'a.keterangan', 'b.id_biodata_tamu', 'a.id_petugas', 'h.type', 'f.jenis as jenis_pembayaran', 'e.metode as metode_pembayaran', 'b.no_kartu_debit', 'b.checkin', 'b.checkout', 'b.durasi', 'g.harga as harga_kamar', 'b.harga as biaya_sewa_perkamar', 'i.total_harga as subtotal', 'a.jml_uangmasuk', 'a.pembayaran', 'a.status_pembayaran'])
        ->from('histori_summarytamu a')
        ->join('LEFT JOIN', 't_tamu b', 'b.id_biodata_tamu = a.id_transaksi_tamu')
        ->join('INNER JOIN', 'm_mapping_kamar c', 'c.id = b.id_mapping_kamar')
        ->join('INNER JOIN', 'm_mapping_pembayaran d', 'd.id = b.id_mapping_pembayaran')
        ->join('INNER JOIN', 'm_metode_pembayaran e', 'e.id = d.id_metode_pembayaran')
        ->join('INNER JOIN', 'm_jenis_pembayaran f', 'f.id = d.id_jenis_pembayaran')
        ->join('LEFT JOIN', 'm_mapping_harga g', 'g.id = c.id_mapping_harga')
        ->join('INNER JOIN', 'm_type h', 'h.id = g.id_type')
        ->join('INNER JOIN', 'summary_ttamu i', 'i.id_transaksi_tamu = a.id_transaksi_tamu')
        ->join('INNER JOIN', 'biodata_tamu j', 'j.id = b.id_biodata_tamu')
        ->where('a.tgl_uangmasuk BETWEEN :param1 AND :param2', [':param1' => $param1, ':param2' => $param2])
        ->andWhere('a.id_petugas = :id_petugas', [':id_petugas' => $idpetugas])
        ->groupBy('b.id_biodata_tamu')
        ->orderBy(['a.id_transaksi_tamu' => SORT_ASC])
        ->all();

        return $model;

    }

    public static function reportFopengeluaran($idpetugas,$param1,$param2)
    {
        if(!empty($idpetugas)) {
            $model = (new \yii\db\Query())
            ->select(['a.id', 'a.tgl_uangkeluar', 'a.id_user', 'a.item', 'a.qty', 'a.harga_per_item', 'a.total_harga_item'])
            ->from('t_pengeluaran_petugas a')
            ->where('a.tgl_uangkeluar BETWEEN :param1 AND :param2', [':param1' => $param1, 'param2' => $param2])
            ->andWhere('a.id_petugas = :id_petugas', [':id_petugas' => $idpetugas])
            ->orderBy(['a.id' => SORT_ASC])
            ->all();
            return $model;
        } else {
            $model = (new \yii\db\Query())
            ->select(['a.id', 'a.tgl_uangkeluar', 'a.id_user', 'a.item', 'a.qty', 'a.harga_per_item', 'a.total_harga_item'])
            ->from('t_pengeluaran_petugas a')
            ->orderBy(['a.id' => SORT_ASC])
            ->all();
            return $model;
        }

    }

    public static function reportBooking($idpetugas)
    {
        $model = (new \yii\db\Query())
        ->select(['c.nomor_kamar', 'a.id_transaksi_tamu', 'b.id_biodata_tamu', 'a.id_petugas', 'h.type', 'f.jenis as jenis_pembayaran', 'e.metode as metode_pembayaran', 'b.no_kartu_debit', 'b.checkin', 'b.checkout', 'b.durasi', 'g.harga as harga_kamar', 'b.harga as biaya_sewa_perkamar', 'a.total_harga as subtotal', 'b.created_date', 'b.created_by', 'i.nama as namatamu', 'i.identitas', 'i.nomor_identitas', 'i.nomor_kontak'])
        ->from('summary_booking a')
        ->join('LEFT JOIN', 't_booking b', 'b.id_biodata_tamu = a.id_transaksi_tamu')
        ->join('INNER JOIN', 'm_mapping_kamar c', 'c.id = b.id_mapping_kamar')
        ->join('INNER JOIN', 'm_mapping_pembayaran d', 'd.id = b.id_mapping_pembayaran')
        ->join('INNER JOIN', 'm_metode_pembayaran e', 'e.id = d.id_metode_pembayaran')
        ->join('INNER JOIN', 'm_jenis_pembayaran f', 'f.id = d.id_jenis_pembayaran')
        ->join('LEFT JOIN', 'm_mapping_harga g', 'g.id = c.id_mapping_harga')
        ->join('INNER JOIN', 'm_type h', 'h.id = g.id_type')
        ->join('INNER JOIN', 'biodata_tamu_booking i', 'i.id = a.id_transaksi_tamu')
        // ->where('a.id_petugas = :id_petugas', [':id_petugas' => $idpetugas])
        ->groupBy('b.id_biodata_tamu')
        // ->orderBy(['b.created_date' => SORT_ASC])
        ->all();

        return $model;

    }

    public static function reportAll($getPosting)
    {
        if($getPosting != 'all'){
            $exp = explode(',',$getPosting);
            $param1 = $exp[0];
            $param2 = $exp[1];

            $model = (new \yii\db\Query())
            ->select(['a.*', 'c.nama as nama_petugas'])
            ->from('histori_summarytamu a')
            ->join('INNER JOIN', 't_petugas b', 'b.id = a.id_petugas')
            ->join('INNER JOIN', 'users c', 'c.id = b.id_user')
            ->where('tgl_uangmasuk BETWEEN :param1 AND :param2', [':param1' => $param1, 'param2' => $param2])
            ->all();

            return $model;
        } else {
            $model = (new \yii\db\Query())
            ->select(['a.*', 'c.nama as nama_petugas'])
            ->from('histori_summarytamu a')
            ->join('INNER JOIN', 't_petugas b', 'b.id = a.id_petugas')
            ->join('INNER JOIN', 'users c', 'c.id = b.id_user')
            // ->where('tgl_uangmasuk BETWEEN :param1 AND :param2', [':param1' => $param1, 'param2' => $param2])
            ->all();

            return $model;
        }
    }

    public static function reportPetugasnew($getPosting,$getidpetugas,$getiduser)
    {
        $connection = Yii::$app->get('db');
        if($getPosting != 'all'){
            // echo"masuk1";exit;
            $exp = explode(',',$getPosting);
            $param1 = $exp[0];
            $param2 = $exp[1];
            $param3 = !empty($exp[2]) ? $exp[2] : "";

            if(empty($param3)) {
                $sql1 = '
                SELECT d.nama AS nama_tamu,
                    a.pembayaran,
                    a.status_pembayaran,
                    (SUM(IFNULL(ttl_kamar.harga,0))) AS total_sewakamar,
                    IFNULL(e.harga_bed,0) AS total_hargabed,
                    (SUM(IFNULL(ttl_kamar.harga,0)) + IFNULL(e.harga_bed,0)) AS total_keseluruhan,
                    b.jml_uangmasuk AS pembayaran_tagihan,
                    ( (SUM(IFNULL(ttl_kamar.harga,0)) + IFNULL(e.harga_bed,0)) - b.jml_uangmasuk ) AS sisa_tagihan,
                    a.tgl_uangmasuk AS tgl_uang_diterima,
                    IFNULL(a.jml_uangmasuk,0) AS jml_uang_diterima,
                    a.keterangan
                FROM histori_summarytamu a
                LEFT JOIN t_tamu ttl_kamar ON ttl_kamar.id_biodata_tamu = a.id_transaksi_tamu
                LEFT JOIN (
                    SELECT id_transaksi_tamu, jml_uangmasuk
                    FROM histori_summarytamu
                    WHERE pembayaran IN(\'PENUH\',\'DP\')
                ) AS b ON b.id_transaksi_tamu = a.id_transaksi_tamu
                INNER JOIN summary_ttamu c ON c.id_transaksi_tamu = a.id_transaksi_tamu
                INNER JOIN biodata_tamu d ON d.id = ttl_kamar.id_biodata_tamu
                LEFT JOIN t_bed e ON e.id_biodata_tamu = a.id_transaksi_tamu
                WHERE a.tgl_uangmasuk BETWEEN :param1 AND :param2 AND a.id_user = :id_user
                GROUP BY ttl_kamar.id_biodata_tamu
                ORDER BY a.id_transaksi_tamu ASC
                ';

                $command1 = $connection->createCommand($sql1);
                $command1->bindValue(":param1", $param1);
                $command1->bindValue(":param2", $param2);
                $command1->bindValue(":id_user", $getiduser);
                $result1 = $command1->queryAll();

                return $result1;
            } else {

                $cekshift = TPetugas::find()->where(['id_shift' => $param3])->asArray()->all();
                foreach ($cekshift as $key => $value) {
                    $result[] = $value['id'];
                }
                $impshift = implode(",",$result);

                $sql2 = '
                SELECT d.nama AS nama_tamu,
                    a.pembayaran,
                    a.status_pembayaran,
                    (SUM(IFNULL(ttl_kamar.harga,0))) AS total_sewakamar,
                    IFNULL(e.harga_bed,0) AS total_hargabed,
                    (SUM(IFNULL(ttl_kamar.harga,0)) + IFNULL(e.harga_bed,0)) AS total_keseluruhan,
                    b.jml_uangmasuk AS pembayaran_tagihan,
                    ( (SUM(IFNULL(ttl_kamar.harga,0)) + IFNULL(e.harga_bed,0)) - b.jml_uangmasuk ) AS sisa_tagihan,
                    a.tgl_uangmasuk AS tgl_uang_diterima,
                    IFNULL(a.jml_uangmasuk,0) AS jml_uang_diterima,
                    a.keterangan
                FROM histori_summarytamu a
                LEFT JOIN t_tamu ttl_kamar ON ttl_kamar.id_biodata_tamu = a.id_transaksi_tamu
                LEFT JOIN (
                    SELECT id_transaksi_tamu, jml_uangmasuk
                    FROM histori_summarytamu
                    WHERE pembayaran IN(\'PENUH\',\'DP\')
                ) AS b ON b.id_transaksi_tamu = a.id_transaksi_tamu
                INNER JOIN summary_ttamu c ON c.id_transaksi_tamu = a.id_transaksi_tamu
                INNER JOIN biodata_tamu d ON d.id = ttl_kamar.id_biodata_tamu
                LEFT JOIN t_bed e ON e.id_biodata_tamu = a.id_transaksi_tamu
                WHERE a.tgl_uangmasuk BETWEEN :param1 AND :param2 AND a.id_petugas IN('.$impshift.')
                GROUP BY ttl_kamar.id_biodata_tamu
                ORDER BY a.id_transaksi_tamu ASC
                ';

                $command2 = $connection->createCommand($sql2);
                $command2->bindValue(":param1", $param1);
                $command2->bindValue(":param2", $param2);
                $result2 = $command2->queryAll();

                return $result2;
            }
        } else {
            // echo"masuk2";exit;
            $sql3 = '
            SELECT d.nama AS nama_tamu,
                a.pembayaran,
                a.status_pembayaran,
                (SUM(IFNULL(ttl_kamar.harga,0))) AS total_sewakamar,
                IFNULL(e.harga_bed,0) AS total_hargabed,
                (SUM(IFNULL(ttl_kamar.harga,0)) + IFNULL(e.harga_bed,0)) AS total_keseluruhan,
                b.jml_uangmasuk AS pembayaran_tagihan,
                ( (SUM(IFNULL(ttl_kamar.harga,0)) + IFNULL(e.harga_bed,0)) - b.jml_uangmasuk ) AS sisa_tagihan,
                a.tgl_uangmasuk AS tgl_uang_diterima,
                IFNULL(a.jml_uangmasuk,0) AS jml_uang_diterima,
                a.keterangan
            FROM histori_summarytamu a
            LEFT JOIN t_tamu ttl_kamar ON ttl_kamar.id_biodata_tamu = a.id_transaksi_tamu
            LEFT JOIN (
                SELECT id_transaksi_tamu, jml_uangmasuk
                FROM histori_summarytamu
                WHERE pembayaran IN(\'PENUH\',\'DP\')
            ) AS b ON b.id_transaksi_tamu = a.id_transaksi_tamu
            INNER JOIN summary_ttamu c ON c.id_transaksi_tamu = a.id_transaksi_tamu
            INNER JOIN biodata_tamu d ON d.id = ttl_kamar.id_biodata_tamu
            LEFT JOIN t_bed e ON e.id_biodata_tamu = a.id_transaksi_tamu
            WHERE a.id_petugas = :id_petugas AND a.id_user = :id_user
            GROUP BY ttl_kamar.id_biodata_tamu
            ORDER BY a.id_transaksi_tamu ASC
            ';

            $command3 = $connection->createCommand($sql3);
            $command3->bindValue(":id_petugas", $getidpetugas);
            $command3->bindValue(":id_user", $getiduser);
            $result3 = $command3->queryAll();

            return $result3;
        }
    }

    public static function reportPetugas($getPosting,$getidpetugas,$getiduser)
    {
        if($getPosting != 'all'){
            $exp = explode(',',$getPosting);
            $param1 = $exp[0];
            $param2 = $exp[1];
            $param3 = !empty($exp[2]) ? $exp[2] : "";

            if(empty($param3)) {
                // echo"masuk1";exit;
                $model = (new \yii\db\Query())
                ->select(['a.keterangan', 'a.pembayaran', 'a.status_pembayaran', 'a.tgl_uangmasuk', 'l.nama as nama_user', 'm.nm_shift', 'c.nomor_kamar', 'j.nama as nama_tamu', 'a.id_transaksi_tamu', 'b.id_biodata_tamu', 'a.id_petugas', 'h.type', 'f.jenis as jenis_pembayaran', 'e.metode as metode_pembayaran', 'b.no_kartu_debit', 'b.checkin', 'b.checkout', 'b.durasi', 'g.harga as harga_kamar', 'b.harga as biaya_sewa_perkamar', 'i.total_harga as subtotal', 'i.sisa', 'a.jml_uangmasuk'])
                ->from('histori_summarytamu a')
                ->join('LEFT JOIN', 't_tamu b', 'b.id_biodata_tamu = a.id_transaksi_tamu')
                ->join('INNER JOIN', 'm_mapping_kamar c', 'c.id = b.id_mapping_kamar')
                ->join('INNER JOIN', 'm_mapping_pembayaran d', 'd.id = b.id_mapping_pembayaran')
                ->join('INNER JOIN', 'm_metode_pembayaran e', 'e.id = d.id_metode_pembayaran')
                ->join('INNER JOIN', 'm_jenis_pembayaran f', 'f.id = d.id_jenis_pembayaran')
                ->join('LEFT JOIN', 'm_mapping_harga g', 'g.id = c.id_mapping_harga')
                ->join('INNER JOIN', 'm_type h', 'h.id = g.id_type')
                ->join('INNER JOIN', 'summary_ttamu i', 'i.id_transaksi_tamu = a.id_transaksi_tamu')
                ->join('INNER JOIN', 'biodata_tamu j', 'j.id = b.id_biodata_tamu')
                ->join('INNER JOIN', 't_petugas k', 'k.id = a.id_petugas')
                ->join('INNER JOIN', 'users l', 'l.id = k.id_user')
                ->join('INNER JOIN', 'm_shift m', 'm.id = k.id_shift')
                ->where('a.tgl_uangmasuk BETWEEN :param1 AND :param2', [':param1' => $param1, 'param2' => $param2])
                ->andWhere('a.id_user = :id_user', [':id_user' => $getiduser])
                ->groupBy('b.id_biodata_tamu')
                ->orderBy(['a.id_transaksi_tamu' => SORT_ASC])
                ->all();

                return $model;
            } else {
                // echo"masuk2";exit;
                $cekshift = TPetugas::find()->where(['id_shift' => $param3])->asArray()->all();
                foreach ($cekshift as $key => $value) {
                    $result[] = $value['id'];
                }
                $impshift = implode(",",$result);
                // var_dump($impshift);exit;
                $model = (new \yii\db\Query())
                ->select(['a.keterangan', 'a.pembayaran', 'a.status_pembayaran', 'a.tgl_uangmasuk', 'l.nama as nama_user', 'm.nm_shift', 'c.nomor_kamar', 'j.nama as nama_tamu', 'a.id_transaksi_tamu', 'b.id_biodata_tamu', 'a.id_petugas', 'h.type', 'f.jenis as jenis_pembayaran', 'e.metode as metode_pembayaran', 'b.no_kartu_debit', 'b.checkin', 'b.checkout', 'b.durasi', 'g.harga as harga_kamar', 'b.harga as biaya_sewa_perkamar', 'i.total_harga as subtotal', 'i.sisa', 'a.jml_uangmasuk'])
                ->from('histori_summarytamu a')
                ->join('LEFT JOIN', 't_tamu b', 'b.id_biodata_tamu = a.id_transaksi_tamu')
                ->join('INNER JOIN', 'm_mapping_kamar c', 'c.id = b.id_mapping_kamar')
                ->join('INNER JOIN', 'm_mapping_pembayaran d', 'd.id = b.id_mapping_pembayaran')
                ->join('INNER JOIN', 'm_metode_pembayaran e', 'e.id = d.id_metode_pembayaran')
                ->join('INNER JOIN', 'm_jenis_pembayaran f', 'f.id = d.id_jenis_pembayaran')
                ->join('LEFT JOIN', 'm_mapping_harga g', 'g.id = c.id_mapping_harga')
                ->join('INNER JOIN', 'm_type h', 'h.id = g.id_type')
                ->join('INNER JOIN', 'summary_ttamu i', 'i.id_transaksi_tamu = a.id_transaksi_tamu')
                ->join('INNER JOIN', 'biodata_tamu j', 'j.id = b.id_biodata_tamu')
                ->join('INNER JOIN', 't_petugas k', 'k.id = a.id_petugas')
                ->join('INNER JOIN', 'users l', 'l.id = k.id_user')
                ->join('INNER JOIN', 'm_shift m', 'm.id = k.id_shift')
                ->where('a.tgl_uangmasuk BETWEEN :param1 AND :param2', [':param1' => $param1, 'param2' => $param2])
                ->andWhere('a.id_petugas IN('.$impshift.')')
                // ->andWhere('k.id_shift = :id_shift', [':id_shift' => $param3])
                ->groupBy('b.id_biodata_tamu')
                ->orderBy(['a.id_transaksi_tamu' => SORT_ASC])
                ->all();
                // var_dump($model);exit;
                return $model;
            }

        } else {
            $model = (new \yii\db\Query())
            ->select(['a.keterangan', 'a.pembayaran', 'a.status_pembayaran', 'a.tgl_uangmasuk', 'l.nama as nama_user', 'm.nm_shift', 'c.nomor_kamar', 'j.nama as nama_tamu', 'a.id_transaksi_tamu', 'b.id_biodata_tamu', 'a.id_petugas', 'h.type', 'f.jenis as jenis_pembayaran', 'e.metode as metode_pembayaran', 'b.no_kartu_debit', 'b.checkin', 'b.checkout', 'b.durasi', 'g.harga as harga_kamar', 'b.harga as biaya_sewa_perkamar', 'i.total_harga as subtotal', 'i.sisa', 'a.jml_uangmasuk'])
            ->from('histori_summarytamu a')
            ->join('LEFT JOIN', 't_tamu b', 'b.id_biodata_tamu = a.id_transaksi_tamu')
            ->join('INNER JOIN', 'm_mapping_kamar c', 'c.id = b.id_mapping_kamar')
            ->join('INNER JOIN', 'm_mapping_pembayaran d', 'd.id = b.id_mapping_pembayaran')
            ->join('INNER JOIN', 'm_metode_pembayaran e', 'e.id = d.id_metode_pembayaran')
            ->join('INNER JOIN', 'm_jenis_pembayaran f', 'f.id = d.id_jenis_pembayaran')
            ->join('LEFT JOIN', 'm_mapping_harga g', 'g.id = c.id_mapping_harga')
            ->join('INNER JOIN', 'm_type h', 'h.id = g.id_type')
            ->join('INNER JOIN', 'summary_ttamu i', 'i.id_transaksi_tamu = a.id_transaksi_tamu')
            ->join('INNER JOIN', 'biodata_tamu j', 'j.id = b.id_biodata_tamu')
            ->join('INNER JOIN', 't_petugas k', 'k.id = a.id_petugas')
            ->join('INNER JOIN', 'users l', 'l.id = k.id_user')
            ->join('INNER JOIN', 'm_shift m', 'm.id = k.id_shift')
            ->where('a.id_petugas = :id_petugas', [':id_petugas' => $getidpetugas])
            ->andWhere('a.id_user = :id_user', [':id_user' => $getiduser])
            ->groupBy('b.id_biodata_tamu')
            ->orderBy(['a.id_transaksi_tamu' => SORT_ASC])
            // ->where('tgl_uangmasuk BETWEEN :param1 AND :param2', [':param1' => $param1, 'param2' => $param2])
            ->all();

            return $model;
        }
    }

    public static function downloadReportpetugas($getPosting,$getidpetugas,$getiduser)
    {
        if($getPosting != 'all'){
            $exp = explode(',',$getPosting);
            $param1 = $exp[0];
            $param2 = $exp[1];
            $param3 = !empty($exp[2]) ? $exp[2] : "";

            if(empty($param3)) {
                $model = (new \yii\db\Query())
                ->select(['a.status_pembayaran', 'a.tgl_uangmasuk', 'l.nama as nama_user', 'm.nm_shift', 'c.nomor_kamar', 'j.nama as nama_tamu', 'a.id_transaksi_tamu', 'b.id_biodata_tamu', 'a.id_petugas', 'h.type', 'f.jenis as jenis_pembayaran', 'e.metode as metode_pembayaran', 'b.no_kartu_debit', 'b.checkin', 'b.checkout', 'b.durasi', 'g.harga as harga_kamar', 'b.harga as biaya_sewa_perkamar', 'i.total_harga as subtotal', 'a.jml_uangmasuk'])
                ->from('histori_summarytamu a')
                ->join('LEFT JOIN', 't_tamu b', 'b.id_biodata_tamu = a.id_transaksi_tamu')
                ->join('INNER JOIN', 'm_mapping_kamar c', 'c.id = b.id_mapping_kamar')
                ->join('INNER JOIN', 'm_mapping_pembayaran d', 'd.id = b.id_mapping_pembayaran')
                ->join('INNER JOIN', 'm_metode_pembayaran e', 'e.id = d.id_metode_pembayaran')
                ->join('INNER JOIN', 'm_jenis_pembayaran f', 'f.id = d.id_jenis_pembayaran')
                ->join('LEFT JOIN', 'm_mapping_harga g', 'g.id = c.id_mapping_harga')
                ->join('INNER JOIN', 'm_type h', 'h.id = g.id_type')
                ->join('INNER JOIN', 'summary_ttamu i', 'i.id_transaksi_tamu = a.id_transaksi_tamu')
                ->join('INNER JOIN', 'biodata_tamu j', 'j.id = b.id_biodata_tamu')
                ->join('INNER JOIN', 't_petugas k', 'k.id = a.id_petugas')
                ->join('INNER JOIN', 'users l', 'l.id = k.id_user')
                ->join('INNER JOIN', 'm_shift m', 'm.id = k.id_shift')
                ->where('a.tgl_uangmasuk BETWEEN :param1 AND :param2', [':param1' => $param1, 'param2' => $param2])
                ->andWhere('a.id_user = :id_user', [':id_user' => $getiduser])
                // ->groupBy('b.id_biodata_tamu')
                ->orderBy(['a.id_transaksi_tamu' => SORT_ASC])
                ->all();

                return $model;
            } else {
                // echo"masuk2";exit;
                $cekshift = TPetugas::find()->where(['id_shift' => $param3])->asArray()->all();
                foreach ($cekshift as $key => $value) {
                    $result[] = $value['id'];
                }
                $impshift = implode(",",$result);
                $model = (new \yii\db\Query())
                ->select(['a.status_pembayaran', 'a.tgl_uangmasuk', 'l.nama as nama_user', 'm.nm_shift', 'c.nomor_kamar', 'j.nama as nama_tamu', 'a.id_transaksi_tamu', 'b.id_biodata_tamu', 'a.id_petugas', 'h.type', 'f.jenis as jenis_pembayaran', 'e.metode as metode_pembayaran', 'b.no_kartu_debit', 'b.checkin', 'b.checkout', 'b.durasi', 'g.harga as harga_kamar', 'b.harga as biaya_sewa_perkamar', 'i.total_harga as subtotal', 'a.jml_uangmasuk'])
                ->from('histori_summarytamu a')
                ->join('LEFT JOIN', 't_tamu b', 'b.id_biodata_tamu = a.id_transaksi_tamu')
                ->join('INNER JOIN', 'm_mapping_kamar c', 'c.id = b.id_mapping_kamar')
                ->join('INNER JOIN', 'm_mapping_pembayaran d', 'd.id = b.id_mapping_pembayaran')
                ->join('INNER JOIN', 'm_metode_pembayaran e', 'e.id = d.id_metode_pembayaran')
                ->join('INNER JOIN', 'm_jenis_pembayaran f', 'f.id = d.id_jenis_pembayaran')
                ->join('LEFT JOIN', 'm_mapping_harga g', 'g.id = c.id_mapping_harga')
                ->join('INNER JOIN', 'm_type h', 'h.id = g.id_type')
                ->join('INNER JOIN', 'summary_ttamu i', 'i.id_transaksi_tamu = a.id_transaksi_tamu')
                ->join('INNER JOIN', 'biodata_tamu j', 'j.id = b.id_biodata_tamu')
                ->join('INNER JOIN', 't_petugas k', 'k.id = a.id_petugas')
                ->join('INNER JOIN', 'users l', 'l.id = k.id_user')
                ->join('INNER JOIN', 'm_shift m', 'm.id = k.id_shift')
                ->where('a.tgl_uangmasuk BETWEEN :param1 AND :param2', [':param1' => $param1, 'param2' => $param2])
                ->andWhere('a.id_petugas IN('.$impshift.')')
                // ->groupBy('b.id_biodata_tamu')
                ->orderBy(['a.id_transaksi_tamu' => SORT_ASC])
                ->all();

                return $model;
            }
        } else {
            $model = (new \yii\db\Query())
            ->select(['a.status_pembayaran', 'a.tgl_uangmasuk', 'l.nama as nama_user', 'm.nm_shift', 'c.nomor_kamar', 'j.nama as nama_tamu', 'a.id_transaksi_tamu', 'b.id_biodata_tamu', 'a.id_petugas', 'h.type', 'f.jenis as jenis_pembayaran', 'e.metode as metode_pembayaran', 'b.no_kartu_debit', 'b.checkin', 'b.checkout', 'b.durasi', 'g.harga as harga_kamar', 'b.harga as biaya_sewa_perkamar', 'i.total_harga as subtotal', 'a.jml_uangmasuk'])
            ->from('histori_summarytamu a')
            ->join('LEFT JOIN', 't_tamu b', 'b.id_biodata_tamu = a.id_transaksi_tamu')
            ->join('INNER JOIN', 'm_mapping_kamar c', 'c.id = b.id_mapping_kamar')
            ->join('INNER JOIN', 'm_mapping_pembayaran d', 'd.id = b.id_mapping_pembayaran')
            ->join('INNER JOIN', 'm_metode_pembayaran e', 'e.id = d.id_metode_pembayaran')
            ->join('INNER JOIN', 'm_jenis_pembayaran f', 'f.id = d.id_jenis_pembayaran')
            ->join('LEFT JOIN', 'm_mapping_harga g', 'g.id = c.id_mapping_harga')
            ->join('INNER JOIN', 'm_type h', 'h.id = g.id_type')
            ->join('INNER JOIN', 'summary_ttamu i', 'i.id_transaksi_tamu = a.id_transaksi_tamu')
            ->join('INNER JOIN', 'biodata_tamu j', 'j.id = b.id_biodata_tamu')
            ->join('INNER JOIN', 't_petugas k', 'k.id = a.id_petugas')
            ->join('INNER JOIN', 'users l', 'l.id = k.id_user')
            ->join('INNER JOIN', 'm_shift m', 'm.id = k.id_shift')
            ->where('a.id_petugas = :id_petugas', [':id_petugas' => $getidpetugas])
            ->andWhere('a.id_user = :id_user', [':id_user' => $getiduser])
            // ->groupBy('b.id_biodata_tamu')
            ->orderBy(['a.id_transaksi_tamu' => SORT_ASC])
            // ->where('tgl_uangmasuk BETWEEN :param1 AND :param2', [':param1' => $param1, 'param2' => $param2])
            ->all();

            return $model;
        }
    }

    public static function reportPetugaspengeluaran($getPosting,$getidpetugas,$getiduser)
    {
        if($getPosting != 'all'){
            $exp = explode(',',$getPosting);
            $param1 = $exp[0];
            $param2 = $exp[1];
            $param3 = !empty($exp[2]) ? $exp[2] : "";

            if(empty($param3)) {
                $model = (new \yii\db\Query())
                ->select(['a.id', 'a.tgl_uangkeluar', 'a.id_user', 'a.item', 'a.qty', 'a.harga_per_item', 'a.total_harga_item'])
                ->from('t_pengeluaran_petugas a')
                ->where('a.tgl_uangkeluar BETWEEN :param1 AND :param2', [':param1' => $param1, 'param2' => $param2])
                ->andWhere('a.id_user = :id_user', [':id_user' => $getiduser])
                ->orderBy(['a.id' => SORT_ASC])
                ->all();

                return $model;
            } else {
                $cekshift = TPetugas::find()->where(['id_shift' => $param3])->asArray()->all();
                foreach ($cekshift as $key => $value) {
                    $result[] = $value['id'];
                }
                $impshift = implode(",",$result);

                $model = (new \yii\db\Query())
                ->select(['a.id', 'a.tgl_uangkeluar', 'a.id_user', 'a.item', 'a.qty', 'a.harga_per_item', 'a.total_harga_item'])
                ->from('t_pengeluaran_petugas a')
                ->where('a.tgl_uangkeluar BETWEEN :param1 AND :param2', [':param1' => $param1, 'param2' => $param2])
                // ->andWhere('a.id_user = :id_user', [':id_user' => $getiduser])
                ->andWhere('a.id_petugas IN('.$impshift.')')
                ->orderBy(['a.id' => SORT_ASC])
                ->all();

                return $model;
            }
        } else {
            $model = (new \yii\db\Query())
            ->select(['a.id', 'a.tgl_uangkeluar', 'a.id_user', 'a.item', 'a.qty', 'a.harga_per_item', 'a.total_harga_item'])
            ->from('t_pengeluaran_petugas a')
            ->where('a.id_petugas = :id_petugas', [':id_petugas' => $getidpetugas])
            ->orderBy(['a.id' => SORT_ASC])
            ->all();

            return $model;
        }
    }

    public static function reportPetugaspengeluaranspec($getPosting)
    {
        if($getPosting != 'all'){
            $exp = explode(',',$getPosting);
            $param1 = $exp[0];
            $param2 = $exp[1];


            $model = (new \yii\db\Query())
            ->select(['a.id', 'a.tgl_uangkeluar', 'a.id_user', 'a.item', 'a.qty', 'a.harga_per_item', 'a.total_harga_item'])
            ->from('t_pengeluaran_petugas a')
            ->where('a.tgl_uangkeluar BETWEEN :param1 AND :param2', [':param1' => $param1, 'param2' => $param2])
            // ->andWhere('a.id_user = :id_user', [':id_user' => $getiduser])
            ->orderBy(['a.id' => SORT_ASC])
            ->all();

            return $model;

        } else {
            $model = (new \yii\db\Query())
            ->select(['a.id', 'a.tgl_uangkeluar', 'a.id_user', 'a.item', 'a.qty', 'a.harga_per_item', 'a.total_harga_item'])
            ->from('t_pengeluaran_petugas a')
            // ->where('a.id_petugas = :id_petugas', [':id_petugas' => $getidpetugas])
            ->orderBy(['a.id' => SORT_ASC])
            ->all();

            return $model;
        }
    }

    public static function detailreportFo($idtranstamu)
    {
        $model = (new \yii\db\Query())
        ->select(['c.nomor_kamar', 'a.id_transaksi_tamu', 'b.id_biodata_tamu', 'a.id_petugas', 'h.type', 'f.jenis as jenis_pembayaran', 'e.metode as metode_pembayaran', 'b.no_kartu_debit', 'b.checkin', 'b.checkout', 'b.durasi', 'g.harga as harga_kamar', 'b.harga as biaya_sewa_perkamar', 'a.total_harga as subtotal'])
        ->from('summary_ttamu a')
        ->join('LEFT JOIN', 't_tamu b', 'b.id_biodata_tamu = a.id_transaksi_tamu')
        ->join('INNER JOIN', 'm_mapping_kamar c', 'c.id = b.id_mapping_kamar')
        ->join('INNER JOIN', 'm_mapping_pembayaran d', 'd.id = b.id_mapping_pembayaran')
        ->join('INNER JOIN', 'm_metode_pembayaran e', 'e.id = d.id_metode_pembayaran')
        ->join('INNER JOIN', 'm_jenis_pembayaran f', 'f.id = d.id_jenis_pembayaran')
        ->join('LEFT JOIN', 'm_mapping_harga g', 'g.id = c.id_mapping_harga')
        ->join('INNER JOIN', 'm_type h', 'h.id = g.id_type')
        ->where('b.id_biodata_tamu = :id_biodata_tamu', [':id_biodata_tamu' => $idtranstamu])
        ->orderBy(['b.id' => SORT_ASC])
        ->all();

        return $model;

    }

    public static function detailbookingtamu($idtranstamu)
    {
        $model = (new \yii\db\Query())
        ->select(['a.dp','a.sisa','a.total_bayar','c.nomor_kamar', 'a.id_transaksi_tamu', 'b.id_biodata_tamu', 'a.id_petugas', 'h.type', 'f.jenis as jenis_pembayaran', 'e.metode as metode_pembayaran', 'b.no_kartu_debit', 'b.checkin', 'b.checkout', 'b.durasi', 'g.harga as harga_kamar', 'b.harga as biaya_sewa_perkamar', 'a.total_harga as subtotal'])
        ->from('summary_booking a')
        ->join('LEFT JOIN', 't_booking b', 'b.id_biodata_tamu = a.id_transaksi_tamu')
        ->join('INNER JOIN', 'm_mapping_kamar c', 'c.id = b.id_mapping_kamar')
        ->join('INNER JOIN', 'm_mapping_pembayaran d', 'd.id = b.id_mapping_pembayaran')
        ->join('INNER JOIN', 'm_metode_pembayaran e', 'e.id = d.id_metode_pembayaran')
        ->join('INNER JOIN', 'm_jenis_pembayaran f', 'f.id = d.id_jenis_pembayaran')
        ->join('LEFT JOIN', 'm_mapping_harga g', 'g.id = c.id_mapping_harga')
        ->join('INNER JOIN', 'm_type h', 'h.id = g.id_type')
        ->where('b.id_biodata_tamu = :id_biodata_tamu', [':id_biodata_tamu' => $idtranstamu])
        ->orderBy(['b.id' => SORT_ASC])
        ->all();

        return $model;

    }

    public static function grandtotalPendapatan($petugas)
    {
        if(!empty($petugas)) {
            $model = (new \yii\db\Query())
            ->from('histori_summarytamu a')
            ->where('a.id_petugas = :idpetugas', [':idpetugas' => $petugas]);
            $sum = $model->sum('jml_uangmasuk');

            return $sum;
        } else {
            $model = (new \yii\db\Query())
            ->from('histori_summarytamu a');
            // ->where('a.id_petugas = :idpetugas', [':idpetugas' => $petugas]);
            $sum = $model->sum('jml_uangmasuk');

            return $sum;
        }
    }
    public static function grandtotalPengeluaran($petugas)
    {
        if(!empty($petugas)) {
            $model = (new \yii\db\Query())
            ->from('t_pengeluaran_petugas a')
            ->where('a.id_petugas = :idpetugas', [':idpetugas' => $petugas]);
            $sum = $model->sum('total_harga_item');

            return $sum;
        } else {
            $model = (new \yii\db\Query())
            ->from('t_pengeluaran_petugas a');
            // ->where('a.id_petugas = :idpetugas', [':idpetugas' => $petugas]);
            $sum = $model->sum('total_harga_item');

            return $sum;
        }
    }

    public static function jamKerja($idshift){
        $model = Users::find()->where(['id_shift' => $idshift])->asArray()->one();
        return $model;
    }


    // Fungsi ambil time nya aja
    public static function ambilJamshift(){
        date_default_timezone_set('Asia/Jakarta');
        $timezone = date_default_timezone_get();
        $date = date('Y-m-d H:i:s', time());
        $exp = explode(" ",$date);
        foreach($exp as $key => $value){
            $result[] = $value;
        }

        return $result[1];
    }

    public static function mappingKamar($id='')
    {
        if(!empty($id)){

            $data = (new \yii\db\Query())
            ->select(['a.id', 'a.nomor_kamar', 'a.status', 'c.type', 'd.kategori_harga', 'b.harga', 'a.created_date', 'a.created_by'])
            ->from('m_mapping_kamar a')
            ->join('INNER JOIN', 'm_mapping_harga b', 'b.id=a.id_mapping_harga')
            ->join('INNER JOIN', 'm_type c', 'c.id = b.id_type')
            ->join('INNER JOIN', 'm_kategori_harga d', 'd.id = b.id_kategori_harga')
            ->where(['a.id' => $id])
            ->orderBy(['a.id' => SORT_ASC])
            ->one();

            return $data;
        } else {
            $data = (new \yii\db\Query())
            ->select(['a.id', 'a.nomor_kamar', 'a.status', 'c.type', 'd.kategori_harga', 'b.harga', 'a.created_date', 'a.created_by'])
            ->from('m_mapping_kamar a')
            ->join('INNER JOIN', 'm_mapping_harga b', 'b.id=a.id_mapping_harga')
            ->join('INNER JOIN', 'm_type c', 'c.id = b.id_type')
            ->join('INNER JOIN', 'm_kategori_harga d', 'd.id = b.id_kategori_harga')
            // ->where(['a.id' => $id])
            ->orderBy(['a.id' => SORT_ASC])
            ->all();

            return $data;
        }
    }

    public static function mappingPrice()
    {
        $data = (new \yii\db\Query())
            ->select(['a.id', 'a.id_kategori_harga', 'b.type', 'c.kategori_harga', 'a.harga', 'a.created_date', 'a.created_by'])
            ->from('m_mapping_harga a')
            ->join('INNER JOIN', 'm_type b', 'b.id = a.id_type')
            ->join('INNER JOIN', 'm_kategori_harga c', 'c.id = a.id_kategori_harga')
            ->orderBy(['a.id' => SORT_ASC])
            ->all();

        return $data;
    }

    public static function mappingUser()
    {
        $data = (new \yii\db\Query())
            ->select(['a.*', 'b.nm_shift'])
            ->from('users a')
            ->join('LEFT JOIN', 'm_shift b', 'b.id = a.id_shift')
            ->orderBy(['a.id' => SORT_ASC])
            ->all();

        return $data;
    }

    public static function mappingPay()
    {
        $data = (new \yii\db\Query())
            ->select(['a.id', 'a.id_metode_pembayaran', 'a.id_jenis_pembayaran', 'b.metode', 'c.jenis', 'a.created_date', 'a.created_by'])
            ->from('m_mapping_pembayaran a')
            ->join('INNER JOIN', 'm_metode_pembayaran b', 'b.id = a.id_metode_pembayaran')
            ->join('INNER JOIN', 'm_jenis_pembayaran c', 'c.id = a.id_jenis_pembayaran')
            ->orderBy(['a.id' => SORT_ASC])
            ->all();

        return $data;
    }

    public static function arrTypekamar()
    {
        $model = MType::find()->asArray()->all();
        $data=[];
        $data[''] = "Pilih Type ...";
        foreach ($model as $key => $value) {

            $data[$value['id']]= $value['type'];
        }

        return $data;
    }

    public static function arrKategoriharga()
    {
        $model = MKategoriHarga::find()->asArray()->all();
        $data=[];
        $data[''] = "Pilih Kategori ...";
        foreach ($model as $key => $value) {
            $data[$value['id']]= $value['kategori_harga'];
        }

        return $data;
    }

    public static function durasikamar($cekin,$cekout)
    {
        $waktuakhir = date_create(); //2019-02-21 09:35 waktu sekarang
        $waktu = \date('H:i:s',strtotime($cekin ));
        $shift = (new \yii\db\Query())
        ->select(['*'])
        ->from('m_shift')
        ->where(':waktu BETWEEN start_date AND end_date;', [':waktu' => $waktu])
        ->one();
        // var_dump($shift);exit;

        //ini shift 1 atau 2
        if(!empty($shift)){
            $tanggal_cekout = \date('Y-m-d 12:00:00',strtotime($cekout));
        }
        else{
            $tanggal_cekout = date('Y-m-d 12:00:00', strtotime($cekout . ' -1 day'));
        }
        // var_dump($waktuakhir);exit;
        $waktuakhir = date_create($tanggal_cekout); //2019-02-21 09:35 waktu sekarang
        $waktuawal  = date_create(); //waktu di setting


        $diff  = date_diff($waktuawal, $waktuakhir);

        $waktu = '';
        if($diff->y != 0){
            $waktu = $waktu.$diff->y.' tahun ';
        }
        // var_dump($waktu);
        if($diff->m != 0){
            $waktu = $waktu.$diff->m.' bulan ';
        }
        // var_dump($waktu);

        if($diff->d != 0){
            $waktu = $waktu.$diff->d.' hari ';
        }

        if($diff->h != 0){
            $waktu = $waktu.$diff->h.' jam ';
        }
        if($diff->i != 0){
            $waktu = $waktu.$diff->i.' menit ';
        }

        // echo 'Selisih waktu: ';

        // // echo $diff->y . ' tahun, ';

        // // echo $diff->m . ' bulan, ';

        // // echo $diff->d . ' hari, ';

        // echo $diff->h . ' jam, ';

        // echo $diff->i . ' menit, ';

        // echo $diff->s . ' detik, ';
        // var_dump($waktu);
        // Output : Selisih waktu: 0 tahun, 11 bulan, 30 hari, 18 jam, 35 menit, 11 detik
        $data['text'] = $waktu;
        $data['tanggal'] = date('d F Y',strtotime($tanggal_cekout));
        return $data;

        // echo '<br> Total selisih hari adalah: ' . $diff->days;

    }

    // public static function durasikerja($res_jamlogin){
    //     date_default_timezone_set('Asia/Jakarta');
    //
    //     $getrange = MShift::find()->where(['id'=>\Yii::$app->user->identity->id_shift])->asArray()->one();
    //     $res_getrange = $getrange['range_date'];
    //     $exp = explode("|",$res_getrange);
    //     $durasi = date('Y-m-d H:i:s',strtotime('+' .$exp[0]. ' hour +' .$exp[1]. ' minutes',strtotime($res_jamlogin)));
    //
    //    return $durasi;
    // }

    public static function dataBookingtamu($idtranstamu)
    {
        $model = (new \yii\db\Query())
            ->select(['a.id', 'a.id_biodata_tamu', 'i.type', 'a.id_mapping_kamar as idmappingkamar', 'a.checkin', 'a.checkout', 'a.durasi', 'a.harga as subtotal', 'a.no_kartu_debit', 'a.status', 'b.nama as namatamu', 'b.identitas', 'b.nomor_identitas', 'b.nomor_kontak', 'b.alamat', 'c.nomor_kamar', 'f.jenis', 'e.metode', 'g.harga', 'h.dp as summary_dp', 'h.sisa as summary_sisa', 'h.total_harga', 'h.total_bayar'])
            ->from('t_booking a')
            ->join('LEFT JOIN', 'biodata_tamu_booking b', 'b.id = a.id_biodata_tamu')
            ->join('INNER JOIN', 'm_mapping_kamar c', 'c.id = a.id_mapping_kamar')
            ->join('INNER JOIN', 'm_mapping_pembayaran d', 'd.id = a.id_mapping_pembayaran')
            ->join('INNER JOIN', 'm_metode_pembayaran e', 'e.id = d.id_metode_pembayaran')
            ->join('INNER JOIN', 'm_jenis_pembayaran f', 'f.id = d.id_jenis_pembayaran')
            ->join('LEFT JOIN', 'm_mapping_harga g', 'g.id = c.id_mapping_harga')
            ->join('LEFT JOIN', 'summary_booking h', 'h.id_transaksi_tamu = a.id_biodata_tamu')
            ->join('INNER JOIN', 'm_type i', 'i.id = g.id_type')
            ->where(['a.id_biodata_tamu' => $idtranstamu])
            ->all();

        return $model;
    }

    public static function reminderBooking()
    {
        $curdate = date('Y-m-d');
        $formathasil = [];
        $cekbooking = TBooking::find()->asArray()->all();
        foreach ($cekbooking as $key => $value) {
            $hasil[] = $value['checkin'];
            $formathasil[] = date("Y-m-d",strtotime($value['checkin']. "-1 days"));
        }
        if(!empty($formathasil)) {
            $result = array_values(array_filter($formathasil, function($v){
                return $v == date('Y-m-d');
            }));
        } else {
            return 0;
        }

        foreach ($result as $keyz => $val) {
            $format[] = date("Y-m-d",strtotime($val. "+1 days"));
        }
        if(isset($format)){

            $modelBooking = (new \yii\db\Query())
            ->select(['COUNT(*) AS total'])
            ->from('t_booking')
            ->where(['checkin' =>$format])
            // ->where(['>=','checkin', $curdate])
            ->all();
        } else {
            $modelBooking = 0;
        }


        return $modelBooking;
    }

    public static function reminderCheckout()
    {
        $curdate = date('Y-m-d');
        $formathasil = [];
        $cektamu = TTamu::find()->asArray()->all();
        foreach ($cektamu as $key => $value) {
            $hasil[] = $value['checkout'];
            $formathasil[] = date("Y-m-d",strtotime($value['checkout']. "-1 days"));
        }

        if(!empty($formathasil)) {
            $result = array_values(array_filter($formathasil, function($v){
                return $v == date('Y-m-d');
            }));
        } else {
            return 0;
        }

        $format = [];
        foreach ($result as $keyz => $val) {
            $format[0] =  $val;
            $format[] = date("Y-m-d",strtotime($val. "+1 days"));
        }
        $impformat = "'" .implode("','", $format). "'";

        if(isset($format)){

            $modelCheckout = (new \yii\db\Query())
            ->select(['COUNT(*) AS total'])
            ->from('t_tamu')
            ->where('checkout IN('.$impformat.')')
            ->andWhere(['status' => 1])
            // ->where(['checkout' =>$format])
            // ->where(['>=','checkin', $curdate])
            ->all();
        } else {
            $modelCheckout = 0;
        }

        return $modelCheckout;
    }
}
