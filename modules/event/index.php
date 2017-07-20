<?php
//echo 'hi m here'; exit();
//print_r($frmdata['edit_event_submit']);exit;
defined("ACCESS") or die("Access Restricted");
include_once('class.event.php');
include_once('image_manipulator.php');
//include_once('send_comments.php');
global $DB;
$DB = new DBFilter();
$eventOBJ= new Event();

if(isset($frmdata['event_submit'])) {
    $result = $eventOBJ->addEvent();
}

if(isset($frmdata['edit_event_submit'])) {
    $result = $eventOBJ->editEvent();
}



if( $result['error']){
    $error =$result['error'];
}
if(isset($_GET['id']))
{
    $nameID=$_GET['id'];
}


$do = '';
if(isset($getVars['do']))
    $do=$getVars['do'];
//echo $do;exit;
switch($do)
{
    default:
    case 'event':
        checker();
        $CFG->template="event/event.php";
        break;
 case 'events':
        checker();
        $CFG->template="event/events.php";
        break;
case 'participants':
        checker();
        $CFG->template="event/participants.php";
        break;

    case 'eventdetails':
        checker();
        global $userData;
        if(!isset($_SESSION['user_id']) || ($_SESSION['user_id'] == ''))
        {
            Redirect(CreateURL('index.php'));
        }
        $event_id = $_GET['eventid'];
//        print_r($event_id);exit;
        $userEvent_id = $eventOBJ->showEvent($event_id);
        $CFG->template="event/eventdetails.php";

        break;

    case 'editevent':
        checker();
        global $userData;
        if(!isset($_SESSION['user_id']) || ($_SESSION['user_id'] == ''))
        {
            Redirect(CreateURL('index.php'));
        }
       $event_id = $_GET['id'];
//        print_r($_GET('id'));exit;
        $CFG->template="event/editevent.php";

        break;


}

include(TEMP."/index.php");
//exit;
?>