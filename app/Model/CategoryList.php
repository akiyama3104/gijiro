<?php
App::uses('AppModel', 'Model');
/**
 * CategoryList Model
 *
 * @property  $
 */
class CategoryList extends AppModel {

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
    public $recursive = 2;
    public $actsAs = array("Search.Searchable","Searchform");
    public $belongsTo=array("Category");
//    public $hasMany=array( "Category"=>array("className"=>"Category",
//        "foreignKey"=>"id",
//        "dependent"=>true)
//    );
}
