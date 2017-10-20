<?php
/**
 * Created by PhpStorm.
 * User: satos
 * Date: 2017/09/27
 * Time: 14:35
 */


?>

<?php //debug($post);?>
<h2><?php echo h($post['Post']['title']);?></h2>
<p><?php echo h($post['Post']['title']);?></p>

<h2>Comments</h2>

<ul>
    <?php foreach ($post["Comment"] as $comment):?>
    <li id="comment_<?=h($comment['id']);?>">
    <?=h($comment["body"]);?> by <?=h($comment["commenter"]);?>
    <?= $this->Html->link("削除","#",array("class"=>"delete","data-comment-id"=>$comment['id'])); ?>
    </li>
    <?php endforeach; ?>
</ul>
<h2>コメントを追加</h2>
<?=
 $this->Form->create("Comment",array("action"=>"add"));?>
<?=$this->Form->input("commenter");?>
<?=$this->Form->input("body",array("row"=>3));?>
<?=$this->Form->input("Comment.post_id",array("type"=>"hidden","value"=>$post["Post"]["id"]));?>
<?=$this->Form->end("post!");
?>

<script>
    $(function(){
        $("a.delete").click(function(e){
            if(confirm("sure?")){
                $.post("/cakephp/comments/delete/"+$(this).data("comment-id"),{},function(res){
                    $("#comment_"+res.id).fadeOut();
                },"json");
            }

        })

    });
</script>