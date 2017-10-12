<?php
/**
 * Created by PhpStorm.
 * User: satos
 * Date: 2017/09/29
 * Time: 11:50
 */
App::uses('AppModel', 'Model');
class Heading extends AppModel{
    public $actsAs = array("Search.Searchable");

    public  $hasMany= array(
       "Content"=>array("className"=>"Content",
                         "foreignKey"=>"heading_id",
                         "dependent"=>true)
    );
    public $validate = array(


    );



}

?>

