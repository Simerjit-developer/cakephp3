<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Menu $menu
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
            <li class="breadcrumb-item active"><?php echo $view; ?>            </li>
        </ul>
    </div>
    <section class="tables">   
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header d-flex align-items-center">
                            <h3 class="h4"><?= h($menu->name) ?></h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table vertical-table">
        <tr>
            <th scope="row"><?php echo $restaurant_label; ?></th>
            <td><?= $menu->has('restaurant') ? $this->Html->link($menu->restaurant->name, ['controller' => 'Restaurants', 'action' => 'view', $menu->restaurant->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?php echo $category_label; ?></th>
            <td><?= $menu->has('category') ? $this->Html->link($menu->category->name, ['controller' => 'Categories', 'action' => 'view', $menu->category->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?php echo $name; ?></th>
            <td><?= h($menu->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?php echo $name; ?>(Portuguese)</th>
            <td><?= h($menu->name_p) ?></td>
        </tr>
        <tr>
            <th scope="row"><?php echo $image; ?></th>
            <td><img style="width:100px;" src="<?php echo $this->request->getAttribute('webroot').$menu->image ?>"></td>
        </tr>
        <tr>
            <th scope="row"><?php echo $description; ?></th>
            <td><?= $this->Text->autoParagraph(h($menu->description)); ?></td>
        </tr>
        <tr>
            <th scope="row"><?php echo $description; ?>(Portuguese)</th>
            <td><?= $this->Text->autoParagraph(h($menu->description_p)); ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($menu->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?php echo $price; ?></th>
            <td><?= $this->Number->format($menu->price) ?></td>
        </tr>
        <tr>
            <th scope="row"><?php echo $created; ?></th>
            <td><?= h($menu->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?php echo $modified; ?></th>
            <td><?= h($menu->modified) ?></td>
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
