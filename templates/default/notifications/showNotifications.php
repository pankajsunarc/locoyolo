<?php
include_once(TEMPPATH . "/header.php");
?>
<script>
    function cancelping(id){

        //POST BY AJAX TO DISPLAY EVENTS IN MAP LIST
        $.ajax({
            type: "POST",
            url: "cancel_ping.php",
            data: { event_id:id },
            //dataType: 'json',
            cache: false,
            success: function(data)
            {
                if(data == 'OK') {
                    result = data;
                } else {
                    result = data;
                }
                $('#pingstatus'+id).html(result);
            }
        });
    }

    function confirm_add_buddy(id){

        var current_user_id = "<?php echo $user_id;?>";

        //POST BY AJAX TO DISPLAY EVENTS IN MAP LIST
        $.ajax({
            type: "POST",
            url: "<?php echo CreateURL('index.php',"mod=ajax&do=confirm_buddy");?>",
            data: { buddy_id:id, current_user_id:current_user_id },
            //dataType: 'json',
            cache: false,
            success: function(data)
            {
                if(data == 'OK') {
                    result = data;
                } else {
                    result = data;
                }
                $('#confirm_add_buddy_status'+id).html(result);
            }
        });
    }
</script>


<div style="height:95px"></div>
<?php
$email = $_SESSION['user_email'];
$sql = "SELECT * from public_users where email='$email'";
$query =$DB->RunSelectQuery($sql);
foreach ($query as $data){
    $result=(array)$data;
    $userid = $result["id"];
}


$status     = "Pending";
 $sql2       = "Select * from notifications where user_id='".$user_id . "' and status='".$status."'";
$resultData = $DB->RunSelectQuery($sql2);
if(!is_array($resultData))
{
    $resultData = array();
}
?>
<table width="820" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
        <td></td>
    </tr>
    <tr>
        <td class="ArialOrange18">Notifications<br>
            <br></td>
    </tr>
    <tr>
        <td class="ArialVeryDarkGreyBold18">New notifications (<?php
echo count($resultData);
?>)</td>
    </tr>

	<?php
$dateset = "";

