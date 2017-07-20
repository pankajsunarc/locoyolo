<?php
defined("ACCESS") or die("Access Restricted");
include_once('class.user.php');
$UserOBJ = new User();
global $DB;

$do = '';
if(isset($getVars['do']))
    $do = $getVars['do'];

if(isset($_REQUEST['update_details_submit'])){
    $UserOBJ->editprofile();
     $do = 'profile';
}
if(isset($frmdata['update_photo_submit'])) {
    $result = $UserOBJ->uploadImage();
}

if(isset($frmdata['submit']))
	$UserOBJ->validateUser();
if(isset($frmdata['register_user']))
	$UserOBJ->registerUser();
if(isset($frmdata['changepassword']))
	$UserOBJ->changePassword();
if(isset($frmdata['signUp_submit']))
    $UserOBJ->signUp();
if(isset($_REQUEST['from'])){
    $UserOBJ->validateUserByfb();
}

if($user_id!='' && $_POST['searchbtnstart']=='Search'&& $do!='logout')
{
	$do = 'Search';
}
switch($do)
{
	default :
	case 'login':
		if(isset($_SESSION['user_id']) && ($_SESSION['user_id'] != '')){
            $CFG->template = "user/dashboard.php";
            break;
        }else{
            $CFG->template = "user/login.php";
        }


//
		break;
	case "resetaccount":

		include_once(MOD."/forgotpass/resetaccount.php");
		break;
		case "forgotpass":

		include_once(MOD."/forgotpass/forgotpass.php");
		break;
	case "dashboard":

			$CFG->template = "user/dashboard.php";
		break;

	case 'Search':
		$CFG->template = "user/search.php";
		break;

	case 'exam_details':
		checker();
		if(!isset($_SESSION['candidate_id']) && ($_SESSION['candidate_id'] == ''))
			Redirect(CreateURL("mod=user"));

		if(isset($_GET['exam']))
			$exam_id = $_GET['exam'];
		$package_id_from_url = $_GET['package'];
		$getPackageIdByLoggedUser = $UserOBJ->getPackageIdByLoggedUser();
		$user_test_details = $UserOBJ->test_details($exam_id,$package_id_from_url);


		$CFG->template = "user/exam_details.php";
		break;

	case 'register':
		if(isset($_SESSION['candidate_id']) && ($_SESSION['candidate_id'] != ''))
			Redirect(CreateURL('index.php',"mod=guidelines"));


		$CFG->template = "user/register.php";
		break;


	case 'loginrecover':
       $CFG->template = "user/loginrecover.php";
		break;

	case 'search':
		$term = trim(strip_tags($_GET['term']));
		$result_data = $DB->SelectRecords('cities',"cityName LIKE '%$term%'",'cityName,cityID,stateID');
		for($i=0;$i<count($result_data);$i++)
		{
			$city[] = $result_data[$i]->cityName;
		}

		echo  json_encode($city);
		exit;
	case "sample_test":
		include_once(MOD."/sample_test/index.php");
		//$CFG->template = "";
		break;
	case "sample_guidelines":
		include_once(MOD."/sample_guidelines/index.php");
		//$CFG->template = "";
		break;
	case "sample_result":
		include_once(MOD."/sample_result/index.php");
		//$CFG->template = "";
		break;

	case 'profile':
		if(!isset($_SESSION['user_id']) || ($_SESSION['user_id'] == ''))
			Redirect(CreateURL('index.php'));

        $user_id = $_SESSION['user_id'];
		$user = $UserOBJ->getUserInfo($user_id);

		$CFG->template = "user/profile.php";
		break;

	case 'editprofile':
		$CFG->template = "user/editprofile.php";
		break;

	case 'upload_image':
		if(isset($_GET['delete_image']) && ($_GET['delete_image'] == 1))
		{
			$UserOBJ->deleteImage();
		}
		else
		{
			$UserOBJ->uploadImage();
		}
		exit;

	case 'edit_personal_info':
		$UserOBJ->updatePersonalInfo();
		exit;

	case 'validate_username':
		echo $DB->SelectRecord('candidate',"candidate_id='".$frmdata['candidate_id']."'") ? 0 : 1;
		exit;

	case 'logout':

	$UserOBJ->logoutUser();
	Redirect(ROOTURL);
	exit;

	case 'changepwd':
	$CFG->template = "user/changepwd.php";

    case 'editprofile':
	$CFG->template = "user/editprofile.php";

}

include(TEMP."/index.php");
exit;
?>