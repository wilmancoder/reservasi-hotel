// # @Author: Defy M Aminuddin @defyma http://defyma.com
// # @Email:  defyma85@gmail.com
// # @Filename: custom.js
var animatedHome = false;
var minutesLabel;
var secondsLabel;
var totalSeconds;
var hitungWaktu;

$(document).ready(function () {
    var path = window.location.href;
    var arrPath = path.split('/');
    var last = arrPath[arrPath.length - 1];
    var LOC = localStorage.getItem('LOC');

    if(last === 'showreference') {
        if(LOC === null) {
            localStorage.setItem('LOC', last);
            LOC = last;
        }
    }

    if(LOC !== null) {
        if(last !== LOC) {
            localStorage.clear();
        }
    }
});

setTime = () => {
    ++totalSeconds;
    detik = pad(totalSeconds % 60);
    menit = pad(parseInt(totalSeconds / 60));

    if (menit == "60") {
        // $("#info").html("Loading terlalu lama, harap cek koneksi internet Anda.");
    }

    secondsLabel.innerHTML = detik;
    minutesLabel.innerHTML = menit;
}

pad = (val) => {
    var valString = val + "";
    if (valString.length < 2) {
        return "0" + valString;
    } else {
        return valString;
    }
}

// $(document).ajaxStart(() => {
//     var loadingnya = '<img src="' + mysite + 'image/loading.svg" width="100px" style="margin-top:20px">';
//     var timelabel = '<center><span id="minutes">00</span>:<span id="seconds">00</span><br><span id="info"></span><br><span id="info_status"></span></center>';
//     var css = '<style>.swalloading{opacity:1;color:rgba(0,0,0,.64);pointer-events:auto;position:fixed;top:0;bottom:0;left:0;right:0;text-align:center;font-size:0;overflow-y:scroll;background-color:rgba(0,0,0,.4);z-index:10000;transition:opacity .3s}.swal-modal-loading{margin-top:15%!important;width:300px;background-color:#fff;text-align:center;border-radius:5px;position:static;margin:20px auto;display:inline-block;vertical-align:middle;-webkit-transform:scale(1);transform:scale(1);-webkit-transform-origin:50% 50%;transform-origin:50% 50%;z-index:10001;transition:opacity .2s,-webkit-transform .3s;transition:transform .3s,opacity .2s;transition:transform .3s,opacity .2s,-webkit-transform .3s}.swal-title-loading:not(:last-child){margin-bottom:13px}.swal-title-loading:not(:first-child){padding-bottom:0}.swal-title-loading{color:rgba(0,0,0,.65);font-weight:600;text-transform:none;position:relative;display:block;padding:13px 16px;padding-bottom:10px;font-size:20px;line-height:normal;text-align:center;margin-bottom:0}.swal-text-loading:last-child{margin-bottom:10px}.swal-text-loading{font-size:13px;position:relative;float:none;line-height:normal;vertical-align:top;text-align:left;display:inline-block;margin:0;margin-bottom:0;padding:0 10px;color:rgba(0,0,0,.64);max-width:calc(100% - 20px);overflow-wrap:break-word;box-sizing:border-box}</style>';
//     var html_loading = '<div class="loading">' + css + '<div class="swalloading" tabindex="-1"><div class="swal-modal-loading"> ' + loadingnya + '  <div class="swal-title-loading">Harap Tunggu ...</div><div class="swal-text-loading">' + timelabel + '</div></div></div></div>';
//
//     $("body").prepend(html_loading);
//
//     minutesLabel = document.getElementById("minutes");
//     secondsLabel = document.getElementById("seconds");
//     totalSeconds = 0;
//
//     hitungWaktu = setInterval(setTime, 1000);
//
//     console.log('show');
//
// }).ajaxStop(() => {
//     // swal.close();
//     $(".loading").remove();
//     clearInterval(hitungWaktu);
//     console.log('hide in sec: ' + totalSeconds);
//     if (animatedHome) {
//         homeAnimate();
//     }
// });

homeAnimate = () => {
    $(".counter").show();
    $('.counter').counterUp({
        delay: 10,
        time: 1000,
        callback: (e) => {
            // console.log(e.attr('id'));
            elID = e.attr('id');
            val = $("#" + elID).html();
            $("#" + elID).html(JSFormatNumber(val));
            animatedHome = false;
        }
    });
}

showGlobalStatus = (stop = false, param = "_") => {
    if (!stop) {
        setTimeout(function () {
            $("#info_status").load(mysite + 'site/getstatusajax?p=' + param, function () {
                showGlobalStatus(stop, param);
            });
        }, 1000);
    } else {
        $(".loading").remove();
        clearInterval(hitungWaktu);
    }
}

