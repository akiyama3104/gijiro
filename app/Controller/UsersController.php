<?php
/**
 * Created by PhpStorm.
 * User: satos
 * Date: 2017/09/28
 * Time: 18:03
 */
App::uses("AppController","Controller");
//App::uses("Pa")
class UsersController extends AppController{
    public $uses=array("Proceeding","User","Attender");
    public $components =array(
        "Session", 
        "Auth",
        "Paginator",   
        "Search.Prg" => array(
              "commonProcess" => array(
                  "paramType" => "querystring",
                  "filterEmpty" =>  true,
              )
        )
    );
    public $presetVars=true;
    public $helpers = array("Html","Form","Text");
    public $paginate = array(
        "limit"=> 10,

//        "order"=> array(
//            "Proceeding.start_time" => "asc"
//        )
    );
    public function beforeFilter(){//どのページでも共通してこの処理を行う

        parent::beforeFilter();//親もbeforeFilterを使えるようにする

        //未ログイン状態であると、ログイン画面、登録画面しか行けないようにする
        $this->Auth->allow("register","login");
        $this->set("title_for_layout","gijiro!");
    }

    //ログイン後のリダイレクトページ
    public function index(){
//        $this->loadModel("Proceeding");
        $user=$this->Auth->user();

        $this->Prg->commonProcess();//検索データのバリデーション
        $conditions=$this->Proceeding->parseCriteria($this->passedArgs);//検索条件の設定
        $this->Proceeding->unbindModel(array("hasMany"=>array("Heading")));
        if(isset($conditions["OR"][0])){
            $highlight_word=$conditions["OR"][0];
        }
        $proceedings=$this->Paginator->paginate($this->Proceeding,$conditions);
        $user_id=$this->Proceeding->User->find("list",array("fields"=>array("id","username")));
        $this->set(compact("proceedings","user","conditions","user_id") );

    }
    public function register(){
        //reqestがpostデータ&&ユーザー追加成功したら
        if($this->request->is("post")&&$this->User->save($this->request->data)){
            $this->Auth->login();
            $this->redirect(array("controller"=>"Users","action"=>"index"));

        }

    }
    public function login(){

        if($this->request->is("post")){
           if( $this->Auth->login() ){
                return  $this->redirect("index");

           }else {
               $this->Session->setFlash("ログイン失敗しました。");

           }


        }
    }
    public function logout(){
        $this->Auth->logout();
        $this->redirect("login");
    }



}



?>