<?php
/**
 * Created by PhpStorm.
 * User: satos
 * Date: 2017/09/27
 * Time: 16:24
 */

 ?>
 <h2>編集</h2>
<?php
echo$this->Form->create('Post',array("action"=>"edit"));
echo$this->Form->input("title");
echo$this->Form->input("body",array("rows"=>3));
echo$this->Form->end('Save!',array("action"=>"edit"));
?>