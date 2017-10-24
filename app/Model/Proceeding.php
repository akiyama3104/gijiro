<?php
/**
 * Created by PhpStorm.
 * User: satos
 * Date: 2017/09/29
 * Time: 11:50
 */
App::uses("AppModel", "Model");
class Proceeding extends AppModel{
    public $actsAs = array("Search.Searchable","Searchform");
    public $filterArgs = array(
        array("name"=>"user_id","type"=>"value","field"=>"Proceeding.user_id"),
        array("name"=>"mt_type","type"=>"value","field"=>"Proceeding.type"),
        array("name"=>"post_date","type"=>"like","field"=>array("Proceeding.start_time")),
        array("name"=>"next_place","type"=>"value","field"=>array("Proceeding.next_place")),
        //子テーブルをさがすので独自メソッド使用
        array("name"=>"from_hold_date","type"=>"query","method"=>"dateFromConditions"),
        array("name"=>"to_hold_date","type"=>"query","method"=>"dateToConditions"),
        array("name"=>"next_from_hold","type"=>"query","method"=>"nextFromConditions"),
        array("name"=>"next_to_hold","type"=>"query","method"=>"nextToConditions"),
        array("name"=>"keyword","type"=>"query","method"=>"searchOverview"),
        array("name"=>"attender_belong","type"=>"query","method"=>"searchAttenderBelongs"),
        array("name"=>"contents","type"=>"query","method"=>"searchContents"),
        array("name"=>"category","type"=>"query","method"=>"searchCategories"),
        //habtm検索用
        array('name' => 'attender', 'type' => 'subquery', 'method' => 'searchAttender', 'field' => 'Proceeding.id'),
        array('name' => 'category', 'type' => 'subquery', 'method' => 'searchCategory', 'field' => 'Proceeding.id'),

    );


    public $recursive = 2;


    public  $hasMany =array(
//        "Attender"=>array("className"=>"Attender",
//                            "foreignKey"=>"proceeding_id",
//                            "dependent"=>true),
        "Heading"=>array("className"=>"Heading",
                          "foreignKey"=>"proceeding_id",
                          "dependent"=>true),


    );
    public $hasAndBelongsToMany = array(
        'Category' => array(
            'className' => 'Category',
            'joinTable' => 'categories_proceedings',
            'foreignKey' => 'proceeding_id',//中間テーブルと親テーブルの外部キー
            'associationForeignKey' => 'category_id',//中間テーブルと子テーブルの
//            'unique' => "keepingExisting"
            'with'=>'CategoriesProceeding'
        ),

        "Attender"=> array(
            "className"=>"Attender",
            "joinTable"=>"attenders_proceedings",
            'foreignKey' => 'proceeding_id',//中間テーブルと親テーブルの外部キー
            'associationForeignKey' => 'attender_id',//中間テーブルと子テーブルの外部キー
            'with'=>'AttendersProceeding'

        )
    );
    public  $belongsTo = array("User" );


//////リスト宣言

    private $type_id=array("tech"=>"技術部","sale"=>"営業部","suppo"=>"サポート","other"=>"その他");//会議種類のリスト
    public function getType(){
        return $this->type_id;
    }
///////


    public function sql(){//sqlログを出力するメソッド
        $sql = $this->getDataSource()->getLog();

        $this->log($sql);
        return $sql;
    }




    public $validate = array(
        "title"=>array(
            array("rule"=>"notBlank","message"=>"必須項目です。")
        ),
        "type"=>array(
            array("rule"=>"notBlank","message"=>"必須項目です。")
        )
    );
    //開催日期間検索.開始日のみで検索している。
    public function dateFromConditions($data = array()){
        $from_date = array(
            "name"=>$data["from_hold_date"],
            "column"=>"start_time"
        );
        return $conditions=$this->termConditions($from_date);
    }
    public function dateToConditions($data = array()){
        $to_date = array(
            "name"=>$data["to_hold_date"],
            "column"=>"start_time",
            "from_to"=>"to"
        );
        return $conditions=$this->termConditions($to_date);
    }
    public function nextFromConditions($data = array()){
        $from_date = array(
            "name"=>$data["from_hold"],
            "column"=>"next_start"
        );
        return $conditions=$this->termConditions($from_date);
    }
    public function nextToConditions($data = array()){
        $to_date = array(
            "name"=>$data["to_hold_date"],
            "column"=>"next_start",
            "from_to"=>"to"
        );
        return $conditions=$this->termConditions($to_date);
    }

    //to_date
    public function _dateToConditions($data = array()){

        $to_date = $data["to_date"];
        $conditions = array("DATE(Post.created) <= DATE(?)"=>array($to_date));
        return $conditions;
    }


