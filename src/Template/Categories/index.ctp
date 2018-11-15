<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Category[]|\Cake\Collection\CollectionInterface $categories
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
            <h2 class="no-margin-bottom"><?php echo $categories_label; ?></h2>
        </div>
    </header>
    <!-- Breadcrumb-->
    <div class="breadcrumb-holder container-fluid">
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo $this->request->getAttribute("webroot"); ?>"><?php echo $home; ?></a></li>
            <li class="breadcrumb-item active"><?php echo $categories_label; ?></li>
        </ul>
    </div>
    <section class="tables">   
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header d-flex align-items-center">
                            <h3 class="h4"><?php echo $all." ".$categories_label; ?></h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">                       
                                <table id="example2" class="table table-bordered table-hover dataTable no-footer" role="grid" aria-describedby="example2_info">
                                    <thead>
                                        <tr>
                                            <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                                            <th scope="col"><?= $this->Paginator->sort('name',$name) ?></th>
                                            <th scope="col"><?= $this->Paginator->sort('sort_order',$sort_order) ?></th>
                                            <th scope="col"><?= $this->Paginator->sort('created',$created) ?></th>
                                            <th scope="col"><?= $this->Paginator->sort('modified',$modified) ?></th>
                                            <th scope="col" class="actions"><?= __($actions) ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($categories as $key=>$category):
                                            //print_r($category);
                                        ?>
                                            <tr>
                                                <td><?= $this->Number->format($key+1) ?></td>
                                                <td><?php
                                                if($lang=='english'){
                                                    echo $category->name;
                                                }else{
                                                    echo $category->name_p;
                                                }
                                                 ?></td>
                                                <td><?php echo $category->sort_order; ?></td>
                                                <td><?= h($category->created) ?></td>
                                                <td><?= h($category->modified) ?></td>
                                                <td class="actions">
                                                    <?= $this->Html->link(__($view), ['action' => 'view', $category->id]) ?>
                                                    <?= $this->Html->link(__($edit), ['action' => 'edit', $category->id]) ?>
                                                    <?= $this->Form->postLink(__($delete), ['action' => 'delete', $category->id], ['confirm' => __('Are you sure you want to delete # {0}?', $category->name)]) ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
    <!-- Page Footer-->
    <?= $this->element('footer'); ?>
</div>
 