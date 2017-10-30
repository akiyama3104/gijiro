<?php
/**
 * Created by PhpStorm.
 * User: satos
 * Date: 2017/09/28
 * Time: 18:36
 */
?>

<h1 class="title_beforeLogin">ログイン</h1>
<?= $this->Form->create("User");?>
<?= $this->Form->input("username");?>
<?= $this->Form->input("password");?>
<?= $this->Form->end(array("label"=>"ログイン","class"=>array("btn btn-success btn-lg"))); ?>
<?=$this->Html->link("新規登録",array( 'controller'=>'users','action'=>'register'));?>