    public function searchContents($searchs=array()){

        if(isset($searchs["contents"])) {
            //空白区切りで配列にしている
            $keys = $this->splitBlank($searchs["contents"]);
            foreach ($keys as $key) {
                $content_conditions["OR"][] = array("Heading.heading_name like" => "%" . $key . "%");
                $content_conditions["OR"][] = array("Content.content like" => "%" . $key . "%");
                $conditions["OR"][]=array("Proceeding.agenda like"=> "%".$key."%");//議会目的検索。いらないかも
            }
            //contentは孫テーブルなので、子テーブル("model_name"=>"Heading")と親との外部キーをとるように設定
            $content_option = array("model" => $this->Heading->Content, "model_name" => "Heading");
            foreach($this->searchParentKeys($content_conditions, $content_option) as $parentKey){
                $conditions["OR"][]=$parentKey;
            }

        }
        return $conditions;

    }

    public function searchAttenderBelongs($searchs=array()){

        if(isset($searchs["attender_belong"])){
            //空白区切りで配列にしている
            $keys =$this->splitBlank($searchs["attender_belong"]);
        foreach($keys as $key){
            $belong_conditions["OR"][]=array("Attender.belongs like"=> "%".$key."%");
        }

            $belong_option=array("model"=>$this->Attender,"model_name"=>"Attender");
            $conditions["OR"]=$this->searchParentKeys($belong_conditions,$belong_option);
        }


        return $conditions;


    }


    public  function searchOverview($searchs=array()) {
        $conditions = array();
        if(isset($searchs["keyword"])){
            $keys=$this->splitBlank($searchs["keyword"]);
            $attender_conditions = array();
            foreach($keys as $key){
                $conditions["OR"][]=array("User.username like"=> "%".$key."%");
                $conditions["OR"][]=array("Proceeding.place like"=> "%".$key."%");
                $conditions["OR"][]=array("Proceeding.title like"=> "%".$key."%");
                $conditions["OR"][]=array("Proceeding.suppl"=>"%".$key."%");

                $attender_conditions["OR"][]=array("Attender.attender_name like"=> "%".$key."%");
                //あいまい検索かつOR検索
            }
            $attenders_option=array("model"=>$this->Attender,"model_name"=>"AttendersProceeding");//検索オプション
            //Attenderは孫テーブルなので、子テーブル("model_name"=>"Attender")と親との外部キーをとるように設定
            foreach($this->searchParentKeys($attender_conditions, $attenders_option) as $parentKey){
                $conditions["OR"][]=$parentKey;
            }


            $conditions["OR"][] =$this->searchParentKeys($attender_conditions,$attenders_option);
        }
        return $conditions;
    }

    //暫定...。
    public function searchAttender($searchs=array()){
        $attenders = [];
//        if (isset($searchs["keyword"])) {
//            $keys = $this->splitBlank($searchs["keyword"]);
//
//            foreach ($keys as $key) {
//                $ids = $this->Attender->find("list", array("conditions" => array("Attender.attender_name like" => "%" . $key . "%")));
//                foreach ($ids as $id) {
//                    $attenders[] = $id;
//                }
//                var_dump($attenders);
//            }

//
//            $attenders_condtions=[];
//            foreach ($attenders as $attender){
//                foreach ($attender as $item){
//                    $attenders_condtions[]= $item["id"];
//                }
//            }


//            $cond=array_unique($attenders);
//            var_dump($cond);

            $this->AttendersProceeding->Behaviors->attach('Containable', array('autoFields' => false));
            $this->AttendersProceeding->Behaviors->attach('Search.Searchable');

            $cond =$searchs["attender"];
            $query = $this->AttendersProceeding->getQuery('all', array(
                    'conditions' => array('AttendersProceeding.attender_id' => $cond),
                    'group' => 'AttendersProceeding.attender_id',
                    'fields' => array('proceeding_id'),
                    'contain' => array('Attender')
                )            );
//        }
        return $query;
//        $conditions = array();
//        if(isset($searchs["keyword"])) {
//            $keys = $this->splitBlank($searchs["keyword"]);
//            $attender_conditions = array();
//            foreach ($keys as $key) {
//                $attender_conditions["OR"][] = array("Attender.attender_name like" => "%" . $key . "%");
//                //あいまい検索かつOR検索
//            }
//            $grand_children = $this->Attender->find("all", array("conditions" => $attender_conditions));
//            $children_conditions = [];
//            if (!empty($grand_children)) {
//                foreach ($grand_children as $grand_child) {
//                    $children_conditions["OR"][] = array("attender_id" => $grand_child["Attender"]["id"]);
//                }
//
//            }
//            $Children = $this->AttendersProceeding->find("all", array("conditions" => $children_conditions));
//            if (!empty($Children)) {
//                foreach ($Children as $child) {
//                    //findしてきた結果で検索条件を作成
//                    $parent_keys["OR"][] = array("Proceeding.id" => $child["proceeding_id"]);
//                }
////                return $parent_keys;
//            }
//        }
//
    }


    public function searchCategory($searchs=array()){

        $this->CategoriesProceeding->Behaviors->attach('Containable', array('autoFields' => false));
        $this->CategoriesProceeding->Behaviors->attach('Search.Searchable');

        $cond =$searchs["category"];
        $query = $this->CategoriesProceeding->getQuery('all', array(
            'conditions' => array('CategoriesProceeding.category_id' => $cond),
            'group' => 'CategoriesProceeding.category_id',
            'fields' => array('proceeding_id'),
            'contain' => array('Category')) );

        return $query;

    }


}




?>

