<?php
/**
 * Created by PhpStorm.
 * User: satos
 * Date: 2017/09/29
 * Time: 11:50
 */
App::uses('AppModel', 'Model');
class Proceeding extends AppModel{
//    public $useTable = 'Proceeding';
    public  $belongsTo = "User";
//    public $actsAs = array('Containable');
    public $recursive = 2;
    public function sql(){
        $sql = $this->getDataSource()->getLog();

        $this->log($sql);
        return $sql;
    }

    public  $hasMany =array(
        "Attender"=>array("className"=>"Attender",
                            "foreignKey"=>"proceeding_id",
                            "dependent"=>true),
        "Heading"=>array("className"=>"Heading",
                          "foreignKey"=>"proceeding_id",
                          "dependent"=>true)
    );
    public $validate = array(
        "title"=>array(
            array("rule"=>"notBlank","message"=>"必須項目です。")
        ),
        "type"=>array(
            array("rule"=>"notBlank","message"=>"必須項目です。")
        )

    );



}

?>

