<?php
/**
 * Created by PhpStorm.
 * User: satos
 * Date: 2017/09/26
 * Time: 18:09
 */
//namespace App\Controller;
App::uses('AppController','Controller');
class  PostsController extends  AppController{

    public $helpers = array('Html','Form');
    public function index(){
        $params = array(
            'order' => 'modified asc',
            'limit' =>2
        );
        $this->set('posts',$this->Post->find('all'));
        $this->set('title_for_layout','記事一覧');
    }

    public function  view($id = null){
        $this->Post->id=$id;
        $this->set('post',$this->Post->read());

    }
    public function add(){
        if ( $this->request->is('post')){
            if($this->Post->save($this->request->data)){
                $this->Session->setFlash('Success');
                $this->redirect(array('action'=>'index'));
            }else{
             $this->Session->setFlash('Failed');

            }
        }
    }

    public function edit($id=null){
        $this->Post->id=$id;
        if ($this->request->is('get')){
            $this->request->data=$this->Post->read();

        }else{
            if($this->Post->save($this->request->data)){
                $this->Session->setFlash("success!");
                $this->redirect(array('action'=>'index'));


            }else{

                $this->Session->setFlash("failed!");
            }




        }
    }
    public function delete($id){
        if ( $this->request->is("get")){
            throw new MethodNotAllowedException();

        }
        if ($this->request->is("ajax")){
            if($this->Post->delete($id)){
                $this->autoRender =false;
                $this->autoLayout=false;
                $response = array("id"=>$id);
                $this->header("Content-Type: application/json");
                echo json_encode($response);
                exit();
            }

        }
        $this->redirect(array("action"=>"index"));
//        if ( $this->Post->delete($id)){
//            $this->Session->setFlash("Deleted!");
//            $this->redirect(array("action"=>"index"));
//        }else{
//            $this->Session->setFlash("Failed!");
//            $this->redirect(array("action"->"index"));
//        }

    }
}
?>