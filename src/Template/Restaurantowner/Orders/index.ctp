
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
            <h2 class="no-margin-bottom"><?php echo $orders_label; ?></h2>
        </div>
    </header> 
    <!-- Breadcrumb-->
    <div class="breadcrumb-holder container-fluid">
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo $this->request->getAttribute("webroot"); ?>"><?php echo $home; ?></a></li>
            <li class="breadcrumb-item active"><?php echo $orders_label; ?></li>
        </ul>
    </div>
    <section class="tables">   
        <div class="container-fluid">
            
            <!-- Filter starts here -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header d-flex align-items-center">
                            <h3 class="h4"><?php echo $filter; ?></h3>
                        </div>
                        <div class="card-body">
                            
                            <div class="form-group">
                                <?= $this->Form->create('', ['type' => 'file'], array('class' => 'form-horizontal')) ?>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class='input-group date' >
                                            <input type='text' class="form-control" name="startdate" id='from' placeholder="From Date" required />
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar"></span>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class='input-group date' >
                                            <input type='text' class="form-control" name="enddate" id='to' placeholder="To Date" required/>
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar"></span>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="col-sm-2">
                                        <?= $this->Form->button(__($submit_button), array('class' => 'btn btn-primary')) ?>
                                    </div>
                                    <div class="col-sm-2">
                                        <button id="resetform" type="button" class="btn btn-primary"><?php echo $reset_button; ?></button>
                                    </div>
                                    <div class="col-sm-2"></div>
                                </div>
                                    <?= $this->Form->end() ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header d-flex align-items-center">
                            <h3 class="h4"><?php echo $all." ".$orders_label; ?></h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">                       
                                <table id="example2" class="table table-bordered table-hover dataTable no-footer" role="grid" aria-describedby="example2_info">
                                    <thead>
                                        <tr>
                                            <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                                            <th scope="col"><?= $this->Paginator->sort('user_id',$user_label) ?></th>
                                            <th scope="col"><?= $this->Paginator->sort('restaurant_id',$restaurant_label) ?></th>
                                            <th scope="col"><?= $this->Paginator->sort('order_number',$order_label) ?></th>
                                            <th scope="col"><?= $this->Paginator->sort('table_id',$table_no) ?></th>
                                            <th scope="col"><?= $this->Paginator->sort('waiter_id',$waiter_label) ?></th>
                                            <th scope="col"><?= $this->Paginator->sort('totalamount',$total) ?></th>
                                            <th scope="col"><?= $this->Paginator->sort('payment_method',$payment_method) ?></th>
                                            <th scope="col"><?= $this->Paginator->sort('created',$created) ?></th>
                                            <th scope="col" class="actions"><?= __($actions) ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($orders as $order): ?>
                                            <tr>
                                                <td><?= $this->Number->format($order->id) ?></td>
                                                <td><?= $order->has('user') ? $this->Html->link($order->user->firstname, ['controller' => 'Users', 'action' => 'view', $order->user->id]) : '' ?></td>
                                                <td><?= $order->has('restaurant') ? $this->Html->link($order->restaurant->name, ['controller' => 'Restaurants', 'action' => 'view', $order->restaurant->id]) : '' ?></td>

                                                <td><?= h('#' . sprintf('%04d', $order->order_number)) ?></td>
                                                <td>
                                                    <?= h($order->table_id) ?>
                                                </td>
                                                <td><?= $order->has('waiter') ? $this->Html->link($order->waiter->name, ['controller' => 'Waiters', 'action' => 'view', $order->waiter->id]) : '' ?></td>
                                                <td><?= h($order->totalamount) ?></td>
                                                <td><?= h($order->payment_method) ?></td>
                                                <td><?= h($order->created) ?></td>
                                                <td class="actions">
                                                    <?= $this->Html->link(__($view), ['action' => 'view', $order->id]) ?>
                                                    <?php //$this->Html->link(__('Edit'), ['action' => 'edit', $order->id]) ?>
                                                    <?= $this->Html->link(__($change_waiter), ['action' => 'assign', $order->id, $order->restaurant->id]) ?>

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

<script>
    $(document).ready(function () {
        $(function () {
            var dateFormat = "mm/dd/yy",
                    from = $("#from")
                    .datepicker({
                        defaultDate: "+1w",
                        changeMonth: true,
                        numberOfMonths: 1,
                        maxDate: "0",
                    })
                    .on("change", function () {
                        to.datepicker("option", "minDate", getDate(this));
                    }),
                    to = $("#to").datepicker({
                defaultDate: "+1w",
                changeMonth: true,
                numberOfMonths: 1,
                maxDate: "0",
            })
                    .on("change", function () {
                        from.datepicker("option", "maxDate", getDate(this));
                    });
            $("#from").keydown(function (event) {
                event.preventDefault();
            });
            $("#to").keydown(function (event) {
                event.preventDefault();
            });
            function getDate(element) {
                var date;
                try {
                    date = $.datepicker.parseDate(dateFormat, element.value);
                } catch (error) {
                    date = null;
                }

                return date;
            }
        });

        $('#resetform').click(function () {
           window.location.href = window.location.pathname;
        });

    });

</script>