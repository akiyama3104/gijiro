<?php
/**
 * Created by PhpStorm.
 * User: satos
 * Date: 2017/09/28
 * Time: 18:46
 */?>
<h1>新規登録</h1>
<?= $this->Session->flash("auth"); ?>
<?= $this->Form->create("User");?>
<?= $this->Form->input("username");?>
<?= $this->Form->input("password");?>
<?= $this->Form->hidden("group_id",array("value"=>"1"));?>
<?= $this->Form->end("新規登録"); ?>
<?=$this->Html->link("ログイン画面はこちら",array('controller'=>'users','action'=>'login'));?>
