<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Restaurant $restaurant
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
            <li class="breadcrumb-item"><a href="<?php echo $this->request->getAttribute("webroot"); ?>"><?php echo $restaurants_label; ?></a></li>
            <li class="breadcrumb-item active"><?php echo $add; ?></li>
        </ul>
    </div>
    <!-- Forms Section-->
    <section class="forms"> 
        <div class="container-fluid">
            <div class="row">
                <!-- Horizontal Form-->
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header d-flex align-items-center">
                            <h3 class="h4"><?php echo $add_new; ?></h3>
                        </div>
                        <div class="card-body">
                            <?= $this->Form->create($restaurant, ['type' => 'file'], array('class' => 'form-horizontal')) ?>
                            <!--<form class="form-horizontal">-->
                            <div class="form-group row">
                                <label class="col-sm-3 form-control-label"><?php echo $name; ?></label>
                                <div class="col-sm-9">
                                    <?php echo $this->Form->control('name', ['class' => 'form-control form-control-success', 'label' => false]); ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 form-control-label"><?php echo $name; ?>(Portuguese)</label>
                                <div class="col-sm-9">
                                    <?php echo $this->Form->control('name_p', ['class' => 'form-control form-control-success', 'label' => false]); ?>
                                </div>
                            </div>


                            <div class="form-group row">
                                <label class="col-sm-3 form-control-label"><?php echo $user_label; ?></label>
                                <div class="col-sm-9">
                                    <?php echo $this->Form->control('user_id', ['options' => $users, 'class' => 'form-control form-control-success', 'label' => false]); ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 form-control-label"><?php echo $image; ?></label>
                                <div class="col-sm-9">
                                    <?php echo $this->Form->control('image', ['type' => 'file', 'class' => 'form-control form-control-success', 'label' => false]); ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 form-control-label"><?php echo $description; ?>(Portuguese)</label>
                                <div class="col-sm-9">
                                    <?php echo $this->Form->control('description_p', ['class' => 'form-control form-control-success', 'label' => false]); ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 form-control-label"><?php echo $description; ?></label>
                                <div class="col-sm-9">
                                    <?php echo $this->Form->control('description', ['class' => 'form-control form-control-success', 'label' => false]); ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 form-control-label"><?php echo $cuisine_label ?></label>
                                <div class="col-sm-9">
                                    <?php echo $this->Form->control('cuisine_id', ['options' => $cuisines, 'class' => 'form-control form-control-success', 'label' => false]); ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 form-control-label"><?php echo $address; ?></label>
                                <div class="col-sm-9">
                                    <?php echo $this->Form->control('address', ['class' => 'form-control form-control-success', 'label' => false]); ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 form-control-label"><?php echo $address; ?>(Portguese)</label>
                                <div class="col-sm-9">
                                    <?php echo $this->Form->control('address_p', ['class' => 'form-control form-control-success', 'label' => false]); ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 form-control-label"><?php echo $latitude; ?></label>
                                <div class="col-sm-9">
                                    <?php echo $this->Form->control('latitude', ['class' => 'form-control form-control-success', 'label' => false]); ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 form-control-label"><?php echo $longitude; ?></label>
                                <div class="col-sm-9">
                                    <?php echo $this->Form->control('longitude', ['class' => 'form-control form-control-success', 'label' => false]); ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 form-control-label"><?php echo $gratuity; ?>(%)</label>
                                <div class="col-sm-9">
                                    <?php 
                                    $options=[];
                                    for($i=1; $i<=100; $i++){
                                       array_push($options, $i);
                                    }
                                    
                                  //  echo $this->Form->control('gratuity', ['class' => 'form-control form-control-success', 'label' => false]);
                                    echo $this->Form->select(
    'gratuity',
    $options,
    ['empty' => '(choose one)', 'class' => 'form-control form-control-success', 'label' => false]
);
                                    
                                    ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 form-control-label"><?php echo $starting_price; ?>($)</label>
                                <div class="col-sm-9">
                                    <?php echo $this->Form->control('starting_price', ['class' => 'form-control form-control-success', 'label' => false]); ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 form-control-label"><?php echo $total_tables; ?></label>
                                <div class="col-sm-9">
                                    <?php echo $this->Form->control('total_tables', ['class' => 'form-control form-control-success', 'label' => false]); ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 form-control-label"><?php echo $order_prep_time;?>(<?php echo $min;?>)</label>
                                <div class="col-sm-9">
                                    <?php echo $this->Form->control('order_time', ['class' => 'form-control form-control-success', 'label' => false]); ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 form-control-label"><?php echo $tax; ?>(%)</label>
                                <div class="col-sm-9">
                                    <?php echo $this->Form->control('tax', ['class' => 'form-control form-control-success', 'label' => false]); ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 form-control-label"><?php echo $status; ?></label>
                                <div class="col-sm-9">
                                    <?php echo $this->Form->checkbox('status', ['class' => 'checkbox-template', 'label' => false]); ?>
                                </div> 
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 form-control-label"><?php echo $amenities_label; ?></label>
                                <div class="col-sm-9">
                                   <ul id="easySelectable">
                                       <?php foreach ($amenities as $key => $value) {
                                           ?>
                                       <label class="checkbox-inline">
                                             <input type="checkbox" name="amenities[]" value="<?php echo $key; ?>"/>  
                                             <li data-id="<?php echo $key; ?>"><?php echo $value; ?></li>
                    

                            <div class="form-group row">       
                                <div class="col-sm-9 offset-sm-3">
                                    <?= $this->Form->button(__($submit_button), array('class' => 'btn btn-primary')) ?>
                                </div>
                            </div>
                            <?= $this->Form->end() ?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="pac-card" id="pac-card">
                        <div>
                            <div id="title">
                                Autocomplete search
                            </div>
                        </div>
                        <div id="pac-container">
                            <input id="pac-input" type="text"
                                   placeholder="Enter a location">
                        </div>
                    </div>
                    <div id="map"></div>
                    <div id="infowindow-content">
                        <img src="" width="16" height="16" id="place-icon">
                        <span id="place-name"  class="title"></span><br>
                        <span id="place-address"></span>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Page Footer-->
    <?= $this->element('footer'); ?>
</div>
<style>
    /* Always set the map height explicitly to define the size of the div
     * element that contains the map. */
    #map {
        height: 100%;
    }
    /* Optional: Makes the sample page fill the window. */
    #description {
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
    }

    #infowindow-content .title {
        font-weight: bold;
    }

    #infowindow-content {
        display: none;
    }

    #map #infowindow-content {
        display: inline;
    }

    .pac-card {
        margin: 10px 10px 0 0;
        border-radius: 2px 0 0 2px;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        outline: none;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
        background-color: #fff;
        font-family: Roboto;
    }

    #pac-container {
        padding: 12px 0;
        margin-right: 12px;
    }

    .pac-controls {
        display: inline-block;
        padding: 5px 11px;
    }

    .pac-controls label {
        font-family: Roboto;
        font-size: 13px;
        font-weight: 300;
    }

    #pac-input {
        background-color: #fff;
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
        margin-left: 12px;
        padding: 0 11px 0 13px;
        text-overflow: ellipsis;
        width: 325px;
    }

    #pac-input:focus {
        border-color: #4d90fe;
    }

    #title {
        color: #fff;
        background-color: #4d90fe;
        font-size: 25px;
        font-weight: 500;
        padding: 6px 12px;
    }
