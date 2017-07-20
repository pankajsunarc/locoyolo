<?php
//echo'hi m dash board';exit;
include_once (TEMPPATH."/header.php");

?>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDHXsI2hOfs6x7NJLR8LnN5wG-2N-ha0S8&libraries=places&callback=initMap" async defer></script>
<script>


function initMap() {

var input = document.getElementById('pac-input');
var autocomplete = new google.maps.places.Autocomplete(input);

var input_mobile = document.getElementById('pac-input_mobile');
var autocomplete_mobile = new google.maps.places.Autocomplete(input_mobile);

var mapOptions = {
    zoom: 13,
    center: new google.maps.LatLng(1.352083, 103.819836),
    mapTypeId: google.maps.MapTypeId.ROADMAP,
	disableDefaultUI: true,
	scrollwheel: false,
  }
 
  var map = new google.maps.Map(document.getElementById("map-canvas"), mapOptions);

var searchbutton  = document.getElementById("searchbtnstart");
searchbutton.addEventListener('click', function() {
		 if (autocomplete.getPlace()){
		  var place = autocomplete.getPlace();
		  }else{
			  alert("Please enter a valid location.");
		  }
          // If the place has a geometry, then present it on a map_mobile.
          if (place.geometry.viewport) {
            map.fitBounds(place.geometry.viewport);
			map.setZoom(17);
          } else {
            map.setCenter(place.geometry.location);
            map.setZoom(17);  // Why 17? Because it looks good.
          }
          //marker.setPosition(place.geometry.location);
          //marker.setVisible(true);
			
          var address = '';
          if (place.address_components) {
            address = [
              (place.address_components[0] && place.address_components[0].short_name || ''),
              (place.address_components[1] && place.address_components[1].short_name || ''),
              (place.address_components[2] && place.address_components[2].short_name || '')
            ].join(' ');
          }
		  
		  // NorthEast Latitude : 89.45016124669523
		 var latNEValue =  map.getBounds().getNorthEast().lat();
		// NorthEast Longitude : 180
		 var longNEValue = map.getBounds().getNorthEast().lng();
		 // SouthWest Latitude : -87.71179927260242
		 var latSWValue =  map.getBounds().getSouthWest().lat();
		 // Southwest Latitude :  -180
		 var longSWValue = map.getBounds().getSouthWest().lng();
		 
		 document.getElementById('maplatNEValue').value = latNEValue;
		 document.getElementById('maplongNEValue').value = longNEValue;
		 document.getElementById('maplatSWValue').value = latSWValue;
		 document.getElementById('maplongSWValue').value = longSWValue;		 
		 var firststarttime = document.getElementById("event_start_time").value;
		var firstendtime = document.getElementById("event_end_time").value;
setTimeout(function(){
    $('#searchfrm').submit();
},500); });}
</script>
<style>
#map-canvas {
  height: 100%;
  position: absolute; 
  top: 0; 
  bottom: -200px; 
  left: 0; 
  right: 0; 
  z-index: -1;
}
#container {
  margin: 0 auto;
  background:white;
  border-radius:3px;
  width:680px;
  padding:20px;
  	/*border: solid 1px #E1E1E1; */
	box-shadow: 0 0 2px rgba(0,0,0,0.2); 
	-moz-box-shadow: 0 0 2px rgba(0,0,0,0.2); 
	-webkit-box-shadow: 0 0 2px rgba(0,0,0,0.2); 
	-o-box-shadow: 0 0 2px rgba(0,0,0,0.2);
}
}
@media screen and (max-width:680px) {
	.display860{
		display:none;
	}
	.display320{
		display:block;
	}
}

@media screen and (min-width:680px) {
	.display860{
		display:block;
	}
	.display320{
		display:none;
	}
}
.col-sm-7.searchsec {
    background: #fff none repeat scroll 0 0;
    float: none;
    margin: auto;
    top: 100px;
    overflow: hidden;
    padding: 7px;
}
</style>


<div class='container event_search_start'>
	<div class='row'>
		<div id='map-canvas'></div>
		<div class='col-sm-7 searchsec'>	
		

