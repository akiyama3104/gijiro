<?php
/**
 * Created by PhpStorm.
 * User: satos
 * Date: 2017/10/02
 * Time: 18:40
 */
App::uses("Component","Controller");
class  UtilComponent extends  Component{
    public $uses=array("Proceeding","User","Attender","CategoryList","Category");
    //変数宣言など

    private $content_type=array("fixed"=>"決定","task"=>"課題",""=>"未設定");//会議内容の種類リスト
    private $type_id=array("tech"=>"技術部","sale"=>"営業部","suppo"=>"サポート","other"=>"その他");//会議種類のリスト

    public function getContentType(){
        return $this->content_type;
    }
    public function getType(){
        return$this->type_id;
    }
    public function getCategory(){
        return $this->Category->find("list",array("fileds"=>["id","category"]));
    }
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
