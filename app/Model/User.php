<?php
/**
 * Created by PhpStorm.
 * User: satos
 * Date: 2017/09/28
 * Time: 17:37
 */
App::uses("AppModel","Model");
class  User extends  AppModel{

//    public $actsAs = array('Acl' => array('type' => 'both'));
//    public  $belongsTo = array('Group');
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

    /**
     * @return array
     */
    public function sql(){//sqlログを出力するメソッド
        $sql = $this->getDataSource()->getLog();

        $this->log($sql);
        return $sql;
    }


    public function beforeSave($options=array()){ //ユーザー保存する前に、パスワードをハッシュ化する
        $this->data["User"]["password"]=AuthComponent::password($this->data["User"]["password"]);
        return true;

    }
//
//        public function parentNode() {
//            if (!$this->id && empty($this->data)) {
//                return null;
//            }
//            if (isset($this->data['User']['group_id'])) {
//                $groupId = $this->data['User']['group_id'];
//            } else {
//                $groupId = $this->field('group_id');
//            }
//            if (!$groupId) {
//                return null;
//            } else {
//                return array('Group' => array('id' => $groupId));
//            }
//        }



}


?>