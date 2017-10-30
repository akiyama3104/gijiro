<?php
/**
 * Created by PhpStorm.
 * User: satos
 * Date: 2017/09/28
 * Time: 18:49
 */

?>


<?php $user=$this->Session->read("Auth.User"); //ユーザー情報読み込み?>



<!--投稿者であるユーザーidも送付する-->

<?php


    $highlight_words=array();
if(isset($this->request->data["Proceeding"]["keyword"])){//ハイライトさせるキーワード
    $highlight=mb_convert_kana($this->request->data["Proceeding"]["keyword"] , "s");
    $highlight_words=preg_split("/[\s,]+/",$highlight);
}

?>
<?php $highlight_option=array("format"=>"<span class =\"bg-warning\">$1</span>");
    //ハイライトの設定。
?>

    <div class="well form_search_index" >
        <?php echo $this->Form->create("Proceeding", array("url"=>array("controller"=>"users","action"=>"index"))); ?>
        <fieldset>

            <?=$this->Form->input("keyword",array( "label"=>"検索キーワード（タイトル、投稿者、場所、補足）"));?>
            <?=$this->Form->input("mt_type",array("label"=>"会議する部署は？","options" => $type_id,"empty"=>""));?>
            <button type="button" class="btn btn-primary hide-button">詳細に検索したい</button>
            <div class="hide-target">
            <?=$this->Form->input("contents",array("label"=>"議題目的、議題内容"));?>

            <?=$this->Form->input("attender_belong",array("label"=>"参加者所属"));?>

            <?=$this->Form->input("next_place",array("label"=>"次回開催場所"));?>

            <?=$this->Form->input("user_id",array("label"=>"投稿者名","class"=>"span4","options"=>$user_id,"empty"=>""));?>

            <p>
            <?=$this->Form->input("attender",array("label"=>"参加者", "class"=>"span4" ,"options"=>$attenders,"empty"=>""));?>
            </p>
            <p>
             <?=$this->Form->input("category",array("label"=>"カテゴリ", "class"=>"span12",'type' => 'select', 'multiple' => 'checkbox',"options"=>$categories,"empty"=>""));?>
            </p>
            <p>
                <span class="input-group date date_time_pick" >
                <?= $this->Form->input("from_hold_date", array("label"=>"開催日期間検索","type"=>"text","div"=>false)); ?>
                <span class="input-group-addon"><span class="glyphicon-calendar glyphicon"></span></span>
                </span>
                ～
                <span class="input-group date date_time_pick" >
                <?= $this->Form->input("to_hold_date", array("label"=>false,"type"=>"text","div"=>false)); ?>
                <span class="input-group-addon"><span class="glyphicon-calendar glyphicon"></span></span>
                </span>
            </p>
            <p>

                <span class="input-group date date_time_pick" >
                <?= $this->Form->input("from_next_hold", array("label"=>"次回開催日期間検索","type"=>"text","div"=>false)); ?>
                <span class="input-group-addon"><span class="glyphicon-calendar glyphicon"></span></span>
                </span>
                ～
                <span class="input-group date date_time_pick" >
                <?= $this->Form->input("to_next_hold", array("label"=>false,"type"=>"text","div"=>false)); ?>
                <span class="input-group-addon"><span class="glyphicon-calendar glyphicon"></span></span>
                </span>

            </p>
            <?= $this->Form->input("post_date", array("label"=>"投稿日","type" => "text","class"=>"datepicker")) ?>
            </div>
            <?php echo $this->Form->end(array("label"=>"検索","class"=>array("btn", "btn-lg","btn-success"))); ?>


        </fieldset>

    </div>


<article class="list_proceeding row">
    <h2>議事録一覧</h2>

    <div class="row-fluid">


        <table class="table">
            <tr>
                <th><?= $this->Paginator->sort("Proceeding.title","タイトル順");?></th>
                <th><?= $this->Paginator->sort("Proceeding.created","投稿日時順");?></th>

            </tr>
        </table>
    </div>
<?php foreach ($proceedings as $proceeding): ?>

<section id="post_<?=h($proceeding["Proceeding"]["id"]) ?> span3">
        <?php $title=$this->Html->link( $proceeding["Proceeding"]["title"],array("controller"=>"proceedings","action"=>"view",$proceeding["Proceeding"]["id"]));?>
    <h2><?=$this->Text->highlight($title,$highlight_words,$highlight_option); ?></h2>
    <ul>
        <li>投稿者:<?=$this->Text->highlight( h($proceeding["User"]["username"]),$highlight_words,$highlight_option);?></li>
        <li>日時：<?= h($proceeding["Proceeding"]["start_time"]);?>～<?= h($proceeding["Proceeding"]["end_time"]);?></li>
        <li>場所：<?=$this->Text->highlight(h($proceeding["Proceeding"]["place"]),$highlight_words,$highlight_option);?></li>
        <li>会議種類：<?= $type_id[$proceeding["Proceeding"]["type"]];?>        </li>
        <li>参加者：
            <?php foreach($proceeding["Attender"] as $attender) :?>
                <?=$this->Text->highlight( h($attender["attender_name"]),$highlight_words,$highlight_option);?>
            <?php endforeach;?>
        </li>
        <li>カテゴリ：<?php foreach($proceeding["Category"] as $category) :?>
                <?=$this->Text->highlight( h($category["category"]),$highlight_words,$highlight_option);?>
            <?php endforeach;?>
        </li>
        <li>補足：<?=$this->Text->highlight( h($proceeding["Proceeding"]["suppl"]),$highlight_words,$highlight_option);?></li>
        <li>投稿日時：<?=h($proceeding["Proceeding"]["created"]);?></li>

    </ul>


</section>
<?php endforeach;?>

</article>



