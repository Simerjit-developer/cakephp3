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
            <h2 class="no-margin-bottom"><?php echo $suggestions_label; ?></h2>
        </div>
    </header>
    <!-- Breadcrumb-->
    <div class="breadcrumb-holder container-fluid">
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo $this->request->getAttribute("webroot"); ?>"><?php echo $home; ?></a></li>
            <li class="breadcrumb-item active"><?php echo $suggestions_label; ?></li>
        </ul>
    </div>
    <section class="tables">   
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header d-flex align-items-center">
                            <h3 class="h4"><?php echo $all." ".$suggestions_label; ?></h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">                       
                                <table id="example2" class="table table-bordered table-hover dataTable no-footer" role="grid" aria-describedby="example2_info">
                                    <thead>
                                        <tr>
                                            <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                                            <th scope="col"><?= $this->Paginator->sort('user_id',$user_label) ?></th>
                                            <th scope="col"><?= $this->Paginator->sort('restaurant_name',$restaurant_name) ?></th>
                                            <th scope="col"><?= $this->Paginator->sort('location',$location) ?></th>
                                            <th scope="col"><?= $this->Paginator->sort('content',$content) ?></th>
                                            <th scope="col"><?= $this->Paginator->sort('created',$created) ?></th>
                                            <th scope="col"><?= $this->Paginator->sort('modified',$modified) ?></th>
                                            <th scope="col" class="actions"><?= __($actions) ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($suggestions as $key=>$suggestion): ?>
                                            <tr>
                                                <td><?= $this->Number->format($key+1) ?></td>
                                                <td><?= $suggestion->has('user') ? $this->Html->link($suggestion->user->username, ['controller' => 'Users', 'action' => 'view', $suggestion->user->id]) : '' ?></td>
                                                <td><?= h($suggestion->restaurant_name) ?></td>
                                                <td><?= h($suggestion->location) ?></td>
                                                <td><?= h($suggestion->content) ?></td>
                                                <td><?= h($suggestion->created) ?></td>
                                                <td><?= h($suggestion->modified) ?></td>
                                                <td class="actions">
                                                    <?= $this->Html->link(__($view), ['action' => 'view', $suggestion->id]) ?>
                                                    <?= $this->Form->postLink(__($delete), ['action' => 'delete', $suggestion->id], ['confirm' => __('Are you sure you want to delete # {0}?', $suggestion->id)]) ?>
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

