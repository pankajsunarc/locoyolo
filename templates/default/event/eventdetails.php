<?php include_once(TEMPPATH . "/header.php");
$eventid = $_REQUEST['eventid'];
$sql = "SELECT entry_type from events where event_id = $userEvent_id";
$result = $DB->RunSelectQuery($sql);


if ($result) {
    if (isset($result['entry_type']) && ($result['entry_type'] != '' || $result['entry_type'] == 'ping')) {

        header("location:/locomvc");
    }
} else {
    //header("location:/lokoyolo/index.php");
//    echo "<script>window.location.href='/lokoyolo/index.php'</script>";
}

if (isset($_POST['cancelyesbutton'])) {
    $sql = "SELECT * from events where event_id=$userEvent_id";
    $query = $DB->RunSelectQuery($sql);

    foreach ($query as $resultCheck) {
        $result_check_cancel = (array)$resultCheck;
        if ($result_check_cancel["event_status"] !== "C") {
            $dataToUpdate =[
            'event_status'=> "C"
            ];
            $query= $DB->UpdateRecord('events',$dataToUpdate,'event_id="'.$userEvent_id.'"');
            $sql = "Select * from event_bookings where event_id = $userEvent_id";
            $query = $DB->RunSelectQuery($sql);

           foreach ($query as $data) {
               $fetchData =(array)$data;
               $insertData["user_id"] = $fetchData["user_id"];
               $insertData["event_id"] = $userEvent_id;
               $insertData["notification_type"] = "Cancel Event";
               $insertData["status"] = "Pending";
               $insertData["notification_date"] = date("Y-m-d H:i:s");
               $sql = $DB->InsertRecord('notifications',$insertData);
            }
        }
    }
}


 $sql = "SELECT * from event_locations where event_id=$userEvent_id";
$locationData = $DB->RunSelectQuery($sql);
foreach ($locationData as $location) {
    $data = (array)$location;
    $eventLat = $data['event_lat'];
    $eventLong = $data['event_long'];

}

$sql = "SELECT * from events where event_id=$userEvent_id";
$eventData = $DB->RunSelectQuery($sql);
foreach ($eventData as $data) {
    $result = (array)$data;
    $userid = $result["user_id"];
    $event_name = $result["event_name"];
    $start_date = $result["start_date"];
    $event_price = $result["event_price"];
}

$sql2 = "SELECT * from public_users where id=$userid";
$userData = $DB->RunSelectQuery($sql2);
foreach ($userData as $data) {
    $resultuser = (array)$data;
    $emailto = $resultuser["email"];
    $organiser_name = $resultuser["firstname"];
}

$email = $_SESSION['user_email'];

$query = "SELECT * from public_users where email='$email'";
$resultdata = $DB->RunSelectQuery($query);
foreach ($resultdata as $data1) {

    $result = (array)$data1;
    $participant_name = $result["firstname"];
    $current_user_id = $result["id"];
    $current_profile_pic = $result["profile_pic"];

}

?>


