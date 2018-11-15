<?php
        echo $this->Html->css([
            'jquery.DonutWidget.min',
        ]);
        ?>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bxslider/4.2.15/jquery.bxslider.min.css" rel="stylesheet" />
<div class="content-inner">
    <!-- Page Header-->
    <header class="page-header">
        <div class="container-fluid">
            <h2 class="no-margin-bottom">Home</h2>
        </div>
    </header>
    <!-- Breadcrumb-->
    <div class="breadcrumb-holder container-fluid">
        <ul class="breadcrumb">
            <li class="breadcrumb-item">Home</li>
        </ul>
    </div>

    <section class="charts">
        <div class="container-fluid">
            <div class="row">
                   <div class="col-lg-12">
                       
          <div class="line-chart-example card">
                        <div class="card-header d-flex align-items-center">
                            <h3 class="h4">Current Week Sale</h3>
                        </div>
                        <div class="card-body">
                             <?php
                    foreach($data['weekdata'] as $index=>$weekdata){
                        ?>
                     <div class="widget-wrap" style="display:inline-block; margin-bottom: 30px; text-align: center;">
                    <div class="donut-widget" data-chart-size="normal" data-chart-max="100" data-chart-value="<?php echo $weekdata['percentage'];  ?>" data-chart-text="<?php echo (int)$weekdata['percentage'];  ?>%" data-chart-primary="#fd7e14" data-chart-background="#D3D3D3"></div>
                    <?php echo date("l", strtotime($weekdata['day'])); ?> 
                     </div>
 <?php
                    }
                    
                    
                    ?>
                        </div>
                    </div>

                </div>
                 <div class="col-lg-6">
                  <div class="bar-chart-example card">
                    <div class="card-header d-flex align-items-center">
                      <h3 class="h4">Commission</h3>
                    </div>
                    <div class="card-body">
                      <canvas id="barChartExample"></canvas>
                    </div>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="bar-chart-example card">
                    <div class="card-close">
                   
                    </div>
                    <div class="card-header d-flex align-items-center">
                      <h3 class="h4">Top Restaurants</h3>
                    </div>
                    <div class="card-body new-style">
                        <div class="table-responsive">                       
                               <table class="table no-footer" role="grid" aria-describedby="example2_info">
                                    <thead>
                                        <tr>
                                            <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                                            <th scope="col"><?= $this->Paginator->sort('user_id') ?></th>
                                            <th scope="col"><?= $this->Paginator->sort('name') ?></th>
                                            <th scope="col"><?= $this->Paginator->sort('image') ?></th>
                                            <th scope="col"><?= $this->Paginator->sort('avg_rating') ?></th>
                                            <th scope="col" class="actions"><?= __('Actions') ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php  foreach($data['rating'] as $toprated){ ?>
                                            <tr>
                                                <td><?= $this->Number->format($toprated->id) ?></td>
                                                <td><?= $toprated->has('user') ? $this->Html->link($toprated->user->firstname, ['controller' => 'Users', 'action' => 'view', $toprated->user->id]) : '' ?></td>
                                                <td><?= h($toprated->name) ?></td>
                                                <td>
                                                    <img style="width:50px;" src="<?php echo "/supperout/".$toprated->image ?>">
                                            
                                                </td>
                                                
                                                
                                                    <td><?php
                                                        //$this->Number->format($restaurant->avg_rating)
                                                        for ($x = 1; $x <= $toprated->avg_rating; $x++) {
                                                            echo '<span class="fa fa-star"></span>';
                                                        }
                                                        if (strpos($toprated->avg_rating, '.')) {
                                                            echo '<span class="fa fa-star-half-empty"></span>';
                                                            $x++;
                                                        }
                                                        while ($x <= 5) {
                                                            echo '<span class="fa fa-star-o"></span>';
                                                            $x++;
                                                        }
                                                        ?></td>
                                                <td class="actions">
                                                    <?= $this->Html->link(__('View'), ['controller'=>'Restaurants', 'action' => 'view', $toprated->id]) ?>
                                                 </td>
                                            </tr>
                                        <?php }; ?>
                                    </tbody>
                                </table>
                            </div>
                        
                    </div>
                  </div>
                </div>
                 <div class="col-lg-6">
                    <div class="line-chart-example card">
                        <div class="card-header d-flex align-items-center">
                            <h3 class="h4">User Comments</h3>
                        </div>
                            <div class="commentsusers" id="commentsusers">
                                <?php foreach($data['comment'] as $usercomments){
                                    ?>
                                <div><img src="<?php echo "/supperout/".$usercomments->restaurant->image ?>" title="<?php echo "<b>".$usercomments->user->firstname." ".$usercomments->user->lastname.": </b>".$usercomments->comment; ?>" /></div>
                                <?
                                } ?>
