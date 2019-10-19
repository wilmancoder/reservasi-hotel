<?php
use yii\helpers\Html;
use yii\helpers\Url;
// use yii\grid\GridView;
use yii\bootstrap\ActiveForm;

$this->title = 'Rooms';
$this->params['breadcrumbs'][] = $this->title;
?>
<style type="text/css">
.media {
display: inline-block;
position: relative;
vertical-align: top;
}

.media__image { display: block; }

.media__body {
background: rgba(43, 40, 38, 0.7);
bottom: 0;
color: white;
font-size: 1em;
left: 0;
opacity: 0;
overflow: hidden;
padding: 1.25em 1em;
position: absolute;
text-align: center;
top: 0;
right: 0;
-webkit-transition: 0.6s;
transition: 0.6s;
}

.media__body:hover { opacity: 1; }

.media__body:after,
.media__body:before {
/* border: 1px solid rgba(255, 255, 255, 0.7); */
bottom: 1em;
content: '';
left: 1em;
opacity: 0;
position: absolute;
right: 1em;
top: 1em;
-webkit-transform: scale(1.5);
-ms-transform: scale(1.5);
transform: scale(1.5);
-webkit-transition: 0.6s 0.2s;
transition: 0.6s 0.2s;
}

.media__body:before {
border-bottom: none;
border-top: none;
left: 2em;
right: 2em;
}

.media__body:after {
border-left: none;
border-right: none;
bottom: 2em;
top: 2em;
}

.media__body:hover:after,
.media__body:hover:before {
-webkit-transform: scale(1);
-ms-transform: scale(1);
transform: scale(1);
opacity: 1;
}

.media__body h2 { margin-top: 0; }

.media__body p { margin-bottom: 1.5em; }

.resizechoose {
    padding: 8px 30px 1px 15px !important;
}

.labelcekin {
    font-size: 20px !important;
    height: 30px !important;
}
</style>
<div class="rooms-index">
<h1 class="title"><i class="fa fa-home" aria-hidden="true"></i> <?= Html::encode($this->title) ?></h1>
    <div class="row">
        <?php
        foreach ($model as $key => $value) {
            $joinid = $value['id'].",".$idharga;
            if($value['status'] == "tersedia"){


                    echo"

                    <div class='col-lg-3 col-xs-6'>
                    <div class='small-box bg-green'>
                    <div class='inner'>
                    <h3>".$value['nomor_kamar']."</h3>
                    <p>".ucfirst($value['type'])."</p>
                    </div>
                    <div class='icon'>
                    <i class='ion ion-home'></i>
                    </div>
                    ".Html::a('<i class="fa fa-check-circle"></i> '.ucfirst($value['status']).'', 'javascript:manage_rooms("'.$joinid.'")', ['class' => 'small-box-footer labelcekin'])."

                    </div>

                    </div>


                    ";

            } else {


                echo"
                <div class='col-lg-3 col-xs-6'>
                    <div class='small-box bg-red'>
                        <div class='inner'>
                            <h3>".$value['nomor_kamar']."</h3>
                            <p>".ucfirst($value['type'])."</p>
                        </div>
                        <div class='icon'>
                            <i class='ion ion-home'></i>
                        </div>
                        ".Html::a('<i class="fa fa-minus-circle"></i> '.ucfirst($value['status']).'', 'javascript:manage_done("'.$joinid.'")', ['class' => 'small-box-footer labelcekin'])."
                    </div>
                </div>
                ";

            }

        }
        ?>

    </div>

</div>

<!-- The Modal -->
<div class="modal fade" id="modalRoomsId">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
              <h4 class="modal-title" id="modalRoomsTitle"></h4>
              <!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->
            </div>

            <!-- Modal body -->
            <div class="modal-body" id="modalRoomsBody">
              Loading ...
            </div>

            <!-- Modal footer -->
            <!-- <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div> -->

        </div>
    </div>
</div>

<!-- The Modal -->
<div class="modal fade" id="modalPilihkamarId">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
              <h4 class="modal-title" id="modalPilihkamarTitle"></h4>
              <!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->
            </div>

            <!-- Modal body -->
            <div class="modal-body" id="modalPilihkamarBody">
              Loading ...
            </div>

            <!-- Modal footer -->
            <!-- <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div> -->

        </div>
    </div>
</div>

<script type="text/javascript">

    function manage_rooms(id) {
        var url = "<?php echo \Yii::$app->getUrlManager()->createUrl(['myadmin/rooms/create']);?>?id="+id;
        var title = "Form Check-in";
        // localStorage.removeItem('itemChecked');
        showModalRooms(url,title);
    }

    function manage_done(idttamu) {
        var url = "<?php echo \Yii::$app->getUrlManager()->createUrl(['myadmin/rooms/createdone']);?>?idttamu="+idttamu;
        var title = "Form Check-out";
        // localStorage.removeItem('itemChecked');
        showModalRooms(url,title);
    }

    function showModalRooms(url,title)
      {
          $("#modalRoomsTitle").empty();
          $("#modalRoomsTitle").html(title);

          $("#modalRoomsBody").empty();
          $("#modalRoomsBody").html("Loading ...");
          $("#modalRoomsBody").load(url);

          $('#modalRoomsId').modal({backdrop: 'static', keyboard: false});
          $("#modalRoomsId").modal("show");
          return false;
    }

    function showModalPilihkamar(url,title)
      {
          $("#modalPilihkamarTitle").empty();
          $("#modalPilihkamarTitle").html(title);

          $("#modalPilihkamarBody").empty();
          $("#modalPilihkamarBody").html("Loading ...");
          $("#modalPilihkamarBody").load(url);

          $('#modalPilihkamarId').modal({backdrop: 'static', keyboard: false});
          $("#modalPilihkamarId").modal("show");
          return false;
    }
</script>
