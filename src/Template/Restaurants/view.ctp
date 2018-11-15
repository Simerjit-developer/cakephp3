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
            <h2 class="no-margin-bottom"><?php echo $restaurants_label; ?></h2>
        </div>
    </header>
    <!-- Breadcrumb-->
    <div class="breadcrumb-holder container-fluid">
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo $this->request->getAttribute("webroot"); ?>">Home</a></li>
            <li class="breadcrumb-item active"><?php echo $restaurants_label; ?></li>
            <li class="breadcrumb-item active"><?php echo $view; ?>            </li>
        </ul>
    </div>
    <section class="tables">   
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header d-flex align-items-center">
                            <h3 class="h4"><?= h($restaurant->name) ?></h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table vertical-table">
                                    <tr>
                                        <th scope="row"><?php echo $user_label; ?></th>
                                        <td><?= $restaurant->has('user') ? $this->Html->link($restaurant->user->username, ['controller' => 'Users', 'action' => 'view', $restaurant->user->id]) : '' ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row"><?php echo $name; ?></th>
                                        <td><?= h($restaurant->name) ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row"><?php echo $name; ?>(Portuguese)</th>
                                        <td><?= h($restaurant->name_p) ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row"><?php echo $image; ?></th>
                                        <td><img style="width:100px;" src="<?php echo "/supperout/".$restaurant->image ?>"></td>
                                    </tr>
                                    <tr>
                                        <th scope="row"><?php echo $cuisine_label; ?></th>
                                        <td><?= $restaurant->has('cuisine') ? $this->Html->link($restaurant->cuisine->name, ['controller' => 'Cuisines', 'action' => 'view', $restaurant->cuisine->id]) : '' ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row"><?php echo $description?></th>
                                        <td><?= $this->Text->autoParagraph(h($restaurant->description)); ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row"><?php echo $description?>(Portuguese)</th>
                                        <td><?= $this->Text->autoParagraph(h($restaurant->description_p)); ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row"><?php echo $address ?></th>
                                        <td><?= h($restaurant->address) ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row"><?php echo $latitude ?></th>
                                        <td><?= h($restaurant->latitude) ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row"><?php echo $longitude; ?></th>
                                        <td><?= h($restaurant->longitude) ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row"><?= __('Id') ?></th>
                                        <td><?= $this->Number->format($restaurant->id) ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row"><?php echo $starting_price; ?></th>
                                        <td><?= $this->Number->format($restaurant->starting_price) ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row"><?php echo $total_tables; ?></th>
                                        <td><?= $this->Number->format($restaurant->total_tables) ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row"><?php echo $order_prep_time; ?></th>
                                        <td><?= $this->Number->format($restaurant->order_time) ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row"><?php echo $tax; ?></th>
                                        <td><?= $this->Number->format($restaurant->tax) ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row"><?php echo $avg_rating; ?></th>
                                        <td><?= $this->Number->format($restaurant->avg_rating) ?></td>
                                    </tr>

                                      <tr>
                                        <th scope="row"><?php echo $status; ?></th>
                                        <td><?php if($restaurant->status ==1){ echo "Active"; }else{ echo "Deactive" ; } ?></td>
                                    </tr> 

                                    
                                    <tr>
                                        <th scope="row"><?php echo $created; ?></th>
                                        <td><?= h($restaurant->created) ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row"><?php echo $modified ?></th>
                                        <td><?= h($restaurant->modified) ?></td>
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
    <?= $this->Text->autoParagraph(h($restaurant->description)); ?>
</div>
<div class="related">
    <h4><?= __('Related Menus') ?></h4>
    <?php if (!empty($restaurant->menus)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Restaurant Id') ?></th>
                <th scope="col"><?= __('Category Id') ?></th>
                <th scope="col"><?= __('Name') ?></th>
                <th scope="col"><?= __('Description') ?></th>
                <th scope="col"><?= __('Price') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($restaurant->menus as $menus): ?>
                <tr>
                    <td><?= h($menus->id) ?></td>
                    <td><?= h($menus->restaurant_id) ?></td>
                    <td><?= h($menus->category_id) ?></td>
                    <td><?= h($menus->name) ?></td>
                    <td><?= h($menus->description) ?></td>
                    <td><?= h($menus->price) ?></td>
                    <td><?= h($menus->created) ?></td>
                    <td><?= h($menus->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['controller' => 'Menus', 'action' => 'view', $menus->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['controller' => 'Menus', 'action' => 'edit', $menus->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['controller' => 'Menus', 'action' => 'delete', $menus->id], ['confirm' => __('Are you sure you want to delete # {0}?', $menus->id)]) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
</div>
</div-->
