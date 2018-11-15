<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit User'), ['action' => 'edit', $user->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete User'), ['action' => 'delete', $user->id], ['confirm' => __('Are you sure you want to delete # {0}?', $user->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Carts'), ['controller' => 'Carts', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Cart'), ['controller' => 'Carts', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Restaurants'), ['controller' => 'Restaurants', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Restaurant'), ['controller' => 'Restaurants', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="users view large-9 medium-8 columns content">
    <h3><?= h($user->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('First Name') ?></th>
            <td><?= h($user->firstname) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Last Name') ?></th>
            <td><?= h($user->lastname) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Username') ?></th>
            <td><?= h($user->username) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Email') ?></th>
            <td><?= h($user->email) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Address') ?></th>
            <td><?= h($user->address) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Nationality') ?></th>
            <td><?= h($user->nationality) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Role') ?></th>
            <td><?= h($user->role) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($user->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($user->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($user->modified) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Status') ?></th>
            <td><?= $user->status ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
    <div class="row">
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
</div>
