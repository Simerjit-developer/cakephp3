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
 * @since         0.10.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = 'SupperOut: Restaurant System';
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $cakeDescription ?>:
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>
    
    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="/supperout/vendor/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome CSS-->
    <link rel="stylesheet" href="/supperout/vendor/font-awesome/css/font-awesome.min.css">
    <!-- Google fonts - Poppins -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,700">
    <?= $this->Html->css(array('fontastic.css','style.sea.css','custom.css')) ?>
    
    
    <!-- JavaScript files-->
    <script src="<?php echo $this->request->getAttribute('webroot'); ?>vendor/jquery/jquery.min.js"></script>
    <script src="<?php echo $this->request->getAttribute('webroot'); ?>vendor/popper.js/umd/popper.min.js"> </script>
    <script src="<?php echo $this->request->getAttribute('webroot'); ?>vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo $this->request->getAttribute('webroot'); ?>vendor/jquery.cookie/jquery.cookie.js"> </script>
    <script src="<?php echo $this->request->getAttribute('webroot'); ?>vendor/chart.js/Chart.min.js"></script>
    <script src="<?php echo $this->request->getAttribute('webroot'); ?>vendor/jquery-validation/jquery.validate.min.js"></script>
    <!-- Main File-->
    <!--<script src="js/front.js"></script>-->
    <?= $this->Html->script('front.js') ?>
    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body>
    <?= $this->fetch('content') ?>
</body>
</html>

