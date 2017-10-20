<?php
/**
 * Created by PhpStorm.
 * User: satos
 * Date: 2017/10/02
 * Time: 11:45
 */
?>

<h2>議事録詳細画面</h2>

<?php $editData=$this->request->data;?>
<?php $dateOption = array('empty' => array('day' => date(''), 'month' => date(''), 'year' => date('')));//次回開催時間などの初期値?>
<?=debug($editData);?>

<ul>
    <?=$this->Form->create("Proceeding",array("action"=>"edit"));?>
    <?=$this->Form->hidden("id");?>
    <li><h2>議題：<?=$this->Form->input("title");?></h2></li>
    <li>開催時間<?=$this->Form->input("start_time",$dateOption);?>：～<?=$this->Form->input("end_time",$dateOption);?></li>
    <li>開催場所：<?=$this->Form->input("place");?></li>
    <li>
        <table class="Attenders-table">
            <tr class="attenders-row"><td>参加者：(Shift+Enterで追加）</td>
                <?php foreach($editData["Attender"] as $i=> $attender):?>
                    <td id="attender-record<?=$i?>">
                        <?=$this->Form->hidden("Attender.".$i.".id",array("class"=>"HideAttenderId"));//更新するため主キー設定?>
                        <button type="button" class="btn add-btn add-btn-attender">+</button>
                        <button type="button" class="btn remove-btn remove-attender">-</button>
                        <?=$this->Form->input("Attender.".$i.".attender_name",array("type"=>"text","size"=>"5","label"=>"" ,"class"=>array("attender-name","add-attender","attender_".$i), "div"=>false));?>
                    </td>
                <?php endforeach; ?>
            </tr>
            <tr class="belongs-row"><td>所属：</td>
                <?php foreach($editData["Attender"] as $i=> $attender):?>
                    <td id="belongs-record<?=$i?>">
                        <?=$this->Form->input("Attender.".$i.".belongs",array("type"=>"text","size"=>"5" ,"label"=>false, "class"=>array("belong","add-belong","add-attender"),"div"=>false));?>
                    </td>
                 <?endforeach;?>
            </tr>
        </table>
    </li>
    <li>会議目的：<?=$this->Form->input("agenda");?></li>
    <li>会議種類：<?=$this->Form->input("type",array("options" => $type_id,"type"=>"radio"));?></li>
    <li>カテゴリ選択：<?=$this->Form->input("Category",array("options"=>$categories,'type' => 'select','multiple'=> 'checkbox',)); ?>
<!--    --><?//=$this->Form->hidden("CategoryList.id"); ?>
    </li>
    <li>会議内容:

        <ul class="content-block">
            <?php foreach($editData["Heading"] as $i =>  $heading):?>


            <li id="heading_<?=$i;?>"class="heading">見出し：<span><button class="btn remove-btn remove-heading" type="button">見出し削除-</button></span>
                <?= $this->Form->input("Heading.".$i.".heading_name",array("class"=>array("form-extension","extension-heading"),"label"=>"見出し名"));?>


                <?=$this->Form->hidden("Heading.".$i.".id", array("class"=>"HideHeadingId"));//更新,削除するため主キー設定?>

                <ul class="inner_content">
                    <?php foreach($heading["Content"] as $j => $content):?>
                    <li class="contents content_<?=$j?>">


                        <?= $this->Form->input("Heading.".$i.".Content.".$j.".content",array("class"=>array("form-extension","extension-content"),"rows"=>"3","label"=>"Shift+Enterで項目追加","div"=>false));?><span><button class="btn remove-btn remove-content" type="button">削除</button></span>

                        <?=$this->Form->hidden("Heading.".$i.".Content.".$j.".id",array("class"=>"HideContentId"));//更新、削除するため主キー設定?>
                        <?=$this->Form->input("Heading.".$i.".Content.".$j.".status",array("options"=>array("fixed"=>"決定","task"=>"課題"),"type"=>"radio","legend"=>false));?>

                    </li>

                    <?php endforeach;?>
                </ul>
                <div><button class="btn add-btn add-heading" type="button">見出し追加</button></div>
            </li>
           <?php endforeach;?>

        </ul>
    </li>
    <li>次回開催時間：<?=$this->Form->input("next_start",$dateOption);?>：～<?=$this->Form->input("next_end",$dateOption);?></li>
    <li>次回開催場所：<?=$this->Form->input("next_place");?></li>
    <li>補足<?=$this->Form->input("suppl");?></li>

    <li><?= $this->Form->end("保存");?></li>
</ul>
<?=$this->form->postLink('削除',array('action'=>'delete', $editData["Proceeding"]["id"]),array("class"=>array("btn btn-danger")),'本当に削除しますか?');?>


<script>
    $(function() {


        //途中で挿入した内容の順番を保持するために、各idを振りなおす修正関数
        function idModify(array_id_val,target_modify) {
            var modified_values = array_id_val
                .sort(function (val1, val2) {
                    if (val1 < val2) return -1;
                    if (val1 > val2) return 1;
                    return 0;
                });
            target_modify.each(function (i) {
                $(this).eq(0).attr("value", modified_values[i]);
//               console.log($(this).eq(0));
            });
        }

        //ajaxでpostする関数 引数はurlのパラメータ、コントローラのメソッド、コンソールログに乗せる関数の名称、データの順
        function postAjax(id,address,nameMethod="",data={}){
            $.ajax({
                type: "post",
                url: "/gijiro/proceedings/"+address+"/" + id,

                data: data,
                //通信失敗
                error: function ( XMLHttpRequest, textStatus, errorThrown,) {
                    console.log(nameMethod+"失敗しました");
                    console.log("XMLHttpRequest : " + XMLHttpRequest.status);
                    console.log("textStatus     : " + textStatus);
                    console.log("errorThrown    : " + errorThrown.message);

                },
                //ajax通信成功
                success : function(response) {
                    console.log(nameMethod+"成功しました");
//                            console.log(response.id_result);
                }
            });
        }


        //参加者追加共通関数
        function addAttender(add_triger){

            var id = $("#ProceedingId").val(),
                idx_cols=Math.max.apply(null ,
                    $("[id^=attender-record]").map(
                        function () {return parseInt($(this).attr("id").match(/[0-9]+/),10)}))+1,//追加するのカラムのidx
                current_idx= add_triger.closest("td").attr("id").match(/[0-9]+/),//現在のidx(挿入する際に必要)
                array_val_cols=$(".HideAttenderId").map(function(){return parseInt($(this).val(),10);}),//参加者idの配列
                val_id_cols =Math.max.apply(null,array_val_cols)+1, //参加者id値の最大値+1
                format_attender=
                    "<td id=\"attender-record"+idx_cols+"\">\n" +
                    "<input type=\"hidden\" name=\"data[Attender]["+idx_cols+"][id]\" class=\"HideAttenderId\" value=\""+val_id_cols+"\" id=\"Attender"+idx_cols+"Id\">" +
                    "<button type=\"button\" class=\"btn add-btn add-btn-attender\">+</button>\n" +
                    "  <button type=\"button\" class=\"btn remove-btn remove-attender\">-</button>\n" +
                    "<label for=\"Attender"+idx_cols+"AttenderName\"></label><input name=\"data[Attender]["+idx_cols+"][attender_name]\" size=\"5\" class=\"attender-name add-attender attender_"+idx_cols+"\" type=\"text\"  id=\"Attender"+idx_cols+"AttenderName\">                    </td>",
                format_belongs="<td id=\"belongs-record"+idx_cols+"\">\n" +
                    "<input name=\"data[Attender]["+idx_cols+"][belongs]\" size=\"5\" " +
                    "class=\"belong add-belong add-attender\" maxlength=\"255\" type=\"text\"  id=\"Attender"+idx_cols+"Belongs\">             " +
                    "</td>";

            $("#attender-record"+current_idx).after(format_attender)
                .hide()
                .fadeIn();
            $("#belongs-record"+current_idx).after(format_belongs)
                .hide()
                .fadeIn();

            array_val_cols.push(val_id_cols);
            idModify(array_val_cols,$(".HideAttenderId"));

            postAjax(id,"add","参加者追加",$("form").serialize());

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
            var　id_val_cols = $(this).siblings(".HideAttenderId").val(),//カラムのid値
                current_idx= $(this).closest("td").attr("id").match(/[0-9]+/),//カラムのidx
                num_attenders = $(".HideAttenderId").length;//カラムの数
            if(num_attenders <= 1 ) {
                alert("参加者は一人以上必要です。");
                return false;
            }else{
                postAjax(id_val_cols,"deleteAttender","参加者削除");
                $("#attender-record"+current_idx).add("#belongs-record"+current_idx).fadeOut(function () {
                    $(this).remove();
                });
                return false;

            }
        });




        //見出し記事追加機能。cloneにすべきか考え中
        $("#content").on("click", ".add-heading", function (event) {

            var id = $("#ProceedingId").val(),
//                last_heading = $(".content-block").find(":last"),
//                $(".heading").length,
                heading_idx =
                    Math.max.apply(null ,
                        $(".heading").map(
                            function (i,el) {return parseInt($(this).attr("id").match(/[0-9]+/),10)}))+1,//追加するidx(現在の最大idx+1）・・・暫定

                id_heading = "\"data[Heading][" + heading_idx + "][id]\"",//見出しのid名
                array_heading_val=$(".HideHeadingId").map(function (index, el){return parseInt($(this).val(),10); }),
                array_content_val=$(".HideContentId").map(function (index, el){return parseInt($(this).val(),10); }),
                id_heading_val = Math.max.apply(null,array_heading_val)+1,//見出しの最大id値+1
                id_content_val=Math.max.apply(null,array_content_val)+1,//記事の最大id値+1
                name_heading = "\"data[Heading][" + heading_idx + "][heading_name]\"",
                label_heading = " \"Heading" + heading_idx + "HeadingName\"",
                format = "<li id=\"heading_" + heading_idx + " \" class=\"heading\"><span><button class=\"btn remove-btn remove-heading\" type=\"button\">見出し削除-</button></span>\n" +
                    "<div class=\"input text\">" +
                    "<label for=" + label_heading + ">見出し名</label>" +
                    "<input name=" + name_heading + " class=\"form-extension extension-heading \" maxlength=\"255\" type=\"text\" value=\"\" id=" + label_heading + "></div> " +
                    "<input type=\"hidden\" name=" + id_heading + " value=\"" + id_heading_val + "\" class=\"HideHeadingId\" id=\"Heading" + heading_idx + "Id\">" +
                    "<ul class=\"inner_content\">\n" +
                        "<li  class=\" contents content_0\">\n" +
                            "<label for=\"Heading" + heading_idx + "Content0Content\">Shift+Enterで項目追加</label>" +
                            "<textarea name=\"data[Heading][" + heading_idx + "][Content][0][content]\" class=\"form-extension extension-content\" cols=\"30\" rows=\"3\" " +
                            "id=\"Heading" + heading_idx + "Content0Content\"></textarea>" +
                            "<input type=\"hidden\" name=\"data[Heading]["+heading_idx+"][Content][0][id]\" value=\""+id_content_val+"\" class=\"HideContentId\" id=\"Heading"+heading_idx+"Content0Id\">" +
                            "<span><button class=\"btn remove-btn remove-content\" type=\"button\">削除</button></span>"+
                            "<div class=\"input radio\"><fieldset><input type=\"hidden\" name=\"data[Heading][" + heading_idx + "][Content][0][status]\" id=\"Heading" + heading_idx + "Content0Status_\"  value=\"\">" +
                            "<input type=\"radio\" name=\"data[Heading][" + heading_idx + "][Content][0][status]\" id=\"Heading" + heading_idx + "Content0StatusFixed\" value=\"fixed\">" +
                            "<label for=\"Heading" + heading_idx + "Content0StatusFixed\">決定</label>" +
                            "<input type=\"radio\" name=\"data[Heading][" + heading_idx + "][Content][0][status]\" id=\"Heading" + heading_idx + "Content0StatusTask\" value=\"task\">" +
                            "<label for=\"Heading" + heading_idx + "Content0StatusTask\">課題</label></fieldset></div>\n" +
                        "</li>\n" +
                    "</ul>\n" +
                    "<div><button class=\"btn add-btn add-heading\" type=\"button\">見出し追加</button></div>\n"+
                    "</li> ";


            $(this).closest("[id^=heading_]").after(format)
                .hide()
                .fadeIn();
            array_heading_val.push(id_heading_val);

            idModify(array_heading_val,$(".HideHeadingId"));
            //id修正


            postAjax(id,"add","見出し追加",$("form").serialize());


            // ページをリロードしないようにする
            return false;
        });
        //見出し削除
        $(document).on("click", ".remove-heading", function () {
            var　id_val_heading = $(this).parent().nextAll(".HideHeadingId").val(),
                num_heading = $(".heading").length;
            if(num_heading <= 1 ) {
            alert("見出しは一つ以上必要です。");//暫定対応。見出しをすべて消してしまうと、見出しが追加できない
            return false;

            }else{
                    postAjax(id_val_heading,"deleteHeading","見出し削除",{});

                    $(this).parents(".heading").fadeOut(function () {
                    $(this).remove();
                    });

                    return false;

            }
        });


        //記事追加
        $(document).on("keydown",".extension-content",function (e) {
            if (event.shiftKey) {
                if (e.keyCode === 13) {
                    var id = $("#ProceedingId").val(),

                        idx_content= Math.max.apply(null , $(this).closest(".inner_content").children().map(function (i,el) {
                            return parseInt($(this).attr("class").match(/[0-9]+/),10)}))+1,//コンテンツの最大idx
                        idx_Heading= $(this).parents(".heading").attr("id").match(/[0-9]+/),//見出しのidx
                        array_val_contents=$(".HideContentId").map(function (index, el){return parseInt($(this).val(),10); }),
                        id_val_content =Math.max.apply(null,array_val_contents)+1, //ページ内最大のコンテンツid値。これをイテレートさせて追加記事を作る次第

                        format=
                            "<li class=\"contents content_"+idx_content+"\">\n" +
                            "<label for=\"Heading"+idx_Heading+"Content"+idx_content+"Content\">Shift+Enterで項目追加</label>" +
                            "<textarea name=\"data[Heading]["+idx_Heading+"][Content]["+idx_content+"][content]\"" +
                            " class=\"form-extension extension-content\" cols=\"30\" rows=\"3\" id=\"Heading"+idx_Heading+"Content"+idx_content+"Content\"></textarea>" +
                            "<span><button class=\"btn remove-btn remove-content\" type=\"button\">削除</button></span>"+
                            "<input type=\"hidden\" name=\"data[Heading]["+idx_Heading+"][Content]["+idx_content+"][id]\" value=\""+id_val_content+"\" class=\"HideContentId\" id=\"Heading"+idx_Heading+"Content"+idx_content+"Id\">" +
                            "<div class=\"input radio\"><fieldset><input type=\"hidden\" name=\"data[Heading]["+idx_Heading+"][Content]["+idx_content+"][status]\" id=\"Heading"+idx_Heading+"Content"+idx_content+"Status_\" value=\"\"><input type=\"radio\" name=\"data[Heading]["+idx_Heading+"][Content]["+idx_content+"][status]\" id=\"Heading"+idx_Heading+"Content"+idx_content+"StatusFixed\" value=\"fixed\">" +
                            "<label for=\"Heading"+idx_Heading+"Content"+idx_content+"StatusFixed\">決定</label>" + "<input type=\"radio\" name=\"data[Heading]["+idx_Heading+"][Content]["+idx_content+"][status]\" id=\"Heading"+idx_Heading+"Content"+idx_content+"StatusTask\" value=\"task\">" +
                            "<label for=\"Heading"+idx_Heading+"Content"+idx_content+"StatusTask\">課題</label></fieldset></div>\n" +
                            "</li>" ;




                    $(this).closest(".contents").after(format)
                        .hide()
                        .fadeIn();

                    //id修正
                    array_val_contents.push(id_val_content);
                    idModify(array_val_contents,$(".HideContentId"));
                    postAjax(id,"add","記事内容追加",$("form").serialize());

                    console.log(id_val_content);
//                    location.reload();
                    return false;
                }
            }
        });
        //記事内容削除
        $(document).on("click", ".remove-content", function () {
            var id_val_content = $(this).parent().nextAll(".HideContentId").val(),
                num_contents=$(this).closest(".inner_content").get(0).childElementCount;//コンテンツの要素数。

            if(num_contents <= 1 ) {
                alert("記事内容は一つ以上必要です。");//記事が追加できないため
                return false;
            }else {
                postAjax(id_val_content,"deleteContent","記事内容削除",{});

                $(this).closest(".contents").fadeOut(function () {
                    $(this).remove();
                });
                return false;
            }
        });

    });
</script>