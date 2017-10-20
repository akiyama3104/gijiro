<?php
/**
 * Created by PhpStorm.
 * User: satos
 * Date: 2017/09/27
 * Time: 12:48
 */

class Post extends  AppModel{
    public $hasMany ="Comment";
    public $validate = array(
      'title'=>array(
          'rule'=>'notBlank',
          'message'=> 'からじゃダメ！'
      )  ,
        'body'=> array(
            'rule' =>'notBlank'
        )
    );
}
?>