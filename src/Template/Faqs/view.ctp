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
            <li class="breadcrumb-item active"><?php echo $faqs_label; ?></li>
            <li class="breadcrumb-item active"><?php echo $view; ?></li>
        </ul>
    </div>
    <section class="tables">   
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header d-flex align-items-center">
                            <h3 class="h4"><?= h($faq->title) ?></h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table vertical-table">
                                    <tr>
                                        <th scope="row"><?php echo $title; ?></th>
                                        <td><?= h($faq->title) ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row"><?php echo $title; ?>(Portuguese)</th>
                                        <td><?= h($faq->title_p) ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row"><?php echo $content; ?></th>
                                        <td><?= h($faq->content) ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row"><?php echo $content; ?>(Portuguese)</th>
                                        <td><?= h($faq->content_p) ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row"><?php echo $status; ?></th>
                                        <td><?= h($faq->status) ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row"><?= __('Id') ?></th>
                                        <td><?= $this->Number->format($faq->id) ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row"><?php echo $created; ?></th>
                                        <td><?= h($faq->created) ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row"><?php echo $modified; ?></th>
                                        <td><?= h($faq->modified) ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>
    <?= $this->element('footer'); ?>
</div>
