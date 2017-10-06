<?php
/**
 * Created by PhpStorm.
 * User: satos
 * Date: 2017/09/28
 * Time: 18:49
 */

?>
ようこそ：<?=h($user["username"]);?>さん
<?= $this->Html->link("ログアウト","logout");?>

<!--投稿者であるユーザーidも送付する-->
<?= $this->Html->link("投稿する",array('controller'=>'proceedings','action'=>'add',$user["id"])); ?>


<article>
    <h2>議事録一覧</h2>
    <!--    会議種類の表示用配列-->
<?php $mtType=array("inner"=>"社内","outer" =>"社外","other"=>"その他");?>

<?php foreach ($proceedings as $proceeding): ?>

<section id="post_<?=h($proceeding["Proceeding"]["id"]) ?>">

    <h2><?=$this->Html->link( $proceeding["Proceeding"]["title"],array('controller'=>'proceedings','action'=>'view',$proceeding["Proceeding"]["id"]));?></h2>
    <ul>
        <li>日時：<?= h($proceeding["Proceeding"]["start_time"]);?>～<?= h($proceeding["Proceeding"]["end_time"]);?></li>
        <li>場所：<?=h($proceeding["Proceeding"]["place"]);?></li>
        <li>会議種類：<?= $mtType[$proceeding["Proceeding"]["type"]];?>        </li>
        <li>参加者：
            <?php foreach($proceeding["Attender"] as $attender) :?>
                <?= h($attender["attender_name"]);?>
            <?php endforeach;?>
        </li>
        <li>投稿者:<?= h($proceeding["User"]["username"]);?></li>
        <li>投稿日時：<?=h($proceeding["Proceeding"]["created"]);?></li>
    </ul>

    <?=debug($proceeding);?>

</section>
<?php endforeach;?>

</article>