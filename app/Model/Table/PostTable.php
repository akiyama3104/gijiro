<?php
/**
 * Created by PhpStorm.
 * User: satos
 * Date: 2017/09/26
 * Time: 17:26
 */
namespace App\Model\Table;

//use Cake\ORM\Table;

class PostsTable extends  AppModel {
    public  function  initialize( array  $config)
    {
        $this->addBehavior('Timestamp');


    }
}
?>