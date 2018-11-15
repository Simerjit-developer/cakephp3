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
            <h2 class="no-margin-bottom"><?php echo $ratings_label; ?></h2>
        </div>
    </header>
    <!-- Breadcrumb-->
    <div class="breadcrumb-holder container-fluid">
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo $this->request->getAttribute("webroot"); ?>"><?php echo $home; ?></a></li>
            <li class="breadcrumb-item active"><?php echo $ratings_label; ?></li>
        </ul>
    </div>
    <section class="tables">   
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header d-flex align-items-center">
                            <h3 class="h4"><?php echo $all." ".$ratings_label; ?></h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">                       
                                <table id="example2" class="table table-bordered table-hover dataTable no-footer" role="grid" aria-describedby="example2_info">
                                    <thead>
                                        <tr>
                                            <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                                            <th scope="col"><?= $this->Paginator->sort('restaurant_id',$restaurant_label) ?></th>
                                            <th scope="col"><?= $this->Paginator->sort('user_id',$user_label) ?></th>
                                            <th scope="col"><?= $this->Paginator->sort('order_id',$order_label) ?></th>
                                            <th scope="col"><?= $this->Paginator->sort('service',$service) ?></th>
                                            <th scope="col"><?= $this->Paginator->sort('quality',$quality) ?></th>
                                            <th scope="col"><?= $this->Paginator->sort('ambiance',$ambiance) ?></th>
                                            <!--<th scope="col"><?= $this->Paginator->sort('reason',$reason) ?></th>-->
                                            <th scope="col"><?= $this->Paginator->sort('comment',$comment_label) ?></th>
                                            <th scope="col"><?= $this->Paginator->sort('created',$created) ?></th>
                                            <th scope="col" class="actions"><?= __($actions) ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($ratings as $key=>$rating): 
                                            $unserialized_data=unserialize($rating->reason);
                                                if(count($unserialized_data)>0){
                                                    foreach ($unserialized_data as $key => $value) {
                                                        
                                                        if(gettype($value)=='array'){
                                                            foreach ($value as $key1 => $value1) {
                                                                $label=$key1;
                                                                $label_value=implode(",",$value1);
                                                                if($label=='service'){
                                                                    $service_reason = "<p>".$label_value."</p>";
                                                                }else if($label=='quality'){
                                                                    $quality_reason = "<p>".$label_value."</p>";
                                                                }else if($label=='ambiance'){
                                                                    $ambiance_reason = "<p>".$label_value."</p>";
                                                                }
                                                               // echo $label.": ".$label_value."<br/><br/>";
                                                            }
                                                        }
                                                    }
                                                }else{
                                                    $service_reason='';
                                                    $quality_reason='';
                                                    $ambiance_reason='';
                                                }
                                            ?>
                                            <tr>
                                                <td><?= $this->Number->format($key+1) ?></td>
                                                <td><?= $rating->has('restaurant') ? $this->Html->link($rating->restaurant->name, ['controller' => 'Restaurants', 'action' => 'view', $rating->restaurant->id]) : '' ?></td>
                                                <td><?= $rating->has('user') ? $this->Html->link($rating->user->username, ['controller' => 'Users', 'action' => 'view', $rating->user->id]) : '' ?></td>
                                                <td><?= $rating->has('order') ? $this->Html->link($rating->order->order_number, ['controller' => 'Orders', 'action' => 'view', $rating->order->id]) : '' ?></td>
                                                <td><?php
                                                        //$this->Number->format($restaurant->avg_rating)
                                                        for ($x = 1; $x <= $rating->service; $x++) {
                                                            echo '<span class="fa fa-star"></span>';
                                                        }
                                                        if (strpos($rating->service, '.')) {
                                                            echo '<span class="fa fa-star-half-empty"></span>';
                                                            $x++;
                                                        }
                                                        while ($x <= 5) {
                                                            echo '<span class="fa fa-star-o"></span>';
                                                            $x++;
                                                        }
                                                        echo $service_reason;
                                                        ?>
                                                </td>
                                                <td><?php
                                                        //$this->Number->format($restaurant->avg_rating)
                                                        for ($x = 1; $x <= $rating->quality; $x++) {
                                                            echo '<span class="fa fa-star"></span>';
                                                        }
                                                        if (strpos($rating->quality, '.')) {
                                                            echo '<span class="fa fa-star-half-empty"></span>';
                                                            $x++;
                                                        }
                                                        while ($x <= 5) {
                                                            echo '<span class="fa fa-star-o"></span>';
                                                            $x++;
                                                        }
                                                        echo $quality_reason;
                                                        ?>
                                                
                                                
                                                </td>
                                                <td><?php
                                                        //$this->Number->format($restaurant->avg_rating)
                                                        for ($x = 1; $x <= $rating->ambiance; $x++) {
                                                            echo '<span class="fa fa-star"></span>';
                                                        }
                                                        if (strpos($rating->ambiance, '.')) {
                                                            echo '<span class="fa fa-star-half-empty"></span>';
                                                            $x++;
                                                        }
                                                        while ($x <= 5) {
                                                            echo '<span class="fa fa-star-o"></span>';
                                                            $x++;
                                                        }
                                                        echo $ambiance_reason;
                                                        ?>
                                                
                                                
                                                </td>
                                                <!--td><?php
                                                /*$unserialized_data=unserialize($rating->reason);
                                                if(count($unserialized_data)>0){
                                                    foreach ($unserialized_data as $key => $value) {
                                                        
                                                        if(gettype($value)=='array'){
                                                            foreach ($value as $key1 => $value1) {
                                                                $label=$key1;
                                                                $label_value=implode(",",$value1);
                                                                echo $label.": ".$label_value."<br/><br/>";
                                                            }
                                                        }
                                                    }
                                                }*/
                                                /*if($rating->reason){
                                                    print_r($rating->reason);
                                                    //h(implode(",", unserialize($rating->reason)));
                                                }*/
                                                 ?></td-->
                                                <td><?= h($rating->comment) ?></td>
                                                <td><?= h($rating->created) ?></td>
                                                <td class="actions">
                                                    <?= $this->Form->postLink(__($delete), ['action' => 'delete', $rating->id], ['confirm' => __('Are you sure you want to delete # {0}?', $rating->id)]) ?>
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

