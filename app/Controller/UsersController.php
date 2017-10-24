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
    public $uses=array("Proceeding","User","Attender","CategoriesProceeding","Category");
    public $components =array(
        "Session",
        "Paginator",
        "Util",//共通して使いたい変数などを載せている
        "Search.Prg" => array(
              "commonProcess" => array(
                  "paramType" => "querystring",
                  "filterEmpty" =>  true,
              )
        ),

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





    }



    //ログイン後のリダイレクトページ
    public function index(){
        $user=$this->Auth->user();

        $this->Prg->commonProcess();//検索データのバリデーション
        $conditions=$this->Proceeding->parseCriteria($this->passedArgs);//検索条件の設定
        $this->Proceeding->unbindModel(array("hasMany"=>array("Heading")));
        $proceedings=$this->Paginator->paginate($this->Proceeding,$conditions);

        $user_id=$this->Proceeding->User->find("list",array("fields"=>array("id","username")));//投稿者一覧で検索するために取得
        $type_id=$this->Proceeding->getType();//会議内容の種類取得
        $categories=$this->Category->getCategory();
        $attenders=$this->Attender->find("list",array("fields"=>array("id","attender_name")));
        $this->set(compact("proceedings","user","user_id","type_id","categories","attenders","categories") );

    }
    public function register(){
        $this->User->create();
        //reqestがpostデータ&&ユーザー追加成功したら
        if($this->request->is("post")&&$this->User->save($this->request->data)){
            debug($this->User->sql());
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