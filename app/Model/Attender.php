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
//    public  $validate =array(
//        "attender_name" => array(
//              array(
//                "rule"=>"notBlank",
//                "message"=>"必須項目です。"
//            )
//        )
//    );



    //autocomplete用のjson参加者リスト。
    public  function jsonizeAttender(){
        $arr_attender= $this->find("all",array("fields"=>array("id","attender_name","belongs")));
        $json_attender=[];
        foreach ($arr_attender as$i => $attender){

            $json_attender[$i]["label"]=$attender["Attender"]["attender_name"];
            $json_attender[$i]["belongs"]=$attender["Attender"]["belongs"];
            $json_attender[$i]["id"]=$attender["Attender"]["id"];

            }
//        $json_attender=$arr_attender;

        return json_encode($json_attender);
    }




}

?>

