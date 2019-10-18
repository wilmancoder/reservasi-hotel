<?php

use yii\helpers\Url;
use yii\helpers\Html;

?>
<style type="text/css">
    /* .cbrand {
        font-size:
    } */
    /* .watch {
        margin-left: 170px;
        padding-top: 15px;
        font-size: 14px;
        font-weight: bold;
    } */
</style>
<header class="main-header">
    <nav class="navbar navbar-static-top">
        <!-- <div class="container"> -->
            <div class="navbar-header">
              <a href="<?=\Yii::$app->homeUrl?>" class="navbar-brand"><h4><b><?=\Yii::$app->name?></b></h4></a>
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                <i class="fa fa-bars"></i>
              </button>
              <!-- <div class="navbar-header watch"> -->

                  <p id="demo" class="watch"></p>
              <!-- </div> -->
            </div>
            <!-- <div class="collapse navbar-collapse pull-left watch" id="navbar-collapse">
            </div> -->
            <!-- Navbar Right Menu -->
            <?php /*
            <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
                <ul class="nav navbar-nav">
                    <li class="active"><a href="<?= Url::to(['/myadmin/rooms']); ?>">Rooms</a></li>
                    <li><a href="<?= Url::to(['/myadmin/booking']); ?>">Booking</a></li>
                    <li><a href="<?= Url::to(['/myadmin/revenue']); ?>">Revenue</a></li>
                </ul>
            </div>
            */ ?>
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <!-- User Account Menu -->
                    <li class="dropdown user user-menu">
                      <!-- Menu Toggle Button -->
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown">

                          <i class="caret"></i>
                        <!-- The user image in the navbar-->
                        <?= Html::img('@web/img/avatar.png', ['class'=>'user-image']);?>
                        <!-- class="user-image" alt="User Image"> -->
                        <!-- hidden-xs hides the username on small devices so only the image appears. -->
                        <span class="hidden-xs"><?= \Yii::$app->user->identity->nama; ?> / <?= \Yii::$app->user->identity->nm_shift; ?></span>
                      </a>
                      <ul class="dropdown-menu">
                        <!-- The user image in the menu -->
                        <li class="user-header">
                          <?= Html::img('@web/img/avatar.png', ['class'=>'img-circle']);?>
                          <!-- " class="img-circle" alt="User Image"> -->

                          <p>
                            <?=\Yii::$app->user->identity->username . "<br>"; ?>
                            <?=\Yii::$app->user->identity->nama . "<br>"; ?>
                            <small>Role  :  <strong><?= Yii::$app->user->identity->role; ?></strong>  |
                            Shift :  <strong><?= Yii::$app->user->identity->nm_shift; ?></strong></small>

                          </p>
                        </li>

                        <li class="user-footer">
                            <a href="<?= \Yii::$app->getUrlManager()->createUrl(['site/logout']) ?>" class="btn btn-default btn-block"><i class="fa fa-sign-out fa-lg" style="padding-top:5px"></i> Sign out</a>
                        </li>
                        <!-- Menu Footer-->
                        <?php /*
                        <?php
                        // var_dump($modelJamkerja);exit;
                        $curdate = date("Y-m-d H:i:s");
                        $res_curdate = date("Y-m-d H:i",strtotime($curdate));

                        $res_jamkerja = date("Y-m-d H:i",strtotime($modelJamkerja));
                        if($res_curdate >= $res_jamkerja){ ?>

                            <li class="user-footer" style="display:block">
                                <a href="<?= \Yii::$app->getUrlManager()->createUrl(['site/logout']) ?>" class="btn btn-default btn-block"><i class="fa fa-sign-out fa-lg" style="padding-top:5px"></i> Sign out</a>
                            </li>
                        <?php } else { ?>
                            <li class="user-footer" style="display:none">
                                <a href="<?= \Yii::$app->getUrlManager()->createUrl(['site/logout']) ?>" class="btn btn-default btn-block"><i class="fa fa-sign-out fa-lg" style="padding-top:5px"></i> Sign out</a>
                            </li>
                        <?php }?>
                        */ ?>
                      </ul>
                    </li>
                </ul>
            </div>
            <?php if(\Yii::$app->user->identity->role == '1') { ?>
                <div class="collapse navbar-collapse pull-right" id="navbar-collapse">
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="<?= Url::to(['/myadmin/rooms']); ?>">Rooms</a></li>
                        <li><a href="<?= Url::to(['/myadmin/booking']); ?>">Booking</a></li>
                        <li><a href="<?= Url::to(['/myadmin/report']); ?>">Report</a></li>
                    </ul>
                </div>
            <?php } else { ?>
                <div class="collapse navbar-collapse pull-right" id="navbar-collapse">
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="<?= Url::to(['/myadmin/rooms']); ?>">Rooms</a></li>
                        <li><a href="<?= Url::to(['/myadmin/booking']); ?>">Booking</a></li>
                        <li><a href="<?= Url::to(['/myadmin/report/indexall']); ?>">Report All</a></li>


                        <li class="dropdown messages-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                Setting
                            </a>
                            <ul class="dropdown-menu">
                                <!-- <li><a href="#">Setting</a> -->
                                    <!-- </a> -->
                                    <!-- <ul class="menu"> -->
                                        <li>
                                            <a href="<?= Url::to(['/myadmin/roomsetting']); ?>">
                                                <font color="white">Manajemen Kamar</font>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?= Url::to(['/myadmin/pricesetting']); ?>">
                                                <font color="white">Manajemen Harga</font>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?= Url::to(['/myadmin/paysetting']); ?>">
                                                <font color="white">Manajemen Pembayaran</font>
                                            </a>
                                        </li>
                                    <!-- </ul> -->
                                <!-- </li> -->
                            </ul>
                        </li>
                    </ul>
                </div>
            <?php } ?>

        <!-- </div> -->
        <!-- /.navbar-custom-menu -->
    </nav>