</style>
<link rel="stylesheet" href="<?php echo $this->request->getAttribute('webroot'); ?>css/easySelectable.css"/>
<script src="<?php echo $this->request->getAttribute('webroot'); ?>js/easySelectable.js"></script>


<script>
    // This example requires the Places library. Include the libraries=places
    // parameter when you first load the API. For example:
    // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

    function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: -33.8688, lng: 151.2195},
            zoom: 13
        });
        var card = document.getElementById('pac-card');
        var input = document.getElementById('pac-input');

        map.controls[google.maps.ControlPosition.TOP_RIGHT].push(card);

        var autocomplete = new google.maps.places.Autocomplete(input);

        // Bind the map's bounds (viewport) property to the autocomplete object,
        // so that the autocomplete requests use the current map bounds for the
        // bounds option in the request.
        autocomplete.bindTo('bounds', map);

        // Set the data fields to return when the user selects a place.
        autocomplete.setFields(
                ['address_components', 'geometry', 'icon', 'name']);

        var infowindow = new google.maps.InfoWindow();
        var infowindowContent = document.getElementById('infowindow-content');
        infowindow.setContent(infowindowContent);
        var marker = new google.maps.Marker({
            map: map,
            anchorPoint: new google.maps.Point(0, -29)
        });

        autocomplete.addListener('place_changed', function () {
            infowindow.close();
            marker.setVisible(false);
            var place = autocomplete.getPlace();


            if (!place.geometry) {
                // User entered the name of a Place that was not suggested and
                // pressed the Enter key, or the Place Details request failed.
                window.alert("No details available for input: '" + place.name + "'");
                return;
            }

            // If the place has a geometry, then present it on a map.
            if (place.geometry.viewport) {
                map.fitBounds(place.geometry.viewport);
            } else {

                map.setCenter(place.geometry.location);
                map.setZoom(17);  // Why 17? Because it looks good.
            }
            marker.setPosition(place.geometry.location);
            marker.setVisible(true);

            var address = '';
            if (place.address_components) {
                address = [
                    (place.address_components[0] && place.address_components[0].short_name || ''),
                    (place.address_components[1] && place.address_components[1].short_name || ''),
                    (place.address_components[2] && place.address_components[2].short_name || '')
                ].join(' ');
                document.getElementById("latitude").value = place.geometry.location.lat();
                document.getElementById("longitude").value = place.geometry.location.lng();
                document.getElementById("address").value = address;

                displayMap(place.geometry.location.lat(),place.geometry.location.lng())
            }

            infowindowContent.children['place-icon'].src = place.icon;
            infowindowContent.children['place-name'].textContent = place.name;
            infowindowContent.children['place-address'].textContent = address;
            infowindow.open(map, marker);
        });
    }



       function displayMap(latitude,longitude){
        console.log('display mapaddress')
       // $('#RestaurantLatitude').val(latitude)
       // $('#RestaurantLongitude').val(longitude)
        var myCenter = new google.maps.LatLng(latitude,longitude);
        var mapCanvas = document.getElementById("map");
        var mapOptions = {center: myCenter, zoom: 15};
        var map = new google.maps.Map(mapCanvas, mapOptions);
        var marker = new google.maps.Marker({position:myCenter,draggable: true});
        marker.setMap(map);
        
        google.maps.event.addListener(marker, 'dragend', function(evt){
            $('#latitude').val(evt.latLng.lat())
            $('#longitude').val(evt.latLng.lng())
            GetAddress(evt.latLng.lat(),evt.latLng.lng());

        });
    }


     function GetAddress(lat,lng) {

        
            var latlng = new google.maps.LatLng(lat, lng);
            var geocoder = geocoder = new google.maps.Geocoder();
            geocoder.geocode({ 'latLng': latlng }, function (results, status) {

                if (status == google.maps.GeocoderStatus.OK) {
                    if (results[1]) {
                       // alert("Location: " + results[1].formatted_address);
                    jQuery("#address").val(results[1].formatted_address);
                    }
                }
            });
        }
        // Select Amenities Section
        $(function(){
          $('#easySelectable').easySelectable();
        })
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBQrWZPh0mrrL54_UKhBI2_y8cnegeex1o&libraries=places&callback=initMap"
async defer></script>