<script type="text/javascript">
    function initMap() {
        // Create the map.
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 16,
            center: {lat: <?= $eventLat ?>, lng: <?= $eventLong ?>},
        });

        // Add the circle for this city to the map.
        var cityCircle = new google.maps.Circle({
            strokeColor: '#FF0000',
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillColor: '#FF0000',
            fillOpacity: 0.35,
            map: map,
            center: {lat: <?= $eventLat ?>, lng: <?= $eventLong ?>},
            radius: 100
        });

        // Create the MOBILE map.
        var map_mobile = new google.maps.Map(document.getElementById('map_mobile'), {
            zoom: 16,
            center: {lat: <?= $eventLat ?>, lng: <?= $eventLong ?>},
        });

        // Add the circle for this city to the map.
        var cityCircle = new google.maps.Circle({
            strokeColor: '#FF0000',
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillColor: '#FF0000',
            fillOpacity: 0.35,
            map: map_mobile,
            center: {lat: <?= $eventLat ?>, lng: <?= $eventLong ?>},
            radius: 100
        });

    }

    $(document).ready(function () {

        var sendcommentbtn = document.getElementById("sendcommentbtn");
        sendcommentbtn.addEventListener('click', function () {
            var comment_message = document.getElementById("comment_message").value;
            var user_id = "<?= $current_user_id ?>";
            var event_id = "<?= $eventid ?>";

            //POST BY AJAX TO DISPLAY EVENTS IN MAP LIST
            $.ajax({
                type: "POST",
                    url: "<?php echo CreateURL('index.php',"mod=ajax&do=send_comment");?>",
                data: {comment_message: comment_message, user_id: user_id, event_id: event_id},
                //dataType: 'json',
                cache: false,
                success: function (data) {
                    if (data == 'OK') {
                        result = data;
                    } else {
                        result = data;
                    }

                    if (document.getElementById("comments_number").value == "0") {
                        $('#commentsdisplay').html('');
                    }

                    $('#comment_message').val('');
                    $('#commentsdisplay').prepend(result);

                    document.getElementById("comments_number").value = parseInt(document.getElementById("comments_number").value) + 1;
                    document.getElementById("total_comments_number").value = parseInt(document.getElementById("total_comments_number").value) + 1;
                    var number_of_records = document.getElementById("comments_number").value;
                    var total_number_of_records = document.getElementById("total_comments_number").value;

                    if (number_of_records < total_number_of_records) {
                        $('#comments_display_progress').html('<font class="ArialVeryDarkGrey15" style="color:#999">Showing ' + number_of_records + ' of ' + total_number_of_records + ' comments | </font><div style="display:inline-block" onclick="add_comments()"><font class="ArialVeryDarkGrey15" style="color:#09C">See more comments</font>');
                    } else {
                        $('#comments_display_progress').html('<font class="ArialVeryDarkGrey15" style="color:#999">Showing ' + number_of_records + ' of ' + total_number_of_records + ' comments</font>');
                    }

                }
            });

        });


        var messagesentbtn = document.getElementById('messagesentbtn');
        // Get the modal
        var cancelpopup = document.getElementById('cancelpopup');
        // Get the modal
        var bookpopup = document.getElementById('bookpopup');
        // Get the button that opens the modal

        // Get the button that opens the modal
        var bookbtn = document.getElementById('bookbtn');
//	var bookbtn_mobile = document.getElementById('bookbtn_mobile');

        // Get the <span> element that closes the modal
        var cancelyesbtn = document.getElementById("cancelyesbutton");
        var cancelnobtn = document.getElementById("cancelnobutton");
        // When the user clicks on the button, open the modal
        if (document.getElementById("canceleventbtn") && document.getElementById("canceleventbtn").value) {
            var canceleventbtn = document.getElementById('canceleventbtn');
            canceleventbtn.onclick = function () {
                cancelpopup.style.display = "block";
            }
        }
        if (document.getElementById("canceleventbtn_mobile") && document.getElementById("canceleventbtn_mobile").value) {
            var canceleventbtn_mobile = document.getElementById('canceleventbtn_mobile');
            canceleventbtn_mobile.onclick = function () {
                cancelpopup.style.width = "90%";
                cancelpopup.style.display = "block";
            }
        }

        // When the user clicks on the button, open the modal
        messagesentbtn.onclick = function () {
            bookpopup.style.display = "none";
        }
        messagesentbtn.style.visibility = "hidden";
        // When the user clicks on <span> (x), close the modal
        cancelyesbtn.onclick = function () {
            cancelpopup.style.display = "none";
        }
        cancelnobtn.onclick = function () {
            cancelpopup.style.display = "none";
        }
        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function (event) {
            if (event.target == cancelpopup) {
                cancelpopup.style.display = "none";
            }
            if (event.target == bookpopup) {
                bookpopup.style.display = "none";
            }
        }
        // When the user clicks on the button, open the modal
        bookbtn.onclick = function () {
            bookpopup.style.display = "block";
        }
//	bookbtn_mobile.onclick = function() {
//		bookpopup.style.display = "block";
//		document.getElementById("modal_content").style.width = "300px";
//	}

        var eventjustupdated = '<?
            echo $_SESSION["event_just_updated"];
            ?>';
        var eventupdatedpopup = document.getElementById('eventupdatedpopup');
        if (eventjustupdated == "YES") {
            eventupdatedpopup.style.display = "block";
        }
        var eventupdateokbtn = document.getElementById('eventupdateokbtn');
        eventupdateokbtn.onclick = function () {
            eventupdatedpopup.style.display = "none";
        }

        var sendmessagebtn = document.getElementById("sendmessagebtn");
        sendmessagebtn.addEventListener('click', function () {

            var emailfrom = "<?php echo $userData->email; ?>";
            var emailto = "<?= $emailto ?>";
            var event_name = "<?= $event_name ?>";
            var organiser_name = "<?= $organiser_name ?>";
            var participant_name = "<?= $participant_name ?>";
            var event_id = "<?= $eventid ?>";
            var start_date = "<?= $start_date ?>";
            var user_id = "<?= $current_user_id ?>";
            var event_price = "<?= $event_price ?>";
            var booking_message = document.getElementById("booking_message").value;

            //POST BY AJAX TO DISPLAY EVENTS IN MAP LIST
            $.ajax({
                type: "POST",
                url: "<?php echo createURL('index.php', 'mod=ajax&do=join_event_message');?>",
                data: {
                    emailfrom: emailfrom,
                    emailto: emailto,
                    organiser_name: organiser_name,
                    participant_name: participant_name,
                    event_id: event_id,
                    booking_message: booking_message,
                    event_name: event_name,
                    start_date: start_date,
                    user_id: user_id,
                    event_price: event_price
                },
                //dataType: 'json',
                cache: false,
                success: function (data) {
                    if (data == 'OK') {
                        result = data;
                    } else {
                        result = data;
                    }
                    $('#join_message_content').html(result);
                    if (document.getElementById("messagestatus").value == "Sent") {
                        messagesentbtn.style.visibility = "visible";
                        sendmessagebtn.style.visibility = "hidden";
                        $('#bookstatus').html('<img src="images/blue_tick.gif" style="vertical-align:middle" width="15" />&nbsp;<font class="ArialVeryDarkGrey15">Booking request sent</font>');
                    }

                }
            });

        });

        var addbuddybtn = document.getElementById("addbuddybtn");
        addbuddybtn.addEventListener('click', function () {
            var user_id = "<?= $current_user_id ?>";
            var buddy_id = "<?= $userid ?>";
            //POST BY AJAX TO DISPLAY EVENTS IN MAP LIST
            $.ajax({
                type: "POST",
                url: "<?php echo CreateURL('index.php','mod=ajax&do=send_buddy_request'); ?>",
                data: {userid: user_id, buddyid: buddy_id},
                //dataType: 'json',
                cache: false,
                success: function (data) {
                    if (data == 'Y') {
                        $('#add_buddy_content').html(result);
                    } else {
                       alert('Unable to send request.');
                    }

                }
            });
        });

    });

    function delete_comment(id, name){

        $.ajax({
            type: "POST",
            url: "<?php echo CreateURL('index.php',"mod=ajax&do=delete_comment");?>",
            data: { comment_id:id },
            //dataType: 'json',
            cache: false,
            success: function(data)
            {

                if(data == 'Y') {
                    $('#comment_content'+id).parent().parent().remove();
                } else {

                    alert('The comment was not deleted.');
                }
//                $('#comment_content'+id).html('<font class="ArialVeryDarkGreyBold15">'+name+'</font>&nbsp;<font class="ArialVeryDarkGrey15" style="color:#F63; font-style: italic;">Comment has been deleted.</font>');
            }
        });
    }
    function add_comments() {
//POST BY AJAX TO DISPLAY EVENTS IN MAP LIST

        var number_of_records = document.getElementById("comments_number").value;
        var total_number_of_records = document.getElementById("total_comments_number").value;
        var user_id = "<?= $current_user_id ?>";
        var event_id = "<?= $eventid ?>";
        $.ajax({
            type: "POST",
            url: "<?php echo CreateURL('index.php',"mod=ajax&do=show_more_comment");?>",
            data: {number_of_records: number_of_records, user_id: user_id, event_id: event_id},
            //dataType: 'json',
            cache: false,
            success: function (data) {
                if (data == 'OK') {
                    result = data;
                } else {
                    result = data;
                }
                $('#commentsdisplay').append(result);
                number_of_records = parseInt(number_of_records) + 10;
                if (number_of_records < total_number_of_records) {
                    document.getElementById("comments_number").value = number_of_records;
                    number_of_records = parseInt(number_of_records) - 10;
                    $('#comments_display_progress').html('<font class="ArialVeryDarkGrey15" style="color:#999">Showing ' + number_of_records + ' of ' + total_number_of_records + ' comments | </font><div style="display:inline-block" onclick="add_comments()"><font class="ArialVeryDarkGrey15" style="color:#09C">See more comments</font>');
                } else {
                    $('#comments_display_progress').html('<font class="ArialVeryDarkGrey15" style="color:#999">Showing ' + total_number_of_records + ' of ' + total_number_of_records + ' comments</font>');
                }
            }
        });
    }
