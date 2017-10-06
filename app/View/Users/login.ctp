<?php
/**
 * Created by PhpStorm.
 * User: satos
 * Date: 2017/09/28
 * Time: 18:36
 */
?>

<h1>ログイン</h1>
<?= $this->Form->create("User");?>
<?= $this->Form->input("username");?>
<?= $this->Form->input("password");?>
<?= $this->Form->end("ログイン"); ?>
<?=$this->Html->link("新規登録",array('controller'=>'users','action'=>'register'));?>