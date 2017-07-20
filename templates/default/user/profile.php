<?php
include_once(TEMPPATH . "/header.php");
if($_GET["userid"])
{
    $userid = $_GET["userid"];
}else
{
    $userid = $user_id;
}

?>
<script>
    $(document).ready(function() {

        // Get the modal
        var canceleventpopup = document.getElementById('canceleventpopup');
        // Get the modal
        var cancelbookingpopup = document.getElementById('cancelbookingpopup');
        // Get the button that closes the modal
        var rejectcancelbutton = document.getElementById("rejectcancelbutton");
        // Get the button that opens the modal
        var cancelconfirmbutton = document.getElementById("cancelconfirmbutton");
        // Get the button that closes the modal
        var rejectcancelbookingbutton = document.getElementById("rejectcancelbookingbutton");
        // Get the button that opens the modal
        var cancelbookingconfirmbutton = document.getElementById("cancelbookingconfirmbutton");
        // Get the button that closes the modal

        var close_cancelpopup = document.getElementById("close_cancelpopup");
        close_cancelpopup.style.display = "none";

        rejectcancelbutton.onclick = function() {
            canceleventpopup.style.display = "none";
        }
        rejectcancelbookingbutton.onclick = function() {
            cancelbookingpopup.style.display = "none";
        }

        close_cancelpopup.onclick = function() {
            canceleventpopup.style.display = "none";
            document.getElementById('cancel_modal_btn_display_end').style.display="none";
            document.getElementById('cancel_modal_btn_display_start').style.display="block";
        }
        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == canceleventpopup) {
                canceleventpopup.style.display = "none";
            }
            if (event.target == cancelbookingpopup) {
                cancelbookingpopup.style.display = "none";
            }
        }

        cancelconfirmbutton.addEventListener('click', function() {
            var id = document.getElementById("section_id").value;
            //POST BY AJAX TO DISPLAY EVENTS IN MAP LIST
            $.ajax({
                type: "POST",
                url: "<?php echo createURL('index.php', "mod=ajax&do=cancel_event");?>",
                data: { event_id:id },
                //dataType: 'json',
                cache: false,
                success: function(data)
                {
                    if(data == 'Y') {

                        $('#eventstatus'+id).html('<br>&nbsp;&nbsp;&nbsp;The event has been cancelled.');
                    } else {
                       alert('Sorry! Not able to cancel right now');
                    }
                    document.getElementById('cancel_modal_btn_display_end').style.display="block";
                    document.getElementById('cancel_modal_btn_display_start').style.display="none";
                    $('#eventstatus'+id).html('<font class="ArialVeryDarkGreyBold15">Cancelled</font>');
                    $('#eventstatus'+id).attr('onclick','');
                    $('#confirm_delete_event_content').html('<br>&nbsp;&nbsp;&nbsp;The event has been cancelled.');
                }
            });
        });

        cancelbookingconfirmbutton.addEventListener('click', function() {
            var id = document.getElementById("section_id").value;
            var userid = "<?php echo  $userid ; ?>";
            //POST BY AJAX TO DISPLAY EVENTS IN MAP LIST
            $.ajax({
                type: "POST",
                url: "<?php echo  createURL('index.php', "mod=ajax&do=cancel_booking");?>",
                data: { event_id:id, user_id: userid },
                //dataType: 'json',
                cache: false,
                success: function(data)
                {

                    if(data == 'Y') {

                        $('#bookingstatus'+id).html('<font class="ArialVeryDarkGreyBold15">Cancelled</font>');
                    } else {
                        alert('Sorry! Not able to cancel right now');
                    }

                    document.getElementById('cancel_booking_modal_btn_display_start').style.display="none";
                     $('#confirm_cancel_booking_content').html('<br>&nbsp;&nbsp;&nbsp;Your booking has been cancelled.');
                }
            });
        });
    });

    function cancel_event(id){
        document.getElementById("eventname").value = document.getElementById("eventname"+id).value;
        document.getElementById("eventphoto").value = document.getElementById("eventphoto"+id).value;
        document.getElementById("eventdatetime").value = document.getElementById("eventdatetime"+id).value;
        document.getElementById("eventlocation").value = document.getElementById("eventlocation"+id).value;
        document.getElementById("section_id").value = id;

        var eventname = document.getElementById("eventname").value;
        var eventphoto = document.getElementById("eventphoto").value;
        var eventdatetime = document.getElementById("eventdatetime").value;
        var eventlocation = document.getElementById("eventlocation").value;

        if ($("#profile_mobile").css('display') == 'block'){
            document.getElementById("cancel_event_modal").style.width = "300px";
        }

        $('#confirm_delete_event_content').html('<table width="100%" style="padding:5px"><tr><td colspan="3">Please confirm that you want to cancel:<br><br></td></tr><td width="35%"><img src="'+eventphoto+'" width="100%" style="vertical-align:middle"></td><td width="5%"></td><td><font style="ArialVeryDarkGrey15"><strong>'+eventname+'</strong><br>'+eventdatetime+'<br><font style="font-size:13px">'+eventlocation+'</font></font></td></tr></table>');
        canceleventpopup.style.display = "block";
    }

    function cancel_booking(id){
        document.getElementById("eventname").value = document.getElementById("eventname"+id).value;
        document.getElementById("eventphoto").value = document.getElementById("eventphoto"+id).value;
        document.getElementById("eventdatetime").value = document.getElementById("eventdatetime"+id).value;
        document.getElementById("eventlocation").value = document.getElementById("eventlocation"+id).value;
        document.getElementById("section_id").value = id;

        var eventname = document.getElementById("eventname").value;
        var eventphoto = document.getElementById("eventphoto").value;
        var eventdatetime = document.getElementById("eventdatetime").value;
        var eventlocation = document.getElementById("eventlocation").value;

        if ($("#profile_mobile").css('display') == 'block'){
            document.getElementById("cancel_booking_modal").style.width = "300px";
        }

        $('#confirm_cancel_booking_content').html('<table width="100%" style="padding:5px"><tr><td colspan="3">Do you want to cancel your booking for:<br><br></td></tr><td width="35%"><img src="'+eventphoto+'" width="100%" style="vertical-align:middle"></td><td width="5%"></td><td><font style="ArialVeryDarkGrey15"><strong>'+eventname+'</strong><br>'+eventdatetime+'<br><font style="font-size:13px">'+eventlocation+'</font></font></td></tr></table>');
        cancelbookingpopup.style.display = "block";
    }