</script>
<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDHXsI2hOfs6x7NJLR8LnN5wG-2N-ha0S8&callback=initMap">
</script>


<div style="height:10px"></div>
<!-- The Cancel Event Modal -->
<div id="cancelpopup" class="modal">

    <!-- Modal content -->
    <div class="modal-content" style="width:400px; padding:10px">
        <table width="420" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
                <td height="10"></td>
            </tr>
            <tr>
                <td height="20" class="ArialOrange18">Cancel Event<br/>
                    <br/></td>
            </tr>
            <tr>
                <td class="ArialVeryDarkGrey15">
                    <table width="400" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td>&nbsp;&nbsp;Are you sure you want to cancel this event?</td>
                            <td width="10">&nbsp;</td>
                            <td>
                                <form action="" method="post"><input class="standardbutton" style="cursor:pointer"
                                                                     type="submit" id="cancelyesbutton"
                                                                     name="cancelyesbutton" value="Yes"/>
                                    <input type="hidden" name="eventid" id="eventid" value="<?php echo $eventid ?>"/></form>
                            </td>
                            <td width="10">&nbsp;</td>
                            <td><input class="standardgreybutton" style="cursor:pointer" type="submit"
                                       id="cancelnobutton" value="No"/></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
            </tr>
        </table>
    </div>