loadingStatis = (show = true, message = "") => {
    if (show) {
        var loadingnya = '<img src="' + mysite + 'image/loading.svg" width="100px" style="margin-top:20px">';
        var timelabel = '<center><span id="minutes">00</span>:<span id="seconds">00</span><br><span id="info"></span><br><span id="info_status"></span></center>';
        var css = '<style>.swalloading{opacity:1;color:rgba(0,0,0,.64);pointer-events:auto;position:fixed;top:0;bottom:0;left:0;right:0;text-align:center;font-size:0;overflow-y:scroll;background-color:rgba(0,0,0,.4);z-index:10000;transition:opacity .3s}.swal-modal-loading{margin-top:15%!important;width:300px;background-color:#fff;text-align:center;border-radius:5px;position:static;margin:20px auto;display:inline-block;vertical-align:middle;-webkit-transform:scale(1);transform:scale(1);-webkit-transform-origin:50% 50%;transform-origin:50% 50%;z-index:10001;transition:opacity .2s,-webkit-transform .3s;transition:transform .3s,opacity .2s;transition:transform .3s,opacity .2s,-webkit-transform .3s}.swal-title-loading:not(:last-child){margin-bottom:13px}.swal-title-loading:not(:first-child){padding-bottom:0}.swal-title-loading{color:rgba(0,0,0,.65);font-weight:600;text-transform:none;position:relative;display:block;padding:13px 16px;padding-bottom:10px;font-size:20px;line-height:normal;text-align:center;margin-bottom:0}.swal-text-loading:last-child{margin-bottom:10px}.swal-text-loading{font-size:13px;position:relative;float:none;line-height:normal;vertical-align:top;text-align:left;display:inline-block;margin:0;margin-bottom:0;padding:0 10px;color:rgba(0,0,0,.64);max-width:calc(100% - 20px);overflow-wrap:break-word;box-sizing:border-box}</style>';
        var html_loading = '<div class="loading">' + css + '<div class="swalloading" tabindex="-1"><div class="swal-modal-loading"> ' + loadingnya + '  <div class="swal-title-loading">Harap Tunggu ...</div><div class="swal-text-loading">' + timelabel + '</div></div></div></div>';

        $("body").prepend(html_loading);

        minutesLabel = document.getElementById("minutes");
        secondsLabel = document.getElementById("seconds");
        totalSeconds = 0;

        hitungWaktu = setInterval(setTime, 1000);

        $("#info_status").html(message);
        console.log('show statis');
    } else {
        $("#info_status").html("");
        $(".loading").remove();
        clearInterval(hitungWaktu);
        console.log('hide in sec statis: ' + totalSeconds);
    }
}

JSFormatNumber = function (str) {
    if (str) {
        return str.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    } else {
        return "0";
    }
}

function iframeLoaded() {
    var iFrameID = document.getElementById('idIframe');
    if (iFrameID) {
        // here you can make the height, I delete it first, then I make it again
        iFrameID.height = "";
        iFrameID.height = iFrameID.contentWindow.document.body.scrollHeight + "px";
    }
}

jQuery.extend(jQuery.fn.dataTableExt.oSort, {
    "signed-num-pre": function (a) {
        console.log(a);
        return (a == "-" || a === "") ? 0 : a.replace('+', '') * 1;
    },

    "signed-num-asc": function (a, b) {
        console.log(a);
        console.log(b);
        return ((a < b) ? -1 : ((a > b) ? 1 : 0));
    },

    "signed-num-desc": function (a, b) {
        console.log(a);
        console.log(b);
        return ((a < b) ? 1 : ((a > b) ? -1 : 0));
    }
});

jQuery.extend(jQuery.fn.dataTableExt.oSort, {
    "formatted-num-pre": function (a) {
        a = (a === "-" || a === "") ? 0 : a.replace(/\./g, "");
        console.log(a);
        return parseFloat(a);
    },

    "formatted-num-asc": function (a, b) {
        console.log(a);
        console.log(b);
        return a - b;
    },

    "formatted-num-desc": function (a, b) {
        console.log(a);
        console.log(b);
        return b - a;
    }
});

$(document).ajaxError(function (event, jqxhr, settings, thrownError) {
    var errorMsg = jqxhr.responseText;
    // console.log("ini dari ajax error global"); sdsrf
    console.log(errorMsg);
});

var url = document.location.toString();
if (url.match('#')) {
    if (url.split('#')[1] != "") {
        $('.nav-tabs a[href="#' + url.split('#')[1] + '"]').tab('show');
        var dataresult = $('#' + url.split('#')[1]).attr('data-result');
        var dataurls = $('#' + url.split('#')[1]).attr('data-urls');
        if (typeof dataurls !== 'undefined') {
            $('#' + url.split('#')[1]).find(dataresult).load(dataurls);
        }
    }
}

jQuery(document).on('shown.bs.tab', '.nav-tabs a', function (e) {
    window.location.hash = e.target.hash;
    dataresult = $(e.target.hash).attr('data-result');
    dataurls = $(e.target.hash).attr('data-urls');
    if (typeof dataurls !== 'undefined') {
        $(e.target.hash).find(dataresult).load(dataurls);
    }
    // console.log(e.target.hash);
    // $(e.target.hash).find('#resultdt').load($('#draftitems').attr('data-urls'));
})
//test ting
