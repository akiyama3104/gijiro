<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
$cakeVersion = __d('cake_dev', 'CakePHP %s', Configure::version())


?>
<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $cakeDescription ?>:
		<?php echo $this->fetch('title'); ?>


	</title>
	<?php
		echo $this->Html->meta('icon');

//		echo $this->Html->css('cake.generic');

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
        echo $this->Html->css('bootstrap.min');
        echo $this->Html->css('bootstrap-responsive');
        echo $this->Html->css('bootstrap-grid.min');
        echo $this->Html->css('bootstrap-reboot.min');
        echo $this->Html->css('jquery-ui.theme.min');
        echo $this->Html->css('jquery-ui.min');
        echo $this->Html->css('jquery-ui.structure.min');
        echo $this->Html->css('layout');
        echo $this->Html->css('bootstrap-datetimepicker.min');
        echo $this->Html->script( 'jquery-3.2.1.min' );
        echo $this->Html->script( 'jquery-ui.min' );
        echo $this->Html->script('bootstrap.min');
        echo $this->Html->script('gijiro-layout');
        echo $this->Html->script("popper");
//        echo $this->Html->script("moment-min");
//        echo $this->Html->script("moment-with-locales-min");
        echo $this->Html->script("bootstrap-datetimepicker.min");



//    echo $this->Html->script('gijiro-form');
    ?>
</head>
<body>
	<div id="container">
		<div id="header">
            <nav class="nav_header"><span class="to_home"><?php echo $this->Html->link('Home', '/'); ?></span>
            <span class="to_add"><?= $this->Html->link("投稿する",array("controller"=>"proceedings","action"=>"add",$this->Session->read("Auth.User.id"))); ?></span>
            </nav>
            <div class="notification">   <span class="msg_wellcome" >ようこそ：<?=h($this->Session->read("Auth.User.username"));?>さん</span>
                <span class="to_logout"><?= $this->Html->link("ログアウト",array("controller"=>"users","action"=>"logout"));?></span></div>
            <h1>Gijiro!</h1>
		</div>
		<div id="content">

			<?php echo $this->Flash->render(); ?>

			<?php echo $this->fetch('content'); ?>
		</div>
		<div id="footer">
			<?php echo $this->Html->link(
					$this->Html->image('cake.power.gif', array('alt' => $cakeDescription, 'border' => '0')),
					'https://cakephp.org/',
					array('target' => '_blank', 'escape' => false, 'id' => 'cake-powered')
				);
			?>
			<p>
				<?php echo $cakeVersion; ?>
			</p>
		</div>
	</div>



	<?php echo $this->element('sql_dump'); ?>
    <script>

        $(function () {
            setTimeout(function(){
$('#flashMessage').fadeOut();
            },800);

        })
    </script>
</body>
</html>
