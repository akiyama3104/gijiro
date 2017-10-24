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
    ////リストの宣言
    private $content_type=array("fixed"=>"決定","task"=>"課題",""=>"未設定");//会議内容の種類リスト
    public function getContentType(){
        return $this->content_type;
    }
    ////

}

?>