<h1 class="ArialVeryDarkGrey30">Search for events on<span class="ArialVeryDarkGrey30"><img src="images/locoyolo_word(30).jpg" width="148" height="39" /></span></h1>
<p class='ArialVeryDarkGrey18' >Whether you're at home or at work, there is always something to do near you!</p>

<div class="col-sm-12 tableorangeborder searchwrp">
  <h3 class="ArialOrange18">Find events</h3>
	<form method="post" action="<?php echo CreateURL('index.php');?>" id='searchfrm'>
<div id="searcheventserror"></div>
          <input placeholder="Where?" name="pac-input" type="text" class="textboxbottomborder" id="pac-input" style="width:100%" />
  
    &nbsp;&nbsp;&nbsp;Date:
      <select 
          name="event_day" class="textboxbottomborder" id="event_day">
        <? $i = 1;
		  while ($i < 32){ ?>
        <option <? if (date('j') == $i){ ?> selected="selected" <? } ?> value="<?=sprintf("%02d", $i) ?>">
          <?=$i ?>
        </option>
        <? $i++; } ?>
      </select>
      &nbsp;
      <select 
          name="event_month" class="textboxbottomborder" id="event_month">
        <? $i = 1;
		  while ($i < 13){ ?>
        <option <? if (date('n') == $i){ ?> selected="selected" <? } ?> value="<?=sprintf("%02d", $i) ?>">
          <? $monthName = date("F", mktime(0, 0, 0, $i, 10));
 			echo $monthName; // Output: May
		?>
        </option>
        <? $i++; } ?>
      </select>
      &nbsp;
      <select 
         name="event_year" class="textboxbottomborder" id="event_year">
        <option <? if (date('Y') == "2017"){ ?> selected="selected" <? } ?> value="2017">2017</option>
        <option <? if (date('Y') == "2018"){ ?> selected="selected" <? } ?> value="2018">2018</option>
      </select>
    Time range:
      <select 
          name="event_start_time" class="textboxbottomborder" id="event_start_time">
        <option value="00:00:00" selected="selected">00:00 AM</option>
        <? $starttime = "00:15:00";
		$a = 1;
		$increment = 0;
		while ($a<96){
			$starttime = date("H:i",strtotime('+'.$increment.' minutes',$starttime));
			$starttime = date("H:i:s", strtotime($starttime));
			?>
        <option <? if ($result['start_time'] == $starttime){ ?> selected="selected" <? } ?> value="<?=$starttime ?>"><?=date("h:i A", strtotime($starttime)) ?></option>
        <? 
		$increment = $a * 15;
		$starttime = date("H:i A",strtotime('+'.$increment.' minutes',$starttime));
		$a++; 
		} ?>
      </select>
      &nbsp;to&nbsp;
      <select 
          name="event_end_time" class="textboxbottomborder" id="event_end_time">
        <? $starttime = "00:00:00";
		$a = 1;
		$increment = 0;
		while ($a<96){
			$starttime = date("H:i",strtotime('+'.$increment.' minutes',$starttime));
			$starttime = date("H:i:s", strtotime($starttime));
			?>
        <option <? if ($result['start_time'] == $starttime){ ?> selected="selected" <? } ?> value="<?=$starttime ?>"><?=date("h:i A", strtotime($starttime)) ?></option>
        <? 
		$increment = $a * 15;
		$starttime = date("H:i A",strtotime('+'.$increment.' minutes',$starttime));
		$a++; 
		} ?>
        <option value="23:45:00" selected="selected">11:45 PM</option>
      </select>
      <input type="hidden" id="firststarttime" value="<?=date("H:i:s") ?>" />
      <input type="hidden" id="firstendtime" value="<?=date('H:i:s', strtotime('+2 hour', strtotime(date("H:i:s")))) ?>" />
      <input type="hidden" id="maplatNEValue"  name="maplatNEValue"  />
      <input type="hidden" id="maplongNEValue" name="maplongNEValue" />
      <input type="hidden" id="maplatSWValue" name="maplatSWValue" />
      <input type="hidden" id="maplongSWValue" name="maplongSWValue" />
		<input class="standardbutton" style="cursor:pointer" type="submit" id="searchbtnstart" name="searchbtnstart" value="Search" />
       
  
</form></div>

		</div>
	</div>
</div>

<!----------------------------------------------------------------------------------->
