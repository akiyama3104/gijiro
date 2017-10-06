<?php

?>


<h1>Blog Posts</h1>
<ul>
    <?php foreach ($posts as $post) : ?>
    <li><?= h($post->title);?></li>
    <?php endforeach; ?>
</ul>