<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
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
            <h2 class="no-margin-bottom"><?php echo $tables_label; ?></h2>
        </div>
    </header>
    <!-- Breadcrumb-->
    <div class="breadcrumb-holder container-fluid">
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo $this->request->getAttribute("webroot"); ?>">Home</a></li>
            <li class="breadcrumb-item active"><?php echo $tables_label; ?></li>
        </ul>
    </div>
    <section class="tables">   
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header d-flex align-items-center">
                            <h3 class="h4"><?= h($table->table_number) ?></h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table vertical-table">
                                    <tr>
                                        <th scope="row"><?php echo $table_no; ?></th>
                                        <td><?= h($table->table_number) ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row"><?php echo $restaurant_label; ?></th>
                                        <td><?= h($table->restaurant->name) ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row"><?php echo $barcode_image; ?></th>
                                        <td><img src="<?php echo $this->request->getAttribute('webroot').$table->barcode_image; ?>"/></td>
                                    </tr>
                                    <tr>
                                        <th scope="row"><?php echo $barcode_digits; ?></th>
                                        <td><?= h($table->barcode_digits) ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row"><?php echo $created ?></th>
                                        <td><?= h($table->created) ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row"><?php echo $modified ?></th>
                                        <td><?= h($table->modified) ?></td>
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
<!--div class="row">
    <h4><?= __('Description') ?></h4>
    <?= $this->Text->autoParagraph(h($user->description)); ?>
</div>
<div class="related">
    <h4><?= __('Related Carts') ?></h4>
    <?php if (!empty($user->carts)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('User Id') ?></th>
                <th scope="col"><?= __('Product Id') ?></th>
                <th scope="col"><?= __('Quantity') ?></th>
                <th scope="col"><?= __('Comment') ?></th>
                <th scope="col"><?= __('Refill') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($user->carts as $carts): ?>
                <tr>
                    <td><?= h($carts->id) ?></td>
                    <td><?= h($carts->user_id) ?></td>
                    <td><?= h($carts->product_id) ?></td>
                    <td><?= h($carts->quantity) ?></td>
                    <td><?= h($carts->comment) ?></td>
                    <td><?= h($carts->refill) ?></td>
                    <td><?= h($carts->created) ?></td>
                    <td><?= h($carts->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['controller' => 'Carts', 'action' => 'view', $carts->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['controller' => 'Carts', 'action' => 'edit', $carts->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['controller' => 'Carts', 'action' => 'delete', $carts->id], ['confirm' => __('Are you sure you want to delete # {0}?', $carts->id)]) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
</div>
<div class="related">
    <h4><?= __('Related Restaurants') ?></h4>
    <?php if (!empty($user->restaurants)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('User Id') ?></th>
                <th scope="col"><?= __('Name') ?></th>
                <th scope="col"><?= __('Image') ?></th>
                <th scope="col"><?= __('Description') ?></th>
                <th scope="col"><?= __('Cuisine Id') ?></th>
                <th scope="col"><?= __('Address') ?></th>
                <th scope="col"><?= __('Latitude') ?></th>
                <th scope="col"><?= __('Longitude') ?></th>
                <th scope="col"><?= __('Starting Price') ?></th>
                <th scope="col"><?= __('Avg Rating') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($user->restaurants as $restaurants): ?>
                <tr>
                    <td><?= h($restaurants->id) ?></td>
                    <td><?= h($restaurants->user_id) ?></td>
                    <td><?= h($restaurants->name) ?></td>
                    <td><?= h($restaurants->image) ?></td>
                    <td><?= h($restaurants->description) ?></td>
                    <td><?= h($restaurants->cuisine_id) ?></td>
                    <td><?= h($restaurants->address) ?></td>
                    <td><?= h($restaurants->latitude) ?></td>
                    <td><?= h($restaurants->longitude) ?></td>
                    <td><?= h($restaurants->starting_price) ?></td>
                    <td><?= h($restaurants->avg_rating) ?></td>
                    <td><?= h($restaurants->created) ?></td>
                    <td><?= h($restaurants->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['controller' => 'Restaurants', 'action' => 'view', $restaurants->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['controller' => 'Restaurants', 'action' => 'edit', $restaurants->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['controller' => 'Restaurants', 'action' => 'delete', $restaurants->id], ['confirm' => __('Are you sure you want to delete # {0}?', $restaurants->id)]) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
</div>
</div-->
