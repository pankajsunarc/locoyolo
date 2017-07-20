<?php
//echo 'm heree';exit;

defined("ACCESS") or die("Access Restricted");
include_once('class.ping.php');

$UserOBJ = new Ping();
global $DB;
if(isset($frmdata['ping_submit'])) {
    $result = $UserOBJ->createPing();
}

if( $result['error']){
    $error =$result['error'];
}

$do = '';
if(isset($getVars['do']))
    $do=$getVars['do'];
switch($do)
{

    default:
    case 'createPing':
        checker();
        $CFG->template="ping/addping.php";
        break;
 case 'pings':

        $CFG->template="ping/pings.php";
        break;

    case 'pingdetails':
        checker();
        global $userData;
        if(!isset($_SESSION['user_id']) || ($_SESSION['user_id'] == ''))
        {
            Redirect(CreateURL('index.php'));
        }

        $event_id = $_GET['eventid'];

        $CFG->template="ping/pingdetails.php";

        break;
}

include(TEMP."/index.php");
//exit;
?>

<?php
/*if(isset($_GET['close']) && ($_GET['close'] == 1))
{
	unset($_SESSION['lastTestId']);
	echo '<script>window.close();</script>';
}

if(!isset($_SESSION['lastTestId']) || ($_SESSION['lastTestId'] == ''))
{
	Redirect(CreateURL('index.php',"mod=guidelines"));
	exit;
}

if(isset($frmdata['forexam']))
{
	if(($frmdata['forexam'] != '') || ($frmdata['forsoftware'] != ''))
	{
		global $DB;

		$feed = array();
		$feed['candidate_id'] = $_SESSION['candidate_id'];
		$feed['test_id'] = $_SESSION['lastTestId'];
		$feed['feed_exam'] = $frmdata['forexam'];
		$feed['feed_software'] = $frmdata['forsoftware'];

		$DB->InsertRecord('candidate', $feed);

		unset($_SESSION['lastTestId']);
		$_SESSION['feed_done'] = true;
	}
}*/

?>