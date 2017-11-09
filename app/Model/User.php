<?php
/**
 * Created by PhpStorm.
 * User: satos
 * Date: 2017/09/28
 * Time: 17:37
 */
App::uses("AppModel","Model");
class  User extends  AppModel
{
    public  $validate =array(
      "username" => array(
        array(
            "rule"=> "isUnique",
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

    public function beforeSave($options=array())
    { //ユーザー保存する前に、パスワードをハッシュ化する
        $this->data["User"]["password"]=AuthComponent::password($this->data["User"]["password"]);
        return true;

    }


}


?>