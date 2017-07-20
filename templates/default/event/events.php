<?php
include_once(TEMPPATH . "/header.php");
?>
<script>
    function cancelping(id){

        //POST BY AJAX TO DISPLAY EVENTS IN MAP LIST
        $.ajax({
            type: "POST",
            url: "<?php echo createURL('index.php', 'mod=ajax&do=cancel_event');?>",
            data: { event_id:id },
            //dataType: 'json',
            cache: false,
            success: function(data)
            {
                if(data == 'Y') {
                    result = data;
                    $('#pingstatus'+id).html('<font class="ArialVeryDarkGreyBold15">Cancelled</font>');
                } else {
                    alert("There is some problem while cancelling ping.");
                }

            }
        });
    }
</script>

</head>

<body>
<div style="height:95px"></div>
<?
function limit_text($text, $limit) {
    if (str_word_count($text, 0) > $limit) {
        $words = str_word_count($text, 2);
        $pos = array_keys($words);
        $text = substr($text, 0, $pos[$limit]) . '...';
    }
    return $text;
}
$userid = $_GET["userid"];
$status = "Confirmed";
$sql = "Select * from buddies where user_id=$userid and status='$status'";
$buddiesData = $DB->RunSelectQuery($sql);
$buddies_count = count($buddiesData);

$today = date("Y-m-d");
$sql = "Select * from event_bookings where user_id=$userid and booking_status='$status' and start_date>'$today'";
$eventData = $DB->RunSelectQuery($sql);
$event_attended_count = count($eventData);

$event_status = "L";
$sql = "Select * from events where event_status='$event_status' and user_id=$userid and entry_type=''";
$eventData = $DB->RunSelectQuery($sql);
$event_organised_count = count($eventData);
$current_user_id =$user_id;
$sql = "Select * from public_users where id=$current_user_id";
$userData = $DB->RunSelectQuery($sql);
foreach($userData as $resultuser){
    $resultuser = (array) $resultuser;
    $firstname = $resultuser["firstname"];
    if ($resultuser["profile_pic"] == ""){
        $profile_pic = ROOTURL."/images/no_profile_pic.gif";
    }else{
        $profile_pic = ROOTURL."/".$resultuser["profile_pic"];
    }
    ?>
    <p></p>
    <table width="820" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
            <td width="120" align="left" valign="top"><img width="120" height="120" style="border-radius:60px" src="<? echo $profile_pic; ?>" /></td>
            <td width="20" align="left" valign="top">&nbsp;</td>
            <td align="left" valign="middle"><font class="ArialVeryDarkGrey25"><? echo $resultuser["firstname"]." ".$resultuser["lastname"]; ?>
                    <?php
                    if(isset($user_id)) {
                        if ($current_user_id == $resultuser["id"]){ ?>
                            <div style="height:10px"></div>
                            <div onClick="location.href='<?php echo CreateURL('index.php',"mod=user&do=editprofile");?>'" style="width:70px;" class="slimbuttonblue">Edit profile</div>
                        <? } } ?>
                    <br />
                    <? echo $resultuser["mood_statement"]; ?>
            </td>
            <td width="100" align="center" valign="middle"><span class="ArialOrange18" style="font-size:30px">
        <?
        echo $buddies_count;
        ?>
        </span><br>
                <span class="ArialVeryDarkGrey15">buddies<br>
 &nbsp; </span></td>
            <td width="100" align="center" valign="middle"><span class="ArialOrange18" style="font-size:30px">
        <? echo $event_attended_count; ?></span><br>
                <span class="ArialVeryDarkGrey15">event(s)<br>
        attended
        </span></td>
            <td width="100" align="center" valign="middle"><span class="ArialOrange18" style="font-size:30px">
        <?php echo $event_organised_count; ?></span><br>
                <span class="ArialVeryDarkGrey15">event(s)<br>
          organised
</span></td>
        </tr>
    </table>
<? } ?>
<p>&nbsp;</p>
<table width="820" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
        <td></td>
    </tr>
    <tr>
        <td class="ArialOrange18">Events organised<br><br></td>
    </tr>
    <tr>
        <td>
            <? $event_attended = "Y";
            $sql = "Select * from events where user_id=$userid and entry_type=''";
            $eventData = $DB->RunSelectQuery($sql);
            $i=1;
            if (count($userData)>0){
            foreach($eventData as $result_events_organised ){
            $result_events_organised = (array) $result_events_organised;
            ?>
            <div style="display:inline-block; width:265px">
                <table width="250" border="0" cellspacing="0" class="tableorangebordernopadding">
                    <tr>
                        <td align="center" valign="top" style="padding:8px"><img width="240" src="<?php echo ROOTURL.'/'. $result_events_organised["event_photo"] ?>" /></td>
                    </tr>
                    <tr>
                        <td style="padding:8px" height="50" valign="middle"><font class="ArialVeryDarkGreyBold18">
                                <?
                                $str = wordwrap($result_events_organised["event_name"], 50);
                                $str = explode("\n", $str);
                                $str = $str[0] . '...';
                                echo $str;
                                ?>
                            </font></td>
                    </tr>
                    <tr>
                        <td style="padding:8px" valign="top"><div style="height:5px"></div>
                            <font class="ArialVeryDarkGrey15"><?php echo date("j F Y", strtotime($result_events_organised["start_date"])) ?></font><font class="ArialVeryDarkGrey15"> | <? echo date("g:ia", strtotime($result_events_organised["start_time"]))." - ".date("g:ia", strtotime($result_events_organised["end_time"])); ?></font><div style="height:5px"></div>
                            <font class="ArialVeryDarkGrey15"><strong>
                                    <?php $booking_status="Confirmed";
                                    $sql = "SELECT * from event_bookings where event_id=".$result_events_organised["event_id"]." and booking_status='$booking_status'";
                                  $eventbookingData = $DB->RunSelectQuery($sql);
                                    echo count($eventbookingData);
                                    ?>
                                </strong> people attending</font>
                            <?php $sql = "SELECT * from event_locations where event_id=".$result_events_organised["event_id"];
                            $eventlocation = $DB->RunSelectQuery($sql);
                            foreach($eventlocation as $resultloc){
                                $resultloc = (array) $resultloc;
                                ?>
                                <div style="height:5px"></div>
                                <font class="ArialVeryDarkGrey15" style="color:#666"><?php echo $resultloc["event_location"] ?></font>
                            <? } ?>
                            <div style="height:5px"></div></td>
                    </tr>
                    <? if ($current_user_id == $userid) { ?>
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
                                <? } else { ?>
                                <tr>
                                    <td height="30" valign="middle" bgcolor="#EAEAEA"><table align="center" cellpadding="1" cellspacing="3">
                                            <tr>
                                                <td width="60" align="center"><div onClick="location.href='http://www.locoyolo.com/participants.php?eventid=<?php echo $result_events_organised["event_id"] ?>'" style="width:110px" class="slimbutton">See participants</div></td>
                                            </tr>
                                            <? } ?>
                                        </table></td>
                                </tr>
                            </table><br></div>
            <? $i++;
            if ($i%4 == 0){ ?>
        </td></tr><tr> <td>
            <? $i=1; } }
            }else {
                ?>
                <font class="ArialVeryDarkGrey15">No events organised yet...</font>
            <? } ?>
        </td>
    </tr>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
</body>
</html>
