<?php
/**
 * Created by PhpStorm.
 * User: satos
 * Date: 2017/09/29
 * Time: 11:50
 */
App::uses('AppModel', 'Model');
class Attender extends AppModel{
    public $displayField = 'id';
    public $actsAs = array("Search.Searchable");
    public  $validate =array(
        "attender_name" => array(
              array(
                "rule"=>"notBlank",
                "message"=>"記入してください。"
            )
        )
    );



    //autocomplete用のjson参加者リスト。
    public  function jsonizeAttender()
    {
        $arr_attender= $this->find("all",array("fields"=>array("id","attender_name","belongs")));
        $json_attender=[];
        foreach ($arr_attender as$i => $attender){
            $json_attender[$i]["label"]=$attender["Attender"]["attender_name"];
            $json_attender[$i]["belongs"]=$attender["Attender"]["belongs"];
            $json_attender[$i]["id"]=$attender["Attender"]["id"];
        }
        return json_encode($json_attender);
    }

    //参加者がテーブルに存在するかチェックし、いない場合、新たに追加する。
    //返り値はそれらの主キーのベクトルである。
    public function addAttender($attenders){

        $ids=[];
        foreach ($attenders as   $attender){
            $conditions=array("attender_name"=>$attender["attender_name"],"belongs"=>$attender["belongs"]);
            if($this->hasAny($conditions)){
                $id=$this->find("first",array("fields"=>"id","conditions"=>$conditions));
                $ids[]=$id["Attender"]["id"];
            }else{
                $this->saveAll($attender);
                $ids[]=$this->getInsertId();
            }
        }

        return $ids;

    }


}

?>

