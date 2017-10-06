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
    public $components=array("JoinProceedings");
    public $uses=array("Proceeding","User");

    public function  add($id=null){

        //投稿者を持ってくる
        $this->set("id",$id);

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
//        $this->Proceeding->recursive=2;
//        $this->Proceeding->unbindModel(
//            array("belongsTo" => array("User"))
//        );
//        $this->Proceeding->bindModel(
//            array("hasMany" => array(
//                "Attender" => array(
//                    "className" => "Attender",
//                    "foreignKey" => "proceeding_id",
//                    "dependent" => false
//                ),"Heading" => array(
//                    "className" => "Heading",
//                    "foreignKey" => "proceeding_id",
//                    "dependent" => true
//                )
//                )
//
//
//            )
//
//        );
//        $this->Proceeding->Heading->bindModel(
//            array("hasMany"=>array("Content"),false)
//        );
        $options = array("field"=> "*",//array("Proceeding.*","User.username"),
            "conditions" => array("Proceeding." . $this->Proceeding->primaryKey => $id),
//            "contain"=>array("User","Heading","Content","Attender"),
//            "recursive" => 2
        );
//        $this->Proceeding->recursive=2;
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
}
?>