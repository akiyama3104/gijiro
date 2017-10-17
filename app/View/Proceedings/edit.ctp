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
    <li>参加者：
        <?php foreach($editData["Attender"] as $i=> $attender):?>
            <?=$this->Form->hidden("Attender.".$i.".id");//更新するため主キー設定?>
            <p><?=$this->Form->input("Attender.".$i.".attender_name",array("type"=>"text","size"=>20));?>
                所属:<?=$this->Form->input("Attender.".$i.".belongs",array("type"=>"text","size"=>20));?></p>


        <?endforeach;?>
    </li>
    <li>会議目的：<?=$this->Form->input("agenda");?></li>
    <li>会議種類：<?=$this->Form->input("type",array("options" => $type_id,"type"=>"radio"));?></li>
    <li>カテゴリ選択：<?=$this->Form->input("CategoryList",array("options"=>$categories,'type' => 'select','multiple'=> 'checkbox',)); ?>
<!--    --><?//=$this->Form->hidden("CategoryList.id"); ?>
    </li>
    <li>会議内容:

        <ul class="content-block">
            <?php foreach($editData["Heading"] as $i =>  $heading):?>


            <li id="heading_<?=$i;?>"class="heading">見出し：<span><button class="remove-btn remove-heading" type="button">見出し削除-</button></span>
                <?= $this->Form->input("Heading.".$i.".heading_name",array("class"=>array("form-extension","extension-heading")));?>


                <?=$this->Form->hidden("Heading.".$i.".id");//更新,削除するため主キー設定?>

                <ul class="inner_content">
                    <?php foreach($heading["Content"] as $j => $content):?>
                    <li class="content_<?=$j?> Heading_<?=$i?> contents">

                        <?= $this->Form->input("Heading.".$i.".Content.".$j.".content",array("class"=>array("form-extension","extension-content")));?>

                        <?=$this->Form->hidden("Heading.".$i.".Content.".$j.".id");//更新、削除するため主キー設定?>
                        <?=$this->Form->input("Heading.".$i.".Content.".$j.".status",array("options"=>array("fixed"=>"決定","task"=>"課題"),"type"=>"radio"));?>

                    </li>

                    <?php endforeach;?>
                </ul>

            </li>
           <?php endforeach;?>

        </ul>
            <span><button class="add-heading" type="button" >見出し追加</button></span>
            <span><button class="remove-heading" type="button" >見出し削除</button></span>
    </li>
    <li>次回開催時間：<?=$this->Form->input("next_start",$dateOption);?>：～<?=$this->Form->input("next_end",$dateOption);?></li>
    <li>次回開催場所：<?=$this->Form->input("next_place");?></li>
    <li>補足<?=$this->Form->input("suppl");?></li>

    <li><?= $this->Form->end("編集完了");?></li>
</ul>
<?=$this->form->postLink('削除',array('action'=>'delete', $editData["Proceeding"]["id"]),array('class'=>'link-style'),'本当に削除しますか?');?>


