<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Cuisine $cuisine
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
            <h2 class="no-margin-bottom"><?php echo $cuisines_label; ?></h2>
        </div>
    </header>
    <!-- Breadcrumb-->
    <div class="breadcrumb-holder container-fluid">
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo $this->request->getAttribute("webroot"); ?>">Home</a></li>
            <li class="breadcrumb-item active"><?php echo $cuisines_label; ?></li>
            <li class="breadcrumb-item active"><?php echo $view; ?>            </li>
        </ul>
    </div>
    <section class="tables">   
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header d-flex align-items-center">
                            <h3 class="h4"><?= h($cuisine->name) ?></h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table vertical-table">
        <tr>
            <th scope="row"><?php echo $name; ?></th>
            <td><?= h($cuisine->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?php echo $name; ?>(Portguese)</th>
            <td><?= h($cuisine->name_p) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($cuisine->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?php echo $created; ?></th>
            <td><?= h($cuisine->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?php echo $modified; ?></th>
            <td><?= h($cuisine->modified) ?></td>
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
        <h4><?= __('Related Restaurants') ?></h4>
        <?php if (!empty($cuisine->restaurants)): ?>
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
            <?php foreach ($cuisine->restaurants as $restaurants): ?>
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
