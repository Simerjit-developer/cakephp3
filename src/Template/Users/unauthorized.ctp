<div class="page login-page">
    <div class="container d-flex align-items-center">
        <div class="form-holder has-shadow">
            <div class="row">
                <!-- Logo & Information Panel-->
                <div class="col-lg-12">
                    <div class="info d-flex align-items-center">
                        <div class="content">
                            <div class="logo">
                                <h1>SupperOut</h1>
                            </div>
                            <p>You are not authorized to access this panel.</p>
                            <?php if(isset($authUser)){
                                if($authUser['role']=='RestaurantOwner'){
                                    $url = $this->request->getAttribute("webroot").'restaurantowner';
                                }else{
                                    $url = $this->request->getAttribute("webroot");
                                }
                            }else{
                                $url = $this->request->getAttribute("webroot");
                            } ?>
                            <p><a style="color: #fff;" href="<?php echo $url ; ?>">Click Here</a> to navigate to the website.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
