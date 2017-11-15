<?php
App::uses('AppModel', 'Model');
/**
 * Category Model
 *
 * @property CategoryList $CategoryList
 */
class Category extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'id';


	// The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
//	public $hasMany = array(
//		'CategoryList' => array(
//			'className' => 'CategoryList',
//			'foreignKey' => 'category_id',
//			'dependent' => false,
//			'conditions' => '',
//			'fields' => '',
//			'order' => '',
//			'limit' => '',
//			'offset' => '',
//			'exclusive' => '',
//			'finderQuery' => '',
//			'counterQuery' => ''
//		)
//	);
	public $validate =array(
	    "category"=>array(
            array("rule"=>"notBlank",
                    "message"=>"記入してください。")
        )
    );
    public function getCategory(){
        return $this->find("list",array("fields"=>"category"));
    }


    //参加者がテーブルに存在するかチェックし、いない場合、新たに追加する。
    //返り値はそれらの主キーのベクトルである。
    public function addCategory($categories)
    {
        $ids=[];
        foreach ($categories as   $category){
            $conditions=array("category"=>$category["category"]);
            if($this->hasAny($conditions)){
                $id=$this->find("first",array("fields"=>"id","conditions"=>$conditions));
                $ids[]=$id["Category"]["id"];
            }else{
                $this->saveAll($category);
                $ids[]=$this->getInsertId();
            }
        }

        return $ids;

    }


    public  function jsonizeCategory()
    {
        $arr_category= $this->find("all",array("fields"=>array("id","category")));
        $json_category=[];
        foreach ($arr_category as$i => $category){
            $json_category[$i]["label"]=$category["Category"]["category"];
            $json_category[$i]["id"]=$category["Category"]["id"];
        }
        return json_encode($json_category);
    }
}
