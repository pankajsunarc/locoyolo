
<?php include_once (TEMPPATH."/header.php")?>
    <script>
        function insertRow(){
            var index = parseInt(document.getElementById("objective_number").value) + 1;
            var table=document.getElementById("objectivestable");
            var row=table.insertRow(table.rows.length);
            var cell1=row.insertCell(0);
            cell1.style.height = '40px';
            cell1.innerHTML = "<font class=\"ArialVeryDarkGrey15\">#" + index + "</font>";

            var cell2=row.insertCell(1);
            cell2.style.height = '40px';
            var t2=document.createElement("input");
            t2.id = "event_objective"+index;
            t2.setAttribute("name","event_objective"+index);
            t2.setAttribute("class",'textboxbottomborder');
            t2.setAttribute("size",'80');
            t2.setAttribute("placeholder", 'Objective #' + index);
            cell2.appendChild(t2);

            var objectivenumber=document.getElementById("objective_number");
            objectivenumber.remove();
            var t3 = document.createElement("input");
            t3.setAttribute("type", 'hidden');
            t3.setAttribute("id",'objective_number');
            t3.setAttribute("name",'objective_number');
            t3.setAttribute("value", index);
            cell2.appendChild(t3);
        }
    </script>

    <style>
        /* Always set the map height explicitly to define the size of the div
         * element that contains the map. */
        #map {
            height: 400px;
        }
        /* Optional: Makes the sample page fill the window. */
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }
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
            padding-bottom: 12px;
            margin-right: 12px;
        }

        .pac-controls {
            display: inline-block;
            padding: 5px 11px;
        }

        .pac-controls label {
            font-family: Roboto;
            font-size: 15px;
            font-weight: 300;
        }

        #event_location {
            background-color: #fff;
            font-family: Roboto;
            font-size: 15px;
            font-weight: 300;
            margin-left: 12px;
            padding: 0 11px 0 13px;
            text-overflow: ellipsis;
            width: 550px;
        }

        #event_location:focus {
            border-color: #4d90fe;
        }

        #title {
            color: #fff;
            background-color: #4d90fe;
            font-size: 25px;
            font-weight: 500;
            padding: 6px 12px;
        }
        #target {
            width: 345px;
        }
    </style>
</head>

<body>


<div class="row Show-error">
    <?php
if(count($error)>=1){
foreach ($error as $errormessage){
if ($errormessage !== ""){ ?>
   <div class="row errors"><div class=" col-sm-6 ArialVeryDarkGrey15" style="color:#F33"><? echo $errormessage; ?></div><br /><br /></div><?php }} }?>

</div>


