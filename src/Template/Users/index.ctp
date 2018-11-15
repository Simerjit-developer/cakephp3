<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
 */
?>
<!--nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New User'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Carts'), ['controller' => 'Carts', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Cart'), ['controller' => 'Carts', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Restaurants'), ['controller' => 'Restaurants', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Restaurant'), ['controller' => 'Restaurants', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="users index large-9 medium-8 columns content">
    <h3><?= __('Users') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('username') ?></th>
                <th scope="col"><?= $this->Paginator->sort('email') ?></th>
                <th scope="col"><?= $this->Paginator->sort('password') ?></th>
                <th scope="col"><?= $this->Paginator->sort('address') ?></th>
                <th scope="col"><?= $this->Paginator->sort('nationality') ?></th>
                <th scope="col"><?= $this->Paginator->sort('role') ?></th>
                <th scope="col"><?= $this->Paginator->sort('status') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
<?php foreach ($users as $user): ?>
                <tr>
                    <td><?= $this->Number->format($user->id) ?></td>
                    <td><?= h($user->name) ?></td>
                    <td><?= h($user->username) ?></td>
                    <td><?= h($user->email) ?></td>
                    <td><?= h($user->password) ?></td>
                    <td><?= h($user->address) ?></td>
                    <td><?= h($user->nationality) ?></td>
                    <td><?= h($user->role) ?></td>
                    <td><?= h($user->status) ?></td>
                    <td><?= h($user->created) ?></td>
                    <td><?= h($user->modified) ?></td>
                    <td class="actions">
    <?= $this->Html->link(__('View'), ['action' => 'view', $user->id]) ?>
    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $user->id]) ?>
    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $user->id], ['confirm' => __('Are you sure you want to delete # {0}?', $user->id)]) ?>
                    </td>
                </tr>
<?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
<?= $this->Paginator->first('<< ' . __('first')) ?>
<?= $this->Paginator->prev('< ' . __('previous')) ?>
<?= $this->Paginator->numbers() ?>
<?= $this->Paginator->next(__('next') . ' >') ?>
<?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div-->

<?php // $this->element('language'); ?>
<?php
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
            <h2 class="no-margin-bottom"><?php echo $users_label; ?></h2>
        </div>
    </header>
    <!-- Breadcrumb-->
    <div class="breadcrumb-holder container-fluid">
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo $this->request->getAttribute("webroot"); ?>"><?php echo $home; ?></a></li>
            <li class="breadcrumb-item active"><?php echo $users_label; ?></li>
        </ul>
    </div>
    <section class="tables">   
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header d-flex align-items-center">
                            <h3 class="h4"><?php echo $all." ".$users_label; ?></h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">                       
                               <table id="example2" class="table table-bordered table-hover dataTable no-footer" role="grid" aria-describedby="example2_info">
                                    <thead>
                                        <tr>
                                            <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                                            <th scope="col"><?= $this->Paginator->sort($firstname) ?></th>
                                            <th scope="col"><?= $this->Paginator->sort($lastname) ?></th>
                                            <th scope="col"><?= $this->Paginator->sort($username) ?></th>
                                            <th scope="col"><?= $this->Paginator->sort($email) ?></th>
                                            <th scope="col"><?= $this->Paginator->sort($role) ?></th>
                                            <th scope="col"><?= $this->Paginator->sort($status) ?></th>
                                            <th scope="col"><?= $this->Paginator->sort($created) ?></th>
                                            <!--<th scope="col"><?= $this->Paginator->sort($modified) ?></th>-->
                                            <th scope="col" class="actions"><?= __($actions) ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($users as $key=>$user): ?>
                                            <tr>
                                                <td><?= $this->Number->format($key+1) ?></td>
                                                <td><?= h($user->firstname) ?></td>
                                                <td><?= h($user->lastname) ?></td>
                                                <td><?= h($user->username) ?></td>
                                                <td><?= h($user->email) ?></td>
                                                <td><?= h($user->role) ?></td>
                                                <td><?php
                                                    if ($user->status == 1) {
                                                        echo 'Active';
                                                    } else {
                                                        echo 'Inactive';
                                                    }
                                                    ?></td>
                                                <td><?= h($user->created) ?></td>
                                                <!--<td><?= h($user->modified) ?></td>-->
                                                <td class="actions">
                                                    <?= $this->Html->link(__($view), ['action' => 'view', $user->id]) ?>
    <?= $this->Html->link(__($edit), ['action' => 'edit', $user->id]) ?>
                                                    <?php if($user->role !='Admin'){ ?>
                                            <?= $this->Form->postLink(__($delete), ['action' => 'delete', $user->id], ['confirm' => __('Are you sure you want to delete # {0}?', $user->username)]) ?>
                                                    <?php } ?>
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
