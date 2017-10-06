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
    public $uses=array("Proceeding","User");
    public $components =array("Session","Auth","Search.Prg","Paginator");
    public $presetVars=true;
    public $helpers = array('Html','Form');
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
    }

    //ログイン後のリダイレクトページ
    public function index(){
//        $this->loadModel("Proceeding");
        $user=$this->Auth->user();
        $option=array("conditions"=>array("user_id"=>$user["id"]));//検索条件。自分が投稿したものだけを表示
        $this->Prg->commonProcess();//検索データのバリデーション
        $this->paginate = array(
            "fields"=>"*",
            "conditions" => $this->Proceeding->parseCriteria($this->passedArgs),
            "joins"=>array("table"=>"proceedings",
                "alias"=>"Proceeding",
                "type"=>"left",
                "conditions"=>"Proceeding.user_id=User.id")

        );
        $this->set("paginate",$this->paginate);
        $this->set("user",$user);
        $this->Proceeding->unbindModel(array("hasMany"=>array("Heading")));
        $this->set('proceedings', $this->Paginator->paginate($this->Proceeding));
//        $this->set("proceedings",$this->Proceeding->find("all",$option));
        $this->set("title_for_layout","gijiro!");
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