</script>
<style>
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
</style>
</head>

<body>
<div style="height:65px"></div>
<input type="hidden" id="eventname" value="">
<input type="hidden" id="eventphoto" value="">
<input type="hidden" id="eventdatetime" value="">
<input type="hidden" id="eventlocation" value="">
<input type="hidden" id="section_id" value="">
<!-- The Cancel Event Modal -->
<div id="canceleventpopup" class="modal" >

    <!-- Modal content -->
    <div class="modal-content" id="cancel_event_modal" style="width:400px; padding:10px">
        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
                <td height="10"></td>
            </tr>
            <tr>
                <td height="20" class="ArialOrange18">&nbsp;&nbsp;Cancel event<br /></td>
            </tr>
            <tr>
                <td class="ArialVeryDarkGrey15">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td><div id="confirm_delete_event_content">&nbsp;&nbsp;&nbsp;Please confirm that you want to cancel:</div></td>
                        </tr>
                        <tr>
                            <td align="right"><div id="cancel_modal_btn_display_end">
                                    <input class="standardgreybutton" style="cursor:pointer" type="submit" id="close_cancelpopup" value="Ok" />
                                </div>
                                <div id="cancel_modal_btn_display_start"><input class="standardbutton" style="cursor:pointer" type="submit" id="cancelconfirmbutton" name="cancelconfirmbutton" value="Yes" />&nbsp;&nbsp;
                                    <input class="standardgreybutton" style="cursor:pointer" type="submit" id="rejectcancelbutton" value="No" /></div>
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


<!-- The Cancel Booking Modal -->
<div id="cancelbookingpopup" class="modal" >

    <!-- Modal content -->
    <div class="modal-content" id="cancel_booking_modal" style="width:400px; padding:10px">
        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
                <td height="10"></td>
            </tr>
            <tr>
                <td height="20" class="ArialOrange18">&nbsp;&nbsp;Cancel booking<br /></td>
            </tr>
            <tr>
                <td class="ArialVeryDarkGrey15">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td><div id="confirm_cancel_booking_content">&nbsp;&nbsp;&nbsp;Do you want to cancel your booking for:</div></td>
                        </tr>
                        <tr>
                            <td align="right"><div id="cancel_booking_modal_btn_display_start"><input class="standardbutton" style="cursor:pointer" type="submit" id="cancelbookingconfirmbutton" name="cancelconfirmbutton" value="Yes" />&nbsp;&nbsp;
                                    <input class="standardgreybutton" style="cursor:pointer" type="submit" id="rejectcancelbookingbutton" value="No" /></div>
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

