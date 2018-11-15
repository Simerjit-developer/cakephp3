<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Menu[]|\Cake\Collection\CollectionInterface $menus
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
            <h2 class="no-margin-bottom"><?php echo $menus_label; ?></h2>
        </div>
    </header>
    <!-- Breadcrumb-->
    <div class="breadcrumb-holder container-fluid">
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo $this->request->getAttribute("webroot"); ?>"><?php echo $home;?></a></li>
            <li class="breadcrumb-item active"><?php echo $menus_label; ?></li>
        </ul>
    </div>
    <section class="tables">   
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header d-flex align-items-center">
                            <h3 class="h4"><?php echo $all." ".$menus_label; ?></h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">                       
                              <table id="example2" class="table table-bordered table-hover dataTable no-footer" role="grid" aria-describedby="example2_info">
                                <thead>
                                    <tr>
                                        <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('restaurant_id',$restaurant_label) ?></th>
                <th scope="col"><?= $this->Paginator->sort('category_id',$category_label) ?></th>
                <th scope="col"><?= $this->Paginator->sort('name',$name) ?></th>
                <th scope="col"><?= $this->Paginator->sort('price',$price) ?></th>
                <th scope="col"><?= $this->Paginator->sort('created',$created) ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified',$modified) ?></th>
                <th scope="col" class="actions"><?= __($actions) ?></th>
                                    </tr>
                                </thead>
                                <tbody>
            <?php foreach ($menus as $key=>$menu): ?>
                                        <tr>
                <td><?= $this->Number->format($key+1) ?></td>
                                            <td><?= $menu->has('restaurant') ? $this->Html->link($menu->restaurant->name, ['controller' => 'Restaurants', 'action' => 'view', $menu->restaurant->id]) : '' ?></td>
                <td><?= $menu->has('category') ? $this->Html->link($menu->category->name, ['controller' => 'Categories', 'action' => 'view', $menu->category->id]) : '' ?></td>
                <td><?php
                if($lang=='english'){
                    echo $menu->name;
                }else{
                    echo $menu->name_p;
                }
                 ?></td>
                                            <td><?= $this->Number->format($menu->price) ?></td>
                                            <td><?= h($menu->created) ?></td>
                                            <td><?= h($menu->modified) ?></td>
                                            <td class="actions">
                    <?= $this->Html->link(__($view), ['action' => 'view', $menu->id]) ?>
                    <?= $this->Html->link(__($edit), ['action' => 'edit', $menu->id]) ?>
                    <?= $this->Form->postLink(__($delete), ['action' => 'delete', $menu->id], ['confirm' => __('Are you sure you want to delete # {0}?', $menu->name)]) ?>
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

