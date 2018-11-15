<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Category $category
 */
if ($lang == 'english') {
    require(WWW_ROOT . 'files/Languages/english.php');
} else {
    require(WWW_ROOT . 'files/Languages/portuguese.php');
}
?>
<div class="content-inner">
    <!-- Page Header-->
    <header class="page-header">
        <div class="container-fluid">
            <h2 class="no-margin-bottom"><?php echo $amenities_label; ?></h2>
        </div>
    </header>
    <!-- Breadcrumb-->
    <div class="breadcrumb-holder container-fluid">
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo $this->request->getAttribute("webroot"); ?>"><?php echo $home; ?></a></li>
            <li class="breadcrumb-item"><?php echo $amenities_label; ?> </li>
            <li class="breadcrumb-item active"><?php echo $view; ?>   </li>
        </ul>
    </div>
    <section class="tables">   
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header d-flex align-items-center">
                            <h3 class="h4"><?= h($amenity->name) ?></h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table vertical-table">
                                    <tr>
                                        <th scope="row"><?php echo $label; ?></th>
                                        <td><?= h($amenity->label) ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row"><?php echo $label; ?>(Portuguese)</th>
                                        <td><?= h($amenity->label_p) ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row"><?= __('Id') ?></th>
                                        <td><?= $this->Number->format($amenity->id) ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row"><?= __('Created') ?></th>
                                        <td><?= h($amenity->created) ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row"><?= __('Modified') ?></th>
                                        <td><?= h($amenity->modified) ?></td>
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
<!--div class="related">
    <h4><?= __('Related Menus') ?></h4>
<?php if (!empty($category->menus)): ?>
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
    <?php foreach ($category->menus as $menus): ?>
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
