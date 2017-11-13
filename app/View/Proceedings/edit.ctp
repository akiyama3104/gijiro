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


<ul>
    <?=$this->Form->create("Proceeding",array("action"=>"edit"));?>
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
    <li><table class="Attenders-table  table table-bordered table-responsive">
            <tr class="attenders-row"><th class="row_explain"><h3>参加者：(Shift+Enterで追加）</h3></th>
                <?php foreach($editData["Attender"] as $i=> $attender):?>
                    <td id="attender-record<?=$i?>">
                        <?=$this->Form->hidden("Attender.".$i.".id",array("class"=>"HideAttenderId"));//更新するため主キー設定?>
                        <button type="button" class="btn add-btn add-btn-attender">+</button>
                        <button type="button" class="btn remove-btn remove-attender">-</button>
                        <?=$this->Form->input("Attender.".$i.".attender_name",array("type"=>"text","size"=>"5","label"=>"" ,"class"=>array("attender-name","add-attender","allow-enter","attender_".$i), "div"=>false));?>
                    </td>
                <?php endforeach; ?>
            </tr>
            <tr class="belongs-row"><th class="row_explain"><h3>所属：</h3></th>
                <?php foreach($editData["Attender"] as $i=> $attender):?>
                    <td id="belongs-record<?=$i?>">
                        <?=$this->Form->input("Attender.".$i.".belongs",array("type"=>"text","size"=>"5" ,"label"=>false, "class"=>array("belong","add-belong","allow-enter","add-attender"),"div"=>false));?>
                    </td>
                 <?php endforeach;?>
            </tr>
    </table></li>

    <li><h3>会議部署：</h3><?=$this->Form->input("type",array("options" => $type_id,"type"=>"radio",));?></li>
    <li><h3>カテゴリ選択：</h3><?=$this->Form->input("Category",array("options"=>$categories,'type' => 'select','multiple'=> 'checkbox',"label"=>false)); ?>
<!--    --><?//=$this->Form->hidden("CategoryList.id"); ?>
    </li>
    <li><h3>会議内容:</h3>

        <ul class="content-block">
            <?php foreach($editData["Heading"] as $i =>  $heading):?>


            <li id="heading_<?=$i;?>"class="heading">
                <?= $this->Form->input("Heading.".$i.".heading_name",array("class"=>array("form-extension","extension-heading"),"label"=>"見出し名"));?>
                <?=$this->Form->hidden("Heading.".$i.".id", array("class"=>"HideHeadingId"));//更新,削除するため主キー設定?>
               <ul class="inner_content">
                    <?php foreach($heading["Content"] as $j => $content):?>
                    <li class="contents content_<?=$j?>">
                        <?= $this->Form->input("Heading.".$i.".Content.".$j.".content",array("class"=>array("form-extension","extension-content"),"rows"=>"3","label"=>"Shift+Enterで項目追加","div"=>false));?>
                        <?=$this->Form->hidden("Heading.".$i.".Content.".$j.".id",array("class"=>"HideContentId"));//更新、削除するため主キー設定?>
                        <?=$this->Form->input("Heading.".$i.".Content.".$j.".status",array("options"=>array("fixed"=>"決定","task"=>"課題"),"type"=>"radio","legend"=>false,"style"=>"float:none;","div"=>"radio-horizontal"));?>
                        <span><button class="btn  btn-danger remove-btn remove-content" type="button">削除</button></span>
                    </li>
                    <?php endforeach;?>
                </ul>
                <div class="zone-btn"><span><button class="btn btn-lg btn-primary add-btn add-heading" type="button">見出し追加</button> </span><span><button class="btn btn-danger remove-btn remove-heading" type="button">見出し削除</button></span></div>
           <?php endforeach;?>

        </ul>
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
    <li><h3>補足</h3><?=$this->Form->input("suppl",array("label"=>false));?></li>

    <li><?= $this->Form->end(array("label"=>"保存", "class"=>array("btn","btn-success","btn-lg")));?></li>
</ul>

<?php //暫定処理。記事を作成したユーザーのみが削除できる.

if( $this->Session->read("Auth.User.id") ==$this->request->data["User"]["id"]){ //セッション内のuserID、議事録の投稿者IDを比較
    echo $this->form->postLink('削除',array('action'=>'delete', $editData["Proceeding"]["id"]),array("class"=>array("btn btn-danger")),'本当に削除しますか?');
 } ?>

<script>

    $(function() {
        var json_attenders =<?= $json_attender?>;


		//auto comlete用
        $(document).on("keyup",".attender-name",function(){


            $(".attender-name").autocomplete({
                source: json_attenders,
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

            //ajaxで検索かける用。レスポンスが遅かったり不具合があったりで不採用
//                var keyword = $(this).val();
//                availableTags = new Array();
//
//                $.ajax({
//                    'type': 'get',
//                    'dataType': 'json',
//                    'url': 'gijiro/proceedings/autoSearch?query=' + keyword,
//                    'success': function(data) {
//                        if (data != '') {
//
//                            availableTags = data;
//
//                            $('.attender-name').autocomplete({
//                                source: availableTags,
//                                autoFocus: true,
//                                delay: 500,
//                                minLength: 2
//
//                            });
//
//                        }
//                    },
//                    'error': function(XMLHttpRequest, textStatus, errorThrown) {
//                            console.log("失敗しました");
//                            console.log("XMLHttpRequest : " + XMLHttpRequest.status);
//                            console.log("textStatus     : " + textStatus);
//                            console.log("errorThrown    : " + errorThrown.message);
//                    }
//                });
        });








        //途中で挿入した内容の順番を保持するために、各idを振りなおす修正関数
        function idModify(array_id_val,target_modify) {
//            console.log(array_id_val);
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
//            console.log(array_id_val);
        }

        // ajaxをPost形式で投げる
        // 引数は
        // 1:urlのパラメータ、2:コントローラのメソッド、
        // 3:コンソールログに乗せる関数の名称、4:データ、5:データタイプ、
        // 6:非同期通信か否かの順
        function postAjax(id,address,data,type="html",async=true){
            return $.ajax({
                type: "post",
                url: "/gijiro/proceedings/"+address+"/" + id,
                dataType:type,
                async:async,//戻り値を取得したいので、同期通信する場合もある。
                data: data
            });

        }


        function addAjax(id,address,nameMethod="",data={}){

           return postAjax(id,address,data,"JSON",false)
            .done(function(res){ //ajax通信成功
//                console.log(nameMethod+"成功しました");
                return res;

            }).fail(function (XMLHttpRequest, textStatus, errorThrown) { //通信失敗
                console.log(nameMethod + "失敗しました");
                console.log("XMLHttpRequest : " + XMLHttpRequest.status);
                console.log("textStatus     : " + textStatus);
                console.log("errorThrown    : " + errorThrown.message);
            })["responseJSON"];//レスポンス部分のキー
        }
        function removeAjax(id,address,nameMethod="",data={}){
            return postAjax(id,address,data,"HTML",true)
                .done(function(){ //ajax通信成功
//                console.log(nameMethod+"成功しました");
                })
                .fail(function (XMLHttpRequest, textStatus, errorThrown) { //通信失敗
                console.log(nameMethod + "失敗しました");
                console.log("XMLHttpRequest : " + XMLHttpRequest.status);
                console.log("textStatus     : " + textStatus);
                console.log("errorThrown    : " + errorThrown.message);


            });
        }
        //参加者追加共通関数
        function addAttender(add_triger){

            var id = $("#ProceedingId").val(),
                //id_values=addAjax(id,"addAttender","参加者追加",{proceeding_id:id}),
                idx_cols=Math.max.apply(null ,
                    $("[id^=attender-record]").map(
                        function () {return parseInt($(this).attr("id").match(/[0-9]+/),10)}))+1,//追加するのカラムのidx
                current_idx= add_triger.closest("td").attr("id").match(/[0-9]+/),//現在のidx(挿入する際に必要)
              //  val_id_cols =id_values["AttenderId"],//echo $AttenderId?>参加者id値の最大値+1
               // array_val_cols=$(".HideAttenderId").map(function(){return parseInt($(this).val(),10);}),//参加者idの配列
                format_attender=
                    "<td id=\"attender-record"+idx_cols+"\">\n" +//"+val_id_cols+"
                   // "<input type=\"hidden\" name=\"data[Attender]["+idx_cols+"][id]\" class=\"HideAttenderId\" value=\""+val_id_cols+"\" id=\"Attender"+idx_cols+"Id\">" +
                    "<button type=\"button\" class=\"btn add-btn add-btn-attender\">+</button>\n" +
                    "  <button type=\"button\" class=\"btn remove-btn remove-attender\">-</button>\n" +
                    "<label for=\"Attender"+idx_cols+"AttenderName\"></label><input name=\"data[Attender]["+idx_cols+"][attender_name]\" size=\"5\" class=\"attender-name add-attender allow-enter attender_"+idx_cols+"\" type=\"text\"  id=\"Attender"+idx_cols+"AttenderName\"> " +
                    "</td>",
                format_belongs="<td id=\"belongs-record"+idx_cols+"\">\n" +
                    "<input name=\"data[Attender]["+idx_cols+"][belongs]\" size=\"5\" " +
                    "class=\"belong add-belong allow-enter add-attender\" maxlength=\"255\" type=\"text\"  id=\"Attender"+idx_cols+"Belongs\">" +
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
            var　id_val_cols = $(this).siblings(".HideAttenderId").val(),//カラムのid値
                current_idx= $(this).closest("td").attr("id").match(/[0-9]+/),//カラムのidx
                num_attenders = $("[id^=attender-record]").length;//カラムの数
            if(num_attenders <= 1 ) {
                alert("参加者は一人以上必要です。");
                return false;
            }else{
//                removeAjax(id_val_cols,"deleteAttender","参加者削除");
                $(this).prevFocusAttender();//フォーカスを前の項目に移動。(gijiro-layoutに関数を記載)
                $("#attender-record"+current_idx).add("#belongs-record"+current_idx).fadeOut(function () {
                    $(this).remove();
                });
                return false;

            }
        });




        //見出し記事追加機能。cloneにすべきか考え中
        $(document).on("click", ".add-heading", function (event) {
            var id = $("#ProceedingId").val(),
                id_values=addAjax(id,"addHeading","記事見出し追加",{proceeding_id:id}),//ajax呼び出し,追加するid値を返す
                id_heading_val=id_values["HeadingId"],
                id_content_val=id_values["ContentId"],

                heading_idx =   //追加するidx(現在の最大idx+1）・・・暫定
                Math.max.apply(null ,
                   $(".heading").map(
                       function (i,el) {return parseInt($(this).attr("id").match(/[0-9]+/),10)}))+1,
                label_heading = " \"Heading" + heading_idx + "HeadingName\"",
                format =
                "<li id=\"heading_" + heading_idx + " \" class=\"heading\">\n" +
                "<div class=\"input text\">" +
                "<label for=" + label_heading + ">見出し名</label>" +
                "<input name= \"data[Heading][" + heading_idx + "][heading_name]\"  class=\"form-extension extension-heading \" maxlength=\"255\" type=\"text\" value=\"\" id=" + label_heading + "></div> " +
                "<input type=\"hidden\" name=\"data[Heading][" + heading_idx + "][id]\" value=\"" + id_heading_val + "\" class=\"HideHeadingId\" id=\"Heading" + heading_idx + "Id\">" +
                "<ul class=\"inner_content\">\n" +
                    "<li  class=\" contents content_0\">\n" +
                    "<label for=\"Heading" + heading_idx + "Content0Content\">Shift+Enterで項目追加</label>" +
                    "<textarea name=\"data[Heading][" + heading_idx + "][Content][0][content]\" class=\"form-extension extension-content\" cols=\"30\" rows=\"3\" " +
                    "id=\"Heading" + heading_idx + "Content0Content\"></textarea>" +
                    "<input type=\"hidden\" name=\"data[Heading]["+heading_idx+"][Content][0][id]\" value=\""+id_content_val+"\" class=\"HideContentId\" id=\"Heading"+heading_idx+"Content0Id\">" +
                    "<div class=\"radio-horizontal\"><input type=\"hidden\" name=\"data[Heading][" + heading_idx + "][Content][0][status]\" id=\"Heading" + heading_idx + "Content0Status_\"  value=\"\">" +
                    "<input type=\"radio\" name=\"data[Heading][" + heading_idx + "][Content][0][status]\" id=\"Heading" + heading_idx + "Content0StatusFixed\" value=\"fixed\" style=\"float:none;\">" +
                    "<label for=\"Heading" + heading_idx + "Content0StatusFixed\">決定</label>" +
                    "<input type=\"radio\" name=\"data[Heading][" + heading_idx + "][Content][0][status]\" id=\"Heading" + heading_idx + "Content0StatusTask\" value=\"task\" style=\"float:none;\">" +
                    "<label for=\"Heading" + heading_idx + "Content0StatusTask\">課題</label>" +
                    "</div>\n" +
                    "<span><button class=\"btn btn-danger remove-btn remove-content\" type=\"button\">削除</button></span>"+
                    "</li>\n" +
                "</ul>\n" +
                "<div class=\"zone-btn\"><span><button class=\"btn btn-lg btn-primary add-btn add-heading\" type=\"button\">見出し追加</button> </span>" +
                    "<span><button class=\"btn btn-danger remove-btn remove-heading\" type=\"button\">見出し削除</button></span></div>\n"+
                "</li> ";


            $(this).closest("[id^=heading_]").after(format)
                .hide()
                .fadeIn();

            var array_heading_val=$(".HideHeadingId").map(function (index, el){return parseInt($(this).val(),10); });

            idModify(array_heading_val,$(".HideHeadingId"));//id修正

            $(this).nextFocusHeading();//フォーカスを次の項目に移動。(gijiro-layoutに関数を記載)
            return false;
        });


        //見出し削除
        $(document).on("click", ".remove-heading", function () {
            var id_val_heading = $(this).parents(".zone-btn").siblings(".HideHeadingId").val(),
                num_heading = $(".heading").length;
            if(num_heading <= 1 ) {
            alert("見出しは一つ以上必要です。");//暫定対応。見出しをすべて消してしまうと、見出しが追加できない
            return false;
            }else{
                    removeAjax(id_val_heading,"deleteHeading","見出し削除",{});
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
                    var id = $(this).closest(".inner_content").siblings(".HideHeadingId").val(),
                        id_values=addAjax(id,"addContent","記事内容追加",{heading_id:id}),//ajax呼び出し
                        id_val_content=id_values["ContentId"],//コンテンツidのvalue
                        idx_content= Math.max.apply(null , $(this).closest(".inner_content").children().map(function (i,el) {
                            return parseInt($(this).attr("class").match(/[0-9]+/),10)}))+1,//コンテンツの最大idx
                        idx_Heading= $(this).parents(".heading").attr("id").match(/[0-9]+/),//見出しのidx


                        format=
                            "<li class=\"contents content_"+idx_content+"\">\n" +
                            "<label for=\"Heading"+idx_Heading+"Content"+idx_content+"Content\">Shift+Enterで項目追加</label>" +
                            "<textarea name=\"data[Heading]["+idx_Heading+"][Content]["+idx_content+"][content]\"" +
                            " class=\"form-extension extension-content\" cols=\"30\" rows=\"3\" id=\"Heading"+idx_Heading+"Content"+idx_content+"Content\"></textarea>" +
                            "<input type=\"hidden\" name=\"data[Heading]["+idx_Heading+"][Content]["+idx_content+"][id]\" value=\""+id_val_content+"\" class=\"HideContentId\" id=\"Heading"+idx_Heading+"Content"+idx_content+"Id\">" +
                            "<div class=\"radio-horizontal\">" +
                            "<input type=\"hidden\" name=\"data[Heading]["+idx_Heading+"][Content]["+idx_content+"][status]\" id=\"Heading"+idx_Heading+"Content"+idx_content+"Status_\" value=\"\">" +
                            "<input type=\"radio\" name=\"data[Heading]["+idx_Heading+"][Content]["+idx_content+"][status]\" id=\"Heading"+idx_Heading+"Content"+idx_content+"StatusFixed\" value=\"fixed\" style=\"float:none;\">" +
                            "<label for=\"Heading"+idx_Heading+"Content"+idx_content+"StatusFixed\">決定</label>" +
                            "<input type=\"radio\" name=\"data[Heading]["+idx_Heading+"][Content]["+idx_content+"][status]\" id=\"Heading"+idx_Heading+"Content"+idx_content+"StatusTask\" value=\"task\" style=\"float:none;\">" +
                            "<label for=\"Heading"+idx_Heading+"Content"+idx_content+"StatusTask\">課題</label>" +
                            "</div>\n" +
                            "<span><button class=\"btn btn-danger remove-btn remove-content\" type=\"button\">削除</button></span>"+
                            "</li>" ;
                    $(this).closest(".contents").after(format)
                        .hide()
                        .fadeIn();
                    var array_val_contents=$(".HideContentId").map(function (index, el){return parseInt($(this).val(),10); });
                    //id修正
                    idModify(array_val_contents,$(".HideContentId"));
                    $(this).nextFocusContent();//フォーカスを次の項目に移動。(gijiro-layoutに関数を記載)
                    return false;
                }
            }
        });
        //記事内容削除
        $(document).on("click", ".remove-content", function () {
            var id_val_content = $(this).parent().siblings(".HideContentId").val(),
                num_contents=$(this).closest(".inner_content").get(0).childElementCount;//コンテンツの要素数。
            if(num_contents <= 1 ) {
                alert("記事内容は一つ以上必要です。");//記事が追加できないため
                return false;
            }else {
                removeAjax(id_val_content,"deleteContent","記事内容削除",{});
                $(this).prevFocusContent();//フォーカスを前の項目に移動。(gijiro-layoutに関数を記載)
                $(this).closest(".contents").fadeOut(function () {
                    $(this).remove();
                });
                return false;
            }
        });

    });
</script>