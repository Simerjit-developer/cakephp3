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
            <h2 class="no-margin-bottom"><?php echo $suggestions_label; ?></h2>
        </div>
    </header>
    <!-- Breadcrumb-->
    <div class="breadcrumb-holder container-fluid">
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo $this->request->getAttribute("webroot"); ?>"><?php echo $home; ?></a></li>
            <li class="breadcrumb-item active"><?php echo $suggestions_label; ?></li>
            <li class="breadcrumb-item active"><?php echo $view; ?>            </li>
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
                                        <th scope="row"><?php echo $user_label; ?></th>
                                        <td><?= $suggestion->has('user') ? $this->Html->link($suggestion->user->username, ['controller' => 'Users', 'action' => 'view', $suggestion->user->id]) : '' ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row"><?php echo $restaurant_label; ?></th>
                                        <td><?= $suggestion->restaurant_name; ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row"><?php echo $location; ?></th>
                                        <td><?= h($suggestion->location) ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row"><?php echo $content; ?></th>
                                        <td><?= h($suggestion->content);?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row"><?php echo $created ?></th>
                                        <td><?= h($suggestion->created) ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row"><?php echo $modified; ?></th>
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
