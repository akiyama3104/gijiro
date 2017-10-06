<?php
/**
 * Created by PhpStorm.
 * User: satos
 * Date: 2017/09/26
 * Time: 18:09
 */
//namespace App\Controller;
App::uses('AppController','Controller');
class  CommentsController extends  AppController{

//    public  function  index(){
//
//        $posts = $this->Post->find('all');
//        $this->set(compact('posts'));
//
//
//    }
    public $helpers = array('Html','Form');
    public function add(){
        if ( $this->request->is('post')){
            if($this->Comment->save($this->request->data)){
                $this->Session->setFlash('Success');
                $this->redirect(array("controller"=>"posts",'action'=>'view',$this->data["Comment"]["post_id"]));
            }else{
             $this->Session->setFlash('Failed');

            }
        }
    }

    public function delete($id){
        if ( $this->request->is("get")){
            throw new MethodNotAllowedException();

        }
        if ($this->request->is("ajax")){
            if($this->Comment->delete($id)){
                $this->autoRender =false;
                $this->autoLayout=false;
                $response = array("id"=>$id);
                $this->header("Content-Type: application/json");
                echo json_encode($response);
                exit();
            }

        }
        $this->redirect(array("controller"=>"posts","action"=>"index"));
     }

    }

?>