if ($resultData > 0) {

    foreach ($resultData as $data) {
        $result = (array) $data;
        $date   = date("Y-m-d", strtotime($result["notification_date"]));
        if ($date !== $dateset) {
            $dateset = $date;
            echo '<tr><td height="30" valign="top"></td></tr>';
        }
?>
            <tr>
                <td height="25" valign="middle"><font class="ArialVeryDarkGrey15">
                        <?
        //IF NOTIFICATION TYPE IS A COMMENT
        if ($result["notification_type"] == "Comment") {
            $sql      = "Select * from events where event_id=" . $result["event_id"];
            $res_data = $DB->RunSelectQuery($sql);
            foreach ($res_data as $resulteventcomment) {
                $resulteventcomment = (array) $resulteventcomment;
                $event_name         = $resulteventcomment["event_name"];
                if ($resulteventcomment["entry_type"] == "") {
                    $event_type = "event";
                    $event_link = createURL('index.php', "mod=event&do=eventdetails&eventid=" . $resulteventcomment["event_id"]);
                } else if ($resulteventcomment["entry_type"] == "Ping") {
                    $event_type = "ping";
                    $event_link = createURL('index.php', "mod=ping&do=pingdetails&eventid=" . $resulteventcomment["event_id"]);
                }
            }

            $sql      = "Select * from public_users where id=" . $result["other_user_id"];
            $res_data = $DB->RunSelectQuery($sql);
            foreach ($res_data as $resultusercomment) {
                $resultusercomment = (array) $resultusercomment;
                $user_name = $resultusercomment["firstname"] . " " . $resultusercomment["lastname"];
            }
?>
                            <font style="color:#999; font-size:13px">
							<?php
            echo date("j F, H:i a", strtotime($result["notification_date"]));
?></font>&nbsp;&nbsp;&nbsp;
							<img src="<?php  echo ROOTURL; ?>/images/comment_box.gif" style="vertical-align:middle" />&nbsp;&nbsp;
							<a href="<?php
            echo createURL('index.php', "mod=user&do=profile&userid=" . $result["other_user_id"]);
?>" 
							style="color:#09C"><?php
            echo $user_name;
?></a> has commented on the <?php
            echo $event_type;
?> <a href=<?php
            echo $event_link;
?> style="color:#09C"><?php
            echo $event_name;
?></a>&nbsp;
							<?php
            
        }
        //IF NOTIFICATION TYPE IS AN ADD BUDDY
        if ($result["notification_type"] == "Add Buddy") {
            $sql      = "Select * from public_users where user_id=" . $result["other_user_id"];
            $res_data = $DB->RunSelectQuery($sql);

            foreach ($res_data as $resultuser) {
                $resultuser = (array) $resultuser;
                $user_name  = $resultuser["firstname"] . " " . $resultuser["lastname"];
            }
?>
                        <font style="color:#999; font-size:13px"><?php
            echo date("j F, H:i a", strtotime($result["notification_date"]));
?></font>&nbsp;&nbsp;&nbsp;<img src="<?php
            echo ROOTURL;
?>/images/add_buddy.gif" style="vertical-align:middle" />&nbsp;&nbsp;
						<a href="<?php
            echo createURL('index.php', "mod=user&do=profile&userid=" . $result["other_user_id"]);
?>" 
						style="color:#09C"><?php
            echo $user_name;
?></a> wants to add you as a buddy.&nbsp;</font>
<?php //Check if current user and event_organiser are buddies
            $sql      = "SELECT * from buddies where user_id=$user_id and buddy_id=" . $result["other_user_id"];
            $res_data = $DB->RunSelectQuery($sql);
            if (count($res_data) > 0) {
?>
                        <img src="<?php
                echo ROOTURL;
?>/images/green_tick.gif" style="vertical-align:middle" width="15" />&nbsp;<font class="ArialVeryDarkGreyBold15">Accepted</font>
<?
            } else {
?>
                        <div id="confirm_add_buddy_status<?= $result["other_user_id"] ?>" style="display:inline-block"><div onClick="confirm_add_buddy(<?= $result["other_user_id"] ?>)" class="slimbuttonblue" style="width:130px;">Accept buddy request</div></div>
<?php
            }
        }
        
        
        //IF NOTIFICATION TYPE IS A CONFIRMED BUDDY
        if ($result["notification_type"] == "Confirmed Buddy") {
            $sql      = "Select * from public_users where user_id=" . $result["other_user_id"];
            $res_data = $DB->RunSelectQuery($sql);
            foreach ($res_data as $resultuser) {
                $resultuser = (array) $resultuser;
                $user_name  = $resultuser["firstname"] . " " . $resultuser["lastname"];
            }
?>
                        <font style="color:#999; font-size:13px"><?php
            echo date("j F, H:i a", strtotime($result["notification_date"]));
?></font>&nbsp;&nbsp;&nbsp;<img src="<?php
            echo ROOTURL;
?>/images/confirmed_buddy.fw.png" style="vertical-align:middle" />&nbsp;&nbsp;<a href="<?php
            echo createURL('index.php', "mod=user&do=profile&userid=" . $result["other_user_id"]);
?>" style="color:#09C"><?php echo $user_name ?></a> has accepted your buddy request.&nbsp;
<?php
        }
        
?>
                    </font></td>
            </tr>
	<?php
    }
} else {
?>
        <tr>
            <td><div style="height:20px"></div><font class="ArialVeryDarkGrey15">There are no new notifications...</font></td>
        </tr>

		<?php
}
?>


    <!------------------------ALL NOTIFICATIONS ROWS-------------------------->
    <tr><td height="30"></td></tr>

	<?php
$status   = "Seen";
 $sql      = "Select * from notifications where user_id=$user_id and status='$status'";
$res_data = $DB->RunSelectQuery($sql);
?>
    <tr>
        <td class="ArialVeryDarkGreyBold18">All notifications</td>
    </tr>
    <?php
