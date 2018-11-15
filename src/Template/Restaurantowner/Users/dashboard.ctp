<?php
echo $this->Html->css([
    'jquery.DonutWidget.min',
]);
?>
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
                    <div class="form-group row1">
                        <?= $this->Form->create('', ['type' => 'file'], array('class' => 'form-horizontal')) ?>
                        <div class="row">
                            <div class="col-sm-3">
                                <?php
                                // echo "<pre>"; print_r($data); echo "</pre>";
                                $resoptions = [];
                                foreach ($data['restaurants'] as $ids => $restaurant) {
                                    $resoptions[$ids] = $restaurant;
                                }
                                echo $this->Form->select(
                                        'restaurant_id', $resoptions, ['class' => 'js-example-basic-single form-control form-control-success', 'label' => false]
                                );
                                ?>
                            </div>
                            <div class="col-sm-3">
                                <?= $this->Form->button(__('Submit'), array('class' => 'btn btn-primary')) ?>
                            </div>

                        </div>
                        <?= $this->Form->end() ?>
                    </div>


                    <div class="line-chart-example card">
                        <div class="card-header d-flex align-items-center">
                            <h3 class="h4">Current Week Sale</h3>
                        </div>
                        <div class="card-body">
                            <?php
                            foreach ($data['weekdata'] as $index => $weekdata) {
                                ?>
                                <div class="widget-wrap" style="display:inline-block; margin-bottom: 30px; text-align: center;">
                                    <div class="donut-widget" data-chart-size="normal" data-chart-max="100" data-chart-value="<?php echo $weekdata['percentage']; ?>" data-chart-text="<?php echo (int) $weekdata['percentage']; ?>%" data-chart-primary="#fd7e14" data-chart-background="#D3D3D3"></div>
                                    <?php echo date("l", strtotime($weekdata['day'])); ?> 
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                    </div>



                </div>
            </div>

<!--            <div class="row">
                <div class="col-md-12">
                    <div class="line-chart-example card">
                        <div class="card-header d-flex align-items-center">
                            <h3 class="h4"></h3>
                        </div>
                        <div class="card-body">
                            <div class="widget-wrap col-md-3" style="display:inline-block; margin-bottom: 30px; text-align: center;">
                                <div class="statistic align-items-center bg-white has-shadow">
                                    <div class="icon bg-red"><i class="fa fa-table"></i></div>
                                    <div class="text"><strong><?php echo $data['tables'][0]->count ?></strong><br><small>Tables</small></div>
                                </div>
                            </div>
                            <div class="widget-wrap col-md-3" style="display:inline-block; margin-bottom: 30px; text-align: center;">
                                <div class="statistic align-items-center bg-white has-shadow">
                                    <div class="icon bg-red"><i class="fa fa-group"></i></div>
                                    <div class="text"><strong><?php echo $data['waiters'][0]->count ?></strong><br><small>Waiters</small></div>
                                </div>
                            </div>
                            <div class="widget-wrap col-md-3" style="display:inline-block; margin-bottom: 30px; text-align: center;">
                                <div class="statistic align-items-center bg-white has-shadow">
                                    <div class="icon bg-red"><i class="fa fa-bars"></i></div>
                                    <div class="text"><strong><?php echo $data['menu'][0]->count ?></strong><br><small>Menue</small></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>-->
            <div class="row">
                <section class="dashboard-counts">
                    <div class="container-fluid">
                        <div class="row bg-white has-shadow">
                            <!-- Item -->
                            <div class="col-xl-4 col-sm-8">
                                <div class="item d-flex align-items-center">
                                    <div class="icon bg-violet"><i class="icon-user"></i></div>
                                    <div class="title"><span>Tables</span>
                                    </div>
                                    <div class="number"><strong><?php echo $data['tables'][0]->count ?></strong></div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-sm-8">
                                <div class="item d-flex align-items-center">
                                    <div class="icon bg-green"><i class="icon-bill"></i></div>
                                    <div class="title"><span>Waiters</span>
                                    </div>
                                    <div class="number"><strong><?php echo $data['waiters'][0]->count ?></strong></div>
                                </div>
                            </div>
                            <!-- Item -->
                            <div class="col-xl-4 col-sm-8">
                                <div class="item d-flex align-items-center">
                                    <div class="icon bg-orange"><i class="icon-check"></i></div>
                                    <div class="title"><span>Menu</span>
                                    </div>
                                    <div class="number"><strong><?php echo $data['menu'][0]->count ?></strong></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>

            <div class="row"> 
                <!-- Line Charts-->
                <div class="col-lg-6">
                    <div class="line-chart-example card">
                        <div class="card-header d-flex align-items-center">
                            <h3 class="h4">Orders</h3>
                        </div>
                        <div class="card-body">
                            <canvas id="lineChartExample"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="bar-chart-example card">
                        <div class="card-header d-flex align-items-center">
                            <h3 class="h4">Revenue</h3>
                        </div>
                        <div class="card-body">
                            <canvas id="barChartExample"></canvas>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </section>
</div>

<?php
echo $this->Html->script([
    'jquery.DonutWidget.min',
]);
?>
<script>
    // ------------------------------------------------------- //
    // Charts Gradients
    // ------------------------------------------------------ //
    var ctx1 = $("canvas").get(0).getContext("2d");
    var gradient1 = ctx1.createLinearGradient(150, 0, 150, 300);
    gradient1.addColorStop(0, 'rgba(133, 180, 242, 0.91)');
    gradient1.addColorStop(1, 'rgba(255, 119, 119, 0.94)');

    var monthes = new Array();
<?php foreach ($data['months'] as $key => $val) { ?>
        monthes.push('<?php echo $val; ?>');
<?php } ?>
    var order_lg_data = new Array();

<?php foreach ($data['order_lg'] as $datakey => $dataval) { ?>
        order_lg_data.push('<?php echo $dataval; ?>');
<?php } ?>

    var revenue_lg_data = new Array();

<?php foreach ($data['revenue_lg'] as $revkey => $revval) { ?>
        revenue_lg_data.push('<?php echo $revval; ?>');
<?php } ?>


    var LINECHARTEXMPLE = $('#lineChartExample');
    var lineChartExample = new Chart(LINECHARTEXMPLE, {
        type: 'line',
        options: {
            legend: {labels: {fontColor: "#777", fontSize: 12}},
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
        },
        data: {
            labels: monthes,
            datasets: [
                {
                    label: "Orders",
                    fill: true,
                    lineTension: 0.3,
                    backgroundColor: gradient1,
                    borderColor: gradient1,
                    borderCapStyle: 'butt',
                    borderDash: [],
                    borderDashOffset: 0.0,
                    borderJoinStyle: 'miter',
                    borderWidth: 1,
                    pointBorderColor: gradient1,
                    pointBackgroundColor: "#fff",
                    pointBorderWidth: 1,
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: gradient1,
                    pointHoverBorderColor: "rgba(220,220,220,1)",
                    pointHoverBorderWidth: 2,
                    pointRadius: 1,
                    pointHitRadius: 10,
                    data: order_lg_data,
                    spanGaps: false
                }
            ]
        }
    });

    // ------------------------------------------------------- //
    // Bar Chart
    // ------------------------------------------------------ //
    var BARCHARTEXMPLE = $('#barChartExample');
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
        },
        data: {
            labels: monthes,
            datasets: [
                {
                    label: "Revenue",
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
                    data: revenue_lg_data,
                }
            ]
        }
    });
    // ------------------------------------------------------- //
    // Doughnut Chart
    // ------------------------------------------------------ //
    DonutWidget.draw();

</script>