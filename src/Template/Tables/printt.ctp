<div class="content-inner" style="padding-bottom: 58.8889px;">
    <!-- Page Header-->
    <header class="page-header">
        <div class="container-fluid">
            <h2 class="no-margin-bottom">Restaurants</h2>
        </div>
    </header>
    <!-- Breadcrumb-->
    <div class="breadcrumb-holder container-fluid">
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="/supperout/">Home</a></li>
            <li class="breadcrumb-item active"><a href="/supperout/tables">Table</a> </li>
            <li class="breadcrumb-item active">Bar Code</li>
        </ul>
    </div>
    <section class="tables">   
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                	<button class="btn btn-info" onclick="myFunction()">Print this page</button>
<img src="<?php echo $this->request->getAttribute('webroot').$table->barcode_image; ?>" width="100%"/>
                </div>
            </div>

        </div>
    </section>

    <!-- Page Footer-->
    <footer class="main-footer">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <p>Your company © 2017-2019</p>
                </div>
                <div class="col-sm-6 text-right">
                    <!--<p>Design by <a href="https://bootstrapious.com/admin-templates" class="external">Bootstrapious</a></p>-->
                    <!-- Please do not remove the backlink to us unless you support further theme's development at https://bootstrapious.com/donate. It is part of the license conditions. Thank you for understanding :)-->
                </div>
            </div>
        </div>
    </footer>
</div>





<script>
function myFunction() {
    window.print();
}
</script>