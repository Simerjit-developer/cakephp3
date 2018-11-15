<div class="page login-page">
    <div class="container d-flex align-items-center">
        <div class="form-holder has-shadow">
            <div class="row">
                <!-- Logo & Information Panel-->
                <div class="col-lg-6">
                    <div class="info d-flex align-items-center">
                        <div class="content">
                            <div class="logo">
                                <h1>SupperOut</h1>
                            </div>
                            <!--<p>Only Administrator will be allowed to access this panel.</p>-->
                        </div>
                    </div>
                </div>
                <!-- Form Panel    -->
                <div class="col-lg-6 bg-white">
                    <div class="form d-flex align-items-center">
                        <div class="content">
                            <?= $this->Flash->render() ?>
                            <?= $this->Form->create('', array('class' => 'form-validate')) ?>
                                <div class="form-group">
                                    <?php //echo $this->Form->control('username', ['id'=>'loginUsername','class' => 'input-material', 'label' => false]); ?>
                                    <input id="login-password" type="password" name="password" required data-msg="Please enter your username" class="input-material">
                                    <label for="login-password" class="label-material">New Password</label>
                                </div>
                                <div class="form-group">
                                    <?php //echo $this->Form->control('username', ['id'=>'loginUsername','class' => 'input-material', 'label' => false]); ?>
                                    <input id="login-cpassword" type="password" name="confirm_password" required data-msg="Please enter your username" class="input-material">
                                    <label for="login-cpassword" class="label-material">Confirm Password</label>
                                </div>
                                <?= $this->Form->button(__('Save'), array('class' => 'btn btn-primary')) ?>
                                <!--<a id="login" href="index.html" class="btn btn-primary">Login</a>-->
                                <!-- This should be submit button but I replaced it with <a> for demo purposes-->
                            <?= $this->Form->end() ?>
                                
                            <br>
                            <!--<small>Do not have an account? </small><a href="register.html" class="signup">Signup</a>-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>