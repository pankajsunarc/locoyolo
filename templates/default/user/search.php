<?php include_once (TEMPPATH."/header.php");
$locationstart = $_POST['pac-input'];
?>
<script>
function show_search_box() {
	document.getElementById("searchtable").style.display = "block";
	document.getElementById("eventlist_details").style.display = "none";
}
// JavaScript Document
//INITIALISING VARIABLES...
var firsttime = "yes";
var gmarkers = [];
var map;
var eventmarker;
var activate_marker_id = 20;
		
//CLEARING MARKERS ARRAY
function removeMarkers(){
    for(i=0; i<gmarkers.length; i++){
        gmarkers[i].setMap(null);
    	}
		gmarkers = [];		
	}
                               
function initMap() {
        // Create the map.
		 var lat = document.getElementById('maplatNEValue');
		  var lng = document.getElementById('maplongNEValue');
         
        map = new google.maps.Map(document.getElementById('map'), {
          zoom: 17,
		  center: {lat:parseFloat(document.getElementById('maplatNEValue').value), lng:parseFloat(document.getElementById('maplongNEValue').value)},
		  disableDefaultUI: true,
		  scrollwheel: false,
        });
		
		//DECLARE ALL ESSENTIAL VARIABLES FOR INITMAP()
		var input = document.getElementById('pac-input');
		var searchbutton = document.getElementById("searchbtn");
        var autocomplete = new google.maps.places.Autocomplete(input);
		var firststarttime = document.getElementById("firststarttime").value;
		var firstendtime = document.getElementById("firstendtime").value;
		var rightoveralldiv = document.getElementById("rightoverall");
		var latNEValue;
		var longNEValue;
		var latSWValue;
		var longSWValue;

		//NOT REALLY NEEDED. FIGURE OUT LATER...
        var marker = new google.maps.Marker({
          map: map,
          anchorPoint: new google.maps.Point(1.2644602, 103.8208577)
        });
		
		var geocoder = new google.maps.Geocoder();
		//SET NEW MAP CENTRE
		var address = "<?=$locationstart ?>";
        geocoder.geocode({'address': address}, function(results, status) {
          if (status === 'OK') {
            map.setCenter(results[0].geometry.location);
          } else {
            alert('Geocode was not successful for the following reason: ' + status);
          }
        });
		
			
		//GET BOUNDS OF MAP. EVENT BASED CODE, WHICH WORKS WHEN BOUNDS ARE CHANGED DURING INITIALISATION...
	google.maps.event.addListener(map, 'idle', function() {
			
			//PAGE NUMBER FOR RESULTS, START WITH FIRST PAGE
			currentpagenumber = 1;
			
			
			
			//GET EVENT DATE FROM VALUES OF DROPDOWNS
		var eventdate = document.getElementById("event_year").value+"-"+document.getElementById("event_month").value+"-"+document.getElementById("event_day").value;
			
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
			 
			 //TAKE DATES FROM INITIAL TIME DROPDOWNS
		 	var firststarttime = document.getElementById("event_start_time").value;
			var firstendtime = document.getElementById("event_end_time").value;
			
			//alert(firstendtime);
			//alert(eventdate);
			//POST BY AJAX TO PUT EVENT ICONS ON MAP
			
			$.ajax({
			type: "POST",
			url: "<?php echo CreateURL('index.php','mod=ajax&do=events_on_map'); ?>",
			data: { SWlat: latSWValue, SWlng: longSWValue, NElat: latNEValue, NElng: longNEValue, starttime: firststarttime, endtime: firstendtime, event_date: eventdate, currentpage: currentpagenumber },
			dataType: 'json',
			cache: false,
			success: function(data)
			{
			 	 $.each(data, function(index, element) {
				eventmarker = new google.maps.Marker({
				  position: { lat: parseFloat(element.eventlat), lng: parseFloat(element.eventlng )},
				  icon: element.eventicon,
				  map: map
			  		}); 
					
					gmarkers.push(eventmarker);
		   		});
			}
			});
			
			for (var i = 0; i < gmarkers.length; i++) {
          		gmarkers[i].setMap(map);
        	}
			
			//POST BY AJAX TO DISPLAY EVENTS IN MAP LIST
			$.ajax({
			type: "POST",
			url: "<?php echo CreateURL('index.php','mod=ajax&do=eventslistupdate'); ?>",
			data: { SWlat: latSWValue, SWlng: longSWValue, NElat: latNEValue, NElng: longNEValue, starttime: firststarttime, endtime: firstendtime, event_date: eventdate, currentpage: currentpagenumber },
			//dataType: 'json',
			cache: false,
			success: function(data)
			{
			 	 if(data == 'OK') {
    				result = data;
    			} else {
    				result = data;
    			}
    			$('#eventlistdisplay').html(result);
			}
			});
		});


//======================UPDATE MAP DISPLAY EVENTS WITH DRAG===============//		
google.maps.event.addListener(map, 'dragend', function() { 
	
		if (gmarkers.length !== 0){
		removeMarkers();
		}
	
		currentpagenumber = 1;
		
		marker.setVisible(false);
		var eventdate = document.getElementById("event_year").value+"-"+document.getElementById("event_month").value+"-"+document.getElementById("event_day").value;
		//Get coordinates of map extreme bounds
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
		 
		 //Get start and end time. If not submitted, get start and end times specified by hidden text boxes.
		 
		var firststarttime = document.getElementById("event_start_time").value;
		var firstendtime = document.getElementById("event_end_time").value;
		
		$('#eventlistdisplay').css("opacity",0.5);
		//$('#map').css("opacity",0.5);
			
			//Post by ajax to display events on map
			$.ajax({
			type: "POST",
			url: "<?php echo CreateURL('index.php','mod=ajax&do=events_on_map'); ?>",
			data: { SWlat: latSWValue, SWlng: longSWValue, NElat: latNEValue, NElng: longNEValue, starttime: firststarttime, endtime: firstendtime, event_date: eventdate, currentpage: currentpagenumber },
			dataType: 'json',
			cache: false,
			success: function(data)
			{
			 	 $.each(data, function(index, element) {
				eventmarker = new google.maps.Marker({
				  position: { lat: parseFloat(element.eventlat), lng: parseFloat(element.eventlng )},
				  icon: element.eventicon,
				  map: map
			  		}); 
					
					gmarkers.push(eventmarker);
		   		});
			}
			});
			
			for (var i = 0; i < gmarkers.length; i++) {
          		gmarkers[i].setMap(map);
        	}
			
			//Post by ajax to display events on map
			$.ajax({
			type: "POST",
			url: "<?php echo CreateURL('index.php','mod=ajax&do=eventslistupdate'); ?>",
			data: { SWlat: latSWValue, SWlng: longSWValue, NElat: latNEValue, NElng: longNEValue, starttime: firststarttime, endtime: firstendtime, event_date: eventdate, currentpage: currentpagenumber },
			//dataType: 'json',
			cache: false,
			success: function(data)
			{
			 	 if(data == 'OK') {
    				result = data;
    			} else {
    				result = data;
    			}
    			$('#eventlistdisplay').html(result);
				$('#eventlistdisplay').css("opacity",1);
				//$('#map').css("opacity",1);
			}
			});
			
			
		 });
		 
   
				
//======================CHECK WHEN SEARCH BUTTON IS CLICKED===============//		
searchbutton.addEventListener('click', function() {
		
		firsttime = "no";
		
		currentpagenumber = 1;
		
		if (gmarkers.length !== 0){
		removeMarkers();
		}
          //infowindow.close();
          marker.setVisible(false);
		  var eventdate = document.getElementById("event_year").value+"-"+document.getElementById("event_month").value+"-"+document.getElementById("event_day").value;
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
		  
          var address = '';
		  if(place.address_components) {
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
		
		$('#eventlistdisplay').css("opacity",0.5);
		//$('#map').css("opacity",0.5);
		 
		 $.ajax({
			type: "POST",
			url: "<?php echo CreateURL('index.php','mod=ajax&do=events_on_map'); ?>",
			data: { SWlat: latSWValue, SWlng: longSWValue, NElat: latNEValue, NElng: longNEValue, starttime: firststarttime, endtime: firstendtime, event_date: eventdate, currentpage: currentpagenumber },
			dataType: 'json',
			cache: false,
			success: function(data)
			{
			 	 $.each(data, function(index, element) {
					eventmarker = new google.maps.Marker({
				  position: { lat: parseFloat(element.eventlat), lng: parseFloat(element.eventlng )},
				  icon: element.eventicon,
				  map: map
			  		}); 
					
					gmarkers.push(eventmarker);
					
					//firsttime = element.firsttimepost;
					
		   		});
			}
			});
			
			//Post by ajax to display events on map
			$.ajax({
			type: "POST",
			url: "<?php echo CreateURL('index.php','mod=ajax&do=eventslistupdate'); ?>",
			data: { SWlat: latSWValue, SWlng: longSWValue, NElat: latNEValue, NElng: longNEValue, starttime: firststarttime, endtime: firstendtime, event_date: eventdate, currentpage: currentpagenumber },
			//dataType: 'json',
			cache: false,
			success: function(data)
			{
			 	 if(data == 'OK') {
    				result = data;
    			} else {
    				result = data;
    			}
    			$('#eventlistdisplay').html(result);
				$('#eventlistdisplay').css("opacity",1);
				//$('#map').css("opacity",1);
			}
			});
		  
        });
		

//======================UPDATE MAP DISPLAY EVENTS WITH DRAG===============//		
google.maps.event.addListener(map, 'dragend', function() { 
	
		if (gmarkers.length !== 0){
		removeMarkers();
		}
	
		currentpagenumber = 1;
		
		marker.setVisible(false);
		var eventdate = document.getElementById("event_year").value+"-"+document.getElementById("event_month").value+"-"+document.getElementById("event_day").value;
		//Get coordinates of map extreme bounds
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
		 
		 //Get start and end time. If not submitted, get start and end times specified by hidden text boxes.
		 
		var firststarttime = document.getElementById("event_start_time").value;
		var firstendtime = document.getElementById("event_end_time").value;
		
		$('#eventlistdisplay').css("opacity",0.5);
		//$('#map').css("opacity",0.5);
			
			//Post by ajax to display events on map
			$.ajax({
			type: "POST",
			url: "<?php echo CreateURL('index.php','mod=ajax&do=events_on_map'); ?>",
			data: { SWlat: latSWValue, SWlng: longSWValue, NElat: latNEValue, NElng: longNEValue, starttime: firststarttime, endtime: firstendtime, event_date: eventdate, currentpage: currentpagenumber },
			dataType: 'json',
			cache: false,
			success: function(data)
			{
			 	 $.each(data, function(index, element) {
				eventmarker = new google.maps.Marker({
				  position: { lat: parseFloat(element.eventlat), lng: parseFloat(element.eventlng )},
				  icon: element.eventicon,
				  map: map
			  		}); 
					
					gmarkers.push(eventmarker);
		   		});
			}
			});
			
			for (var i = 0; i < gmarkers.length; i++) {
          		gmarkers[i].setMap(map);
        	}
			
			//Post by ajax to display events on map
			$.ajax({
			type: "POST",
			url: "<?php echo CreateURL('index.php','mod=ajax&do=eventslistupdate'); ?>",
			data: { SWlat: latSWValue, SWlng: longSWValue, NElat: latNEValue, NElng: longNEValue, starttime: firststarttime, endtime: firstendtime, event_date: eventdate, currentpage: currentpagenumber },
			//dataType: 'json',
			cache: false,
			success: function(data)
			{
			 	 if(data == 'OK') {
    				result = data;
    			} else {
    				result = data;
    			}
    			$('#eventlistdisplay').html(result);
				$('#eventlistdisplay').css("opacity",1);
				//$('#map').css("opacity",1);
			}
			});
		 });}


//=====================SHOW MORE EVENTS WITH PAGINATION=====================//
function show_more_events(currentpagenumber) { 

		if (gmarkers.length !== 0){
		removeMarkers();
		}
		
		var eventdate = document.getElementById("event_year").value+"-"+document.getElementById("event_month").value+"-"+document.getElementById("event_day").value;
		//Get coordinates of map extreme bounds
		// NorthEast Latitude : 89.45016124669523
		 var latNEValue =  document.getElementById('maplatNEValue').value;
		// NorthEast Longitude : 180
		 var longNEValue = document.getElementById('maplongNEValue').value;
		 // SouthWest Latitude : -87.71179927260242
		 var latSWValue =  document.getElementById('maplatSWValue').value;
		 // Southwest Latitude :  -180
		 var longSWValue = document.getElementById('maplongSWValue').value;

			var firststarttime = document.getElementById("event_start_time").value;
		var firstendtime = document.getElementById("event_end_time").value;
			
			//Post by ajax to display events on map
			$.ajax({
			type: "POST",
			url: "<?php echo CreateURL('index.php','mod=ajax&do=events_on_map'); ?>",
			data: { SWlat: latSWValue, SWlng: longSWValue, NElat: latNEValue, NElng: longNEValue, starttime: firststarttime, endtime: firstendtime, event_date: eventdate, currentpage: currentpagenumber },
			dataType: 'json',
			cache: false,
			success: function(data)
			{ alert();
			 	 $.each(data, function(index, element) {
					eventmarker = new google.maps.Marker({
				  position: { lat: parseFloat(element.eventlat), lng: parseFloat(element.eventlng )},
				  icon: element.eventicon,
				  map: map
			  		}); 
					
					gmarkers.push(eventmarker);
		   		});
			}
			});	
			
			for (var i = 0; i < gmarkers.length; i++) {
          		gmarkers[i].setMap(map);
        	}
			
			
			//Post by ajax to display events on map
			$.ajax({
			type: "POST",
			url: "<?php echo CreateURL('index.php','mod=ajax&do=eventslistupdate'); ?>",
			data: { SWlat: latSWValue, SWlng: longSWValue, NElat: latNEValue, NElng: longNEValue, starttime: firststarttime, endtime: firstendtime, event_date: eventdate, currentpage: currentpagenumber },
			//dataType: 'json',
			cache: false,
			success: function(data)
			{
			 	 if(data == 'OK') {
    				result = data;
    			} else {
    				result = data;
    			}
    			$('#eventlistdisplay').html(result);
			}
			});
		 }		
		 
		
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDHXsI2hOfs6x7NJLR8LnN5wG-2N-ha0S8&libraries=places&callback=initMap" async defer></script>
    <style>
.right {
    width: 700px;
    float: right;
}

.left {
    float: none; /* not needed, just for clarification */
    background: #e8f6fe;
    /* the next props are meant to keep this block independent from the other floated one */
    width: auto;
	height:100%;
    overflow: hidden;
}
</style>
</head>

<body style="overflow:auto">
<div class="display860" style="height:100%;">
    <div class="right" style="background:#F2F2F2; height:100%; overflow:auto">
  
  <div class='col-sm-12 right-contaner'>
    <div class='1'>
      <p class="ArialOrange18">Find events
      </p>
      <div class='2'>
       <div id="searcheventserror"></div><input placeholder="Where?" name="pac-input" type="text" class="textboxbottomborder" id="pac-input" style="width:100%" value="<?php echo $_POST['pac-input'];?>" />
      </div>
      <div class="ArialVeryDarkGrey15">
        <label>&nbsp;&nbsp;&nbsp;Date:</label>
          <select 
          name="event_day" class="textboxbottomborder" id="event_day">
            <? $i = 1;
		  while ($i < 32){ ?>
        <option <? if ($_POST['event_day'] == $i){ ?> selected="selected" <? } ?> value="<?=sprintf("%02d", $i) ?>"><?=$i ?></option>
        <? $i++; } ?>
          </select>
          &nbsp;
          <select 
          name="event_month" class="textboxbottomborder" id="event_month">
            <? $i = 1;
		  while ($i < 13){ ?>
        <option <? if ($_POST['event_month'] == $i){ ?> selected="selected" <? } ?> value="<?=sprintf("%02d", $i) ?>">
		<? $monthName = date("F", mktime(0, 0, 0, $i, 10));
 			echo $monthName; // Output: May
		?>
        </option>
        <? $i++; } ?>
          </select>
          &nbsp;
<select name="event_year" class="textboxbottomborder" id="event_year">
<option <? if($_POST['event_year'] == "2017"){ ?> selected="selected" <? } ?> value="2017">2017</option>
<option <? if($_POST['event_year'] == "2018"){ ?> selected="selected" <? } ?> value="2018">2018</option>
</select>
<label>Time range:</label>
<select name="event_start_time" class="textboxbottomborder" id="event_start_time">
            <? $starttime = "00:00:00";
		$a = 1;
		$increment = 0;
		while ($a<97){
			$starttime = date("H:i",strtotime('+'.$increment.' minutes',$starttime));
			$starttime = date("H:i:s", strtotime($starttime));
			?>
        <option <? if ($_POST['event_start_time'] == $starttime){ ?> selected="selected" <? } ?> value="<?=$starttime ?>"><?=date("h:i A", strtotime($starttime)) ?></option>
        <? 
		$increment = $a * 15;
		$starttime = date("H:i A",strtotime('+'.$increment.' minutes',$starttime));
		$a++; 
		} ?>
          </select>
&nbsp;to&nbsp;
<select 
          name="event_end_time" class="textboxbottomborder" id="event_end_time">
              <? $endtime = "00:00:00";
		$a = 1;
		$increment = 0;
		while ($a<97){
			$endtime = date("H:i",strtotime('+'.$increment.' minutes',$endtime));
			$endtime = date("H:i:s", strtotime($endtime));
			?>
        <option <? if ($_POST['event_end_time'] == $endtime){ ?> selected="selected" <? } ?> value="<?=$endtime ?>"><?=date("h:i A", strtotime($endtime)) ?></option>
        <? 
		$increment = $a * 15;
		$endtime = date("H:i A",strtotime('+'.$increment.' minutes',$endtime));
		$a++; 
		} ?>
</select>

<input type="hidden" id="firststarttime" value="<?=date("H:i:s") ?>" />
<input type="hidden" id="firstendtime" value="<?=date('H:i:s', strtotime('+2 hour', strtotime(date("H:i:s")))) ?>" />
<input type="hidden" id="maplatNEValue" value='<?php echo $_POST['maplatNEValue'];?>' />
<input type="hidden" id="maplongNEValue" value='<?php echo $_POST['maplongNEValue'];?>' />
<input type="hidden" id="maplatSWValue" value='<?php echo $_POST['maplatSWValue'];?>' />
<input type="hidden" id="maplongSWValue" value='<?php echo $_POST['maplongSWValue'];?>'  />

         <input class="standardbutton" style="cursor:pointer" type="button" id="searchbtn" value="Search">
		</div>
        </div>
      <!--<tr>
    <td height="90" colspan="3" align="center" valign="middle">&nbsp;</td>
  </tr>-->
   </div>

  
  
  <!--------------DISPLAY EVENT LIST HERE------------->
<div id="eventlistdisplay">
</div>
  <!--------------DISPLAY EVENT LIST END------------->
</div>
    
     <div class="left">
		<div id="map" style="width:100%; height:100%;margin-top:50px"></div>
    </div>
</div>
</body>
</html>