<?php
function limit_text($text, $limit)
{
    if (str_word_count($text, 0) > $limit) {
        $words = str_word_count($text, 2);
        $pos   = array_keys($words);
        $text  = substr($text, 0, $pos[$limit]) . '...';
    }
    return $text;
}


$status        = "Confirmed";
$sql           = "Select * from buddies where user_id=$userid and status='$status'";
$result        = $DB->RunSelectQuery($sql);
if(!is_array($result))
{
    $result=array();
}
$buddies_count = count($result);

$today                = date("Y-m-d");
$sql                  = "Select * from event_bookings where user_id=$userid and booking_status='$status' and start_date>$today";
$result  = $DB->RunSelectQuery($sql);
if(!is_array($result))
{
    $result = array();
}
$event_attended_count = count($result);

$event_status          = "L";
$sql                   = "Select * from events where event_status='$event_status' and user_id=$userid and entry_type=''";
$result                = $DB->RunSelectQuery($sql);
if(!is_array($result))
{
    $result = array();
}
$event_organised_count = count($result);

$current_user_id = $user_id;

$sql    = "Select * from public_users where id=$userid";
$result = $DB->RunSelectQuery($sql);
foreach ($result as $resultuser) {
    $resultuser    = (array) $resultuser;
    $firstname = $resultuser["firstname"];
    if ($resultuser["profile_pic"] == "") {
        $profile_pic = ROOTURL . "/images/no_profile_pic.gif";
    } else {
        $profile_pic = ROOTURL . '/' . $resultuser["profile_pic"];
    }
?>
<div class="display860">
    <p></p>
    <table width="820" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
            <td width="120" align="left" valign="top"><img width="120" height="120" style="border-radius:60px" src="<?
    echo $profile_pic;
?>" /></td>
            <td width="20" align="left" valign="top">&nbsp;</td>
            <td align="left" valign="middle"><font class="ArialVeryDarkGrey25"><?
    echo $resultuser["firstname"] . " " . $resultuser["lastname"];
?>

                    <?
    if (isset($_SESSION["login_user"])) {
        if ($current_user_id == $resultuser["id"]) {
?>
                            <div class="col"><?
                                echo $resultuser["mood_statement"];
                                ?> </div>

                            <div onClick="location.href='<?php echo createURL('index.php', "mod=user&do=editprofile");
                            ?>'" style="width:70px;" class="slimbuttonblue">Edit profile</div>
                        <?
        }
    }
?>
                    <br />

            </td>
            <td width="100" align="center" valign="middle"><span class="ArialOrange18" style="font-size:30px">
        <?
    echo $buddies_count;
?>
        </span><br>
                <span class="ArialVeryDarkGrey15">buddies<br>
 &nbsp; </span></td>
            <td width="100" align="center" valign="middle"><span class="ArialOrange18" style="font-size:30px">
        <?
    echo $event_attended_count;
?></span><br>
                <span class="ArialVeryDarkGrey15">event(s)<br>
        booked
        </span></td>
            <td width="100" align="center" valign="middle"><span class="ArialOrange18" style="font-size:30px">
        <?
    echo $event_organised_count;
?></span><br>
                <span class="ArialVeryDarkGrey15">event(s)<br>
          organised
</span></td>
        </tr>
    </table>
<!--    --><? // } 
?>
    <p>&nbsp;</p>
    <table width="820" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
            <td></td>
        </tr>
        <tr>
            <td class="ArialOrange18"><?= $firstname ?> has...<br><br></td>
        </tr>
		<?php
    $event_attended  = "Y";
    $sql             = "Select * from event_bookings where id=$userid and event_attended='$event_attended'";
    $result          = $DB->RunSelectQuery($sql);
        if(!is_array($result))
        {
            $result = array();
        }
    $event_id_string = "";
    foreach ($result as $result_events_attended) {
        $result_events_attended = (array) $result_events_attended;
        $event_id_string .= $result_events_attended["event_id"] . ", ";
    }
    
    $event_id_string = substr($event_id_string, 0, -2);
    if( $event_id_string ){
    $sql    = "Select * from events where event_id=(:$event_id_string) order by start_date desc";
    $result = $DB->RunSelectQuery($sql);
    
    if (is_array($result) && count($result) > 0) {
        foreach ($result as $result_events_attended) {
            $result_events_attended = (array) $result_events_attended;
?>
                <tr>
                    <td><font class="ArialVeryDarkGrey15"><?php
            $result_events_attended["achievement_stmt"];
?></font></td>
                </tr>
				<?
        }
    } else {
?>
            <tr>
                <td><font class="ArialVeryDarkGrey15">Not attended any events yet...<a href="<?php echo ROOTURL;?>">Find stuff to do!</a></font></td>
            </tr>
			<?
    }
    }
    else { ?>
        <tr>
            <td><font class="ArialVeryDarkGrey15">Not attended any events yet...<a href="<?php echo ROOTURL;?>">Find stuff to do!</a></font></td>
        </tr>
    <?php }
?>
    </table>
    <p>&nbsp;</p>
    <table width="820" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
            <td></td>
        </tr>
        <tr>
            <td class="ArialOrange18">Events booked<br>
                <br></td>
        </tr><tr>
            <td>
			<?php
    $status="Confirmed";
    $today  = date("Y-m-d");
    //$sql4 = "Select * from event_bookings where user_id=? and start_date > ? limit 10";
    $sql4   = "Select * from event_bookings where user_id=$userid and start_date >= $today and booking_status='$status'";
    $result = $DB->RunSelectQuery($sql4);
    if(!is_array($result))
    {
        $result=array();
    }
    
    $i      = 1;
    if (is_array($result)&& count($result) > 0) {
        foreach ($result as $result_events_booked) {
            $result_events_booked = (array) $result_events_booked;
            $sql                  = "Select * from events where event_id=" . $result_events_booked["event_id"];
            $result               = $DB->RunSelectQuery($sql);
            foreach ($result as $result_event) {
                $result_event = (array) $result_event;
?>
                            <input type="hidden" id="eventname<?= $result_event["event_id"] ?>" value="<?= $result_event["event_name"] ?>">
                            <input type="hidden" id="eventphoto<?= $result_event["event_id"] ?>" value="<?php
                echo ROOTURL . '/' . $result_event["event_photo"];
?>">
                            <input type="hidden" id="eventdatetime<?= $result_event["event_id"] ?>" value="<?= date("j F Y", strtotime($result_event["start_date"])) ?> | <?= date("g:ia", strtotime($result_event["start_time"])) ?>">
                            <input type="hidden" id="eventlocation<?= $result_event["event_id"] ?>" value="<?= $result_event["event_location"] ?>">
                            <div style="display:inline-block; width:260px">
                                <table width="250" border="0" cellpadding="3" cellspacing="0" class="tableorangebordernopadding">
                                    <tr>
                                        <td align="center" valign="top" style="padding:8px"><img width="240" src="<?php
                echo ROOTURL . '/' . $result_event["event_photo"];
?>" /></td>
                                    </tr>
                                    <tr>
                                        <td height="50" valign="top" style="padding:8px"><div style="height:5px"></div>
                                            <a href='<?php echo createURL('index.php', "mod=event&do=eventdetails?eventid=". $result_event["event_id"]);
                                            ?>'>
                                                <font class="ArialVeryDarkGreyBold18">
<!--                                                    --><?php
                $str = wordwrap($result_event["event_name"], 50);
                $str = explode("\n", $str);
                $str = $str[0] . '...';
                echo $str;
?>
                                                </font>

                                            </a>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding:8px" valign="top"><div style="height:5px"></div>
                                            <font class="ArialVeryDarkGrey15">
                                                <?= date("j F Y", strtotime($result_event["start_date"])) ?>
                                            </font><font class="ArialVeryDarkGrey15"> | <?
                echo date("g:ia", strtotime($result_event["start_time"])) . " - " . date("g:ia", strtotime($result_event["end_time"]));
?></font><font class="ArialVeryDarkGrey15">&nbsp;
                                            </font>
                                            <div style="height:5px"></div>
                                            <font class="ArialVeryDarkGrey15"><strong>
											<?php // $booking_status="Confirmed";
                $sql    = "SELECT * from event_bookings where event_id=" . $result_event["event_id"] . " and booking_status='$booking_status'";
                $result = $DB->RunSelectQuery($sql);
                echo count($result);
?>
                                                </strong> people attending
                                            </font>
											
											<?php
                $sql    = "SELECT * from event_locations where event_id=" . $result_event["event_id"];
                $result = $DB->RunSelectQuery($sql);
                foreach ($result as $resultloc) {
                    $resultloc = (array) $resultloc;
?>
                                                <div style="height:5px"></div>
                                                <font class="ArialVeryDarkGrey15" style="color:#666">
                                                    <?= $resultloc["event_location"] ?>
                                                </font>
<?php
                }
?>
                                            <div style="height:5px"></div>
                                            <font class="ArialVeryDarkGrey15"><strong>Booking status: </strong>
                                                <?= $result_events_booked["booking_status"] ?>
                                            </font></td>
                                    </tr>
                                    <?
                if ($current_user_id == $userid) {
?>
                                    <tr>
                                        <td height="30" valign="top" bgcolor="#EAEAEA"><table align="center" cellpadding="1" cellspacing="3"> <?
                    if ($current_user_id == $userid) {
?>
                                                    <tr>
                                                        <td width="60"><div id="bookingstatus<?= $result_event["event_id"] ?>"><div onClick="cancel_booking(<?= $result_event["event_id"] ?>)" style="width:100px" class="slimbutton">Cancel booking</div></div></td>
                                                    </tr>
                                                <?
                    }
                }
?>
                                            </table></td>
                                    </tr>
                                </table>
                                <br></div>
								<?php
            }
            
            $i++;
            if ($i % 3 == 0) {
                $i = 1;
            }
        }
    } else {
?>
            </td>
        </tr><tr><td><font class="ArialVeryDarkGrey15">No upcoming events booked...<a href="<?php echo ROOTURL;?>">Find stuff to do!</a></font>
            </td></tr>
	<?php
    }
?>
    </table><?php
    if (count($result)> 10) {
?><div style="text-align:center"><input class="standardbutton" style="cursor:pointer" type="submit" name="submit" id="submit" value="More events booked"></div><?
    }
?>
    <p>&nbsp;</p>
    <table width="820" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
            <td></td>
        </tr>
        <tr>
            <td class="ArialOrange18">Events organised&nbsp;&nbsp;
			<?php
    $event_attended = "Y";
    $sql            = "Select * from events where user_id=$userid and entry_type='' limit 6";
    $result         = $DB->RunSelectQuery($sql);
    if(!array($result))
    {
        $result = array();
    }

    if (count($result) >= 6) {
?>
                    <div class="standardbutton" style=" min-width:120px; display:inline-block" onClick="location.href='<?php echo createURL('index.php', "mod=event&do=events&userid=".$userid);?>'">See all <strong>
                           <?php        echo count($result);?></strong> events</div>
					<?php
    }
?>
                <br><br></td>
        </tr>
        <tr>
            <td>
                <?php
    $i = 1;
    if (is_array($result) && count($result) > 0) {
        foreach ($result as $result_events_organised) {
            $result_events_organised = (array) $result_events_organised;
            
?>
                <div style="display:inline-block; width:265px">
                    <table width="250" border="0" cellspacing="0" class="tableorangebordernopadding">
                        <tr>
                            <td align="center" valign="top" style="padding:8px"><img width="240" src="<?php
            echo ROOTURL . '/' . $result_events_organised["event_photo"];
?>" /></td>
                        </tr>
                        <tr>
                            <td style="padding:8px" height="50" valign="middle">
                                <a href='
<?php echo createURL('index.php', "mod=event&do=eventdetails&eventid=".$result_events_organised["event_id"]);
?>'

                                    <font class="ArialVeryDarkGreyBold18">
										 <?php
            $str = wordwrap($result_events_organised["event_name"], 50);
            $str = explode("\n", $str);
            $str = $str[0] . '...';
            echo $str;
?>
                                    </font></a></td>
                        </tr>
                        <tr>
                            <td style="padding:8px" valign="top"><div style="height:5px"></div>
                                <font class="ArialVeryDarkGrey15">
                                    <?= date("j F Y", strtotime($result_events_organised["start_date"])) ?></font><font class="ArialVeryDarkGrey15"> | <?
            echo date("g:ia", strtotime($result_events_organised["start_time"])) . " - " . date("g:ia", strtotime($result_events_organised["end_time"]));
?></font><div style="height:5px"></div>
                                <font class="ArialVeryDarkGrey15"><strong>
								<? // $booking_status="Confirmed";
            $sql    = "SELECT * from event_bookings where event_id=" . $result_events_organised["event_id"] . " and booking_status='$booking_status'";
            $result = $DB->RunSelectQuery($sql);
            echo count($result);
?>
                                   </strong> people attending</font>
								   <?php
            $sql    = "SELECT * from event_locations where event_id=" . $result_events_organised["event_id"];
            $result = $DB->RunSelectQuery($sql);
            foreach ($result as $resultloc) {
                $resultloc = (array) $resultloc;
?>
                                    <div style="height:5px"></div>
                                    <font class="ArialVeryDarkGrey15" style="color:#666; font-size:13px"><?php
                echo $resultloc["event_location"];
?></font>
                                <?php
            }
?>
                                <div style="height:5px"></div></td>
                        </tr>
                        <?php
            if ($current_user_id == $userid) {
?>
                        <tr>
                            <td height="30" valign="middle" bgcolor="#EAEAEA"><table align="center" cellpadding="1" cellspacing="3">
                                    <tr>
                                        <td width="60" align="center"><div onClick="location.href='<?php
                echo createURL('index.php', "mod=event&do=edit&eventid=" . $result_events_organised["event_id"]);
?>'" style="width:60px" class="slimbuttonblue">Edit event</div></td>
                                        <td width="60" align="center"><div onClick="location.href='<?php
                echo createURL('index.php', "mod=event&do=participants&eventid=" . $result_events_organised["event_id"]);
?>'" style="width:110px" class="slimbutton">Check participants</div></td>
                                    </tr>
                                    <?
            } else {
?>
                                    <tr>
                                        <td height="30" valign="middle" bgcolor="#EAEAEA"><table align="center" cellpadding="1" cellspacing="3">
                                                <tr>
                                                    <td width="60" align="center"><div onClick="<?php
                echo createURL('index.php', "mod=event&do=participants&eventid=" . $result_events_organised["event_id"]);
?>" style="width:110px" class="slimbutton">See participants</div></td>
                                                </tr>
                                                <?
            }
?>
                                            </table></td>
                                    </tr>
                                </table><br></div>
<?php
            $i++;
            if ($i % 4 == 0) {
?>
            </td></tr><tr> <td>
   <?php
                $i = 1;
            }
        }
    } else {
?>
                    <font class="ArialVeryDarkGrey15">No events organised yet...</font>
			<?php
    }
?>
            </td>
        </tr>
    </table>

    <p>&nbsp;</p>
    <table width="820" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
            <td></td>
        </tr>
        <tr>
            <td class="ArialOrange18">Pings&nbsp;&nbsp;
			 <?php
    $event_attended = "Y";
    $entry_type     = "Ping";
    $sql            = "Select * from events where user_id=$userid and entry_type='" . $entry_type . "' limit 6";
    $result         = $DB->RunSelectQuery($sql);
    if(!is_array($result))
    {
        $result = array();
    }
    if (count($result) > 0) {
?>
                    <div class="standardbutton" onClick="location.href='<?php echo createURL('index.php', "mod=ping&do=pings&userid=".$userid);?>'">See all <strong><?php echo count($result);?></strong> pings</div>
               <?php
    }
?><br>
                <br></td>
        </tr>
        <tr>
            <td>
			<?php
    $i = 1;
    if (count($result) > 0) {
        foreach ($result as $result_events_organised) {
            $result_events_organised = (array) $result_events_organised;
?>

                <div style="display:inline-block; width:265px"><table width="250" border="0" cellpadding="3" cellspacing="0" class="tableorangebordernopadding">
                        <tr>
                            <td align="center" valign="top" style="padding:8px"><img width="240" src="<?php
            echo ROOTURL.'/'. $result_events_organised["event_photo"];
?>" />
                                <input type="hidden" id="eventname<?= $result_events_organised["event_id"] ?>" value="<?= $result_events_organised["event_name"] ?>">
                                <input type="hidden" id="eventphoto<?= $result_events_organised["event_id"] ?>" value="<?php
            echo ROOTURL.'/'. $result_events_organised["event_photo"];
?>">
                                <input type="hidden" id="eventdatetime<?= $result_events_organised["event_id"] ?>" value="<?= date("j F Y", strtotime($result_events_organised["start_date"])) ?> | <?= date("g:ia", strtotime($result_events_organised["start_time"])) ?>">
                                <input type="hidden" id="eventlocation<?= $result_events_organised["event_id"] ?>" value="<?= $result_events_organised["event_location"] ?>">
                            </td>
                        </tr>
                        <tr>
                            <td height="50" valign="middle" style="padding:8px">
                                <a href='<?php echo createURL('index.php', "mod=ping&do=pingdetails&eventid=".$result_events_organised["event_id"]);?>

'>
                                    <font class="ArialVeryDarkGreyBold18">
                                        <?= $result_events_organised["event_name"] ?>
                                    </font>
                                </a>

                            </td>
                        </tr>
                        <tr>
                            <td valign="top" style="padding:8px"><div style="height:5px"></div>
                                <font class="ArialVeryDarkGrey15">
                                    <?= date("j F Y", strtotime($result_events_organised["start_date"])) ?>
                                </font><font class="ArialVeryDarkGrey15"> | <?
            echo date("g:ia", strtotime($result_events_organised["start_time"]));
?></font>
                                <div style="height:5px"></div>
                                <font class="ArialVeryDarkGrey15"><strong>
								 <?php // $booking_status="Confirmed";
            $sql    = "SELECT * from event_bookings where event_id=" . $result_events_organised["event_id"] . " and booking_status='" . $booking_status . "'";
            $result = $DB->RunSelectQuery($sql);
            echo count($result);
?>
                                    </strong> people attending</font>
									<?php
            $sql    = "SELECT * from ping_locations where event_id=" . $result_events_organised["event_id"];
            $result = $DB->RunSelectQuery($sql);
            foreach ($result as $resultloc) {
                $resultloc = (array) $resultloc;
?>
                                   <div style="height:5px"></div>
                                    <font class="ArialVeryDarkGrey15" style="color:#666; font-size:13px">
                                      <?php
                echo $resultloc["event_location"];
?>
                                   </font>
                               <?php
            }
?>
                                <div style="height:5px"></div></td>
                        </tr>
						<?php
            if ($current_user_id == $userid) {
?>
                        <tr>
                            <td valign="top" bgcolor="#EAEAEA"><table align="center" cellpadding="1" cellspacing="3">
                                    <tr>
                                        <td width="60">
                                           <?php
                if ($result_events_organised["event_status"] == "L") {
?> <div id="eventstatus<?php
                    echo $result_events_organised["event_id"];
?>"
                                                <div onclick="cancel_event(<?= $result_events_organised["event_id"] ?>)" style="width:100px" class="slimbutton">Cancel meetup</div></div>
                                            <?
                } else if ($result_events_organised["event_status"] == "C") {
?>
                                                <font class="ArialVeryDarkGreyBold15">Cancelled</font>
                                            <?
                }
?>
                                        </td>
                                    </tr>
                                 <?php
            }
?>
                                </table></td>
                        </tr>
                    </table>
                    <br></div>
					<?php
            $i++;
            if ($i % 4 == 0) {
?>
            </td></tr><tr> <td>
			<?php
                $i = 1;
            }
        }
    } else {
?>
                    <font class="ArialVeryDarkGrey15">Nothing pinged yet...</font>
					<?php
    }
?>
            </td>
        </tr></table>
</div>




 <?php
    $sql    = "Select * from public_users where id=" . $userid;
    $result = $DB->RunSelectQuery($sql);
    foreach ($result as $resultuser) {
        $resultuser    = (array) $resultuser;
        $firstname = $resultuser["firstname"];
        if ($resultuser["profile_pic"] == "") {
            $profile_pic = ROOTURL . "/images/no_profile_pic.gif";
        } else {
            $profile_pic =  ROOTURL.'/'.$resultuser["profile_pic"];
        }
    }
}
?>
<p>&nbsp;</p>
</body>
</html>