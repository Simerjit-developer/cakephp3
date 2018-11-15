<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Cuisine $cuisine
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $cuisine->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $cuisine->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Cuisines'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Restaurants'), ['controller' => 'Restaurants', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Restaurant'), ['controller' => 'Restaurants', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="cuisines form large-9 medium-8 columns content">
    <?= $this->Form->create($cuisine) ?>
    <fieldset>
        <legend><?= __('Edit Cuisine') ?></legend>
        <?php
            echo $this->Form->control('name');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
