<?php
/**
 * Created by PhpStorm.
 * User: satos
 * Date: 2017/09/29
 * Time: 11:50
 */
App::uses("AppModel", "Model");
class Proceeding extends AppModel{



    public $actsAs = array("Search.Searchable");
    public $filterArgs = array(
        array("name"=>"attender","type"=>"query","presetType"=>"value","field"=>"Attender.attender_name","method"=>"searchAttenders"),
        //fieldに"Attender.attender_name"、"method"=>"searchAttenders"を追加して、1つのボックスで検索を行えるようにしたい。
        array("name"=>"user_id","type"=>"value","field"=>"Proceeding.user_id"),

        array("name"=>"keyword","type"=>"query","presetType"=>"value" ,"field"=>array(
            "User.username","Proceeding.place","Proceeding.agenda",
            "Proceeding.title","Proceeding.next_place","Attender.attender_name "),
            "method"=>"searchTable"
        ),
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
    public  $belongsTo = array("User" );
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
    //参加者テーブルから該当するproceeding_idを返す
    public  function searchAttenders($searchs=array()) {
        $conditions = array();
//        var_dump(reset($searchs));

        if(isset($searchs["attender"])){

            //空白区切りで配列にしている。（暫定）
            $keys=mb_convert_kana($searchs["attender"] , "s");
            $keys=preg_split("/[\s,]+/",$keys);

            $attender_conditions = array();

            foreach($keys as $key){
                $attender_conditions["OR"][]=array("Attender.attender_name like"=> "%".$key."%");
                //あいまい検索かつOR検索
            }

            if(!empty($attender_conditions)){
                $AttenderNames = $this->Attender->find("all", array("conditions" => $attender_conditions));

                foreach($AttenderNames as $AttenderName){
                    $conditions["OR"][] = array("Proceeding.id" => $AttenderName["Attender"]["proceeding_id"]);
                }
            }
        }

        return $conditions;//=$this->searchTable($searchs,);
    }
    public  function searchTable($searchs=array()) {
        $conditions = array();


        if(isset($searchs["keyword"])){

            //空白区切りで配列にしている。（暫定）
            $keys=mb_convert_kana($searchs["keyword"] , "s");
            $keys=preg_split("/[\s,]+/",$keys);

            $attender_conditions = array();

            foreach($keys as $key){

                $conditions["OR"][]=array("User.username like"=> "%".$key."%");
                $conditions["OR"][]=array("Proceeding.place like"=> "%".$key."%");
                $conditions["OR"][]=array("Proceeding.agenda like"=> "%".$key."%");
                $conditions["OR"][]=array("Proceeding.title like"=> "%".$key."%");
                $conditions["OR"][]=array("Proceeding.next_place like"=> "%".$key."%");
                $attender_conditions["OR"][]=array("Attender.attender_name like"=> "%".$key."%");
                //あいまい検索かつOR検索
            }

            if(!empty($attender_conditions)){//子テーブルの該当する外部キーがほしい
                $AttenderNames = $this->Attender->find("all", array("conditions" => $attender_conditions));
                //idのみを引っ張ってくるように要修正
                foreach($AttenderNames as $AttenderName){
                    $conditions["OR"][] = array("Proceeding.id" => $AttenderName["Attender"]["proceeding_id"]);
                }
            }

        }
        return $conditions;
    }


}

?>

