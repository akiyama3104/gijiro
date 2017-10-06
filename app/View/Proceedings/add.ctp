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
<?php $addData= $this->request->data?>
<?= debug($addData);?>
<ul>
    <?=$this->Form->create("Proceeding",array("action"=>"add"));?>
    <?=$this->Form->hidden("id");?>
    <li>議題：<?=$this->Form->input("title");?></li>
    <li>開催時間<?=$this->Form->input("start_time");?>：～<?=$this->Form->input("end_time");?></li>
    <li>開催場所：<?=$this->Form->input("place");?></li>
    <li>会議目的：<?=$this->Form->input("agenda");?></li>
    <li>参加者：
        <?php for($i=0; $i<3; $i++):?>
            <?=$this->Form->hidden("Attender.".$i.".id");//更新するため主キー設定?>
            <p>
                参加者<?=$displayI=$i+1?>：<?=$this->Form->input("Attender.".$i.".attender_name",array("type"=>"text","size"=>20));?>
                所属:<?=$this->Form->input("Attender.".$i.".belongs",array("type"=>"text","size"=>20));?>

            </p>


        <?php endfor; ?>
    </li>
    <li>会議種類：<?=$this->Form->input("type",array("options" => array("inner"=>"社内","outer"=>"社外","other"=>"その他"),"type"=>"radio"));?></li>
    <li>次回開催時間：<?=$this->Form->input("next_start",$dateOption);?>：～<?=$this->Form->input("next_end",$dateOption);?></li>
    <li>次回開催場所：<?=$this->Form->input("next_place");?></li>
    <li>補足<?=$this->Form->input("suppl");?></li>

    <?=$this->Form->hidden("user_id",array("value"=>$id));?>

    <li><?= $this->Form->end("議事録開始！");?></li>

</ul>
