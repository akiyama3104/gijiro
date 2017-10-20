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
                    "filterEmpty" =>  true)
         ),
        "Util"   //共通して使いたい変数などを載せている
    );

    public $uses=array("Proceeding","User","CategoryList","Category","Heading","Content","Attender");
    public function beforeFilter(){
        parent::beforeFilter();

    }


    public function  add($id=null){
        $content_type=$this->Util->getContentType();//会議内容の種類をセットする
        $type_id=$this->Util->getType();//会議種類をセットする

        $categories=$this->Category->find("list",array("fields"=>array("id","category")));
        $this->set(compact("id","type_id","content_type","categories"));

        if ( $this->request->is("post")  ){



            if($this->Proceeding->saveAll($this->request->data,array("deep"=>true))){
                $this->Session->setFlash("Success");

                $this->redirect(array("action"=>"edit",$this->Proceeding->id));
            }else{
                $this->Session->setFlash("Failed");
                echo json_encode(compact("id_result"));
            }
        }
    }
    public  function addForm($id = null){


        if (!$this->request->is("ajax") ){
            throw new BadRequestException();
        }

        if($this->Heading->saveAll($this->request->data,array("deep"=>true))){

            $options = array("fields"=>array("Heading.id","Content.id","Attender.id") ,
                "conditions" => array("Proceeding." . $this->Proceeding->primaryKey => $id),
            );

            $id_result=$this->Proceeding->find("first", $options);

            $this->redirect("/");
            echo $this->json_encode($id_result);

        }else{
            $this->Session->setFlash("Failed");

        }


    }




    public  function view($id=null){

        $this->Proceeding->id=$id;

        $options = array("field"=> "*",//array("Proceeding.*","User.username"),
            "conditions" => array("Proceeding." . $this->Proceeding->primaryKey => $id),

        );

        $proceeding=$this->Proceeding->find("first", $options);
        $content_type=$this->Util->getContentType();//会議内容の種類をセットする
        $type_id=$this->Util->getType();//会議種類をセットする
        $categories=$this->Category->find("list",array("fields"=>array("id","category")));
        $this->set(compact("proceeding","type_id","content_type","category","categories"));
    }
    public function edit($id=null){



        $this->Proceeding->id=$id;
        if($this->request->is("get")){

            $this->request->data=$this->Proceeding->read();
            $content_type=$this->Util->getContentType();//会議内容の種類をセットする
            $type_id=$this->Util->getType();//会議種類をセットする
            $categories=$this->Category->find("list",array("fields"=>array("id","category")));
            $this->set(compact("type_id","content_type","categories"));

        }else{
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
    public function deleteHeading($id){
        if($this->request->is("get")){
            throw new MethodNotAllowedException();
        }

        if ($this->request->is("ajax")){
            $this->Util->deleteForm($this->Heading,$id);

        }

    }
    public function deleteContent($id){
        if($this->request->is("get")){
            throw new MethodNotAllowedException();
        }

        if ($this->request->is("ajax")){
            $this->Util->deleteForm($this->Content,$id);

        }

    }
    public function deleteAttender($id){
        if($this->request->is("get")){
            throw new MethodNotAllowedException();
        }

        if ($this->request->is("ajax")){
            $this->Util->deleteForm($this->Attender,$id);

        }

    }


}
?>