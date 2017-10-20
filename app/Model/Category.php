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
	        array(
                    "rule"=>"isUnique",
                    "message"=>"すでにあるカテゴリです。"),
            array("rule"=>"notBlank",
                    "message"=>"記入してください。")
        )

    );

}
