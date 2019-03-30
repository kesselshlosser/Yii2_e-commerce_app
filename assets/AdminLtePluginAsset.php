<?php
namespace app\assets;

use yii\web\AssetBundle;

class AdminLtePluginAsset extends AssetBundle
{
    public $sourcePath = '@vendor/almasaeed2010/adminlte/plugins';

    public $js = [
        //<!-- jQuery 3 -->
        'bower_components/jquery/dist/jquery.min.js',
        //<!-- jQuery UI 1.11.4 -->
        'bower_components/jquery-ui/jquery-ui.min.js',
        //<!-- Bootstrap 3.3.7 -->
        'bower_components/bootstrap/dist/js/bootstrap.min.js',
        //<!-- Morris.js charts -->
        'bower_components/raphael/raphael.min.js',
        //<!-- Morris.js charts -->
        'bower_components/morris.js/morris.min.js',
        //<!-- Sparkline -->
        'bower_components/jquery-sparkline/dist/jquery.sparkline.min.js',
        //<!-- jvectormap -->
        'plugins/jvectormap/jquery-jvectormap-1.2.2.min.js',
        //<!-- jvectormap -->
        'plugins/jvectormap/jquery-jvectormap-world-mill-en.js',
        //<!-- jQuery Knob Chart -->
        'bower_components/jquery-knob/dist/jquery.knob.min.js',
        //<!-- daterangepicker -->
        'bower_components/moment/min/moment.min.js',
        //<!-- daterangepicker -->
        'bower_components/bootstrap-daterangepicker/daterangepicker.js',
        //<!-- datepicker -->
        'bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js',
        //<!-- Bootstrap WYSIHTML5 -->
        'plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js',
        //<!-- Slimscroll -->
        'bower_components/jquery-slimscroll/jquery.slimscroll.min.js',
        //<!-- FastClick -->
        'bower_components/fastclick/lib/fastclick.js',
        //<!-- AdminLTE App -->
        'dist/js/adminlte.min.js',
        //<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
        'dist/js/pages/dashboard.js',
        //<!-- AdminLTE for demo purposes -->
        'dist/js/demo.js',

        // POS_HEAD
        /*
         * <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
           <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
           <!--[if lt IE 9]>
         */
        'https://oss.maxcdn.com/respond/1.4.2/respond.min.js',
        'https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js',
    ];
    public $css = [
        //Bootstrap 3.3.7
        'bower_components/bootstrap/dist/css/bootstrap.min.css',
        //<!-- Font Awesome -->
        'bower_components/font-awesome/css/font-awesome.min.css',
        //<!-- Ionicons -->
        'bower_components/Ionicons/css/ionicons.min.css',
        //<!-- Theme style -->
        'dist/css/AdminLTE.min.css',
        // <!-- AdminLTE Skins. Choose a skin from the css/skins folder instead of downloading all of them to reduce the load. -->
        'dist/css/skins/_all-skins.min.css',
        //<!-- Morris chart -->
        'bower_components/morris.js/morris.css',
        //<!-- jvectormap -->
        'bower_components/jvectormap/jquery-jvectormap.css',
        //<!-- Date Picker -->
        'bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css',
        //<!-- Daterange picker -->
        'bower_components/bootstrap-daterangepicker/daterangepicker.css',
        //<!-- bootstrap wysihtml5 - text editor -->
        'plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css',
        // Google fonts
        'https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic',
    ];
    public $depends = [
        'dmstr\web\AdminLteAsset',
    ];
}
