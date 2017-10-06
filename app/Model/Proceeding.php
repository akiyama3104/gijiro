<?php
/**
 * Created by PhpStorm.
 * User: satos
 * Date: 2017/09/29
 * Time: 11:50
 */
App::uses("AppModel", "Model");
class Proceeding extends AppModel{
//    public $useTable = "Proceeding";

//    public $order = array("Proceeding.id DESC");
    public $actsAs = array("Search.Searchable");
    public $filterArgs = array(
        "place"=>array("type"=>"like"),
        "agenda"=>array("type"=>"like"),
//        "start_time"=> array("type"=>"like"),
        "user_id" => array("type" => "value"),
        "title" => array("type" => "like"),
    );
    public $recursive = 2;
    

    public  $hasMany =array(
        "Attender"=>array("className"=>"Attender",
                            "foreignKey"=>"proceeding_id",
                            "dependent"=>true),
        "Heading"=>array("className"=>"Heading",
                          "foreignKey"=>"proceeding_id",
                          "dependent"=>true)
    );
    public  $belongsTo = "User";
    public $validate = array(
        "title"=>array(
            array("rule"=>"notBlank","message"=>"必須項目です。")
        ),
        "type"=>array(
            array("rule"=>"notBlank","message"=>"必須項目です。")
        )

    );
    
    public function sql(){//sqlログを出力するメソッド
        $sql = $this->getDataSource()->getLog();

        $this->log($sql);
        return $sql;
    }

}

?>

