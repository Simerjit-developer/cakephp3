
<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Restaurant[]|\Cake\Collection\CollectionInterface $restaurants
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
            <h2 class="no-margin-bottom"><?php echo $restaurants_label; ?></h2>
        </div>
    </header>
    <!-- Breadcrumb-->
    <div class="breadcrumb-holder container-fluid">
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo $this->request->getAttribute("webroot"); ?>"><?php echo $home; ?></a></li>
            <li class="breadcrumb-item active"><?php echo $restaurants_label; ?></li>
        </ul>
    </div>
    <section class="tables">   
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">


                    <div class="card">
                        <div class="card-header d-flex align-items-center">
                            <h3 class="h4"><?php echo $all." ".$restaurants_label; ?></h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">                       
                               <table id="example2" class="table table-bordered table-hover dataTable no-footer" role="grid" aria-describedby="example2_info">
                                    <thead>
                                        <tr>
                                            <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                                            <th scope="col"><?= $this->Paginator->sort('user_id',$user_label) ?></th>
                                            <th scope="col"><?= $this->Paginator->sort('name',$name) ?></th>
                                            <th scope="col"><?= $this->Paginator->sort('image',$image) ?></th>
                                            <th scope="col"><?= $this->Paginator->sort('cuisine_id',$cuisine_label) ?></th>
                                            <th scope="col"><?= $this->Paginator->sort('starting_price',$starting_price) ?></th>
                                            <th scope="col"><?= $this->Paginator->sort('avg_rating',$avg_rating) ?></th>
                                            <th scope="col"><?= $this->Paginator->sort('created',$created) ?></th>
                                            <th scope="col"><?= $this->Paginator->sort('modified',$modified) ?></th>
                                            <th scope="col" class="actions"><?= __($actions) ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($restaurants as $key =>$restaurant): ?>
                                            <tr>
                                                <td><?= $this->Number->format($key+1) ?></td>
                                                <td><?= $restaurant->has('user') ? $this->Html->link($restaurant->user->firstname, ['controller' => 'Users', 'action' => 'view', $restaurant->user->id]) : '' ?></td>
                                                <td><?php
                                                if($lang=='english'){
                                                    echo $restaurant->name;
                                                }else{
                                                    echo $restaurant->name_p;
                                                }
                                                 ?></td>
                                                <td>
                                                    <img style="width:50px;" src="<?= h($restaurant->image) ?>">
                                            
                                                </td>
                                                <td><?= $restaurant->has('cuisine') ? $this->Html->link($restaurant->cuisine->name, ['controller' => 'Cuisines', 'action' => 'view', $restaurant->cuisine->id]) : '' ?></td>
                                                <td><?= $this->Number->format($restaurant->starting_price) ?></td>
                                                    <td><?php
                                                        //$this->Number->format($restaurant->avg_rating)
                                                        for ($x = 1; $x <= $restaurant->avg_rating; $x++) {
                                                            echo '<span class="fa fa-star"></span>';
                                                        }
                                                        if (strpos($restaurant->avg_rating, '.')) {
                                                            echo '<span class="fa fa-star-half-empty"></span>';
                                                            $x++;
                                                        }
                                                        while ($x <= 5) {
                                                            echo '<span class="fa fa-star-o"></span>';
                                                            $x++;
                                                        }
                                                        ?></td>
                                                    <td><?= h($restaurant->created) ?></td>
                                                <td><?= h($restaurant->modified) ?></td>
                                                <td class="actions">
                                                    <?= $this->Html->link(__($view), ['action' => 'view', $restaurant->id]) ?>
                                                    <?= $this->Html->link(__($edit),['action' => 'edit', $restaurant->id],['target' => '_blank']) ?>
                                                    <?= $this->Html->link(__($generate_barcodes), ['controller'=>'Tables','action' => 'generatebarcodes', $restaurant->id]) ?>
                                                    <?= $this->Html->link(__($get_barcodes), ['controller'=>'Tables','action' => 'index', $restaurant->id]) ?>
                                                    <?= $this->Form->postLink(__($delete), ['action' => 'delete', $restaurant->id], ['confirm' => __('Are you sure you want to delete # {0}?', $restaurant->name)]) ?>
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

