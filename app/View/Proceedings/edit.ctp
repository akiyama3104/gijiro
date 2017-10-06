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
    <li>会議種類：<?=$this->Form->input("type",array("options" => array("inner"=>"社内","outer"=>"社外","other"=>"その他"),"type"=>"radio"));?></li>
    <li>会議内容:

        <ul>
            <?php foreach($editData["Heading"] as $i =>  $heading):?>


            <li>見出し：<?= $this->Form->input("Heading.".$i.".heading_name");?>

                <?=$this->Form->hidden("Heading.".$i.".id");//更新するため主キー設定?>

                <ul>
                    <?php foreach($heading["Content"] as $j => $content):?>
                    <li>

                        <?= $this->Form->input("Heading.".$i.".Content.".$j.".content");?>
                        <?=$this->Form->hidden("Heading.".$i.".Content.".$j.".id");//更新するため主キー設定?>
                        <?=$this->Form->input("Heading.".$i.".Content.".$j.".status",array("options"=>array("fixed"=>"決定","task"=>"課題"),"type"=>"radio"));?>
                    </li>
                    <?endforeach;?>
                </ul>
            </li>
           <?endforeach;?>
        </ul>

    </li>
    <li>次回開催時間：<?=$this->Form->input("next_start",$dateOption);?>：～<?=$this->Form->input("next_end",$dateOption);?></li>
    <li>次回開催場所：<?=$this->Form->input("next_place");?></li>
    <li>補足<?=$this->Form->input("suppl");?></li>

    <li><?= $this->Form->end("編集完了");?></li>
</ul>
<?=$this->form->postLink('削除',array('action'=>'delete', $editData["Proceeding"]["id"]),array('class'=>'link-style'),'本当に削除しますか?');?>


<script>
    $(function(){
        $("a.delete").click(function(e){
            if(confirm("sure?")){
                $.post("/gijiro/proceedings/delete/"+$(this).data("post-id"),{},function(res){
                    $("#post_"+res.id).fadeOut();
                },"json");
            }

        })

    });
</script>