$(function () {

    //ボタンを表示すると詳細が表示されたりする
    $('.hide-target').hide();
   $('.hide-button').on('click',function () {
       $('.hide-target').toggle('swing');
   }) ;




   //インプットタグ内でenterを押しても送信されないようにする。
    $("input"). keydown(function(e) {
        if (!$(this).is(".allow-enter")){//allow-enterの場合は、enterが機能するようにする。
            var c = e.which ? e.which : e.keyCode;

            return c != 13;


        }

        //
        // if ((e.which && e.which === 13) || (e.keyCode && e.keyCode === 13)) {
        //     return false;
        // } else {
        //     return true;
        // }
    });

    //     $.datepicker.setDefaults({
    //     closeText: '閉じる',
    //     prevText: '<前',
    //     nextText: '次>',
    //     currentText: '今日',
    //     monthNames: ['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月'],
    //     monthNamesShort: ['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月'],
    //     dayNames: ['日曜日','月曜日','火曜日','水曜日','木曜日','金曜日','土曜日'],
    //     dayNamesShort: ['日','月','火','水','木','金','土'],
    //     dayNamesMin: ['日','月','火','水','木','金','土'],
    //     weekHeader: '週',
    //     dateFormat: 'yy-mm-dd',
    //     changeYear: true,
    //     changeMonth: true
    // });



    $(".date_time_pick").datetimepicker({
        autoclose: true,
        language: 'ja',
        todayHighlight : true

    });

    //フォームを追加した際の、フォーカス遷移 start//
    $.fn.nextFocusContent = function(){
       this.closest(".contents").next().find("textarea").focus();
        return true;
    };
    $.fn.prevFocusContent = function(){
        this.closest(".contents").prev().find("textarea").focus();
        return true;
    };


    $.fn.nextFocusHeading=function () {
        this.closest("[id^=heading_]").next().find(".extension-heading ").focus();
    };
    $.fn.prevFocusHeading=function () {
        this.closest("[id^=heading_]").prev().find(".extension-heading ").focus();
    };


    $.fn.nextFocusAttender= function () {
        console.log(this.closest("td").next().find(".add-attender"));
        this.closest("td").next().find(".add-attender").focus();
    };
    $.fn.prevFocusAttender= function () {

        this.closest("td").prev().find(".add-attender").focus();
    };
    //フォームを追加した際の、フォーカス遷移 end//

});