</div>

<!-- The Event Update Modal -->
<div id="eventupdatedpopup" class="modal">

    <!-- Modal content -->
    <div class="modal-content" style="width:340px; padding:10px">
        <table width="320" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
                <td height="10"></td>
            </tr>
            <tr>
                <td class="ArialVeryDarkGrey15">
                    <table width="300" border="0" align="center" cellpadding="0" cellspacing="0">
                        <tr>
                            <td>&nbsp;&nbsp;Your event has been updated!</td>
                            <td width="10">&nbsp;</td>
                            <td><input class="standardbutton" style="cursor:pointer" type="submit" id="eventupdateokbtn"
                                       name="eventupdateokbtn" value="OK"/>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td height="10"></td>
            </tr>
        </table>
    </div>
</div>


<!-- The Cancel Event Modal -->
<div id="bookpopup" class="modal">
    <!-- Modal content -->
    <div id="modal_content" class="modal-content" style="width:400px; padding:10px">
        <table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
                <td>
                    <div id="join_message_content">
                        <table>
                            <tr>
                                <td>
                                    <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td><font class="ArialOrange18">Join event</font><br/>
                                                <br/>
                                                <font class="ArialVeryDarkGrey15">Send <?= $organiser_name ?> a message
                                                    to join this event. Replies will come to your email.</font><br/>
                                                <br/></td>
                                        </tr>
                                        <tr>
                                            <td class="ArialVeryDarkGrey15">
                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                    <tr>
                                                        <td colspan="4"><textarea name="booking_message"
                                                                                  style="width:100%" rows="10"
                                                                                  class="textboxbottomborder"
                                                                                  id="booking_message"
                                                                                  placeholder="Send a request to join this event..."></textarea>
                                                            <input type="hidden" id="messagestatus" value=""/>
                                                            <br/>
                                                            <br/></td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </div>
                </td>
            </tr>
            <tr>
                <td align="right">
                    <input class="standardbutton" style="cursor:pointer" type="submit" id="messagesentbtn"
                           name="messagesentbtn" value="OK"/><input class="standardbutton" style="cursor:pointer"
                                                                    type="submit" id="sendmessagebtn"
                                                                    name="sendmessagebtn" value="Send"/></td>
            </tr>
        </table>
    </div>
