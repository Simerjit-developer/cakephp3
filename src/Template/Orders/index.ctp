
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
            <h2 class="no-margin-bottom"><?php echo $orders_label; ?></h2>
        </div>
    </header>
    <!-- Breadcrumb-->
    <div class="breadcrumb-holder container-fluid">
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo $this->request->getAttribute("webroot"); ?>"><?php echo $home; ?></a></li>
            <li class="breadcrumb-item active"><?php echo $orders_label; ?></li>
        </ul>
    </div>
    <section class="tables">   
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header d-flex align-items-center">
                            <h3 class="h4">All Orders</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">                       
                               <table id="example2" class="table table-bordered table-hover dataTable no-footer" role="grid" aria-describedby="example2_info">
                                    <thead>
                                        <tr>
                                            <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                                            <th scope="col"><?= $this->Paginator->sort('user_id') ?></th>
                                            <th scope="col"><?= $this->Paginator->sort('restaurant_id') ?></th>
                                            <th scope="col"><?= $this->Paginator->sort('order_number') ?></th>
                                            <th scope="col"><?= $this->Paginator->sort('table_id') ?></th>
                                            <th scope="col"><?= $this->Paginator->sort('waiter_id') ?></th>
                                            <th scope="col"><?= $this->Paginator->sort('totalamount') ?></th>
                                            <th scope="col"><?= $this->Paginator->sort('payment_method') ?></th>
                                            <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                                            <!--<th scope="col"><?= $this->Paginator->sort('modified') ?></th>-->
                                            <th scope="col" class="actions"><?= __('Actions') ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($orders as $key=>$order): ?>
                                            <tr>
                                                <td><?= $this->Number->format($key+1) ?></td>
                                                <td><?= $order->has('user') ? $this->Html->link($order->user->firstname, ['controller' => 'Users', 'action' => 'view', $order->user->id]) : '' ?></td>
                                                <td><?= $order->has('restaurant') ? $this->Html->link($order->restaurant->name, ['controller' => 'Restaurants', 'action' => 'view', $order->restaurant->id]) : '' ?></td>
                                                <td>
                                                   <?= h('#'.sprintf('%04d', $order->order_number)) ?>
                                                </td>
                                                <td>
                                                   <?= h($order->table_id) ?>
                                                </td>
                                                <td><?= $order->has('waiter') ? $this->Html->link($order->waiter->name, ['controller' => 'Waiters', 'action' => 'view', $order->waiter->id]) : '' ?></td>
                                                <td><?= h($order->totalamount) ?></td>
                                                <td><?= h($order->payment_method) ?></td>
                                                <td><?= h($order->created) ?></td>
                                                <!--<td><?= h($order->modified) ?></td>-->
                                                <td class="actions">
                                                    <?= $this->Html->link(__('View'), ['action' => 'view', $order->id]) ?>
                                                    <?php //$this->Html->link(__('Edit'), ['action' => 'edit', $order->id]) ?>
                                                    <?php echo $this->Html->link(__('Change Waiter'), ['action' => 'assign', $order->id,$order->restaurant->id]) ?>
                                                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $order->id], ['confirm' => __('Are you sure you want to delete # {0}?', $order->id)]) ?>
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

