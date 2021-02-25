<?php
$cakeDescription = 'Bnindia';
 ?>
<!DOCTYPE html>
<html lang="en">

    <!-- begin::Head -->
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

        <!--begin::Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700|Roboto:300,400,500,600,700">

        <!--end::Fonts -->

        <!--begin::Page Custom Styles(used by this page) -->
         <?= $this->Html->css('assets/css/pages/error/error-3.css') ?>

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
       

        <?= $this->fetch('meta') ?>
        <?= $this->fetch('css') ?>
    </head>

    <!-- end::Head -->

    <!-- begin::Body -->
    <body class="kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header-mobile--fixed kt-subheader--enabled kt-subheader--fixed kt-subheader--solid kt-aside--enabled kt-aside--fixed kt-page--loading">

        <!-- begin:: Page -->
        <div class="kt-grid kt-grid--ver kt-grid--root">
            <div class="kt-grid__item kt-grid__item--fluid kt-grid  kt-error-v3" style="background-image: url(assets/media/error/bg3.jpg);">
                <div class="kt-error_container">
                    <span class="kt-error_number">
                        <h1>404</h1>
                    </span>
                    <p class="kt-error_title kt-font-light">
                        How did you get here
                    </p>
                    <p class="kt-error_subtitle">
                        Sorry we can't seem to find the page you're looking for.
                    </p>
                    <p class="kt-error_description">
                        There may be amisspelling in the URL entered,<br>
                        or the page you are looking for may no longer exist.
                    </p>
                </div>
            </div>
        </div>

        <!-- end:: Page -->

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
         
        <?= $this->fetch('script') ?>

        <!--end::Global Theme Bundle -->
    </body>

    <!-- end::Body -->
</html>