<form method="post" action="" enctype="multipart/form-data">
    <table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
            <td width="50%" height="40" class="ArialVeryDarkGreyBold20">Ping a meetup<br />
                <br /></td>
            <td height="40">&nbsp;</td>
        </tr>
        <tr>
            <td height="40" colspan="2" class="ArialVeryDarkGrey15">
                <font class="ArialVeryDarkGrey15"><strong><? echo date('j'); ?></font> <font class="ArialVeryDarkGrey15"><? echo date('F'); ?></font> <font class="ArialVeryDarkGrey15"><? echo date('Y'); ?></font></strong>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;Time to meet:
                <select
                    name="start_time" class="textboxbottomborder" id="start_time">
                    <option value="00:00">00:00 AM</option>
                    <option value="00:15">00:15 AM</option>
                    <option value="00:30">00:30 AM</option>
                    <option value="00:45">00:45 AM</option>
                    <option value="01:00">01:00 AM</option>
                    <option value="01:15">01:15 AM</option>
                    <option value="01:30">01:30 AM</option>
                    <option value="01:45">01:45 AM</option>
                    <option value="02:00">02:00 AM</option>
                    <option value="02:15">02:15 AM</option>
                    <option value="02:30">02:30 AM</option>
                    <option value="02:45">02:45 AM</option>
                    <option value="03:00">03:00 AM</option>
                    <option value="03:15">03:15 AM</option>
                    <option value="03:30">03:30 AM</option>
                    <option value="03:45">03:45 AM</option>
                    <option value="04:00">04:00 AM</option>
                    <option value="04:15">04:15 AM</option>
                    <option value="04:30">04:30 AM</option>
                    <option value="04:45">04:45 AM</option>
                    <option value="05:00">05:00 AM</option>
                    <option value="05:15">05:15 AM</option>
                    <option value="05:30">05:30 AM</option>
                    <option value="05:45">05:45 AM</option>
                    <option value="06:00">06:00 AM</option>
                    <option value="06:15">06:15 AM</option>
                    <option value="06:30">06:30 AM</option>
                    <option value="06:45">06:45 AM</option>
                    <option value="07:00">07:00 AM</option>
                    <option value="07:15">07:15 AM</option>
                    <option value="07:30">07:30 AM</option>
                    <option value="07:45">07:45 AM</option>
                    <option value="08:00">08:00 AM</option>
                    <option value="08:15">08:15 AM</option>
                    <option value="08:30">08:30 AM</option>
                    <option value="08:45">08:45 AM</option>
                    <option value="09:00">09:00 AM</option>
                    <option value="09:15">09:15 AM</option>
                    <option value="09:30">09:30 AM</option>
                    <option value="09:45">09:45 AM</option>
                    <option value="10:00">10:00 AM</option>
                    <option value="10:15">10:15 AM</option>
                    <option value="10:30">10:30 AM</option>
                    <option value="10:45">10:45 AM</option>
                    <option value="11:00">11:00 AM</option>
                    <option value="11:15">11:15 AM</option>
                    <option value="11:30">11:30 AM</option>
                    <option value="11:45">11:45 AM</option>
                    <option value="12:00">12:00 PM</option>
                    <option value="12:15">12:15 PM</option>
                    <option value="12:30">12:30 PM</option>
                    <option value="12:45">12:45 PM</option>
                    <option value="13:00">01:00 PM</option>
                    <option value="13:15">01:15 PM</option>
                    <option value="13:30">01:30 PM</option>
                    <option value="13:45">01:45 PM</option>
                    <option value="14:00">02:00 PM</option>
                    <option value="14:15">02:15 PM</option>
                    <option value="14:30">02:30 PM</option>
                    <option value="14:45">02:45 PM</option>
                    <option value="15:00">03:00 PM</option>
                    <option value="15:15">03:15 PM</option>
                    <option value="15:30">03:30 PM</option>
                    <option value="15:45">03:45 PM</option>
                    <option value="16:00">04:00 PM</option>
                    <option value="16:15">04:15 PM</option>
                    <option value="16:30">04:30 PM</option>
                    <option value="16:45">04:45 PM</option>
                    <option value="17:00">05:00 PM</option>
                    <option value="17:15">05:15 PM</option>
                    <option value="17:30">05:30 PM</option>
                    <option value="17:45">05:45 PM</option>
                    <option value="18:00">06:00 PM</option>
                    <option value="18:15">06:15 PM</option>
                    <option value="18:30">06:30 PM</option>
                    <option value="18:45">06:45 PM</option>
                    <option value="19:00">07:00 PM</option>
                    <option value="19:15">07:15 PM</option>
                    <option value="19:30">07:30 PM</option>
                    <option value="19:45">07:45 PM</option>
                    <option value="20:00">08:00 PM</option>
                    <option value="20:15">08:15 PM</option>
                    <option value="20:30">08:30 PM</option>
                    <option value="20:45">08:45 PM</option>
                    <option value="21:00">09:00 PM</option>
                    <option value="21:15">09:15 PM</option>
                    <option value="21:30">09:30 PM</option>
                    <option value="21:45">09:45 PM</option>
                    <option value="22:00">10:00 PM</option>
                    <option value="22:15">10:15 PM</option>
                    <option value="22:30">10:30 PM</option>
                    <option value="22:45">10:45 PM</option>
                    <option value="23:00">11:00 PM</option>
                    <option value="23:15">11:15 PM</option>
                    <option value="23:30">11:30 PM</option>
                    <option value="23:45">11:45 PM</option>
                </select>
                &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;Ping category:
                <select
                    name="event_category" class="textboxbottomborder" id="event_category">
                    <option value="1" <? if($_POST["event_category"] == "1"){?> selected="selected" <? } ?>  <? if($_POST["event_category"] == ""){?> selected="selected" <? } ?> >
                        Sports
                    </option>
                    <option value="2" <? if($_POST["event_category"] == "2"){?> selected="selected" <? } ?> >Relaxation</option>
                    <option value="3" <? if($_POST["event_category"] == "3"){?> selected="selected" <? } ?> >Food &amp; Drink</option>
                </select>
                </font></td>
        </tr>
        <tr>
            <td height="20">&nbsp;</td>
            <td height="20">&nbsp;</td>
        </tr>
        <tr>
            <td height="40" colspan="2" class="ArialVeryDarkGrey15"><textarea name="event_name" cols="100" rows="2" class="textboxbottomborder" id="event_name" placeholder="What's the meetup about?"><?=$_POST["event_name"] ?></textarea></td>
        </tr>
        <tr>
            <td width="50%" height="20">&nbsp;</td>
            <td height="20">&nbsp;</td>
        </tr>
