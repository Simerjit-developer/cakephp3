<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Restaurant $restaurant
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
            <h2 class="no-margin-bottom"><?php echo $discounts_label; ?></h2>
        </div>
    </header>
    <!-- Breadcrumb-->
    <div class="breadcrumb-holder container-fluid">
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo $this->request->getAttribute("webroot"); ?>"><?php echo $home; ?></a></li>
            <li class="breadcrumb-item"><a href="<?php echo $this->request->getAttribute("webroot"); ?>"><?php echo $discounts_label; ?></a></li>
            <li class="breadcrumb-item active"><?php echo $add; ?></li>
        </ul>
    </div>
    <!-- Forms Section-->
    <section class="forms"> 
        <div class="container-fluid">
            <div class="row">
                <!-- Horizontal Form-->
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header d-flex align-items-center">
                            <h3 class="h4"><?php echo $add_new." ".$discounts_label; ?></h3>
                        </div>
                        <div class="card-body">
                            <?= $this->Form->create($discount, array('class' => 'form-horizontal')) ?>
                            <div class="form-group row">
                                <label class="col-sm-3 form-control-label"><?php echo $restaurant_label; ?></label>
                                <div class="col-sm-9">
                                    <?php echo $this->Form->control('restaurant_id', ['options' => $restaurants,'empty'=>'Select', 'class' => 'form-control form-control-success', 'label' => false]); ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 form-control-label"><?php echo $type_label; ?></label>
                                <div class="col-sm-9">
                                    <?php echo $this->Form->control('type', ['options' => ['visits'=>'Visits','amount'=>'Spend'], 'class' => 'form-control form-control-success', 'label' => false]); ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 form-control-label"><?php echo $discount_after." ".$discount_after_hint; ?></label>
                                <div class="col-sm-9">
                                    <?php echo $this->Form->control('discount_after', ['class' => 'form-control form-control-success', 'label' => false]); ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 form-control-label"><?php echo $discount_unit." ".$discount_unit_hint; ?></label>
                                <div class="col-sm-9">
                                    <?php echo $this->Form->control('discount_unit', ['options'=>['percentage'=>'Percentage','amount'=>'Amount'],'class' => 'form-control form-control-success', 'label' => false]); ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 form-control-label"><?php echo $discount_of." ".$discount_of_hint; ?></label>
                                <div class="col-sm-9">
                                    <?php echo $this->Form->control('discount_of', ['class' => 'form-control form-control-success', 'label' => false]); ?>
                                </div>
                            </div>
                            
                             <div class="form-group row">
                                <label class="col-sm-3 form-control-label"><?php echo $menu_label." ".$menu_label_hint; ?> </label>
                                <div class="col-sm-9">
                                    <?php echo $this->Form->control('menu_id', ['options' => $menus,'empty'=>'Select','class' => 'form-control form-control-success', 'label' => false]); ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 form-control-label"><?php echo $valid_till; ?></label>
                                <div class="col-sm-9">
                                    <?php echo $this->Form->control('valid_till', ['class' => 'form-control form-control-success', 'label' => false]); ?>
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
<script>
$(document).ready(function(){
    var getUrl = window.location;
    var baseUrl = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];
    $('#restaurant-id').on('change', function() {
        $.get(baseUrl+'/api/menus/fetchmenu/'+this.value+'.json', function(data, status){
            if(status == 'success' && data.status==true){
                var html = '<option value="">Select</option>';
                $.each( data.data, function( key, value ) {
                    html += '<option value="'+key+'">'+value+'</option>';
                });
                $('#menu-id').html(html)
            }
            //console.log("Data: " + data + "\nStatus: " + status);
        });
    });
})
</script>