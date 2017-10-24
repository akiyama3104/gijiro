<?php
/**
 * Created by PhpStorm.
 * User: satos
 * Date: 2017/10/02
 * Time: 15:49
 */
class SearchformBehavior extends ModelBehavior {

    public function splitBlank( Model $model,$keywords) {
    $keys=mb_convert_kana($keywords , "s");

    $keys=preg_split("/[\s,]+/",$keys);
    return  $keys;
    }
    //期間検索　デフォルトはfrom
    public function termConditions(Model $model,$data=array()
    ){
    switch (@$data["from_to"]){//未定義状態のnoticeを回避している・・・
        case "to":
            $from_to="<=";
            break;
        case "from":
            $from_to =">=";
            break;
        default:
            $from_to=">=";
    }
    $conditions = array("DATE(Proceeding.".$data["column"].")".$from_to." DATE(?)"=>array($data["name"]));
    return $conditions;
    }
    //子テーブルの親IDを取得する 引数１：検索キーワードとカラム,モデルインスタントと、モデル名
    public  function searchParentKeys(Model $model,$searchs=array(),$options) {
    $parent_keys = array();
    $parent_col="Proceeding.id";
    $foreign="proceeding_id";//

    //       以下の処理は、もしbelongsToを結んでいない（親テーブルを外部結合しない）
    //       孫テーブルを探索する場合、その親テーブルの外部キーカラムを設定する処理である。使いにくいため使用しない
    //        if(isset($options["grand_child"])){
    //
    //            $parent_col=$options["grand_child"]["parent"];
    //            $foreign=$options["grand_child"]["foreign"];
    //        }else{//設定されてなければ、デフォルト値を設定
    //            $parent_col="Proceeding.id";
    //            $foreign="proceeding_id";
    //        }
    $Children = $options["model"]->find("all", array("conditions" => $searchs));
    if(!empty($Children)){
        foreach($Children as $child){
            //findしてきた結果で検索条件を作成
            $parent_keys[] = array($parent_col => $child[$options["model_name"]][$foreign]);
        }
        return $parent_keys;
    }
        return  $parent_keys[]=array("Proceeding.id"=>"");//findできなかったらどんな条件を送るべきか模索中
    }

}