<?php

if($_POST)
{
    $errorcheck = false;
    $event_id = $_POST["event_id"];
    $user_id = $_POST["user_id"];
    $DB->DeleteRecord('event_bookings','event_id="'.$event_id.'" and user_id='.$user_id);
   echo 'Y';
}
else
{
    echo 'N';
}

// Check name
?>