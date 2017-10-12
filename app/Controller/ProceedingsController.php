<?php
/**
 * Created by PhpStorm.
 * User: satos
 * Date: 2017/09/29
 * Time: 11:51
 */

App::uses("AppController","Controller");
class ProceedingsController extends AppController{
    public $helpers =array("Html","Form" );
    public $components=array(
        "Session",
        "Paginator",
        "Search.Prg"=>array(
                "commonProcess" => array(
                    "paramType" => "querystring",
                    "filterEmpty" =>  true,
                )
        ));

    public $uses=array("Proceeding","User");

    public function  add($id=null){

        //投稿者を持ってくる
        $this->set(compact("id"));

        if ( $this->request->is("post")){



            if($this->Proceeding->saveAll($this->request->data,array("deep"=>true))){
                $this->Session->setFlash("Success");
                $this->redirect(array("action"=>"edit",$this->Proceeding->id));
            }else{
                $this->Session->setFlash("Failed");

            }
        }
    }
    public  function view($id=null){

        $this->Proceeding->id=$id;

        $options = array("field"=> "*",//array("Proceeding.*","User.username"),
            "conditions" => array("Proceeding." . $this->Proceeding->primaryKey => $id),

        );
        $this->set("proceeding",$this->Proceeding->find("first", $options));
    }
    public function edit($id=null){



        $this->Proceeding->id=$id;
        if($this->request->is("get")){
            $this->request->data=$this->Proceeding->read();


        }else{
//                    var_dump($this->request->data());
            if($this->Proceeding->saveAll($this->request->data,array("deep"=>true))){
//                var_dump($this->Proceeding->sql());
                $this->Session->setFlash("編集成功しました");

                $this->redirect(array("action"=>"view",$id));

            }else{
                $this->Session->setFlash("編集失敗しました");


            }
        }



    }
    public function delete($id){
        if($this->request->is("get")){
            throw new MethodNotAllowedException();
        }
        if ($this->request->is("post")){
            if($this->Proceeding->delete($id)){

                $this->Session->setFlash("削除しました。");

            }else{
                $this->Session->setFlash("削除失敗しました。");
            }

            $this->redirect("/");
        }






    }
    public  function search(){
        $user_id=$this->Proceeding->User->find("list",array("fields"=>array("id","username")));
        if ( $this->request->is("post")){
            $conditions=$this->Proceeding->parseCriteria($this->passedArgs);//検索条件の設定
//            $this->Proceeding->unbindModel(array("hasMany"=>array("Heading")));

            $proceedings=$this->Paginator->paginate($this->Proceeding,$conditions);
            $user_id=$this->Proceeding->User->find("list",array("fields"=>array("id","username")));



        }
        $this->set(compact("proceedings","user","conditions","user_id") );


    }

}
?>