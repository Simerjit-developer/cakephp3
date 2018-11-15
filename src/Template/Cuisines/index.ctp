<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Cuisine[]|\Cake\Collection\CollectionInterface $cuisines
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
            <li class="breadcrumb-item"><a href="<?php echo $this->request->getAttribute("webroot"); ?>"><?php echo $home; ?></a></li>
            <li class="breadcrumb-item active"><?php echo $cuisines_label; ?></li>
        </ul>
    </div>
    <section class="tables">   
        <div class="container-fluid">


                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <h3 class="h4"><?php echo $all." ".$cuisines_label; ?></h3>   
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">                       
                            <table id="example2" class="table table-bordered table-hover dataTable no-footer" role="grid" aria-describedby="example2_info">
                                <thead>
                                    <tr>
                                        <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                                        <th scope="col"><?= $this->Paginator->sort('name',$name) ?></th>
                                        <th scope="col"><?= $this->Paginator->sort('created',$created) ?></th>
                                        <th scope="col"><?= $this->Paginator->sort('modified',$modified) ?></th>
                                        <th scope="col" class="actions"><?= __($actions) ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($cuisines as $cuisine): ?>
                                        <tr>
                                            <td><?= $this->Number->format($cuisine->id) ?></td>
                                            <td><?php
                                                if($lang=='english'){
                                                    echo $cuisine->name;
                                                }else{
                                                    echo $cuisine->name_p; 
                                                }
                                                
                                            ?></td>
                                            <td><?= h($cuisine->created) ?></td>
                                            <td><?= h($cuisine->modified) ?></td>
                                            <td class="actions">
                                                <?= $this->Html->link(__($view), ['action' => 'view', $cuisine->id]) ?>
                                                <?= $this->Html->link(__($edit), ['action' => 'edit', $cuisine->id]) ?>
                                                <?= $this->Form->postLink(__($delete), ['action' => 'delete', $cuisine->id], ['confirm' => __('Are you sure you want to delete # {0}?', $cuisine->name)]) ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

    

        </div>
    </section>
    <!-- Page Footer-->
    <?= $this->element('footer'); ?>
</div>

