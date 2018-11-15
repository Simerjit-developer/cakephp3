
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
            <h2 class="no-margin-bottom"><?php echo $waiters_label; ?></h2>
        </div>
    </header>
    <!-- Breadcrumb-->
    <div class="breadcrumb-holder container-fluid">
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo $this->request->getAttribute("webroot"); ?>"><?php echo $home; ?></a></li>
            <li class="breadcrumb-item active"><?php echo $waiters_label; ?></li>
        </ul>
    </div>
    <section class="tables">   
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header d-flex align-items-center">
                            <h3 class="h4"><?php echo $all." ".$waiters_label; ?></h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">                       
                               <table id="example2" class="table table-bordered table-hover dataTable no-footer" role="grid" aria-describedby="example2_info">
                                    <thead>
                                        <tr>
                                            <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                                            <th scope="col"><?= $this->Paginator->sort('restaurant_id') ?></th>
                                            <th scope="col"><?= $this->Paginator->sort('name') ?></th>
                                            <th scope="col"><?= $this->Paginator->sort('image') ?></th>
                                            <th scope="col"><?= $this->Paginator->sort('description') ?></th>
                                            <th scope="col"><?= $this->Paginator->sort('status') ?></th>
                                            <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                                            <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                                            <th scope="col" class="actions"><?= __('Actions') ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($waiters as $key=>$waiter): ?>
                                            <tr>
                                                <td><?= $this->Number->format($key+1) ?></td>
                                                <td><?= $waiter->has('restaurant') ? $this->Html->link($waiter->restaurant->name, ['controller' => 'Restaurants', 'action' => 'view', $waiter->restaurant->id]) : '' ?></td>
                                                <td><?= h($waiter->name) ?></td>
                                                <td>
                                                    <img style="width:50px;" src="<?php echo $this->request->getAttribute("webroot").$waiter->image ?>">
                                                </td>
                                                <td><?= h($waiter->description) ?></td>
                                                <td><?= h($waiter->status) ?></td>
                                                <td><?= h($waiter->created) ?></td>
                                                <td><?= h($waiter->modified) ?></td>
                                                <td class="actions">
                                                    <?= $this->Html->link(__($view), ['action' => 'view', $waiter->id]) ?>
                                                    <?= $this->Html->link(__($edit), ['action' => 'edit', $waiter->id]) ?>
                                                    <?= $this->Form->postLink(__($delete), ['action' => 'delete', $waiter->id], ['confirm' => __('Are you sure you want to delete # {0}?', $waiter->name)]) ?>
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

