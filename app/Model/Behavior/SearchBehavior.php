<?php
/**
 * Created by PhpStorm.
 * User: satos
 * Date: 2017/10/02
 * Time: 15:49
 */
class SearchBehavior extends AppModel{
    public  function searchParentKeys(Model $model,$searchs=array(),$options) {//子テーブルの親IDを取得する
        $parent_keys = array();
        if(isset($options["grand_child"])){//もし孫テーブルであれば、その親テーブルの外部キーカラムを設定する

            $parent_col=$options["grand_child"]["parent"];
            $foreign=$options["grand_child"]["foreign"];
        }else{//設定されてなければ、デフォルト値を設定

            $parent_col="Proceeding.id";
            $foreign="proceeding_id";
        }


        if(!empty($searchs)){
            $Children = $options["model"]->find("all", array("conditions" => $searchs));
            foreach($Children as $child){
                $parent_keys = array($parent_col => $child[$options["model_name"]][$foreign]);
            }
        }
        return $parent_keys;
    }



}