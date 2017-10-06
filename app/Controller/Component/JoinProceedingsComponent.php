<?php
/**
 * Created by PhpStorm.
 * User: satos
 * Date: 2017/10/02
 * Time: 17:02
 */

App::uses("Component","Controller");
//議事録テーブルと各テーブルを内部結合する
class JoinProceedingsComponent extends Component{

    public function getJoins($conditions=null) {
        return [
//            array("Proceeding.*","User.username","Heading.heading_name",
//                "Attender.attender_name","Attender.belongs","Content.content")
            "fields" => "*",
            "conditions"=> $conditions,
            "recursive"=>1,
            "joins" => [
                [   //ユーザー
                    "type" => "inner",
                    "table" => "users",
                   // "alias" => "User",
                    "conditions" => "Proceeding.user_id = users.id"
                ],
                [   //見出し
                    "type" => "left",
                    "table" => "headings",
                    "alias" => "Heading",
                    "conditions" => "Proceeding.id = Heading.proceeding_id"
                ],

                [   //議事録内容
                    "type" => "left",
                    "table" => "contents",
                    "alias" => "Content",
                    "conditions" => "Heading.id = Content.heading_id"
                ],
                [   //参加者
                    "type" => "left",
                    "table" => "attenders",
                    "alias" => "Attender",
                    "conditions" => "Proceeding.id = Attender.proceeding_id"
                ]


            ]
        ];
    }

    public function getData($conditions =null) {
        $Proceeding = ClassRegistry::init("Proceeding");
        $joinParam = $this->getJoins($conditions);
        return $Proceeding->find("all", $joinParam);
    }
}