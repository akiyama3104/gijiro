<?php
/**
 * Created by PhpStorm.
 * User: satos
 * Date: 2017/10/02
 * Time: 18:40
 */
App::uses("Component","Controller");
class  UtilComponent extends  Component{
    public $uses=array("Proceeding","User","Attender","CategoriesProceeding","Category");
    //変数宣言など


    //フォームを削除する。フォーム追加の共通化は考え中
    public function deleteForm($model,$id,$req){

        if($req->is("get")){
            throw new MethodNotAllowedException();
        }

        if ($req->is("ajax")){
            if($model->delete($id)){
                $this->autoRender =false;
                $this->autoLayout=false;
                exit();
            }
        }



    }


}
