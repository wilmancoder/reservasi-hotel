<style>
  .timer, .timer-done, .timer-loop {
    font-size: 20px;
    color: black;
    font-weight: bold;
    padding: 8px;
  }
  .jst-hours {
    float: left;
    margin-left: 650px;
  }
  .jst-minutes {
    float: left;
  }
  .jst-seconds {
    float: left;
  }
  .jst-clearDiv {
    clear: both;
  }
  .jst-timeout {
    color: red;
  }
</style>


<div class='timer' style="color:red;" data-minutes-left=<?= Yii::$app->user->identity->range_date; ?>></div>


<script type="text/javascript">
$(document).ready(function () {
    $('.timer').startTimer();

    // $('.timer').startTimer({
    //     classNames: {
    //     hours: 'myClass-hours',
    //     minutes: 'myClass-minutes',
    //     seconds: 'myClass-seconds',
    //     clearDiv: 'myClass-clearDiv',
    //     timeout: 'myClass-timeout'
    //   }
    // });
});
</script>
