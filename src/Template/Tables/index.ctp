<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
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
            <li class="breadcrumb-item"><a href="<?php echo $this->request->getAttribute("webroot"); ?>"><?php echo $home; ?></a></li>
            <li class="breadcrumb-item active"><?php echo $tables_label; ?></li>
        </ul>
    </div>
    <section class="tables">   
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header d-flex align-items-center">
                            <h3 class="h4"><?php echo $all." ".$tables_label; ?></h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">                       
                               <table id="example2" class="table table-bordered table-hover dataTable no-footer" role="grid" aria-describedby="example2_info">
                                    <thead>
                                        <tr>
                                            <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                                            <th scope="col"><?= $this->Paginator->sort('table_number',$table_no) ?></th>
                                            <th scope="col"><?= $this->Paginator->sort('restaurant_id',$restaurant_label) ?></th>
                                            <th scope="col"><?= $this->Paginator->sort('waiter_id',$waiter_label) ?></th>
                                            <th scope="col"><?= $this->Paginator->sort('barcode_image',$barcode_image) ?></th>
                                            <th scope="col"><?= $this->Paginator->sort('barcode_digits',$barcode_digits) ?></th>
                                            <th scope="col"><?= $this->Paginator->sort('created',$created) ?></th>
                                            <!--<th scope="col"><?= $this->Paginator->sort('modified',$modified) ?></th>-->
                                            <th scope="col" class="actions"><?= __($actions) ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($tables as $key=>$table): ?>
                                            <tr>
                                                <td><?= $this->Number->format($key+1) ?></td>
                                                <td><?= h('#'.$table->table_number) ?></td>
                                                <td><?= $table->has('restaurant') ? $this->Html->link($table->restaurant->name, ['controller' => 'Restaurants', 'action' => 'view', $table->restaurant->id]) : ''  ?></td>
                                                <td><?= $table->has('waiter') ? $this->Html->link($table->waiter->name, ['controller' => 'Waiters', 'action' => 'view', $table->waiter->id]) : ''  ?></td>
                                                <td><img style="width:100px;" src="<?php echo $this->request->getAttribute('webroot').$table->barcode_image ?>"></td>
                                                <td><?= h($table->barcode_digits) ?></td>
                                                <td><?= h($table->created) ?></td>
                                                <!--<td><?= h($table->modified) ?></td>-->
                                                <td class="actions">
                                                    <?= $this->Html->link(__($view), ['action' => 'view', $table->id]) ?>
                                                    <?= $this->Html->link(__($print), ['action' => 'printt', $table->id]) ?>
                                                    <?= $this->Html->link(__($edit), ['action' => 'edit', $table->id]) ?>
                                                    <?= $this->Form->postLink(__($delete), ['action' => 'delete', $table->id], ['confirm' => __('Are you sure you want to delete # {0}?', $table->id)]) ?>
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
