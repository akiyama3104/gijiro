<?php
/**
 * Created by PhpStorm.
 * User: satos
 * Date: 2017/09/27
 * Time: 15:09
 */
?>

<h2>記事追加</h2>


<?php
echo $this->Form->create('Post');
echo $this->Form->input('title');
echo $this->Form->input('body');
echo $this->Form->end('Save Post');
?>