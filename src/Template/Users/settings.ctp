<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
if($lang=='english')
{
   require(WWW_ROOT.'files/Languages/english.php');
}
else
{
   require(WWW_ROOT.'files/Languages/portuguese.php');
}
?>
<div class="content-inner">
    <!-- Page Header-->
    <header class="page-header">
        <div class="container-fluid">
            <h2 class="no-margin-bottom"><?php echo $settings; ?></h2>
        </div>
    </header>
    <!-- Breadcrumb-->
    <div class="breadcrumb-holder container-fluid">
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo $this->request->getAttribute("webroot"); ?>"><?php echo $home; ?></a></li>
            <li class="breadcrumb-item"><a href="<?php echo $this->request->getAttribute("webroot"); ?>"><?php echo $users_label; ?></a></li>
            <li class="breadcrumb-item active"><?php echo $settings; ?></li>
        </ul>
    </div>
    <!-- Forms Section-->
    <section class="forms"> 
        <div class="container-fluid">
            <div class="row">
                <!-- Horizontal Form-->
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header d-flex align-items-center">
                            <h3 class="h4"><?php echo $settings; ?></h3>
                        </div>
                        <div class="card-body">
                            <?= $this->Form->create($setting, array('class' => 'form-horizontal')) ?>
                            <!--<form class="form-horizontal">-->
                            <div class="form-group row">
                                <label class="col-sm-3 form-control-label"><?php echo $sel_lang; ?></label>
                                <div class="col-sm-9">
                                   <div class="i-checks">
                                        <input id="radioCustom1" type="radio" value="english" name="sel_lang" class="radio-template">
                                        <label for="radioCustom1">English</label>
                                    </div>
                                    <div class="i-checks">
                                        <input id="radioCustom2" type="radio" value="portuguese" name="sel_lang" class="radio-template">
                                        <label for="radioCustom2">Portuguese</label>
                                    </div>
                                </div>
                            </div>
                            
                          

                            <!--div class="form-group row">
                                <label class="col-sm-3 form-control-label" title="Charged for each restaurant"><?php echo $tax; ?></label>
                                <div class="col-sm-9">
                                    <?php //echo $this->Form->control('tax', ['type'=>'number','class' => 'form-control form-control-success', 'label' => false,'value'=>$setting->meta_value]); ?>
                                </div>
                            </div-->

                            <div class="form-group row">       
                                <div class="col-sm-9 offset-sm-3">
                                    <?= $this->Form->button(__($submit_button), array('class' => 'btn btn-primary')) ?>
                                  <!--<input type="submit" value="Signin" class="btn btn-primary">-->
                                </div>
                            </div>
                            <?= $this->Form->end() ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Page Footer-->
    <?= $this->element('footer'); ?>
</div>