<!--        <tr>-->
<!--            <td height="40"><span class="ArialOrange18">Photo<br />-->
<!--      <br />-->
<!--    </span></td>-->
<!--            <td height="40">&nbsp;</td>-->
<!--        </tr>-->
<!--        <tr>-->
<!--            <td height="40" colspan="2"><span class="ArialVeryDarkGrey15">-->
<!--      <input name="event_photo" type="file" class="textboxbottomborder" id="event_photo3" size="40" />-->
<!--      </span></td>-->
<!--        </tr>-->
        <tr>
            <td height="20">&nbsp;</td>
            <td height="20">&nbsp;</td>
        </tr>
        <tr>
            <td height="40" class="ArialOrange18">Location<br />
                <br /></td>
            <td height="40">&nbsp;</td>
        </tr>
        <tr>
            <td height="40" colspan="2" class="ArialVeryDarkGrey15" style="color:#666">Please search for the exact or closest location to your event, then click on the map to mark the location of your event.
                <input type="hidden" id="city2" name="city2" />
                <input type="hidden" id="event_lat" name="event_lat" />
                <input type="hidden" id="event_long" name="event_long" />
                <br />
                <br /></td>
        </tr>
        <tr>
            <td height="20" colspan="2">
                <!-- MAP HOLDER -->
                <input type="text" class="controls" id="event_location" name="event_location" placeholder="Search for the exact or nearest location of your event..." size="60">
                <div id="map" style="height:300px"></div>
                <!-- REFERENCES -->
                <script>
                    // This example adds a search box to a map, using the Google Place Autocomplete
                    // feature. People can enter geographical searches. The search box will return a
                    // pick list containing a mix of places and predicted search terms.

                    // This example requires the Places library. Include the libraries=places
                    // parameter when you first load the API. For example:
                    // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

                    function initAutocomplete() {

                        var directionsService = new google.maps.DirectionsService();
                        var directionsDisplay = new google.maps.DirectionsRenderer();
                        var marker;

                        var map = new google.maps.Map(document.getElementById('map'), {
                            center: {lat: -33.8688, lng: 151.2195},
                            zoom: 13,
                            mapTypeId: 'roadmap'
                        });

                        // Create the search box and link it to the UI element.
                        var input = document.getElementById('event_location');
                        var searchBox = new google.maps.places.SearchBox(input);
                        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

                        // Bias the SearchBox results towards current map's viewport.
                        map.addListener('bounds_changed', function() {
                            searchBox.setBounds(map.getBounds());
                        });

                        var markers = [];
                        // Listen for the event fired when the user selects a prediction and retrieve
                        // more details for that place.
                        searchBox.addListener('places_changed', function() {
                            var places = searchBox.getPlaces();
                            places.forEach(function(place) {

                                document.getElementById('city2').value = place.name;
//                                alert(place.geometry.location.lat());

                            document.getElementById('event_lat').value = place.geometry.location.lat();
                            document.getElementById('event_long').value = place.geometry.location.lng();
                            });
                            var geocoder = new google.maps.Geocoder();
                            var address = document.getElementById('event_location').value;
                            geocoder.geocode({ 'address': address }, function (results, status) {
                                if (status == google.maps.GeocoderStatus.OK) {
                                    document.getElementById('event_lat').value = results[0].geometry.location.lat();
                                    document.getElementById('event_long').value = results[0].geometry.location.lng();
                                }
                            });

                            if (places.length == 0) {
                                return;
                            }

                            // Clear out the old markers.
                            markers.forEach(function(marker) {
                                marker.setMap(null);
                            });
                            markers = [];

                            // For each place, get the icon, name and location.
                            var bounds = new google.maps.LatLngBounds();
                            places.forEach(function(place) {
                                if (!place.geometry) {
                                    console.log("Returned place contains no geometry");
                                    return;
                                }
                                var icon = {
                                    url: place.icon,
                                    size: new google.maps.Size(71, 71),
                                    origin: new google.maps.Point(0, 0),
                                    anchor: new google.maps.Point(17, 34),
                                    scaledSize: new google.maps.Size(25, 25)
                                };

                                // Create a marker for each place.
                                markers.push(new google.maps.Marker({
                                    map: map,
                                    icon: icon,
                                    title: place.name,
                                    position: place.geometry.location
                                }));

                                google.maps.event.addListener(map, 'click', function(event) {
                                    placeMarker(event.latLng);
                                });

                                function placeMarker(location) {

                                    if (marker == null)
                                    {
                                        marker = new google.maps.Marker({
                                            position: location,
                                            icon: 'images/red_pos_marker.fw.png',
                                            map: map
                                        });
//                                        alert(getElementById('event_lat'));
                                        document.getElementById('event_lat').value = marker.getPosition().lat();
                                        document.getElementById('event_long').value = marker.getPosition().lng();
                                        //getDirections(document.getElementById('city2').value);
                                    } else {
                                        marker.setPosition(location);
                                        document.getElementById('event_lat').value = marker.getPosition().lat();
                                        document.getElementById('event_long').value = marker.getPosition().lng();
                                        //getDirections(document.getElementById('city2').value);
                                    }
                                }

                                if (place.geometry.viewport) {
                                    // Only geocodes have viewport.
                                    bounds.union(place.geometry.viewport);
                                } else {
                                    bounds.extend(place.geometry.location);
                                }
                            });
                            map.fitBounds(bounds);
                        });
                    }

                    /*function getDirections(destination) {
                     var start = marker.getPosition();
                     var dest = destination;
                     alert(dest);
                     var request = {
                     origin: start,
                     destination: dest,
                     travelMode: google.maps.TravelMode.WALKING
                     };
                     directionsService.route(request, function (result, status) {
                     if (status == google.maps.DirectionsStatus.OK) {
                     directionsDisplay.setDirections(result);
                     }
                     });
                     }*/

                </script>
                <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDHXsI2hOfs6x7NJLR8LnN5wG-2N-ha0S8&libraries=places&callback=initAutocomplete" async defer></script>
            </td>
        </tr>
        <tr>
            <td height="20">&nbsp;</td>
            <td height="20">&nbsp;</td>
        </tr>
        <?
        $numberofobjectives = $_POST['objective_number'];
        $i=1;
        ?>
        <tr>
            <td height="40" colspan="2"><table align="center">
                    <tr>
                        <td>
                            <input type="hidden" id="new_event_entry" name="new_event_entry" value="Y" />
                            <input class="standardbutton" style="cursor:pointer" type="submit" name="ping_submit" id="submit" value="Ping it!"></td>
                    </tr>
                </table></td>
        </tr>
    </table>
</form>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>

</body>
</html>