<script>
    $(function() {
        $(".addheading").click(function (e) {
            if (confirm("sure?")) {
                $.post("/gijiro/proceedings/add/" + id, {}, function (res) {

                }, "json");
            }


        });
        //なぜか外部ファイルだと読み込めないので記述。消します
        //見出し記事追加機能。cloneにすべきか考え中
        $("#content").on("click", ".add-heading", function (event) {
            var id = $("#ProceedingId").val(),
                last_heading = $(".content-block").find(":last"),

                heading_idx = $(".heading").length,
                heading_end_idx = heading_idx - 1,
                id_heading = "\"data[Heading][" + heading_idx + "][id]\"",
                id_heading_val = parseInt($("#Heading" + heading_end_idx + "Id").val(), 10) + 1,//見出しのid値
                name_heading = "\"data[Heading][" + heading_idx + "][heading_name]\"",
                label_heading = " \"Heading" + heading_idx + "HeadingName\"",
                format = "<li id=\"heading_" + heading_idx + " \" class=\"heading\">見出し：<span><button class=\"remove-btn remove-heading\" type=\"button\">見出し削除-</button></span>\n" +
                    "<div class=\"input text\">" +
                    "<label for=" + label_heading + ">Heading Name</label>" +
                    "<input name=" + name_heading + " class=\"form-extension extension-heading \" maxlength=\"255\" type=\"text\" value=\"\" id=" + label_heading + "></div> " +
                    "<span><button class=\"add-btn add-content\" type=\"button\" >+</button></span>\n" +
                    "<input type=\"hidden\" name=" + id_heading + " value=\"" + id_heading_val + "\" id=\"Heading" + heading_idx + "Id\">" +
                    "<ul class=\"inner_content\">\n" +
                    "<li  class=\"content_0 Heading_"+heading_idx+" contents\">\n" +
                    " <div class=\"input textarea\"><label for=\"Heading" + heading_idx + "Content0Content\">Content</label>" +
                    "<textarea name=\"data[Heading][" + heading_idx + "][Content][0][content]\" class=\"form-extension extension-content\" cols=\"30\" rows=\"6\" " +
                    "id=\"Heading" + heading_idx + "Content0Content\"></textarea></div>" +
                    "<div class=\"input radio\"><fieldset><legend>Status</legend><input type=\"hidden\" name=\"data[Heading][" + heading_idx + "][Content][0][status]\" id=\"Heading" + heading_idx + "Content0Status_\" value=\"\">" +
                    "<input type=\"radio\" name=\"data[Heading][" + heading_idx + "][Content][0][status]\" id=\"Heading" + heading_idx + "Content0StatusFixed\" value=\"fixed\">" +
                    "<label for=\"Heading" + heading_idx + "Content0StatusFixed\">決定</label>" +
                    "<input type=\"radio\" name=\"data[Heading][" + heading_idx + "][Content][0][status]\" id=\"Heading" + heading_idx + "Content0StatusTask\" value=\"task\">" +
                    "<label for=\"Heading" + heading_idx + "Content0StatusTask\">課題</label></fieldset></div>\n" +
                    "</li>\n" +
                    "</ul>\n" +
                    "</li> ";


            $(".content-block").append(format)
                .hide()
                .fadeIn();

            $.ajax({
                type: "post",
                url: "/gijiro/proceedings/add/" + id,
                data: $("form").serialize(),
                //通信失敗
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    console.log("ajax通信に失敗しました");
                    console.log("XMLHttpRequest : " + XMLHttpRequest.status);
                    console.log("textStatus     : " + textStatus);
                    console.log("errorThrown    : " + errorThrown.message);
                },
                //ajax通信成功
                success : function(response) {
                    console.log("ajax通信に成功しました");

                }
            });
            // ページをリロードしないようにする
            return false;
        });

        $(document).on("click", ".remove-heading", function (e) {
            var id_heading = $(this).closest("li").attr("id"),
                id_val_heading = $(this).parent().nextAll("input").val(),
                num_heading = $(".heading").length;
            if(num_heading <= 1 ) {
            alert("見出しは一つ以上必要です。");//暫定対応。見出しをすべて消してしまうと、見出しが追加できない
            return false;

            }else{

                    $.ajax({
                        type: "post",
                        url: "/gijiro/proceedings/deleteHeading/" + id_val_heading,
                        data: {},
                        dataType: "html",
                        //通信失敗
//                        error: function (XMLHttpRequest, textStatus, errorThrown) {
//                            console.log("ajax通信に失敗しました");
//                            console.log("XMLHttpRequest : " + XMLHttpRequest.status);
//                            console.log("textStatus     : " + textStatus);
//                            console.log("errorThrown    : " + errorThrown.message);
//                        },
                        //ajax通信成功
                        success: function (res) {
                            console.log("ajax通信に成功しました");

                        }
                    });

//                        alert(id_val_heading);
                    $(this).parents(".heading").fadeOut(function () {
                    $(this).remove();
                    });

                    return false;

            }
        });
        $(document).on("keydown",".extension-content",function (e) {
            if (event.shiftKey) {
                if (e.keyCode === 13) {


                    var id = $("#ProceedingId").val(),
                        num_contents=$(this).parents("[class^=content_]").siblings().length+1,//コンテンツの数
                        idx_Heading=$(this).parents(".heading").attr("id").match(/[0-9]+/),//見出しのidx
                        format=
                        "<li>\n" +
                        "<div class=\"input textarea\">" +
                            "<label for=\"Heading"+idx_Heading+"Content"+num_contents+"Content\">Content</label>" +
                            "<textarea name=\"data[Heading]["+idx_Heading+"][Content]["+num_contents+"][content]\"" +
                            " class=\"form-extension extension-content\" cols=\"30\" rows=\"6\" id=\"Heading"+idx_Heading+"Content"+num_contents+"Content\"></textarea>" +
                        "</div>\n" +
//                         "<input type=\"hidden\" name=\"data[Heading]["+idx_Heading+"][Content]["+num_contents+"][id]\" value=\"55\" id=\"Heading"+idx_Heading+"Content"+num_contents+"Id\">" +
                        "<div class=\"input radio\"><fieldset><legend>Status</legend><input type=\"hidden\" name=\"data[Heading]["+idx_Heading+"][Content]["+num_contents+"][status]\" id=\"Heading"+idx_Heading+"Content"+num_contents+"Status_\" value=\"\"><input type=\"radio\" name=\"data[Heading]["+idx_Heading+"][Content]["+num_contents+"][status]\" id=\"Heading"+idx_Heading+"Content"+num_contents+"StatusFixed\" value=\"fixed\">" +
                        "<label for=\"Heading"+idx_Heading+"Content"+num_contents+"StatusFixed\">決定</label>" + "<input type=\"radio\" name=\"data[Heading]["+idx_Heading+"][Content]["+num_contents+"][status]\" id=\"Heading"+idx_Heading+"Content"+num_contents+"StatusTask\" value=\"task\">" +
                        "<label for=\"Heading"+idx_Heading+"Content"+num_contents+"StatusTask\">課題</label></fieldset></div>\n" +
                        "</li>" ;

//                        alert(idx_Heading);


                    $(this).parents(".inner_content").append(format)
                        .hide()
                        .fadeIn();

                    $.ajax({
                        type: "post",
                        url: "/gijiro/proceedings/add/" + id,
                        data: $("form").serialize(),
                        //通信失敗
                        error: function (XMLHttpRequest, textStatus, errorThrown) {
                            console.log("ajax通信に失敗しました");
                            console.log("XMLHttpRequest : " + XMLHttpRequest.status);
                            console.log("textStatus     : " + textStatus);
                            console.log("errorThrown    : " + errorThrown.message);
                        },
                        //ajax通信成功
                        success : function(response) {
                            console.log("ajax通信に成功しました");

                        }
                    });
//                    location.reload();
                    return false;
                }
            }
        });



    });
</script>