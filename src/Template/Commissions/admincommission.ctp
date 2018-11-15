<div class="content-inner">
    <!-- Page Header-->
    <header class="page-header">
        <div class="container-fluid">
            <h2 class="no-margin-bottom">Commission</h2>
        </div>
    </header>
    <div class="breadcrumb-holder container-fluid">
        <ul class="breadcrumb">
            <li class="breadcrumb-item active">Commissions</li>
        </ul>
    </div>
    <section class="forms"> 
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header d-flex align-items-center">
                            <h3 class="h4">Filter</h3>
                        </div>
                        <div class="card-body">
 <?= $this->Form->create('', ['type' => 'file'], array('class' => 'form-horizontal')) ?>
                            <!--Blue select-->
                            <div class="form-group row">
                        <div class="col-sm-3">    
                            <?php
                           // echo "<pre>"; print_r($data); echo "</pre>";
                            $resoptions=[];
 foreach ($data['Restaurants'] as $restaurant){
     $resoptions[$restaurant->id]= $restaurant->name;
 }
                        echo $this->Form->select(
    'restaurant_id',
    $resoptions,
    ['empty' => '(Choose Restaurant)', 'class' => 'js-example-basic-single form-control form-control-success', 'label' => false]
);
           
            
                            ?>
                            
                        </div>  
                           
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
                                
<!--                                <label for="from">From</label>
<input type="text" id="from" name="from">
<label for="to">to</label>
<input type="text" id="to" name="to">
                                -->
                                
                                 
                                <div class="col-sm-3">
                                    <?= $this->Form->button(__('Submit'), array('class' => 'btn btn-primary')) ?>
                                </div>
                            </div>
                            
                            
                             <?= $this->Form->end() ?>
                        </div>
                    </div>
                    <?php if(isset($output)){
                       // echo "<pre>"; print_r($output); echo "</pre>";
                        
                        if($output['restaurant'] != ""){
                            ?>
                    <b> Restaurant Name:</b> <?php echo $output['restaurant']->name;
                                
                        }
                        ?> <br>
                        <b> Total commission: </b> <?php if(is_numeric($output['result'][0]->sum)){
                            echo $output['result'][0]->sum;
                            
                        }else{ 
                            echo "0";
                            } ?>
                        </br>
                                <?php
                            echo "<b>From: &nbsp</b>".$output['start']. "  <b> &nbsp &nbsp &nbsp To: &nbsp</b>".$output['end'];  ?>
                    
                    <?php        
                        
                        
                    } ?>
                    
                    
                </div>
            </div>
        </div>
    </section>
</div>
<script>
$(document).ready(function() {
    $('.js-example-basic-single').select2();
    
     $( function() {
    var dateFormat = "mm/dd/yy",
      from = $( "#from" )
        .datepicker({
          defaultDate: "+1w",
          changeMonth: true,
          numberOfMonths: 1,
          maxDate: "0",
        })
        .on( "change", function() {
          to.datepicker( "option", "minDate", getDate( this ) );
        }),
      to = $( "#to" ).datepicker({
        defaultDate: "+1w",
        changeMonth: true,
        numberOfMonths: 1,
        maxDate: "0",
      })
      .on( "change", function() {
        from.datepicker( "option", "maxDate", getDate( this ) );
      });
 $( "#from" ).keydown(function (event) {
    event.preventDefault();
});
 $( "#to" ).keydown(function (event) {
    event.preventDefault();
});
    function getDate( element ) {
      var date;
      try {
        date = $.datepicker.parseDate( dateFormat, element.value );
      } catch( error ) {
        date = null;
      }
 
      return date;
    }
  });
});

</script>