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
        <meta http-equiv="content-type"
              content="text/html; charset=ISO-8859-1">
        <title>
            <?= $cakeDescription ?>:
            <?= $this->fetch('title') ?>
        </title>
        <?=
        //$this->Html->meta('icon')
        $this->Html->meta('icon', 'icon.png');
        ?>

        <!-- Bootstrap CSS-->
        <link rel="stylesheet" href="/supperout/vendor/bootstrap/css/bootstrap.min.css">
        <!-- Font Awesome CSS-->
        <link rel="stylesheet" href="/supperout/vendor/font-awesome/css/font-awesome.min.css">
        <!-- Google fonts - Poppins -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,700">
        <?= $this->Html->css(array('fontastic.css', 'style.sea.css', 'custom.css')) ?>  
        <link rel="stylesheet" href="<?php echo $this->request->getAttribute('webroot'); ?>css/dataTables.bootstrap.min.css"/>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <?php echo $this->Html->css(['select2.min']); ?>
        <!-- JavaScript files-->
        <script src="<?php echo $this->request->getAttribute('webroot'); ?>vendor/jquery/jquery.min.js"></script>
        <script src="<?php echo $this->request->getAttribute('webroot'); ?>vendor/popper.js/umd/popper.min.js"></script>
        <script src="<?php echo $this->request->getAttribute('webroot'); ?>vendor/bootstrap/js/bootstrap.min.js"></script>
        <script src="<?php echo $this->request->getAttribute('webroot'); ?>vendor/jquery.cookie/jquery.cookie.js"></script>
        <script src="<?php echo $this->request->getAttribute('webroot'); ?>vendor/chart.js/Chart.min.js"></script>
        <script src="<?php echo $this->request->getAttribute('webroot'); ?>vendor/jquery-validation/jquery.validate.min.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <!-- Main File-->
        <!--<script src="js/front.js"></script>-->

        <?= $this->fetch('meta') ?>
        <?= $this->fetch('css') ?>
        <?= $this->fetch('script') ?>

        <?php
        echo $this->Html->script([
            'select2.min',
            'front',
        ]);
        ?>

    </head>
    <body>
        <div class="page">
            <?= $this->element('header'); ?>
            <?= $this->Flash->render() ?>
            <div class="page-content d-flex align-items-stretch"> 
                <!-- Side Navbar -->
                <?= $this->element('sidebar'); ?>
                <?= $this->fetch('content') ?>
            </div>
        </div>
        <!--<script src="<?php echo $this->request->getAttribute('webroot'); ?>js/jquery.dataTables.min.js"></script>-->
        <script src="<?php echo $this->request->getAttribute('webroot'); ?>js/jquery.dataTables.js"></script>
        <script src="<?php echo $this->request->getAttribute('webroot'); ?>js/dataTables.bootstrap.min.js"></script>
        <script>
$(document).ready(function () {

    $('#example2').DataTable({
        'paging': true,
        'lengthChange': false,
        'searching': true,
        'ordering': false,
        'info': true,
        'autoWidth': false,
        'order': [[1, "desc"]],
        'lang':'portguese'
    });

    $('#example2_wrapper').removeClass('form-inline');
        var current_lang = "<?php echo $lang; ?>";
        console.log(current_lang)
        if(current_lang=='portuguese'){
            $("#showing_label").text('mostrando')
            $("#to_label").text('para')
            $("#of_label").text('do')
            $("#entries_label").text('Entradas')
            $("#search_label").text('Procurar')
            $('#example2_previous a').text('Anterior')
            $('#example2_next a').text('Próximo')
            
        }
    });

        </script>

    </body>
</html>
