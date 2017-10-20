<?php
/**
 * Created by PhpStorm.
 * User: satos
 * Date: 2017/09/28
 * Time: 17:37
 */
App::uses("AppModel","Model");
class  User extends  AppModel{
//  public $hasMany = "Proceeding";
    public  $actsAs = array('Acl' => array('type' => 'requester'));;
    public  $belongsTo = array('Group');
    public  $validate =array(
      "usrname" => array(
        array(
            "rule"=> "isUnique",//ユニークであること
            "message"=>"既に使用されています。"
        ),

        array(
            "rule"=>"notBlank",
            "message"=>"必須項目です。"
        )
      ),
        "password"=>array(
            array(
                "rule"=>"alphaNumeric",
                "message"=>"パスワードは半角英数にしてください。"
            ),
            array(
                "rule"=>array("between",4,20),
                "message"=>"パスワードは4文字以上20文字以内にしてください。"
            )
        )


    );


    public function beforeSave($options=array()){ //ユーザー保存する前に、パスワードをハッシュ化する
        $this->data["User"]["password"]=AuthComponent::password($this->data["User"]["password"]);
        return true;

    }
    function parentNode(){
        if (!$this->id && empty($this->data)) {
            return null;
        }
        $data = $this->data;
        if (empty($this->data)) {
            $data = $this->read();
        }
        if (!$data['User']['group_id']) {
            return null;
        } else {
            return array('Group' => array('id' => $data['User']['group_id']));
        }
    }


}


?>