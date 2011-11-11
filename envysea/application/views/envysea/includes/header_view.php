<!doctype html>
<html>

<!-- Envysea Header (normal pages) -->

<head>
<!-- meta tags -->
<?php echo meta('Content-type', 'text/html; charset=UTF-8', 'equiv'); ?>
<meta name="description" content="<?php if (!empty($page_description)) { echo $page_description; } else { echo $this->config->item('site_description'); } ?>"/> 
<meta name="keywords" content="<?php if (!empty($page_keywords)) { echo $page_keywords; } else { echo $this->config->item('site_keywords'); } ?>"/> 
<meta name="author" content="<?php echo $this->config->item('author'); ?>"/> 

<!-- favicon -->
<?php echo link_tag('assets/images/favicon.png', 'shortcut icon', 'image/png'); ?>

<!-- css -->
<?php echo link_tag('assets/css/reset.css', 'stylesheet', 'text/css'); ?><!-- Eric Meyer CSS reset v2.0 (HTML5 and CSS3 support) -->
<?php echo link_tag('assets/css/base.css', 'stylesheet', 'text/css'); ?><!-- Shared CSS Elements -->
<?php echo link_tag('assets/css/style.css', 'stylesheet', 'text/css'); ?><!-- Unique to non-admin and non-secure pages only -->

<!-- javascript -->
<!--[if IE]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.js"></script><!-- jQuery v1.7 -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/scripts.js"></script><!-- custom jQuery scripts/plugins -->

<title><?php if (!empty($title)) { echo $title; } else { echo $this->config->item('site_title'); } ?></title>

</head>
<body>
<div id="container">
	<div id="header">
		<!-- delete this -->
		<div id="logo">
			<?php echo anchor('http://envysea.com/showcase/open/', 'Home'); ?>
		</div>
		<!-- /end delete this -->
		<ul id="nav">
			<li><?php echo anchor(base_url(), 'Home', 'title="Home is where you make it."'); ?></li>
			<li><?php echo anchor('envysea/about', 'About'); ?></li>
			<li><?php echo anchor('members','Members'); ?></li>
			<li><?php echo anchor('envysea/contact','Contact'); ?></li>
		</ul>
	</div>