</header>

<!-- /.container-fluid -->

<script type="text/javascript">
$(document).ready(function () {
    // var ambiljamker = $('#jamkerja').val();
    // var firstDate = $('#firstdate').val();
    // var secondDate = $('#seconddate').val();
    // var rangeDate = $('#rangedate').val();
    //
    // var jampulang = sumWatch(firstDate,rangeDate);
    //
    //
    // // Set the date we're counting down to
    // // var countDownDate = new Date("Sep 15, 2019 10:27:00").getTime();
    // var countDownDate = jampulang;
    //
    // // Update the count down every 1 second
    // var x = setInterval(function() {
    //
    // // Get today's date and time
    // // var now = new Date().getTime();
    // var now = firstDate;
    // // alert(now); return false;
    //
    // // Find the distance between now and the count down date
    // var distance = countDownDate - now;
    //
    // // Time calculations for days, hours, minutes and seconds
    // var days = Math.floor(distance / (1000 * 60 * 60 * 24));
    // var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    // var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    // var seconds = Math.floor((distance % (1000 * 60)) / 1000);
    //
    // // Output the result in an element with id="demo"
    // document.getElementById("demo").innerHTML = days + "d " + hours + "h "
    // + minutes + "m " + seconds + "s ";
    //
    // // If the count down is over, write some text
    // if (distance < 0) {
    // clearInterval(x);
    // document.getElementById("demo").innerHTML = "EXPIRED";
    // }
    // }, 1000);
});


// Fungsi penjumlahan jam
function sumWatch(firstDate,secondDate){
    // alert(secondDate); return false;
    var prodhrd = firstDate;
    var conprod = secondDate;
    prodhrdArr = prodhrd.split(":");
    conprodArr = conprod.split(":");
    var hh1 = parseInt(prodhrdArr[0]) + parseInt(conprodArr[0]);
    var mm1 = parseInt(prodhrdArr[1]) + parseInt(conprodArr[1]);
    var ss1 = parseInt(prodhrdArr[2]) + parseInt(conprodArr[2]);

    if (ss1 > 59) {
        var ss2 = ss1 % 60;
        var ssx = ss1 / 60;
        var ss3 = parseInt(ssx);//add into min
        var mm1 = parseInt(mm1) + parseInt(ss3);
        var ss1 = ss2;
    }
    if (mm1 > 59) {
        var mm2 = mm1 % 60;
        var mmx = mm1 / 60;
        var mm3 = parseInt(mmx);//add into hour
        var hh1 = parseInt(hh1) + parseInt(mm3);
        var mm1 = mm2;
    }
    var finaladd = hh1 + ':' + mm1 + ':' + ss1;
    return finaladd;
}

</script>
