<?php
include_once("../../config.php");
include_once(INC."/commonfunction.php");
include_once(INC.'/dbfilter.php');
include_once(INC.'/dbqueries.php');
include_once(INC.'/dbhelper.php');
$search = $_REQUEST["s"];

if ($search == null) {

//    header('Location: index.php');
//    echo $message = "enter some text";

} else {
    $qry = "SELECT event_id as id, event_name, event_photo as img, 'event' as type, entry_type as data_type FROM events WHERE event_name LIKE '%" . $search . "%' UNION SELECT id as id, firstname, profile_pic img,'user' as type, 'na' as data_type FROM public_users WHERE firstname LIKE '%" . $search . "%'";

    $result = $res_data = $DB->RunSelectQuery($qry);
     if(!is_array($result))
     {
         $result =(array)$result;
     }
    $data = array();
    if (count($result)> 0) {
        foreach($result as $row) {
			$row = (array) $row;
            $data[] = $row['event_name'];
        $link='';
		if($row['type']=='user')
		{
			$link =	$link = createURL('index.php',"mod=user&do=profile&userid=".$row['id']."&s=".$row['event_name']);
		}
		if($row['type']=='event')
		{
			if($row['data_type']=='Ping')
			{

					$link = createURL('index.php',"mod=ping&do=pingdetails&eventid=".$row['id']."&s=".$row['event_name']);
			}
			else
			{

				$link = createURL('index.php',"mod=event&do=eventdetails&eventid=".$row['id']."&s=".$row['event_name']);
			}
		}
//		if(file_exists(ROOTURL.'/'.$row['img']))
		if($row['img']!= null)
		{
			$img = ROOTURL.'/'.$row['img'];
		}
		else
		{
			$img = ROOTURL.'/images/profile_img.jpg';
		}
       $d .='<a href="'.$link.'"><div class="display_box" align="left">
<img src="'.$img.'" style="width:50px; height:50px; float:left; margin-right:6px;" />
<span class="name">'.$row['event_name'].'</span></div></a>';
	   
	   // echo json_encode($data);exit;
    }
	$d .='<a href="'.createURL('index.php',"mod=search&do=searchlist").'"><div class="display_box" align="left">
<span class="name">See All</span></div></a>';
	}
	else
	{
		$d .='<div class="display_box" align="left">
<span class="name">No result found!</span></div>';
		
	}
	
echo $d;exit;

}

?>