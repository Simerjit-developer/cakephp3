<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Category $category
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
            <h2 class="no-margin-bottom"><?php echo $faqs_label; ?></h2>
        </div>
    </header>
    <!-- Breadcrumb-->
    <div class="breadcrumb-holder container-fluid">
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo $this->request->getAttribute("webroot"); ?>"><?php echo $home; ?></a></li>
            <li class="breadcrumb-item"><a href="<?php echo $this->request->getAttribute("webroot"); ?>"><?php echo $faqs_label; ?></a></li>
            <li class="breadcrumb-item active"><?php echo $add; ?></li>
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
                            <h3 class="h4"><?php echo $add_new; ?></h3>
                        </div>
                        <div class="card-body">
                            <?= $this->Form->create($faq, ['type' => 'file'], array('class' => 'form-horizontal')) ?>
                            <div class="form-group row">
                                <label class="col-sm-3 form-control-label"><?php echo $title; ?></label>
                                <div class="col-sm-9">
                                    <?php echo $this->Form->control('title', [ 'class' => 'form-control form-control-success', 'label' => false]); ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 form-control-label"><?php echo $title; ?>(Portuguese)</label>
                                <div class="col-sm-9">
                                    <?php echo $this->Form->control('title_p', [ 'class' => 'form-control form-control-success', 'label' => false]); ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 form-control-label"><?php echo $content; ?></label>
                                <div class="col-sm-9">
                                    <?php echo $this->Form->control('content', [ 'class' => 'form-control form-control-success', 'label' => false]); ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 form-control-label"><?php echo $content; ?>(Portuguese)</label>
                                <div class="col-sm-9">
                                    <?php echo $this->Form->control('content_p', [ 'class' => 'form-control form-control-success', 'label' => false]); ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 form-control-label"><?php echo $status; ?></label>
                                <div class="col-sm-9">
                                    <?php echo $this->Form->checkbox('status', ['class' => 'checkbox-template', 'label' => false]); ?>
                                </div> 
                            </div>
                            <div class="form-group row">       
                                <div class="col-sm-9 offset-sm-3">
                                    <?= $this->Form->button(__($submit_button), array('class' => 'btn btn-primary')) ?>
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
