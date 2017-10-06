<?php
/**
 * Created by PhpStorm.
 * User: satos
 * Date: 2017/10/02
 * Time: 18:40
 */
App::uses("Component","Controller");
class  BindModelComponent extends  Component{
//試作用。動的にアソシエーションしたいためのメソッド
    public function getOption($id=null){
        return array('conditions' => array('Office.' . $this->Office->primaryKey => $id));
}





}
