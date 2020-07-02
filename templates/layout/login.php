<!DOCTYPE html>

<!--
Template Name: Metronic - Responsive Admin Dashboard Template build with Twitter Bootstrap 4 & Angular 8
Author: KeenThemes
Website: http://www.keenthemes.com/
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Dribbble: www.dribbble.com/keenthemes
Like: www.facebook.com/keenthemes
Purchase: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
Renew Support: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
<html lang="en">

	<!-- begin::Head -->
	<head>
		<base href="http://localhost/bnindia/" target="_blank">
		<meta charset="utf-8" />
		<title>Login Page</title>
		<meta name="description" content="Login page">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<!--begin::Fonts -->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700|Roboto:300,400,500,600,700">

		<!--end::Fonts -->

		<!--begin::Page Custom Styles(used by this page) -->
		<?= $this->Html->css('assets/css/pages/login/login-6.css') ?>

		<!--end::Page Custom Styles -->

		<!--begin::Global Theme Styles(used by all pages) -->
		<?= $this->Html->css('assets/plugins/global/plugins.bundle.css') ?>
		<?= $this->Html->css('assets/css/style.bundle.css') ?>

		<!--end::Global Theme Styles -->

		<!--begin::Layout Skins(used by all pages) -->
		<?= $this->Html->css('assets/css/skins/header/base/light.css') ?>
		<?= $this->Html->css('assets/css/skins/header/menu/light.css') ?>
		<?= $this->Html->css('assets/css/skins/brand/dark.css') ?>
		<?= $this->Html->css('assets/css/skins/aside/dark.css') ?>

		<!--end::Layout Skins -->

		<?= $this->Html->meta('icon') ?>

	    <?= $this->fetch('meta') ?>
    	<?= $this->fetch('css') ?>
	</head>

	<!-- end::Head -->

	<!-- begin::Body -->
	<body class="kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header-mobile--fixed kt-subheader--enabled kt-subheader--fixed kt-subheader--solid kt-aside--enabled kt-aside--fixed kt-page--loading">

        <?= $this->fetch('content') ?> 

		<!-- begin::Global Config(global config for global JS sciprts) -->
		<script>
			var KTAppOptions = {
				"colors": {
					"state": {
						"brand": "#5d78ff",
						"dark": "#282a3c",
						"light": "#ffffff",
						"primary": "#5867dd",
						"success": "#34bfa3",
						"info": "#36a3f7",
						"warning": "#ffb822",
						"danger": "#fd3995"
					},
					"base": {
						"label": [
							"#c5cbe3",
							"#a1a8c3",
							"#3d4465",
							"#3e4466"
						],
						"shape": [
							"#f0f3ff",
							"#d9dffa",
							"#afb4d4",
							"#646c9a"
						]
					}
				}
			};
		</script>

		<!-- end::Global Config -->

		<!--begin::Global Theme Bundle(used by all pages) -->
		<?= $this->Html->script('assets/plugins/global/plugins.bundle.js') ?>
		<?= $this->Html->script('assets/js/scripts.bundle.js') ?>

		<!--end::Global Theme Bundle -->

		<!--begin::Page Scripts(used by this page) -->
		<?= $this->Html->script('assets/js/pages/custom/login/login-general.js') ?>

        <?= $this->fetch('script') ?>
		<!--end::Page Scripts -->
	</body>

	<!-- end::Body -->
</html>