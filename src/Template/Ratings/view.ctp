<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Menu $menu
 */
?>
<div class="content-inner">
    <!-- Page Header-->
    <header class="page-header">
        <div class="container-fluid">
            <h2 class="no-margin-bottom">Suggestions</h2>
        </div>
    </header>
    <!-- Breadcrumb-->
    <div class="breadcrumb-holder container-fluid">
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
            <li class="breadcrumb-item">Suggestions            </li>
            <li class="breadcrumb-item active">View            </li>
        </ul>
    </div>
    <section class="tables">   
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header d-flex align-items-center">
                            <h3 class="h4"><?= h($suggestion->id) ?></h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table vertical-table">
                                    <tr>
                                        <th scope="row"><?= __('User') ?></th>
                                        <td><?= $suggestion->has('user') ? $this->Html->link($suggestion->user->username, ['controller' => 'Users', 'action' => 'view', $suggestion->user->id]) : '' ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row"><?= __('Restaurant Name') ?></th>
                                        <td><?= $suggestion->restaurant_name; ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row"><?= __('Location') ?></th>
                                        <td><?= h($suggestion->location) ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row"><?= __('Content') ?></th>
                                        <td><?= h($suggestion->content);?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row"><?= __('Created') ?></th>
                                        <td><?= h($suggestion->created) ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row"><?= __('Modified') ?></th>
                                        <td><?= h($suggestion->modified) ?></td>
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
