<?php
/**
 * Created by PhpStorm.
 * User: satos
 * Date: 2017/10/02
 * Time: 11:45
 */
?>

<h2>議事録詳細画面</h2>

<?//カテゴリを表示する際のリスト宣言?>
<?php $mtType=array("inner"=>"社内","outer" =>"社外","other"=>"その他",""=>"");?>
<?php $ct_status=array("fixed"=>"決定","task"=>"課題","other"=>"その他",""=>"未設定");?>
<?=debug($proceeding);?>
<ul>
    <li><h2>議題：<?= h($proceeding["Proceeding"]["title"]);?></h2></li>
    <li>投稿者：<?= h($proceeding["User"]["username"]);?></li>
    <li>開催時間：<?= h($proceeding["Proceeding"]["start_time"]);?>～<?= h($proceeding["Proceeding"]["end_time"]);?></li>
    <li>開催場所：<?= h($proceeding["Proceeding"]["place"]);?></li>
    <li>参加者：<?php foreach ($proceeding["Attender"] as $attender ) : ?>
            <span><?= h($attender["attender_name"]);?></span>
    <?endforeach;?>
    </li>
    <li>会議目的：<p><?= nl2br(h($proceeding["Proceeding"]["agenda"]));?></p></li>
    <li>会議種類：<?=$mtType[$proceeding["Proceeding"]["type"]];?></li>
    <li>会議内容:
        <ul><?php foreach ($proceeding["Heading"] as $heading): ?>
            <li><h3>見出し：<?=h( $heading["heading_name"]);?></h3>
                <ul>
                    <?php foreach ($heading["Content"] as $content): ?>

                    <li>
                        <ul>
                            <li><?=nl2br(h($content["content"]));?></li>
                            <li>状態：<?=$ct_status[$content["status"]]?></li>
                        </ul></li>

                  <?php endforeach;?>
                </ul>
            </li>
            <?php endforeach;?>
        </ul>
    </li>
    <li>次回開催時間：<?= h($proceeding["Proceeding"]["next_start"]);?>～<?= h($proceeding["Proceeding"]["next_end"]);?></li>
    <li>補足：<?= h($proceeding["Proceeding"]["suppl"]);?></li>
    <li>投稿日時：<?= h($proceeding["Proceeding"]["created"]);?></li>
    <li>更新日時：<?= h($proceeding["Proceeding"]["modified"]);?></li>
    
</ul>
<p><?=$this->Html->link("詳細編集",array('controller'=>'proceedings',"action"=>"edit",$proceeding["Proceeding"]["id"]));?></p>

