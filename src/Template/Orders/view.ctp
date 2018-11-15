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
            <h2 class="no-margin-bottom"><?php echo $orders_label; ?></h2>
        </div>
    </header>
    <!-- Breadcrumb-->
    <div class="breadcrumb-holder container-fluid">
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo $this->request->getAttribute("webroot"); ?>">Home</a></li>
            <li class="breadcrumb-item active"><?php echo $orders_label; ?></li>
            <li class="breadcrumb-item active"><?php echo $view; ?>            </li>
        </ul>
    </div>
    <section class="tables">   
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header d-flex align-items-center">
                            <h3 class="h4"><?= h($order->id) ?></h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table vertical-table">
                                    <tr>
                                        <th scope="row"><?php echo $user_label; ?></th>
                                        <td><?= $order->has('user') ? $this->Html->link($order->user->username, ['controller' => 'Users', 'action' => 'view', $order->user->id]) : '' ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row"><?php echo $restaurant_label; ?></th>
                                        <td><?= $order->has('restaurant') ? $this->Html->link($order->restaurant->name, ['controller' => 'Restaurants', 'action' => 'view', $order->restaurant->id]) : '' ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row"><?php echo $waiter_label; ?></th>
                                        <td><?= $order->has('waiter') ? $this->Html->link($order->waiter->name, ['controller' => 'Waiters', 'action' => 'view', $order->waiter->id]) : '' ?></td>
                                    </tr>

                                    <tr>
                                        <th scope="row"><?php echo $table_label; ?></th>
                                        <td><?= h($order->table_id) ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row"><?php echo $subtotal; ?></th>
                                        <td><?= h($order->subtotal) ?></td>
                                    </tr>
                                     <tr>
                                        <th scope="row"><?php echo $discount_label; ?></th>
                                        <td><?= h($order->orderdiscount) ?></td>
                                    </tr>
                                     
                                    <tr>
                                        <th scope="row"><?php echo $payment_method; ?></th>
                                        <td><?= h($order->payment_method) ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row"><?php echo $stripe_pay_token; ?></th>
                                        <td><?= h($order->payment_token) ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row"><?php echo $gratuity; ?></th>
                                        <td><?= h($order->gratuity) ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row"><?php echo $tax; ?></th>
                                        <td><?= h($order->tax) ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row"><?php echo $total; ?></th>
                                        <td><?= h($order->totalamount) ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row"><?php echo $admin_commission; ?></th>
                                        <td><?= h($order->commission) ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row"><?php echo $created ?></th>
                                        <td><?= h($order->created) ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row"><?php echo $modified ?></th>
                                        <td><?= h($order->modified) ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <?php if (!empty($order->order_items)):
                        //print_r($order->order_items);
                        ?>
                        <div class="card">
                            <div class="card-header d-flex align-items-center">
                                <h3 class="h4"><?php echo $rel_order_items; ?></h3>
                            </div>
                            <div class="card-body">

                                <div class="table-responsive">
                                    <table class="table vertical-table">
                                        <tr>
                                            <th scope="col"><?php echo $product_name ?></th>
                                            <th scope="col"><?php echo $quantity; ?></th>
                                            <th scope="col"><?php echo $price; ?></th>
                                            <th scope="col"><?php echo $refill; ?></th>
                                            <th scope="col"><?php echo $comment_label; ?></th>
                                            <th scope="col"><?php echo $created; ?></th>
                                            <th scope="col"><?php echo $modified; ?></th>
                                            <!--<th scope="col" class="actions"><?= __('Actions') ?></th>-->
                                        </tr>
                                        <?php foreach ($order->order_items as $menus): ?>
                                            <tr>
                                                <td><?= $menus->has('menu') ? $this->Html->link($menus->menu->name, ['controller' => 'Menus', 'action' => 'view', $menus->menu->id]) : '' ?></td>
                                                <td><?= h($menus->quantity) ?></td>
                                                <td><?php
                                                if($menus->refill==1){
                                                    if($menus->menu->freeavailable==1){
                                                        echo '0';
                                                    } else{
                                                        echo $menus->quantity * $menus->menu->price;
                                                    }
                                                }else{
                                                    echo $menus->quantity * $menus->menu->price;
                                                }
                                                 ?></td>
                                                <td><?php if($menus->refill==1){
                                                    if($menus->menu->freeavailable==1){
                                                        echo 'Free';
                                                    } else{
                                                        echo 'Paid';
                                                    }
                                                }else{
                                                    
                                                } ?></td>
                                                <td><?= h($menus->comment) ?></td>
                                                <td><?= h($menus->created) ?></td>
                                                <td><?= h($menus->modified) ?></td>
                                                <!--td class="actions">
                                                <?= $this->Html->link(__($view), ['controller' => 'Menus', 'action' => 'view', $menus->id]) ?>
                                                <?= $this->Html->link(__($edit), ['controller' => 'Menus', 'action' => 'edit', $menus->id]) ?>
                                                <?= $this->Form->postLink(__($delete), ['controller' => 'Menus', 'action' => 'delete', $menus->id], ['confirm' => __('Are you sure you want to delete # {0}?', $menus->id)]) ?>
                                                </td-->
                                            </tr>
                                        <?php endforeach; ?>
                                    </table>
                                </div>

                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
    <?= $this->element('footer'); ?>
</div>
