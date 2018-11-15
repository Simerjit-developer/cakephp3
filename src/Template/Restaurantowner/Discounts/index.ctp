
<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Restaurant[]|\Cake\Collection\CollectionInterface $restaurants
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
            <h2 class="no-margin-bottom"><?php echo $offered_discounts; ?></h2>
        </div>
    </header>
    <!-- Breadcrumb-->
    <div class="breadcrumb-holder container-fluid">
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo $this->request->getAttribute("webroot"); ?>"><?php echo $home; ?></a></li>
            <li class="breadcrumb-item"><a href="<?php echo $this->request->getAttribute("webroot"); ?>"><?php echo $discounts_label; ?></a></li>
        </ul>
    </div>
    <section class="tables">   
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header d-flex align-items-center">
                            <h3 class="h4"><?php echo $offered_discounts; ?></h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">                       
                               <table id="example2" class="table table-bordered table-hover dataTable no-footer" role="grid" aria-describedby="example2_info">
                                    <thead>
                                        <tr>
                                            <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                                            <th scope="col"><?= $this->Paginator->sort('restaurant_id',$restaurant_label) ?></th>
                                            <th scope="col"><?= $this->Paginator->sort('type',$type_label) ?></th>
                                            <th scope="col"><?= $this->Paginator->sort('discount_after',$discount_after) ?></th>
                                            <th scope="col"><?= $this->Paginator->sort('discount_unit',$discount_unit) ?></th>
                                            <th scope="col"><?= $this->Paginator->sort('discount_of',$discount_of) ?></th>
                                            <th scope="col"><?= $this->Paginator->sort('menu_id',$menu_label) ?></th>
                                            <th scope="col"><?= $this->Paginator->sort('valid_till',$valid_till) ?></th>
                                            <th scope="col"><?= $this->Paginator->sort('created',$created) ?></th>
                                            <th scope="col" class="actions"><?= __($actions) ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($discounts as $discount): ?>
                                            <tr>
                                                <td><?= $this->Number->format($discount->id) ?></td>
                                                <td><?= $discount->has('restaurant') ? $this->Html->link($discount->restaurant->name, ['controller' => 'Restaurants', 'action' => 'view', $discount->restaurant->id]) : '' ?></td>
                                                <td><?= h($discount->type) ?></td>
                                                <td><?= h($discount->discount_after) ?></td>
                                                <td><?= h($discount->discount_unit) ?></td>
                                                <td><?= h($discount->discount_of) ?></td>
                                                <td><?= $discount->has('menu') ? $this->Html->link($discount->menu->name, ['controller' => 'Menus', 'action' => 'view', $discount->menu->id]) : '' ?></td>
                                                <td><?= ($discount->valid_till) ?></td>
                                                <td><?= h($discount->created) ?></td>
                                                <td class="actions">
                                                    <?php //$this->Html->link(__('View'), ['action' => 'view', $discount->id]) ?>
                                                    <?= $this->Html->link(__($edit), ['action' => 'edit', $discount->id]) ?>
                                                    <?= $this->Form->postLink(__($delete), ['action' => 'delete', $discount->id], ['confirm' => __('Are you sure you want to delete # {0}?', $discount->id)]) ?>
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