</div>

<body>

<div id="event-detail-page-wrapper">
    <div class="container" style="width: 1170px;">
        <div class="has-event-message">
            <?
            $sql = "SELECT * from events where event_id=$userEvent_id";
            $eventData = $DB->RunSelectQuery($sql);
            foreach ($eventData as $event) {
                $result = (array)$event;

                $userid = $result["user_id"];
            }
            $sql2 = "SELECT * from public_users where id= $userid";
            $userData = $DB->RunSelectQuery($sql2);
//
            foreach ($userData as $data) {
            $public_user = (array)$data;
            $profilepic = $public_user['profile_pic'];
            ?>
            <?
            if ($profilepic == null) {
//

                ?>
                <div class="event-message-image col-sm-1"><img class="image-has-radius" src="images/no_profile_pic.gif"
                                                               alt="event-image"></div>
                <div class="event-message-content col-sm-11"><strong><?= $resultuser["firstname"] ?></strong>
                    <p>is organizing an event.</p></div>
                <?
            } else {
//
                ?>
                <div class="event-message-image col-sm-1"><img class="image-has-radius" src="<?
                    echo ROOTURL . '/' . $profilepic;
                    ?>" alt="event-image"></div>
                <div class="event-message-content col-sm-11"><strong><?= $resultuser["firstname"] ?></strong>
                    <p>is organizing an event.</p>
                </div>
                <?php
            } ?>
        </div>
        <div class="col-md-5 goes-on-left">
            <div class="row has-event-image">
                <?php if ($result["event_photo"] == "") { ?>
                    <img class="image-doesnt-has-radius" src="images/no_profile_pic.gif" alt="image">
                <?php } else { ?>
                    <img class="image-doesnt-has-radius" src="<?php echo ROOTURL . '/' . $result["event_photo"] ?>" alt="image">
                <?php } ?>
            </div>

            <div class="row has-event-title">
                <h3><strong><?= $result["event_name"] ?></strong></h3>
            </div>
            <div class="row has-date-time">
                <span><?= date("j F Y", strtotime($result["start_date"])) ?></span><span
                        class="make-space">|</span><span><?
                    echo date("g:ia", strtotime($result["start_time"])) . " - " . date("g:ia", strtotime($result["end_time"]));
                    ?></span>
            </div>
            <?
            if ($userid == $current_user_id) {

                if ($result["event_status"] == "L") {
                    ?>
                    <div class="row" id="add_buddy_content">

                        <button class="btn btn-primary"
                            <?php echo CreateURL('index.php',"mod=ajax&do=send_comment");?>
                                onclick="location.href='<?php echo CreateURL('index.php',"mod=event&do=editevent&id=".$result['event_id']);?>'">
                            Edit event
                        </button>
                        <button class="btn btn-primary" type="submit" id="canceleventbtn" value="Cancel event" ?>Cancel
                            event
                        </button>
                        <?


                        //                            if(isset($_SESSION["login_user"])) {
                        //                                $sql3 = "SELECT * from buddies where buddy_id=:buddyid and user_id=:userid";
                        //                                $stmt3 = $pdo->prepare($sql3);
                        //                                $stmt3->bindParam(':buddyid', $userid, PDO::PARAM_INT);
                        //                                $stmt3->bindParam(':userid', $current_user_id, PDO::PARAM_INT);
                        //                                $stmt3->execute();
                        //
                        //                                if ($stmt3->rowCount() < 1){
                        //                                    ?>
                        <!--                                    <input class="standardbutton" style="cursor:pointer" type="submit" name="addbuddybtn" id="addbuddybtn" value="Add Buddy">-->
                        <!---->
                        <!--                                --><? // }
                        //                                while ($resultbuddy = $stmt2->fetch( PDO::FETCH_ASSOC )){
                        //                                    if ($resultbuddy["status"] == "Confirmed"){
                        //
                        //                                    }
                        //                                } } ?>
                        <!--<tr>
                          <td width="50"><input class="standardbutton" style="cursor:pointer" type="submit" name="messagebtn" id="messagebtn" value="Message"></td>
                        </tr>-->
                    </div>

                    <?
                } else {
                    ?>

                    <?
                }
            }
            ?>
            <?
            $event_user_id = $result["user_id"];
            $current_user_email = $_SESSION["user_email"];
           $sqlQuery = "SELECT * from public_users where email='$current_user_email'  ";
           $queryData = $DB->RunSelectQuery($sqlQuery);

            foreach ($queryData as $resultdata) {
                $resultuser = (array)$resultdata;
                $current_user_id = $resultuser["id"];
            }

            $sql4 = "SELECT * from event_bookings where event_id=$userEvent_id and user_id=$current_user_id";

            $data = $DB->RunSelectQuery($sql4);

             foreach ($data as $resultData) {
                $result_booking = (array)$resultData;
                $booking_status = $result_booking["booking_status"];

            }


            if ($_SESSION["user_id"] == "") {
                ?>
                <span>Please<a href="<?php echo ROOTURL; ?>"
                               style="text-decoration:underline">sign in</a> to join.</span>
                <?
            } else {
                if ($current_user_id == $event_user_id) {
                    ?>

                    <?
                } else {
                    if ($result["event_status"] == "L" && $data < 1) {
                       ?>
                                        <div class="row has-booking-details">
                                           <span>Free</span><span class="make-more-space"></span>
                                             <div id="bookstatus">
                                                 <button class="btn btn-warning standardbutton" type="submit" name="bookbtn"
                                                        id="bookbtn">Book a spot
                                                  </button>
                                           </div>
                                          </div>
                   <?//
                  }
                                   if ($result["event_status"] == "L" & $booking_status == "Pending") {
                        ?><img src="images/blue_tick.gif" style="vertical-align:middle" width="15"/>&nbsp;<span>Booking request sent</span>
                        <?
                    }
                    if ($result["event_status"] == "L" & $booking_status == "Confirmed") {
                        ?><img src="images/green_tick.gif" style="vertical-align:middle" width="15"/>&nbsp;<span>Booking confirmed</span>
                        <?
                    }
                    if ($result["event_status"] == "N") {
                        ?>
                        <div class="ArialRedBold15">Event closed</div><?
                    }
                }
                if ($result["event_status"] == "C") {
                    ?>
                    <div class="ArialRedBold15">Event cancelled</div>
                    <?
                }
            }
            ?>

            <?php $status = "Confirmed";
            $qryToFetchBuddy = " SELECT buddies.buddy_id, public_users.profile_pic, CONCAT(public_users.firstname, ' ', public_users.lastname ) As FullName
                FROM buddies INNER JOIN public_users ON buddies.buddy_id=public_users.id WHERE user_id = $current_user_id AND status = '$status'";
            $data = $DB->RunSelectQuery($qryToFetchBuddy);
            if(!is_array($data))
            {
                $data =array();
            }
            ?>
            <?php if(count($data) < 1){ ?>
                <div class="row" id="has-invite-friends">
                    <h4><strong>Invite your friends</strong></h4>
                    <br/>
                    <span>No Friend Available</span>
                </div>
            <?php } else {?>

            <div class="row" id="has-invite-friends">
                <h4><strong>Invite your friends</strong></h4>
                <br/>
<!--                --><?php  foreach ($data as $buddyData) {
                    $buddy = (array)$buddyData;

                    if (isset($buddy['profile_pic']) && $buddy['profile_pic'] != '') {
                        $img =  $buddy['profile_pic'];
                    } else {
                        $img = 'images/profile_img.jpg';

                    }
                    ?>
                    <div class="has-invites">
                        <span class="buddy-img"><img class="image-has-radius" src="<?php echo $img ?>"
                         alt="event-image"></span>
                        <span class="make-more-space"></span>
                        <span><strong><?php echo $buddy['FullName'] ?></strong></span>
                        <a class="invite-button">invite</a>
                    </div>
                <?php } ?>


                <div class="has-see-all-friends-btn">
                    <button class="btn btn-primary">See all friends</button>
                </div>
            </div>
            <?php } ?>
        </div>

        <div class="col-md-7 goes-on-right">
            <div class="row has-event-summary">
                <div class="has-title">
                    <h3>Event Summary</h3>
                </div>
                <div class="has-content">
                    <?php if ($result["event_description"] == null) {
                        echo "N/A";
                    } else {
                        ?>

                        <p><?= $result["event_description"] ?></p>
                    <?php } ?>
                </div>
            </div>
            <div class="row has-event-summary has-event-objective">
                <div class="has-title">
                    <h3>Event Objectives</h3>
                </div>
                <div class="has-content">
                    <?php
                    if ($result["event_objectives"] == null)
                    {
                        echo "N/A";
                    }else { ?>
                    <ol>
                        <? //$event_objectives_string = substr(trim($result["event_objectives"]), 0, -1);
                        //$event_objectives = explode(";", $event_objectives_string);
                        $event_objectives = explode(";", $result["event_objectives"]);

                        $i = 0;
                        while ($i < sizeof($event_objectives)) { ?>
                            <li><?= $event_objectives[$i] ?></li>
                            <? $i++;
                        }
                        }
                        ?>
                    </ol>
                </div>
            </div>
            <div class="row has-event-summary has-event-requirements">
                <div class="has-title">
                    <h4>Requirements</h4>
                </div>
                <div class="has-content">
                    <p><span><strong>Attire</strong></span><span
                                class="make-even-more-space"></span><span> <?= $result["event_attire"] ?></span></p>
                    <p><?= $result["event_attire_desc"] ?></p>
                </div>

                <div class="has-content">
                    <p><span><strong>F&amp;B:</strong></span><span
                                class="make-even-more-space"></span><span><?= $result["event_food_and_drinks"] ?></span>
                    </p>
                    <p> <?
                        if ($result["event_food_and_drinks_desc"] !== "Not applicable") {
                            echo $result["event_food_and_drinks_desc"];
                        }
                        ?></p>
                </div>

                <?
                if ($result["event_fitness"] !== "Not applicable") {
                    ?>
                    <div class="has-content">
                        <p><span><strong>Fitness:</strong></span><span
                                    class="make-even-more-space"></span><span> <?= $result["event_fitness"] ?></span>
                        </p>
                        <p> <?= $result["event_fitness_desc"] ?></p>
                    </div>
                    <?
                }
                if ($result["event_essentials"] !== "") {
                    ?>
                    <p><span><strong>Essentials:</strong></span><span
                                class="make-even-more-space"></span><span><?= $result["event_essentials"] ?></span></p>
                    <?
                }
                if ($result["event_safety"] !== "") {
                    ?>
                    <div class="has-content">
                        <p><span><strong>Safety:</strong></span><span
                                    class="make-even-more-space"></span><span><?= $result["event_safety"] ?></span></p>
                    </div>
                    <?
                }
                if ($result["event_additional_notes"] !== "") {
                    ?>
                    <p><span><strong>Additional notes:</strong></span><span
                                class="make-even-more-space"></span><span><?= $result["event_fitness_desc"] ?></span>
                    </p>

                    <?
                }
                ?>
            </div>
            <?php


            ?>
            <div class="row has-map-title"><h4>Event Location</h4></div>

            <div class="row has-map">
                <?
                $query = "SELECT * from event_locations where event_id=$userEvent_id";
                $data = $DB->RunSelectQuery($query);
                foreach ($data as $resultLocation) {
                    $resultloc =(array)$resultLocation;
                    $location_details = $resultloc["event_location_description"];
                    ?>
                    <?= $resultloc["event_location"] ?>
                    <?
                }
                ?>
                <div id="map" style="height:300px"></div>
<!--                --><?//
//                if ($location_details !== "") {
//                    ?>
<!--                    <span><b>Location Details:</b></span>-->
<!--                    --><?//= $location_details ?>
<!--                    --><?//
//                }
//                ?>

            </div>


            <div class="has-title"><h4>Comments</h4></div>
            <div class="row has-comments">

                <?
                if ($current_profile_pic == "") {
                    ?>
                    <div class="col-md-2 event-user-image"><img class="image-has-radius" src="images/no_profile_pic.gif"
                                                                alt="event-image"></div>
                    <?
                } else {
                    ?>

                    <div class="col-md-2 event-user-image"><img class="image-has-radius" src="<?
                        echo ROOTURL . '/' . $current_profile_pic;
                        ?>" alt="event-image"></div>
                    <?
                }
                ?>
                <div class="row col-md-8 comment-textarea"><input type="textarea" class="comment-area"
                                                                  id="comment_message" placeholder="Send a Comment...">
                </div>
                <div class="row col-md-2 send-comment"><input class="standardgreybutton" style="cursor:pointer"
                                                              type="submit" name="sendcommentbtn" id="sendcommentbtn"
                                                              value="Send"/></div>
            </div>
            <div class="has-comment-area">

            </div>
            <?

            $sql = "Select * from comments where event_id= $userEvent_id";

            $commentData = $DB->RunSelectQuery($sql);
            $total_comments_number = count($commentData);
//
            $sql = "Select * from comments where event_id=$userEvent_id order by id desc limit 0,3";
            $stmt = $DB->RunSelectQuery($sql);
            ?>



<div id="commentsdisplay">
    <?
    if (count($stmt) > 0) {
        foreach ($stmt as $commentData) {
            $result =(array)$commentData;
            ?>
            <div>

                            <div style="display:inline-block; vertical-align:top; width:35px">
                                <?
                                $user_id = $result["user_id"];
                                $sql2 = "SELECT * from public_users where id= $user_id";
                                $Data = $DB->RunSelectQuery($sql2);
                               foreach ($Data as $resultData) {
                                   $resultuser =(array)$resultData;
                                    $profilepic = $resultuser['profile_pic'];
                                    $user_name = $resultuser['firstname'] . " " . $resultuser['lastname'];
                                    if ($profilepic == "") {
                                        ?>
                                        <img width="30" height="30" valign="middle"
                                             style="border-radius:100px" src="images/no_profile_pic.gif"/>
                                    <? } else { ?>
                                        <img width="30" height="30" valign="middle"
                                             style="border-radius:100px"
                                             src="<? echo ROOTURL .'/'. $profilepic; ?>"/>
                                    <? }
                                } ?>
                            </div>


                            <div style="display:inline-block; width:10px; vertical-align:top;">

                                <img src="images/speech_triangle.gif" width="10"/></div>


                            <div style="display:inline-block;">
                                <div style="height:5px"></div>
                                <div style="background:#FFFAEA; border-radius:0px 3px 3px 3px; padding:5px"
                                     id="comment_content<?= $result["id"] ?>"><font
                                            class="ArialVeryDarkGreyBold15"><? echo $user_name; ?></font>
                                    <font class="ArialVeryDarkGrey15"> <? echo $result["comment"] ?></font><br/>
                                    <div style="display:inline-block;"><font class="ArialVeryDarkGrey15"
                                                                             style="color:#999; font-size:13px"> <?= date("j M", strtotime($result["entry_date"])) ?>
                                            , <?= date("h:i a", strtotime($result["entry_date"])) ?></font>
                                    </div>&nbsp;&nbsp;
                                    <div style="display:inline-block; cursor:pointer" onclick="delete_comment(<?=$result["id"] ?>, '<?=$user_name ?>')"><font class="ArialVeryDarkGrey15" style="color:#F63; font-size:13px">Delete</font>
                                    </div>
                                </div>
                            </div>


            </div>
            <?
        }
    } else { ?>
        <div style="height:40px; width:100% margin: 0 auto; text-align:center">
            <div style="height:20px"></div>
            <font class="ArialVeryDarkGrey15">No comments yet...</font></div>
        <?
    }
    ?>
</div>

</div>
<input type="hidden" value="<?= count($stmt) ?>" id="comments_number"/>
<input type="hidden" value="<?= $total_comments_number ?>" id="total_comments_number"/>
<div id="comments_display_progress"> <?
if ($total_comments_number > 3) {
    ?><font class="ArialVeryDarkGrey15" style="color:#999">Showing <?= count($stmt) ?>
    of <?= $total_comments_number ?> comments | </font>
    <div style="display:inline-block" onclick="add_comments()"><font class="ArialVeryDarkGrey15"
                                                                     style="color:#09C">See more
            comments</font></div>    <?
}

}
?></div>
</div>

</div>


</body>
</html>