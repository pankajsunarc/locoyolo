<?php

if($POST)
{

    $errorcheck = false;

    $userid = $_POST['userid'];
    $buddyid = $_POST['buddyid'];
    $status = "Pending";
    $notification_type = "Add Buddy";
    $message = "Buddy request sent";
    $notification_date = date("Y-m-d H:i:s");

    $data['userid']=$userid;
    $data['buddyid']=$buddyid;
    $data['status']=$status;

    $id = $DB->InsertRecord('buddies', $data);

    $buddydata['buddyid']=$buddyid;
    $buddydata['userid']=$userid;
    $buddydata['status']=$status;
    $id = $DB->InsertRecord('buddies', $buddydata);

    $notificationsdata['userid'] = $buddyid;
    $notificationsdata['otheruserid'] = $userid;
    $notificationsdata['notification_type'] = $notification_type;
    $notificationsdata['status'] = $status;
    $notificationsdata['notification_date'] = $notification_date;

    $id = $DB->InsertRecord('buddies', $notificationsdata);
    ?>
    <font class="ArialVeryDarkGrey15"><? echo $message ?></font>
    <?
}

// Check name
?>