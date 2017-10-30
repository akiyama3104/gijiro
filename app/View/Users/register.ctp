<?php
/**
 * Created by PhpStorm.
 * User: satos
 * Date: 2017/09/28
 * Time: 18:46
 */?>
<h1 class="title_beforeLogin">新規登録</h1>
<?= $this->Form->create("User");?>
<?= $this->Form->input("username");?>
<?= $this->Form->input("password");?>
<?= $this->Form->hidden("group_id",array("value"=>"1"));?>
<?= $this->Form->end(array("label"=>"新規登録","class"=>array("btn","btn-lg","btn-success"))); ?>
<?=$this->Html->link("ログイン画面はこちら",array('controller'=>'users','action'=>'login'));?>
