<?php

?>


<h2>記事一覧</h2>
<?php //debug($posts); ?>
<ul>
<?php foreach ($posts as $post) :

?>

<li id="post_<?=h($post['Post']['id']);?>"><?=
//    h($post['Post']['title']);

     $this->Html->link($post['Post']['title'],array('controller'=>'posts','action'=>'view' ,$post['Post']['id']));
    ?>
    <?=
     $this->Html->link("編集",array('controller'=>'posts','action'=>'edit' ,$post['Post']['id']));
    ?>
    <?=
        $this->Html->link("削除","#",array("class"=>"delete","data-post-id"=>$post['Post']['id']));
    ?>

</li>
    <?php endforeach; ?>
</ul>

<h2>記事作成</h2>
<?php echo $this->Html->link('Add post',array('controller'=>'posts','action'=>'add'));

?>
<script>
    $(function(){
        $("a.delete").click(function(e){
            if(confirm("sure?")){
                $.post("/cakephp/posts/delete/"+$(this).data("post-id"),{},function(res){
                        $("#post_"+res.id).fadeOut();
                },"json");
            }

        })

    });
</script>

