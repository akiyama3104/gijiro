<?php
/**
 * Created by PhpStorm.
 * User: satos
 * Date: 2017/10/02
 * Time: 11:45
 */


$status_color=array("fixed"=>"text-success","task"=>"text-danger" ,""=>"text-muted");
?>

<h2>議事録詳細画面</h2>

<ul>
    <li><h2>議題：<?= h($proceeding["Proceeding"]["title"]);?></h2></li>
    <li><h3>投稿者：</h3><?= h($proceeding["User"]["username"]);?></li>
    <li><h3>開催時間：</h3><?= h($proceeding["Proceeding"]["start_time"]);?>～<?= h($proceeding["Proceeding"]["end_time"]);?></li>
    <li><h3>開催場所：</h3><?= h($proceeding["Proceeding"]["place"]);?></li>
    <li><table class="table table-bordered">
            <tr><td class="row_explain"><h3>参加者：</h3></td>
                <?php foreach ($proceeding["Attender"] as $attender ) : ?>
                <td><?= h($attender["attender_name"]);?></td>
                <?php endforeach;?>
            </tr>
            <tr><td class="row_explain"><h3>所属：</h3></td>
                <?php foreach ($proceeding["Attender"] as $attender ) : ?>
                    <td><?= h($attender["belongs"]);?></td>
                <?php endforeach;?>
            </tr>
        </table>
    </li>
    <li><h3>会議目的：</h3><p><?= nl2br(h($proceeding["Proceeding"]["agenda"]));?></p></li>
    <li><h3>会議部署：</h3><?=$type_id[$proceeding["Proceeding"]["type"]];?></li>
    <li><h3>カテゴリ：</h3><?php foreach ($proceeding["Category"] as $category): ?>
                <span><?=$category["category"];?></span>
                <?php endforeach;?>
    </li>
    <li><h3>会議内容:</h3>
        <ul><?php foreach ($proceeding["Heading"] as $heading): ?>
            <li><h3>見出し：<span class="headings_view"><?=h( $heading["heading_name"]);?></span></h3>
                <ul>
                    <?php foreach ($heading["Content"] as $content): ?>

                    <li>
                        <ul>
                            <li class="contents_view"><span class="arrow">→</span><?=nl2br(h($content["content"]));?></li>
                            <li class= "status_row">状態：<span class="status_view <?=$status_color[$content["status"]]?>"><?=$content_type[$content["status"]]?></span></li>
                        </ul></li>

                  <?php endforeach;?>
                </ul>
            </li>
            <?php endforeach;?>
        </ul>
    </li>
    <li><h3>次回開催時間：</h3><?= h($proceeding["Proceeding"]["next_start"]);?>～<?= h($proceeding["Proceeding"]["next_end"]);?></li>
    <li><h3>補足：</h3><?= h($proceeding["Proceeding"]["suppl"]);?></li>
    <li><h3>投稿日時：</h3><?= h($proceeding["Proceeding"]["created"]);?></li>
    <li><h3>更新日時：</h3><?= h($proceeding["Proceeding"]["modified"]);?></li>
    </ul>
<p>
    <?php echo   $this->Html->link("編集",array('controller'=>'proceedings',"action"=>"edit",$proceeding["Proceeding"]["id"]),array("class"=>array("btn", "btn-lg","btn-success")));?>
</p>