<!DOCTYPE html>
<html lang="pt-br">
<head>
	<?= $this->Html->charset() ?>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="keywords" content="your,keywords">
	<meta name="description" content="Short explanation about this website">

	<title>
		Supra
		<?= $this->fetch('title') ?>
	</title>
	<?= $this->Html->meta('icon') ?>

	<?= $this->Html->css('http://fonts.googleapis.com/css?family=Roboto:300italic,400italic,300,400,500,700,900') ?>
	<?= $this->Html->css('Admin.theme-default/bootstrap.css') ?>
	<?= $this->Html->css('Admin.theme-default/materialadmin.css') ?>
	<?= $this->Html->css('Admin.theme-default/font-awesome.min.css') ?>
	<?= $this->Html->css('Admin.theme-default/material-design-iconic-font.min') ?>

	<?= $this->fetch('meta') ?>
	<?= $this->fetch('css') ?>
	<?= $this->fetch('script') ?>
</head>

<body class="menubar-hoverable header-fixed ">

	<!-- BEGIN LOGIN SECTION -->
	<section class="section-account">
		<div class="img-backdrop"></div>
		<div class="spacer"></div>
		<div class="card contain-sm style-transparent">
			<div class="card-body">
				<?= $this->fetch('content') ?>
			</div><!--end .card-body -->
		</div><!--end .card -->
	</section>
	<!-- END LOGIN SECTION -->

	<!-- BEGIN JAVASCRIPT -->
	<?= $this->Html->script('Admin.libs/jquery/jquery-1.11.2.min'); ?>
	<?= $this->Html->script('Admin.libs/jquery/jquery-migrate-1.2.1.min'); ?>
	<?= $this->Html->script('Admin.libs/bootstrap/bootstrap.min'); ?>
	<?= $this->Html->script('Admin.libs/spin.js/spin.min'); ?>
	<?= $this->Html->script('Admin.libs/autosize/jquery.autosize.min'); ?>
	<?= $this->Html->script('Admin.libs/nanoscroller/jquery.nanoscroller.min'); ?>
	<?= $this->Html->script('Admin.libs/d3/d3.min'); ?>
	<?= $this->Html->script('Admin.libs/d3/d3.v3.min'); ?>
	<?= $this->Html->script('Admin.libs/rickshaw/rickshaw.min'); ?>
	<?= $this->Html->script('Admin.core/source/App'); ?>
	<?= $this->Html->script('Admin.core/source/AppNavigation'); ?>
	<?= $this->Html->script('Admin.core/source/AppOffcanvas'); ?>
	<?= $this->Html->script('Admin.core/source/AppCard'); ?>
	<?= $this->Html->script('Admin.core/source/AppForm'); ?>
	<?= $this->Html->script('Admin.core/source/AppNavSearch'); ?>
	<?= $this->Html->script('Admin.core/source/AppVendor'); ?>
	<?= $this->Html->script('Admin.core/demo/Demo'); ?>
	<?= $this->Html->script('Admin.core/demo/DemoDashboard'); ?>
	<!-- END JAVASCRIPT -->
</body>
</html>
