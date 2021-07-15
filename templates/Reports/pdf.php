<?php 
$cakeDescription = 'Bnindia';
?>
<!DOCTYPE html>
<html>
<head>
 <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!--begin::Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700|Roboto:300,400,500,600,700">
    <!--end::Fonts -->
    <title>
        <?= $cakeDescription ?>:
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/normalize.css@8.0.1/normalize.css">

    <!-- <?= $this->Html->css('milligram.min.css') ?>
    <?= $this->Html->css('cake.css') ?> -->

    <!--begin::Page Vendors Styles(used by this page) -->
    <?= $this->Html->css('assets/plugins/custom/fullcalendar/fullcalendar.bundle.css', ['fullBase' => true]) ?>

    <!--end::Page Vendors Styles -->

    <!--begin::Global Theme Styles(used by all pages) -->
    <?= $this->Html->css('assets/plugins/global/plugins.bundle.css', ['fullBase' => true]) ?>
    <?= $this->Html->css('assets/css/style.bundle.css', ['fullBase' => true]) ?>
    <!--end::Global Theme Styles -->

    <!--begin::Layout Skins(used by all pages) -->
    <?= $this->Html->css('assets/css/skins/header/base/light.css', ['fullBase' => true]) ?>
    <?= $this->Html->css('assets/css/skins/header/menu/light.css', ['fullBase' => true]) ?>
    <?= $this->Html->css('assets/css/skins/brand/dark.css', ['fullBase' => true]) ?>
    <?= $this->Html->css('assets/css/skins/aside/dark.css', ['fullBase' => true]) ?>
    <?= $this->Html->css('custom.css', ['fullBase' => true]) ?>
    <!--end::Layout Skins -->
    <!--begin::Page Vendors Styles(used by this page) -->
    <?= $this->Html->css('assets/plugins/custom/datatables/datatables.bundle.css', ['fullBase' => true]) ?>
    <!--end::Page Vendors Styles -->

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <style>
@page {
	margin: 0px 0px 0px 0px !important;
	padding: 0px 0px 0px 0px !important;
}
</style>
</head>
<body>
<h3>Welcome to Bnindia application</h3>
</body>
</html> 

<?php //echo $this->Html->link(__('Download PDF'), ['action' => 'pdf', $report->id ]) ?>
