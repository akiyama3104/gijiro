<?php
/**
 * Created by PhpStorm.
 * User: satos
 * Date: 2017/09/29
 * Time: 11:56
 */

?>

<?php $dateOption = array('empty' => array('day' => date(''), 'month' => date(''), 'year' => date('')));//次回開催時間などの初期値?>
<h2>議事録準備画面</h2>


<ul>
    <?=$this->Form->create("Proceeding",array("action"=>"add"));?>
    <?=$this->Form->hidden("id");?>
    <li><h2>議題：<?=$this->Form->input("title",array("label"=>false));?></h2></li>
    <li><h3>開催時間：</h3>
            <span class="input-group date date_time_pick" >
                <?=$this->Form->input("start_time",array("type"=>"text","label"=>false,"div"=>false));?>
                <span class="input-group-addon"><span class="glyphicon-calendar glyphicon"></span></span>
            </span>
            ～
        <span class="input-group date date_time_pick" >
        <?=$this->Form->input("end_time",array("label"=>false,"type"=>"text","div"=>false));?>
        <span class="input-group-addon"><span class="glyphicon-calendar glyphicon"></span></span>
        </span>
    </li>


    <li><h3>開催場所：</h3><?=$this->Form->input("place",array("label"=>false));?></li>
    <li><h3>会議目的：</h3><?=$this->Form->input("agenda",array("label"=>false));?></li>
    <li>

        <table class="Attenders-table table table-bordered table-responsive">
            <tr class="attenders-row">
                <td class="row_explain"><h3>参加者：(Shift+Enterで追加）</h3></td>
                    <td id="attender-record0">
                        <button type="button" class="btn add-btn add-btn-attender">+</button>
                        <button type="button" class="btn remove-btn remove-attender">-</button>
                        <?=$this->Form->input("Attender.0.attender_name",array("type"=>"text","size"=>"5","label"=>"" ,"class"=>array("attender-name","add-attender","allow-enter","attender_0"), "div"=>false));?>

                    </td>
            </tr>
            <tr class="belongs-row">
                <td class="row_explain"><h3>所属：</h3></td>
                    <td id="belongs-record0">
                        <?=$this->Form->input("Attender.0.belongs",array("type"=>"text","size"=>"5" ,"label"=>false, "class"=>array("belong","add-belong","allow-enter","add-attender"),"div"=>false));?>
                    </td>
            </tr>
        </table>
    </li>
    <li><h3>会議部署：</h3><?=$this->Form->input("type",array("options" => $type_id,"type"=>"radio",));?></li>
    <li><h3>カテゴリ選択：</h3><?=$this->Form->input("Category",array("options"=>$categories,'type' => 'select','multiple'=> 'checkbox',"label"=>false)); ?>
    </li>

    <li><h3>次回開催時間：</h3>
        <span class="input-group date date_time_pick" >
                <?=$this->Form->input("next_start",array("type"=>"text","label"=>false,"div"=>false));?>
            <span class="input-group-addon"><span class="glyphicon-calendar glyphicon"></span></span>
        </span>
        ～
        <span class="input-group date date_time_pick" >
        <?=$this->Form->input("next_end",array("label"=>false,"type"=>"text","div"=>false));?>
            <span class="input-group-addon"><span class="glyphicon-calendar glyphicon"></span></span>
        </span>


    </li>
    <li><h3>次回開催場所：</h3><?=$this->Form->input("next_place",array("label"=>false));?></li>
    <li><h3>会議内容：</h3>
        <ul class="content-block">
            <li id="heading_0"class="heading">
                <?= $this->Form->input("Heading.0.heading_name",array("class"=>array("form-extension","extension-heading"),"label"=>"見出し名"));?>

                <ul class="inner_content">
                    <li class="contents content_0">

                        <?= $this->Form->input("Heading.0.Content.0.content",array("class"=>array("form-extension","extension-content"),"rows"=>"3","label"=>"Shift+Enterで項目追加","div"=>false));?>


                        <?=$this->Form->input("Heading.0.Content.0.status",array("options"=>array("fixed"=>"決定","task"=>"課題"),"type"=>"radio","legend"=>false,"style"=>"float:none;","div"=>"radio-horizontal"));?>
                        <span><button class="btn remove-btn btn-danger remove-content" type="button">削除</button></span>
                    </li>
                </ul>
                <div class="zone-btn"><span><button class="btn btn-lg btn-primary add-btn add-heading" type="button">見出し追加</button> </span><span><button class="btn btn-danger remove-btn remove-heading" type="button">見出し削除</button></span></div>
            </li>
            <?=$this->Form->hidden("user_id",array("value"=>$id));?>
        </ul>
    </li>
    <li ><h3>補足：</h3><?=$this->Form->input("suppl",array("label"=>false));?></li>
    <li><?= $this->Form->end(array("label"=>"議事録開始！" ,"class"=>array("btn-success","btn-lg","btn")));?></li>

</ul>




<script>
 $(function() {



     var attenders =<?= $json_attender?>;
     //オートコンプリート機能
     $(document).on("keyup",".attender-name",function(){
        $(".attender-name").autocomplete({
            source: attenders,
            autoFocus: true,
            delay: 500,
            minLength: 1,

            select:function(e,ui){
                $(this).val(ui.item.label);
                var attender_idx = $(this).closest("td").attr("id").match(/[0-9]+/);//自分のテーブルデータ(td)のid番号を取得
                $("#Attender"+attender_idx+"Belongs").val(ui.item.belongs);//所属項目に値を入れる

                return false;
            }
        });
    });



        //参加者追加共通関数
    function addAttender(add_triger){

        var id = $("#ProceedingId").val(),
            idx_cols=Math.max.apply(null ,
                $("[id^=attender-record]").map(
                    function () {return parseInt($(this).attr("id").match(/[0-9]+/),10)}))+1,//追加するのカラムのidx
            current_idx= add_triger.closest("td").attr("id").match(/[0-9]+/),//現在のidx(挿入する際に必要)

            format_attender=
                "<td id=\"attender-record"+idx_cols+"\">\n" +
                "<button type=\"button\" class=\"btn add-btn add-btn-attender\">+</button>\n" +
                "<button type=\"button\" class=\"btn remove-btn remove-attender\">-</button>\n" +
                "<label for=\"Attender"+idx_cols+"AttenderName\"></label>" +
                "<input name=\"data[Attender]["+idx_cols+"][attender_name]\" size=\"5\" class=\"attender-name add-attender allow-enter attender_"+idx_cols+"\" type=\"text\"  id=\"Attender"+idx_cols+"AttenderName\">" +
                " </td>",
            format_belongs="<td id=\"belongs-record"+idx_cols+"\">\n" +
                "<input name=\"data[Attender]["+idx_cols+"][belongs]\" size=\"5\" " +
                "class=\"belong add-belong allow-enter add-attender\" maxlength=\"255\" type=\"text\"  id=\"Attender"+idx_cols+"Belongs\">             " +
                "</td>";

        $("#attender-record"+current_idx).after(format_attender)
            .hide()
            .fadeIn();
        $("#belongs-record"+current_idx).after(format_belongs)
            .hide()
            .fadeIn();
        $(add_triger).nextFocusAttender();//フォーカスを次の項目に移動。(gijiro-layoutに関数を記載)
        return false;
    }

    //参加者追加
    $(document).on("keydown",".add-attender",function (e) {
        if (event.shiftKey) {
            if (e.keyCode === 13) {
                addAttender($(this));
                return false;
            }
        }
    });
    //参加者追加2（指定セレクタや、発火イベントが違うためメソッド複製・・・・)
    $(document).on("click",".add-btn-attender",function () {
        addAttender($(this));

    });
    //参加者削除
    $(document).on("click",".remove-attender",function () {
        var //id_val_cols = $(this).siblings(".HideAttenderId").val(),//カラムのid値
            current_idx= $(this).closest("td").attr("id").match(/[0-9]+/),//カラムのidx
            num_attenders = $(".attender-name").length;//カラムの数
        if(num_attenders <= 1 ) {
            alert("参加者は一人以上必要です。");
            return false;
        }else{
            $(this).prevFocusAttender();//フォーカスを前の項目に移動。(gijiro-layoutに関数を記載)
            $("#attender-record"+current_idx).add("#belongs-record"+current_idx).fadeOut(function () {
                $(this).remove();
            });
            return false;

        }
    });




    //見出し記事追加機能。cloneにすべきか考え中
    $("#content").on("click", ".add-heading", function (event) {

        var id = $("#ProceedingId").val(),
            heading_idx =
                Math.max.apply(null ,
                    $(".heading").map(
                        function (i,el) {return parseInt($(this).attr("id").match(/[0-9]+/),10)}))+1,//追加するidx(現在の最大idx+1）・・・暫定
            name_heading = "\"data[Heading][" + heading_idx + "][heading_name]\"",
            label_heading = " \"Heading" + heading_idx + "HeadingName\"",
            format = "<li id=\"heading_" + heading_idx + " \" class=\"heading\">\n" +
                "<div class=\"input text\">" +
                "<label for=" + label_heading + ">見出し名</label>" +
                "<input name=" + name_heading + " class=\"form-extension extension-heading \" maxlength=\"255\" type=\"text\" value=\"\" id=" + label_heading + "></div> " +
                "<ul class=\"inner_content\">\n" +
                "<li  class=\" contents content_0\">\n" +
                "<label for=\"Heading" + heading_idx + "Content0Content\">Shift+Enterで項目追加</label>" +
                "<textarea name=\"data[Heading][" + heading_idx + "][Content][0][content]\" class=\"form-extension extension-content\" cols=\"30\" rows=\"3\" " +
                "id=\"Heading" + heading_idx + "Content0Content\"></textarea>" +
                "<div class=\"radio-horizontal\"><input type=\"hidden\" name=\"data[Heading][" + heading_idx + "][Content][0][status]\" id=\"Heading" + heading_idx + "Content0Status_\"  value=\"\">" +
                "<input type=\"radio\" name=\"data[Heading][" + heading_idx + "][Content][0][status]\" id=\"Heading" + heading_idx + "Content0StatusFixed\" value=\"fixed\" style=\"float:none;\">" +
                "<label for=\"Heading" + heading_idx + "Content0StatusFixed\">決定</label>" +
                "<input type=\"radio\" name=\"data[Heading][" + heading_idx + "][Content][0][status]\" id=\"Heading" + heading_idx + "Content0StatusTask\" value=\"task\" style=\"float:none;\">" +
                "<label for=\"Heading" + heading_idx + "Content0StatusTask\">課題</label></div>\n" +
                "<span><button class=\"btn remove-btn btn-danger remove-content\" type=\"button\">削除</button></span>"+
                "</li>\n" +
                "</ul>\n" +
                "<div class=\"zone-btn\"><span><button class=\"btn btn-lg btn-primary add-btn add-heading\" type=\"button\">見出し追加</button></span> <span><button class=\"btn btn-danger remove-btn remove-heading\" type=\"button\">見出し削除</button></span></div>\n"+
                "</li> ";


        $(this).closest("[id^=heading_]").after(format)
            .hide()
            .fadeIn();
        $(this).nextFocusHeading();//フォーカスを次の項目に移動。(gijiro-layoutに関数を記載)
        return false;// ページをリロードしないようにする
    });
    //見出し削除
    $(document).on("click", ".remove-heading", function () {
        var id_val_heading = $(this).parent().nextAll(".HideHeadingId").val(),
            num_heading = $(".heading").length;
        if(num_heading <= 1 ) {
            alert("見出しは一つ以上必要です。");//暫定対応。見出しをすべて消してしまうと、見出しが追加できない
            return false;

        }else{

            $(this).prevFocusHeading();//フォーカスを前の項目に移動。(gijiro-layoutに関数を記載)
            $(this).parents(".heading").fadeOut(function () {
                $(this).remove();
            });

            return false;

        }
    });


    //記事内容追加
    $(document).on("keydown",".extension-content",function (e) {
        if (event.shiftKey) {
            if (e.keyCode === 13) {
                var id = $("#ProceedingId").val(),

                    idx_content= Math.max.apply(null , $(this).closest(".inner_content").children().map(function (i,el) {
                        return parseInt($(this).attr("class").match(/[0-9]+/),10)}))+1,//コンテンツの最大idx
                    idx_Heading= $(this).parents(".heading").attr("id").match(/[0-9]+/),//見出しのidx
                    format=
                        "<li class=\"contents content_"+idx_content+"\">\n" +
                        "<label for=\"Heading"+idx_Heading+"Content"+idx_content+"Content\">Shift+Enterで項目追加</label>" +
                        "<textarea name=\"data[Heading]["+idx_Heading+"][Content]["+idx_content+"][content]\"" +
                        " class=\"form-extension extension-content\" cols=\"30\" rows=\"3\" id=\"Heading"+idx_Heading+"Content"+idx_content+"Content\"></textarea>" +

                        "<div class=\"radio-horizontal\"><input type=\"hidden\" name=\"data[Heading]["+idx_Heading+"][Content]["+idx_content+"][status]\" id=\"Heading"+idx_Heading+"Content"+idx_content+"Status_\" value=\"\"><input type=\"radio\" name=\"data[Heading]["+idx_Heading+"][Content]["+idx_content+"][status]\" id=\"Heading"+idx_Heading+"Content"+idx_content+"StatusFixed\" value=\"fixed\">" +
                        "<label for=\"Heading"+idx_Heading+"Content"+idx_content+"StatusFixed\">決定</label>" + "<input type=\"radio\" name=\"data[Heading]["+idx_Heading+"][Content]["+idx_content+"][status]\" id=\"Heading"+idx_Heading+"Content"+idx_content+"StatusTask\" value=\"task\" style=\"float:none;\">" +
                        "<label for=\"Heading"+idx_Heading+"Content"+idx_content+"StatusTask\" style=\"float:none;\">課題</label></div>\n" +
                        "<span><button class=\"btn remove-btn btn-danger remove-content\" type=\"button\">削除</button></span>"+
                        "</li>" ;



                $(this).closest(".contents").after(format)
                    .hide()
                    .fadeIn();
                $(this).nextFocusContent();//フォーカスを次の項目に移動。(gijiro-layoutに関数を記載)
//                    location.reload();
                return false;
            }
        }
    });
    //記事内容削除
    $(document).on("click", ".remove-content", function () {
        var  num_contents=$(this).closest(".inner_content").get(0).childElementCount;//コンテンツの要素数。

        if(num_contents <= 1 ) {
            alert("記事内容は一つ以上必要です。");//記事が追加できないため
            return false;
        }else {

            $(this).prevFocusContent();//フォーカスを前の項目に移動。(gijiro-layoutに関数を記載)
            $(this).closest(".contents").fadeOut(function () {
                $(this).remove();
            });
            return false;
        }
    });

});
        </script>