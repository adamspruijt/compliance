<?php

/**
 * ProcessWire 2.x Admin Markup Template
 *
 * Copyright 2012 by Ryan Cramer
 *
 *
 */

$searchForm = $user->hasPermission('page-edit') ? $modules->get('ProcessPageSearch')->renderSearchForm() : '';
$bodyClass = $input->get->modal ? 'modal' : '';
if(!isset($content)) $content = '';

$config->styles->prepend($config->urls->adminTemplates . "styles/style.css?v=6");
$config->styles->prepend($config->urls->adminTemplates . "styles/jqui/jqui.css");
$config->scripts->append($config->urls->adminTemplates . "scripts/inputfields.js");
$config->scripts->append($config->urls->adminTemplates . "scripts/main.js?v=3");

$browserTitle = wire('processBrowserTitle');
if(!$browserTitle) $browserTitle = __(strip_tags($page->get('title|name')), __FILE__) . ' &bull; ProcessWire';
if ($input->get->modal==1) {
	$modalMod = ($input->get->ab==1 ? ' modalMod' : ' modalNoMod');}

/*
 * Dynamic phrases that we want to be automatically translated
 *
 * These are in a comment so that they register with the parser, in place of the dynamic __() function calls with page titles.
 *
 * __("Pages");
 * __("Setup");
 * __("Modules");
 * __("Access");
 * __("Admin");
 *
 */

?>
<!DOCTYPE html>
<html class="<?php echo $modalMod; ?>" lang="<?php echo __('en', __FILE__); // HTML tag lang attribute
	/* this intentionally on a separate line */ ?>">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="robots" content="noindex, nofollow" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title><?php echo $browserTitle; ?></title>

	<script type="text/javascript">
		<?php

		$jsConfig = $config->js();
		$jsConfig['debug'] = $config->debug;
		$jsConfig['urls'] = array(
			'root' => $config->urls->root,
			'admin' => $config->urls->admin,
			'modules' => $config->urls->modules,
			'core' => $config->urls->core,
			'files' => $config->urls->files,
			'templates' => $config->urls->templates,
			'adminTemplates' => $config->urls->adminTemplates,
			);

		?>
		var config = <?php echo json_encode($jsConfig); ?>;




	</script>
	<?php foreach($config->styles->unique() as $file) echo "\n\t<link type='text/css' href='$file' rel='stylesheet' />"; ?>
	<?php foreach($config->scripts->unique() as $file) echo "\n\t<script type='text/javascript' src='$file'></script>"; ?>
	<!--[if IE]>
		<link rel="stylesheet" type="text/css" href="<?php echo $config->urls->adminTemplates ?>styles/ie.css" />
	<![endif]-->
	<!--[if lte IE 8]>
		<link rel="stylesheet" type="text/css" href="<?php echo $config->urls->adminTemplates ?>styles/ie8.css" />
	<![endif]-->
</head>

<body class="<?php if($bodyClass) echo $bodyClass; if ($user->isGuest()) echo 'login-body';?>">
	<div  id="head" class='page-header'>
		<?php if (!$user->isGuest()): ?>
		<div class="nav-wrapper">
			<div class="nav-bar">
				<div class="container">
					<ul class='nav-menu nav-main'>
						<?php include($config->paths->adminTemplates . "topnav.inc"); ?>
						

						<li class='search-box'><?php echo tabIndent($searchForm, 3); ?></li>

					</ul>
				</div>
			</div>
		</div>
		<div class="nav-bread">
			<div class="container">
				<ul id='breadcrumb' class='nav-menu'><?php
					foreach($this->fuel('breadcrumbs') as $breadcrumb) {
						$title = __($breadcrumb->title, __FILE__);
						echo "\n\t\t\t\t<li><a href='{$breadcrumb->url}'>{$title} <span>&rsaquo;</span></a> </li>";
					}
					?>

			<?php if(!$user->isGuest()): ?>
				<li class="fright"><a href='<?php echo $config->urls->root; ?>'><?php echo __('View Site', __FILE__); ?></a></li>
				<li class="fright"><a class='action' href='<?php echo $config->urls->admin; ?>login/logout/'><?php echo __('logout', __FILE__); ?></a>&nbsp;//&nbsp;</li>

				<li class="fright">
				<?php if ($user->hasPermission('profile-edit')): ?>
					<a class='action' href='<?php echo $config->urls->admin; ?>profile/'><?php echo __('Edit Profile', __FILE__); ?></a>&nbsp;//&nbsp;
				<?php endif ?>
				</li>
				<li class="fright">
					<span>
						<?php echo $user->name ?>
					</span>
					&nbsp;//&nbsp;
				</li>
				
			<?php endif; ?>
				</ul>
			</div>
		</div>

		<?php endif ?>


		<div class="container title-container">
			<h1 id='title'>
				<?php echo __(strip_tags($this->fuel->processHeadline ? $this->fuel->processHeadline : $page->get("title|name")), __FILE__); ?>
			</h1>
			<?php if(trim($page->summary)) echo "<h2 class='summary'>{$page->summary}</h2>"; ?>
		</div>
		<div class="container">
			<?php if(count($notices)) include($config->paths->adminTemplates . "notices.inc"); ?>

		</div>
	</div>





	<div id="content" class="content fouc_fix">
		<div class="container">
			<div class="inner">

				<?php if($page->body) echo $page->body; ?>
				<?php echo $content?>
			</div>
		</div>
	</div>


	<div class="footer container">
		<p class="copy">
			ProcessWire <?php echo $config->version . ' <!--v' . $config->systemVersion; ?>--> &copy; <?php echo date("Y"); ?> Ryan Cramer

		</p>
		<?php if($config->debug && $this->user->isSuperuser()) include($config->paths->adminTemplates . "debug.inc"); ?>
	</div>



</body>
</html>