$dateset = "";
if (count($res_data) > 0) {
    foreach ($res_data as $result) {
        $result = (array) $result;
        $date   = date("Y-m-d", strtotime($result["notification_date"]));
        /*if ($date !== $dateset) {
            $dateset = $date;
            echo '<tr><td height="30" valign="top"></td></tr>';
        }*/
?>
            <tr>
                <td height="25" valign="middle"><font class="ArialVeryDarkGrey15">
<?php
        //IF NOTIFICATION TYPE IS A COMMENT
        if ($result["notification_type"] == "Comment") {
            $sql      = "Select * from events where event_id=" . $result["event_id"];
            $res_data = $DB->RunSelectQuery($sql);
            foreach ($res_data as $resulteventcomment) {
                $resulteventcomment = (array) $resulteventcomment;
                $event_name         = $resulteventcomment["event_name"];
                if ($resulteventcomment["entry_type"] == "") {
                    $event_type = "event";
                    $event_link = createURL('index.php', "mod=event&do=eventdetails&eventid=" . $resulteventcomment["event_id"]);
                    
                } else if ($resulteventcomment["entry_type"] == "Ping") {
                    $event_type = "ping";
                    $event_link = createURL('index.php', "mod=ping&do=pingdetails&eventid=" . $resulteventcomment["event_id"]);
                }
            }
            $sql      = "Select * from public_users where id=" . $result["other_user_id"];
            $res_data = $DB->RunSelectQuery($sql);
            foreach ($res_data as $resultusercomment) {
                $resultusercomment = (array) $resultusercomment;
                $user_name         = $resultusercomment["firstname"] . " " . $resultusercomment["lastname"];
            }
?>
                            <font style="color:#999; font-size:13px"><?= date("j F, H:i a", strtotime($result["notification_date"])) ?>
							</font>&nbsp;&nbsp;&nbsp;<img src="<?php echo ROOTURL;?>/images/comment_box.gif" style="vertical-align:middle" />&nbsp;&nbsp;<a href="<?php
            echo createURL('index.php', "mod=user&do=profile&userid=" . $result["$user_id"]);
?>" style="color:#09C"><?= $user_name ?></a> has commented on the <?= $event_type ?> <a href=<?= $event_link ?> style="color:#09C"><?= $event_name ?></a>&nbsp;
<!--                            --><? //
        }
        
        //IF NOTIFICATION TYPE IS AN ADD BUDDY
        if ($result["notification_type"] == "Add Buddy") {

$sql      = "Select * from public_users where id=" . $result["other_user_id"];
            $res_data = $DB->RunSelectQuery($sql);
            foreach ($res_data as $data) {
                $resultuser = (array) $data;

                $user_name  = $resultuser["firstname"] . " " . $resultuser["lastname"];
            }
?>
                        <font style="color:#999; font-size:13px"><?= date("j F, H:i a", strtotime($result["notification_date"])) ?></font>&nbsp;&nbsp;&nbsp;<img src="<?php
            echo ROOTURL;
?>/images/add_buddy.gif" style="vertical-align:middle" />&nbsp;&nbsp;<a href="<?php
            echo createURL('index.php', "mod=user&do=profile&userid=" . $resultuser["user_id"]);
?>" style="color:#09C"><?= $user_name ?></a> wants to add you as a buddy.&nbsp;</font>
						<?php //Check if current user and event_organiser are buddies
            
            $sql      = "SELECT * from buddies where user_id=$user_id and buddy_id=" . $result["other_user_id"];
            $res_data = $DB->RunSelectQuery($sql);
            
            if (count($res_data) > 0) {
?>
                        <img src="images/green_tick.gif" style="vertical-align:middle" width="15" />&nbsp;<font class="ArialVeryDarkGreyBold15">Accepted</font>
						<?php
            } else {
?>
                        <div id="confirm_add_buddy_status<?php
                echo $result["other_user_id"];
?>" style="display:inline-block"><div onClick="confirm_add_buddy(<?php
                echo $result["other_user_id"];
?>)" class="slimbuttonblue" style="width:130px;">Accept buddy request</div></div>
						<?php
            }
        }
        
        
        //IF NOTIFICATION TYPE IS A CONFIRMED BUDDY
        if ($result["notification_type"] == "Confirmed Buddy") {
            $sql      = "Select * from public_users where user_id=" . $result["other_user_id"];
            $res_data = $DB->RunSelectQuery($sql);
            foreach ($res_data as $resultuser) {
                $resultuser = (array) $resultuser;
                $user_name  = $resultuser["firstname"] . " " . $resultuser["lastname"];
            }
?>
                        <font style="color:#999; font-size:13px"><?= date("j F, H:i a", strtotime($result["notification_date"])) ?></font>&nbsp;&nbsp;&nbsp;<img src="<?php
            echo ROOTURL;
?>images/confirmed_buddy.fw.png" style="vertical-align:middle" />&nbsp;&nbsp;<a href="<?php
            echo createURL('index.php', "mod=user&do=profile&userid=" . $resultuser["other_user_id"]);
?>" style="color:#09C"><?php
            echo $user_name;
?></a> has accepted your buddy request.&nbsp;
                        <?php
        }
        
?>
                    </font></td>
            </tr>
        <?php
    }
} else {
?>
        <tr>
            <td><div style="height:20px"></div><font class="ArialVeryDarkGrey15">There are no new notifications...</font></td>
        </tr>

     <?php
}
$status  = "Seen";
$updateData['status'] = $status;
$DB->updateRecord('notifications', $updateData, "user_id='" . $user_id . "'")

?>
</table>

</body>

</html>