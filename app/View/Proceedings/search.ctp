<?php
/**
* Created by PhpStorm.
* User: satos
* Date: 2017/09/29
* Time: 11:50
*/
?>



<h2>詳細検索画面</h2>



<div class="span3">
    <div class="well" >
        <?php echo $this->Form->create("Proceeding", array("action"=>"search")); ?>
        <fieldset>
            <span></span>
            <?=$this->Form->input("overview",array("label"=>"議題名、議題目的"));?>
            <?=$this->Form->input("contents",array("label"=>"議題内容"));?>
            <?=$this->Form->input("attender_name",array("label"=>"参加者"));?>
            <?=$this->Form->input("attender_belong",array("label"=>"参加者所属名"));?>
            <?=$this->Form->input("pro_type",array("label"=>"議題種類"));//チェックボックス?>
            <?=$this->Form->input("user_id",array("label"=>"投稿者名","class"=>"span12","options"=>$user_id,"empty"=>""));?>
            <?=$this->Form->input("time",array("label"=>"開催時間の期間検索","class"=>"span12","options"=>$user_id,"empty"=>""));?>
            <?=$this->Form->input("next_time",array("label"=>"次回開催時間の期間検索","class"=>"span12","options"=>$user_id,"empty"=>""));?>
            <?=$this->Form->input("place",array("label"=>"開催場所"));?>
            <?=$this->Form->input("next_place",array("label"=>"次回開催場所"));?>
            <?=$this->Form->input("next_place",array("label"=>"次回開催場所"));?>
            <!--            --><?//=$this->Form->input("Proceeding.type",array("options" => array("inner"=>"社内","outer"=>"社外","other"=>"その他"),"multiple"=>"checkbox"));?>
            <?php echo $this->Form->end("検索"); ?>
            <?= $this->Html->link("詳細検索へ",array("controller"=>"Proceedings","action"=>"search"));?>
        </fieldset>

    </div>
</div>

<article>
    <h2>議事録一覧</h2>
    <!--    会議種類の表示用配列-->
    <?php $mtType=array("inner"=>"社内","outer" =>"社外","other"=>"その他");?>

    <div class="row-fluid">

        <div class="span9">
            <table class="table">
                <tr>
                    <th><?= $this->Paginator->sort("User.id","ID");?></th>
                    <th><?= $this->Paginator->sort("Proceeding.title","タイトル");?></th>
                    <th><?= $this->Paginator->sort("Proceeding.created","投稿日時");?></th>

                </tr>
            </table>
            <?php foreach ($proceedings as $proceeding): ?>

                <section id="post_<?=h($proceeding["Proceeding"]["id"]) ?>">
                    <?php $title=$this->Html->link( $proceeding["Proceeding"]["title"],array("controller"=>"proceedings","action"=>"view",$proceeding["Proceeding"]["id"]));?>
                    <h2><?=$this->Text->highlight($title,$highlight_words,$highlight_option); ?></h2>
                    <ul>
                        <li>日時：<?= h($proceeding["Proceeding"]["start_time"]);?>～<?= h($proceeding["Proceeding"]["end_time"]);?></li>
                        <li>場所：<?=$this->Text->highlight(h($proceeding["Proceeding"]["place"]),$highlight_words,$highlight_option);?></li>
                        <li>会議種類：<?= $mtType[$proceeding["Proceeding"]["type"]];?>        </li>
                        <li>参加者：
                            <?php foreach($proceeding["Attender"] as $attender) :?>
                                <?=$this->Text->highlight( h($attender["attender_name"]),$highlight_words,$highlight_option);?>
                            <?php endforeach;?>
                        </li>
                        <li>投稿者:<?=$this->Text->highlight( h($proceeding["User"]["username"]),$highlight_words,$highlight_option);?></li>
                        <li>投稿日時：<?=h($proceeding["Proceeding"]["created"]);?></li>
                    </ul>

                    <?=debug($proceeding);?>

                </section>
            <?php endforeach;?>

</article>
</div>
</div>