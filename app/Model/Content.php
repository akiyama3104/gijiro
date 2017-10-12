<?php
/**
 * Created by PhpStorm.
 * User: satos
 * Date: 2017/09/29
 * Time: 11:50
 */
App::uses('AppModel', 'Model');
class Content extends AppModel{
    public $actsAs = array("Search.Searchable");
    public $belongsTo = array("Heading");
    public $validate = array(


    );



}

?>