<!--  <li><img src="/images/pic1.jpg" /></li>
  <li><img src="/images/pic2.jpg" /></li>
  <li><img src="/images/pic3.jpg" /></li>
  <li><img src="/images/pic4.jpg" /></li>-->
</div>
                       
                    </div>
                </div>
                   <div class="col-lg-6">
                    <div class="line-chart-example card">
                        <div class="card-header d-flex align-items-center">
                            <h3 class="h4">Recently Added Restaurants</h3>
                        </div>
                            <div class="latestrestaurant" id="latestrestaurant">
                                <?php foreach($data['latest_res'] as $restaurants){
                                    ?>
                                <div><img src="<?php echo "/supperout/".$restaurants->image ?>" title="<?php echo $restaurants->name; ?>" /></div>
                                <?
                                } ?>
<!--  <li><img src="/images/pic1.jpg" /></li>
  <li><img src="/images/pic2.jpg" /></li>
  <li><img src="/images/pic3.jpg" /></li>
  <li><img src="/images/pic4.jpg" /></li>-->
</div>
                       
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bxslider/4.2.15/jquery.bxslider.min.js"></script>
<?php
        echo $this->Html->script([
            'jquery.DonutWidget.min',
        ]);
        ?>
<script>
    $(document).ready(function(){
       DonutWidget.draw();
      var ctx1 = $("canvas").get(0).getContext("2d");
    var gradient1 = ctx1.createLinearGradient(150, 0, 150, 300);
    gradient1.addColorStop(0, 'rgba(133, 180, 242, 0.91)');
    gradient1.addColorStop(1, 'rgba(255, 119, 119, 0.94)');

   var monthes = new Array();
    <?php foreach ($data['months'] as $key => $val) { ?>
            monthes.push('<?php echo $val; ?>');
    <?php } ?>
        
       var commission =new Array();
   
    <?php foreach ($data['commission'] as $revkey => $commission) { ?>
            commission.push('<?php echo $commission; ?>');
    <?php } ?> 
         var BARCHARTEXMPLE    = $('#barChartExample');
    var barChartExample = new Chart(BARCHARTEXMPLE, {
        type: 'bar',
        options: {
            scales: {
                xAxes: [{
                    display: true,
                    gridLines: {
                        color: '#eee'
                    }
                }],
                yAxes: [{
                    display: true,
                    gridLines: {
                        color: '#eee'
                    }
                }]
            },
            legend: {
                display: false
            }
        },
        data: {
            labels: monthes,
            datasets: [
                {
                    label: "Commission",
                    backgroundColor: [
                        '#fd7e14',
                        '#fd7e14',
                        '#fd7e14',
                        '#fd7e14',
                        '#fd7e14',
                        '#fd7e14',
                        '#fd7e14',
                        '#fd7e14',
                        '#fd7e14',
                        '#fd7e14',
                        '#fd7e14',
                        '#fd7e14',
                        
                        
                    ],
                    hoverBackgroundColor: [
                        '#fd7e14',
                        '#fd7e14',
                        '#fd7e14',
                        '#fd7e14',
                        '#fd7e14',
                        '#fd7e14',
                        '#fd7e14',
                        '#fd7e14',
                        '#fd7e14',
                        '#fd7e14',
                        '#fd7e14',
                        '#fd7e14',
                       
                    ],
                    borderColor: [
                         '#fd7e14',
                        '#fd7e14',
                        '#fd7e14',
                        '#fd7e14',
                        '#fd7e14',
                        '#fd7e14',
                        '#fd7e14',
                        '#fd7e14',
                        '#fd7e14',
                        '#fd7e14',
                        '#fd7e14',
                        '#fd7e14',
                    ],
                    borderWidth: 1,
                    data: commission,
                }
            ]
        }
    });
    $('#commentsusers').bxSlider({
    mode: 'fade',
    captions: true,
    slideWidth: 300,
    auto: true,
  });
    $('#latestrestaurant').bxSlider({
    mode: 'fade',
    captions: true,
    slideWidth: 300,
    auto: true,
  });
  });
        
    </script>
    <style type="text/css">
        @media only screen and (min-width:1024px){
            .new-style{
                height:256px;
                overflow-y: scroll;
            }
        }
    </style>