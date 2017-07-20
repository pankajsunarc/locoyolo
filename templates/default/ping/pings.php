<?php
include_once(TEMPPATH . "/header.php");

?>
<script>
    function cancelping(id){

        //POST BY AJAX TO DISPLAY EVENTS IN MAP LIST
        $.ajax({
            type: "POST",
            url: "<?php echo createURL('index.php', 'mod=ajax&do=cancel_ping');?>",
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

<div style="height:95px"></div>
<?php
function limit_text($text, $limit) {
    if (str_word_count($text, 0) > $limit) {
        $words = str_word_count($text, 2);
        $pos = array_keys($words);
        $text = substr($text, 0, $pos[$limit]) . '...';
    }
    return $text;
}


$userid = $_REQUEST['userid'];

$status = "Confirmed";
$sql = "Select * from buddies where user_id= $userid and status='$status'";
$buddiesData = $DB->RunSelectQuery($sql);
$buddies_count = count($buddiesData);

$today = date("Y-m-d");
$sql = "Select * from event_bookings where user_id=$userid and booking_status='$status' and start_date>'$today'";
$booingData = $DB->RunSelectQuery($sql);
$event_attended_count = count($booingData);

$event_status = "L";
$sql = "Select * from events where event_status='$event_status' and user_id=$userid and entry_type=''";
$eventsData = $DB->RunSelectQuery($sql);
$event_organised_count = count($eventsData);

$current_user_id = $user_id;

$sql = "Select * from public_users where id=$userid";
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
            <td align="left" valign="middle"><font class="ArialVeryDarkGrey25"><?php echo $resultuser["firstname"]." ".$resultuser["lastname"]; ?>
                    <?php
                    if(isset($user_id)) {
                        if ($current_user_id == $user_id){ ?>
                            <div style="height:10px"></div>
                            <div onClick="location.href='<?php echo CreateURL('index.php',"mod=user&do=editprofile");?>'" style="width:70px;" class="slimbuttonblue">Edit profile</div>
                        <?php } } ?>
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
        <? echo $event_organised_count; ?></span><br>
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
        <td class="ArialOrange18">Pings<br>
            <br></td>
    </tr>
    <tr>
        <td>
            <? $event_attended = "Y";
            $entry_type = "Ping";
            $sql = "Select * from events where user_id=$userid and entry_type='$entry_type'";
            $eventData = $DB->RunSelectQuery($sql);
            $i=1;
            if (count($eventData)>0){
            foreach($eventData as $result_events_organised){
            $result_events_organised = (array) $result_events_organised;
            ?>

            <div style="display:inline-block; width:265px"><table width="250" border="0" cellpadding="3" cellspacing="0" class="tableorangebordernopadding">
                    <tr>
<!--                        <td align="center" valign="top" style="padding:8px"><img width="240" src="--><?php //echo ROOTURL;?><!--/--><?php //echo $result_events_organised["event_photo"] ?><!--" /></td>-->
                    </tr>
                    <tr>
                        <td height="50" valign="middle" style="padding:8px"><font class="ArialVeryDarkGreyBold18">
                                <a href='<?php echo createURL('index.php', "mod=ping&do=pingdetails&eventid=".$result_events_organised["event_id"]);?>

'>
                                <?=$result_events_organised["event_name"] ?>
                                </a>
                            </font></td>
                    </tr>
                    <tr>
                        <td valign="top" style="padding:8px"><div style="height:5px"></div>
                            <font class="ArialVeryDarkGrey15">
                                <?=date("j F Y", strtotime($result_events_organised["start_date"])) ?>
                            </font><font class="ArialVeryDarkGrey15"> | <? echo date("g:ia", strtotime($result_events_organised["start_time"])); ?></font>
                            <div style="height:5px"></div>
                            <font class="ArialVeryDarkGrey15"><strong>
                                    <?php $booking_status="Confirmed";
                                    $sql = "SELECT * from event_bookings where event_id=".$result_events_organised["event_id"]." and booking_status='$booking_status'";
                                  $eventbookingData = $DB->RunSelectQuery($sql);
                                    echo count($eventbookingData);
                                    ?>
                                </strong> people attending</font>
                            <?php $sql = "SELECT * from ping_locations where event_id=".$result_events_organised["event_id"];
                            $pinglocationData = $DB->RunSelectQuery($sql);
                            foreach( $pinglocationData as $resultloc){
                                $resultloc = (array)$resultloc;
                                ?>
                                <div style="height:5px"></div>
                                <font class="ArialVeryDarkGrey15" style="color:#666">
                                    <?=$resultloc["event_location"] ?>
                                </font>
                            <? } ?>
                            <div style="height:5px"></div></td>
                    </tr>
                    <? if ($current_user_id == $userid) { ?>
                    <tr>
                        <td valign="top" bgcolor="#EAEAEA"><table align="center" cellpadding="1" cellspacing="3">
                                <tr>
                                    <td width="60"><? if ($result_events_organised["event_status"] == "L") { ?><div id="pingstatus<?=$result_events_organised["event_id"] ?>"><div onClick="cancelping(<?=$result_events_organised["event_id"] ?>)" style="width:100px" class="slimbutton">Cancel meetup</div></div>
                                        <? } else if ($result_events_organised["event_status"] == "C") { ?>
                                            <font class="ArialVeryDarkGreyBold15">Cancelled</font>
                                        <? } ?>
                                    </td>
                                </tr>
                                <? } ?>
                            </table></td>
                    </tr>
                </table>
                <br></div>
            <?php $i++;
            if ($i%4 == 0){ ?>
        </td></tr><tr> <td>
            <?php $i=1; } }
            }else {
                ?>
                <font class="ArialVeryDarkGrey15">Nothing pinged yet...</font>
            <? } ?>
        </td>
    </tr></table>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>

</body>
</html>
