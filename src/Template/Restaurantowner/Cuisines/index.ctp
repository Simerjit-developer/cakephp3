<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Cuisine[]|\Cake\Collection\CollectionInterface $cuisines
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Cuisine'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Restaurants'), ['controller' => 'Restaurants', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Restaurant'), ['controller' => 'Restaurants', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="cuisines index large-9 medium-8 columns content">
    <h3><?= __('Cuisines') ?></h3>
   <table id="example2" class="table table-bordered table-hover">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($cuisines as $cuisine): ?>
            <tr>
                <td><?= $this->Number->format($cuisine->id) ?></td>
                <td><?= h($cuisine->name) ?></td>
                <td><?= h($cuisine->created) ?></td>
                <td><?= h($cuisine->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $cuisine->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $cuisine->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $cuisine->id], ['confirm' => __('Are you sure you want to delete # {0}?', $cuisine->id)]) ?>
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
</div>
