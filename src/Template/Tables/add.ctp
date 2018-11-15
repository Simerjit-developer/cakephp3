<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<div class="content-inner">
    <!-- Page Header-->
    <header class="page-header">
        <div class="container-fluid">
            <h2 class="no-margin-bottom">Users</h2>
        </div>
    </header>
    <!-- Breadcrumb-->
    <div class="breadcrumb-holder container-fluid">
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item"><a href="/">Users</a></li>
            <li class="breadcrumb-item active">Add</li>
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
                            <h3 class="h4">Add New User</h3>
                        </div>
                        <div class="card-body">
                            <?= $this->Form->create($user, array('class' => 'form-horizontal')) ?>
                            <!--<form class="form-horizontal">-->
                            <div class="form-group row">
                                <label class="col-sm-3 form-control-label">First Name</label>
                                <div class="col-sm-9">
                                    <?php echo $this->Form->control('firstname', ['class' => 'form-control form-control-success', 'label' => false]); ?>
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label class="col-sm-3 form-control-label">Last Name</label>
                                <div class="col-sm-9">
                                    <?php echo $this->Form->control('lastname', ['class' => 'form-control form-control-success', 'label' => false]); ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 form-control-label">Username</label>
                                <div class="col-sm-9">
                                    <?php echo $this->Form->control('username', ['class' => 'form-control form-control-success', 'label' => false]); ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 form-control-label">Email</label>
                                <div class="col-sm-9">
                                    <?php echo $this->Form->control('email', ['class' => 'form-control form-control-success', 'label' => false]); ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 form-control-label">Password</label>
                                <div class="col-sm-9">
                                    <?php echo $this->Form->control('password', ['class' => 'form-control form-control-success', 'label' => false]); ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 form-control-label">Address</label>
                                <div class="col-sm-9">
                                    <?php echo $this->Form->control('address', ['class' => 'form-control form-control-success', 'label' => false]); ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 form-control-label">Nationality</label>
                                <div class="col-sm-9">
                                    <?php echo $this->Form->control('nationality', ['class' => 'form-control form-control-success', 'label' => false]); ?>
                                </div>
                            </div>


                            <div class="form-group row">
                                <label class="col-sm-3 form-control-label">Description</label>
                                <div class="col-sm-9">
                                    <?php echo $this->Form->control('description', ['class' => 'form-control form-control-success', 'label' => false]); ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 form-control-label">Role</label>
                                <div class="col-sm-9">
                                    <?php echo $this->Form->control('role', ['class' => 'form-control form-control-success', 'label' => false]); ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 form-control-label">Status</label>
                                <div class="col-sm-9">
                                    <div class="i-checks">
                                        <input type="checkbox" name="status" value="1" class="checkbox-template">
                                        <label for="checkboxCustom2">Active</label>
                                    </div>
                                    
                                    
                                    <?php //echo $this->Form->control('status', ['class' => 'form-control form-control-success', 'label' => false]); ?>
                                </div>
                            </div>

                            <div class="form-group row">       
                                <div class="col-sm-9 offset-sm-3">
                                    <?= $this->Form->button(__('Submit'), array('class' => 'btn btn-primary')) ?>
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