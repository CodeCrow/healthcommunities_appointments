<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       Cake.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
	<?php echo $this->Html->charset(); ?>
	
	<title>BLUE Appointment Request Form | <?php echo $title_for_layout; ?></title>
	<?php
		echo $this->Html->meta('icon');
		
		echo $this->Html->css('cake.generic');
		
		echo $scripts_for_layout;
	?>
	
	<!--[if lt IE 9]>
	  <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<link rel="stylesheet/less" href="/less/style.blue.less" media="all" />
	<script src="/js/less-1.1.5.min.js"></script>
	<?php if ($practice): ?>
	<style type="text/css">
	#content {
		background-image: url('<?php echo $practice['Practice']['logo']; ?>') !important;
		background-repeat: no-repeat !important;
		background-position: 25px 10px !important;
	}
	</style>
	<?php endif; ?>
	
</head>
<body>
	<div id="container">
		<header>
			<h1>Appointment Request Form</h1>
			<nav>
				<ul>
					<li><a href="/admin">Admin</a></li>
					<?php if (!empty($user)): ?>
					<li><a href="/practices">Practice</a></li>
					<li><a href="/users/logout">Logout</a></li>
					<li><a href="/app/<?php echo $practice['Practice']['slug']; ?>">Form</a></li>
					<?php endif; ?>
				</ul>
			</nav>
		</header>
		<div id="content">
			<?php echo $this->Session->flash(); ?>

			<?php echo $content_for_layout; ?>

		</div>
		<footer>
			<?php if ($practice): ?>
			<?php echo $this->Html->para('website', $this->Html->link($practice['Practice']['name'], $practice['Practice']['website'] ) ); ?>
			<?php echo $this->Html->para('phone',$practice['Practice']['phone']); ?>
			<?php endif; ?>
			<?php echo $this->element('sql_dump'); ?>
		</footer>
	</div>
</body>
</html>