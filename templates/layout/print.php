<?php
use Cake\Routing\Router;
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
    <?= $this->Html->css('assets/plugins/custom/fullcalendar/fullcalendar.bundle.css') ?>

    <!--end::Page Vendors Styles -->

    <!--begin::Global Theme Styles(used by all pages) -->
    <?= $this->Html->css('assets/plugins/global/plugins.bundle.css') ?>
    <?= $this->Html->css('assets/css/style.bundle.css') ?>
    <!--end::Global Theme Styles -->

    <!--begin::Layout Skins(used by all pages) -->
    <?= $this->Html->css('assets/css/skins/header/base/light.css') ?>
    <?= $this->Html->css('assets/css/skins/header/menu/light.css') ?>
    <?= $this->Html->css('assets/css/skins/brand/dark.css') ?>
    <?= $this->Html->css('assets/css/skins/aside/dark.css') ?>
    <?= $this->Html->css('custom.css') ?>
    <!--end::Layout Skins -->
    <!--begin::Page Vendors Styles(used by this page) -->
    <?= $this->Html->css('assets/plugins/custom/datatables/datatables.bundle.css') ?>
    <!--end::Page Vendors Styles -->

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
</head>
<!-- begin::Body -->
<body class="kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header-mobile--fixed kt-subheader--enabled kt-subheader--fixed kt-subheader--solid kt-aside--enabled kt-aside--fixed kt-page--loading">

    <!-- begin:: Page -->

    <!-- begin:: Header Mobile -->
    <!-- <div id="kt_header_mobile" class="kt-header-mobile  kt-header-mobile--fixed no-print">
        <div class="kt-header-mobile__logo">
            <a href="<?php echo Router::url('/dashboard', true); ?>">
                <img alt="Logo" src="assets/media/logos/bn2.png" />
            </a>
        </div>
        <div class="kt-header-mobile__toolbar">
            <button class="kt-header-mobile__toggler kt-header-mobile__toggler--left" id="kt_aside_mobile_toggler"><span></span></button>
            <button class="kt-header-mobile__toggler" id="kt_header_mobile_toggler"><span></span></button>
            <button class="kt-header-mobile__topbar-toggler" id="kt_header_mobile_topbar_toggler"><i class="flaticon-more"></i></button>
        </div>
    </div> -->

    <!-- end:: Header Mobile -->

    <div class="kt-grid kt-grid--hor kt-grid--root">
        <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--ver kt-page"> 

            <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-wrapper kt_wrapper-receipt" id="kt_wrapper">
           
                <!-- begin:: Content -->
                <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
                    <?= $this->Flash->render() ?>
                    <?= $this->fetch('content') ?>                        
                </div>
                <!-- end:: Content -->
 
            </div>


        </div>
    </div>

    <footer>
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

        <!--begin::Page Vendors(used by this page) -->
        <?= $this->Html->script('assets/plugins/custom/fullcalendar/fullcalendar.bundle.js') ?>
        <?= $this->Html->script('assets/plugins/custom/gmaps/gmaps.js') ?>
        <script src="//maps.google.com/maps/api/js?key=AIzaSyBTGnKT7dt597vo9QgeQ7BFhvSRP4eiMSM" type="text/javascript"></script>
       
        <!--end::Page Vendors -->

        <!--begin::Page Scripts(used by this page) -->
        <?= $this->Html->script('assets/js/pages/dashboard.js') ?>

        <?= $this->Html->script('assets/js/pages/crud/forms/widgets/bootstrap-datepicker.js') ?>
        
         <?= $this->Html->script('assets/js/pages/custom/user/profile.js') ?>

         <?= $this->Html->script('form_validation.js') ?>

         <?= $this->Html->script('assets/js/pages/crud/file-upload/dropzonejs.js') ?>
         
        <!--begin::Page Vendors(used by this page) -->
        <?= $this->Html->script('assets/plugins/custom/datatables/datatables.bundle.js') ?>
        <!--end::Page Vendors -->

        <!-- Popup js -->
         
        <?= $this->fetch('script') ?>

         <script type="text/javascript"> 
        window.onload = function() {
            $('#printbtn').trigger('click');
            $('.kt-dialog--shown').remove();
        }
 </script>
        <!--end::Page Scripts -->
    </footer> 
</body>
</html>
<!-- class="kt-dialog kt-dialog--shown kt-dialog--default kt-dialog--loader kt-dialog--top-center" -->