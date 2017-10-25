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
    public $uses=array("Proceeding","User","Attender","CategoriesProceeding","Category","Content");
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


    public function beforeFilter(){
        parent::beforeFilter();




    }





    public function  add($id=null){
        $content_type=$this->Content->getContentType();//会議内容の種類をセットする
        $type_id=$this->Proceeding->getType();//会議種類をセットする
        $json_attender=$this->Attender->jsonizeAttender();
        $categories=$this->Category->getCategory();
        $this->set(compact("id","type_id","content_type","categories","json_attender"));

        if ( $this->request->is("post")  ){



            //参加者がテーブルに存在するかチェックし、いない場合、新たに追加する。
            //返り値はそれらの参加者の主キーのベクトルである。
            $attenders_id=$this->Attender->addAttender($this->request->data["Attender"]);
            $this->request->data["Attender"]["Attender"]=$attenders_id;


            if($this->Proceeding->saveAll($this->request->data,array("deep"=>true))){


                $this->Session->setFlash("Success");

                $this->redirect(array("action"=>"edit",$this->Proceeding->id));
            }else{
                $this->Session->setFlash("Failed");

            }
        }
    }


    //見出しを追加して、見出しid、記事内容idを返す。
    public  function addHeading(){


        if (!$this->request->is("ajax") ){
            throw new BadRequestException();
        }

        if($this->Heading->save($this->request->data)){
            $HeadingId=$this->Heading->getInsertID();
            if($this->Content->save(array("Content"=>array("heading_id"=>$HeadingId)))){
                $ContentId=$this->Content->getInsertID();
                $this->autoRender = false;
                $this->header("Content-Type: application/json");

                return json_encode(compact("HeadingId","ContentId"));
            }
        }


    }
    public  function addContent(){


        if (!$this->request->is("ajax")) {
            throw new BadRequestException();
        }

        if ($this->Content->save($this->request->data)) {
            $ContentId = $this->Content->getInsertID();
            $this->autoRender = false;
            $this->header("Content-Type: application/json");

            return json_encode(compact("ContentId"));

        }

    }


    public function addAttender(){


        if (!$this->request->is("ajax") ){
            throw new BadRequestException();
        }

        if($this->Attender->save($this->request->data)){
            $AttenderId=$this->Attender->getInsertID();
            $this->autoRender = false;
            $this->header("Content-Type: application/json");

            return json_encode(compact("AttenderId"));

        }
        $this->Util->addForm();


    }







    public  function view($id=null){

        $this->Proceeding->id=$id;

        $options = array("field"=> "*",//array("Proceeding.*","User.username"),
            "conditions" => array("Proceeding." . $this->Proceeding->primaryKey => $id),

        );

        $proceeding=$this->Proceeding->find("first", $options);
        $content_type=$this->Content->getContentType();//会議内容の種類をセットする
        $type_id=$this->Proceeding->getType();//会議種類をセットする
        $categories=$this->Category->getCategory();
        $this->set(compact("proceeding","type_id","content_type","category","categories"));
    }
    public function edit($id=null){



        $this->Proceeding->id=$id;
        if($this->request->is("get")){
            $uid = $this->Auth->user()["id"];//ユーザ-idのみ取得
            $this->request->data=$this->Proceeding->read();
            $content_type=$this->Content->getContentType();//会議内容の種類をセットする
            $type_id=$this->Proceeding->getType();//会議種類をセットする


            $this->header("Content-Type: application/json");
            $json_attender=$this->Attender->jsonizeAttender();//id,belongs,nameをjson形式で返す

            $categories=$this->Category->getCategory();
            $this->set(compact("type_id","content_type","categories","uid","json_attender"));

        }else{



            //参加者がテーブルに存在するかチェックし、いない場合、新たに追加する。
            //返り値はそれらの参加者の主キーのベクトルである。
            $attenders_id=$this->Attender->addAttender($this->request->data["Attender"]);
            $this->request->data["Attender"]["Attender"]=$attenders_id;



            if($this->Proceeding->saveAll($this->request->data,array("deep"=>true))){
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
            $req=$this->request;
            $this->Util->deleteForm($this->Heading,$id,$req);

    }
    public function deleteContent($id){

        $req=$this->request;
        $this->Util->deleteForm($this->Content,$id,$req);


    }
    public function deleteAttender($id){
        $req=$this->request;


            $this->Util->deleteForm($this->Attender,$id,$req);


    }


//    public function autoSearch($param){
//
//        $this->layout = false;
//
//
//        $this->autoRender = false;
//        $data = '';
//        $json = '';
//
//        // Ajax以外の通信の場合
//        if (!$this->request->is('ajax')) {
//            throw new BadRequestException();
//        }
//        $data=["し","っ","ぱ","い"];
//        $this->header("Content-Type: application/json");
//        $json = json_encode(compact("data"));  // Json形式に
//
//        return $json;
//
//
////        if($this->request->is("ajax")){
////            $this->response->type('json');
////            $this->autoLayout = false;
////            $key =$this->data["param1"];
////            $attenders=$this->Attender->find("all",array("fields"=>array("attender_name"),"conditions"=>array("Attender.attender_name like "=>"%"+$key)));
////            $arr_attender=[];
////            $this->autoRender = false;
////            $this->header("Content-Type: application/json");
////            foreach ($attenders as $i => $attender ){
////                $arr_attender[]= $attender["attender_name"];
////            }
////        $key ="add";//"list",array("fields"=>"attender_name"));
////        $attenders=$this->Attender->find("all",array("fields"=>"attender_name","id",));
////        $arr_attender=$attenders;
////        foreach ($attenders as $i => $attender ){
////            $arr_attender[]= $attender["Attender"]["attender_name"];
////        }
//
//
//          //  return json_encode(compact("arr_attender"));
////        }else{
////            throw new BadRequestException();
////        }
////        $a = array(
////            'HPI',
////            'Kyosho',
////            'Losi',
////            'Tamiya',
////            'Team Associated',
////            'Team Durango',
////            'Traxxas',
////            'Yokomo'
////        );
////
////        $b = array();
////
////        if($this->request->data['param1']){
////            $w = $this->request->data['param1'];
////            foreach($a as $i){
////                if(stripos($i, $w) !== FALSE){
////                    $b[] = $i;
////                }
////            }
////            echo json_encode($b);
////        }
////        else{
////            echo json_encode($b);
////        }
//
//    }

}
?>