<?php
defined("ACCESS") or die("Access Restricted");

function RecordPerPage($no)
{
	if ($no)
	{
		return $no;
	}	
	else
	{
		return 10;
	}	
}

// to fetch postdata
function Changedata()
{
	global $_POST;
	return  $_POST;
}

// to parse URLS
function ParsingURL()
{
	global $getVars;
	$urlArr=@parse_url($_SERVER['REQUEST_URI']);
 	@parse_str( Decode($urlArr['query']),$getVars);
 	@parse_str( $urlArr['query'],$getVars);
}

//	Redirect a page through javascript
function Redirect($file)
{
	echo  '<script>';
	echo  'location.href="'.$file.'"';
	echo  '</script>';
	exit();
}

// to make a link
function CreateURL($url,$querystring='',$encode=false,$redirect=false)
{
	$url = ROOTURL.'/'.$url;
	if($querystring)
	{
		if($encode)
		{
			return $url.'?'.Encode($querystring);		
		}
		else
		{
			return $url.'?'.$querystring;		
		}
	}
	else
	{
		return $url;
	}
	return false;
}

/**
 * @Auther	: Niteen Acharya
 * @para	: any value
 * @return 	: encoded value
 * @Des 	: to encode value
 */

function Encode($value)
{
	return base64_encode($value);
}

function Encrypt($value)
{
	return crypt($value, 'seigolonhcet#CRANUS321$');
}

function Decode($value)
{
	return base64_decode($value);
}

/**
 * 	@author	:	Ashwini Agarwal
 * 	@desc	:	Randomly shuffle array preserving key => value.
 * 				(Used to shuffle match type question)
 */
function shuffle_assoc($list) 
{ 
  if (!is_array($list)) return $list; 

  $keys = array_keys($list); 
  shuffle($keys); 
  $random = array(); 
  foreach ($keys as $key) 
  { 
    $random[] = $list[$key]; 
  }
  return $random; 
}
//==================== Upload Image Files After Compression =============================================//
function UploadImageFile(&$SavePath,$FileObject,$FileType)
{
    $Message='';
	$Upldate=time();
	$savefile = 1;
	
    if($FileObject->name=='')
	{ 
	   return;
	}	
	
	 $FileObject->name = str_replace(" ","",$FileObject->name);
	 $pos=strpos($FileObject->name,".");
	 $SavePath=substr($FileObject->name,0,$pos);
	 
	 
	if($FileType == 'image')
	{
		$maxsize = IMAGESIZE;
		$extension = IMAGEEXT;
	}
	else
	{
		$maxsize = FILESIZE;
		$extension = FILEEXT;
    }	
	
	//================================ Check file size ===================
	   if($FileObject->size>$maxsize)
	   { 
			 $savefile = 0;
			 $Message = MAXSIZEMESSAGE;
		}
		elseif($FileObject->size <= 0)
		{
			$savefile = 0;
			$Message = MINSIZEMESSAGE;
			
		}
	//================================ Check file type ===================
	  $fileext = explode("/",$FileObject->type); // Fetch the file type
	  $extension1 = explode(",",$extension); // Change the string into array
	  $filename = $FileObject->name; // Fetch the filename of posted file
	  $pos=strrpos($FileObject->name,"."); 
	 $ext = strtolower(substr($FileObject->name,$pos+1)); // Acheive only file extionsion
	

  //##########################################################################
	 $key = array_search($ext,$extension1); // Search the received extionsion in array  
       
	   if($extension1[$key] != $ext)
		  {
			$Message = EXTMESSAGE.$extension." files.";
	        $savefile = 0;
		  } 
      		
	//================================ copy file all validations are true ===================
		if($savefile == 1)
		{
		   $SavePath.= time().".".$ext;
		   $copypath = FILEPATH.$SavePath;
		   
		
			if(is_uploaded_file($FileObject->tmp_name))
		 	{
		 		include_once(ROOT.'/lib/image.class.php');
				$img = new thumb_image;
				$img->GenerateThumbFile($FileObject->tmp_name, $copypath);
		 		
				if(!file_exists($copypath))
				{
					$Message=FAILEDCOPYMESSAGE;
					$SavePath = '';
				}
			}
			else
			{
				$Message="File not uploaded.";
				$SavePath = '';
			}
		}
		
	return $Message;
}
/*
function MakeNewpassword()
{		
	$s=rand(time()%357,time());
	srand($s);
	$san=rand((time()-$s),time());
	$san1=rand((time()-4322),time());
	 $san2=encrypt($san.$san1,time());
	$pass=encrypt(time(),$san2);
	return $pass;
}*/
//-------------------------
function MakeNewpassword($length = 6, $add_dashes = false, $available_sets = 'luds')
{
$sets = array();if(strpos($available_sets, 'l') !== false)$sets[] = 'abcdefghjkmnpqrstuvwxyz';if(strpos($available_sets, 'u') !== false)$sets[] = 'ABCDEFGHJKMNPQRSTUVWXYZ';if(strpos($available_sets, 'd') !== false)$sets[] = '23456789';/*if(strpos($available_sets, 's') !== false)$sets[] = '!@#$%&*?';*/ $all = '';$password = '';foreach($sets as $set){$password .= $set[array_rand(str_split($set))];$all .= $set;} $all = str_split($all);for($i = 0; $i < $length - count($sets); $i++)$password .= $all[array_rand($all)]; $password = str_shuffle($password); if(!$add_dashes)return $password; $dash_len = floor(sqrt($length));$dash_str = '';while(strlen($password) > $dash_len){$dash_str .= substr($password, 0, $dash_len) . '-';$password = substr($password, $dash_len);}$dash_str .= $password;return $dash_str;
}
//--------------------



//------------------------
function PaginationWork($option='')
{
	global $frmdata ;
	
	if(!isset($frmdata['record'])) $frmdata['record'] = '';
	
	$recordPerPage=RecordPerPage($frmdata['record']);
  	
	//	if page number not set or search done
	if(!isset($frmdata['pageNumber']))
	{	
		$frmdata['pageNumber']=1;
	}
	if($recordPerPage!='All')
	{
		// at first page 
		if($frmdata['pageNumber']==1)
		{
			 $frmdata['from']=0;
			 $frmdata['to']=$recordPerPage;
		}
	   //for next pages
		else
		{
	       if($frmdata['pageNumber']<=0)
	       {
				$frmdata['pageNumber']=1;
				$frmdata['from']=0;
				$frmdata['to']=$recordPerPage;
	       }
	       else
	       {
				$frmdata['from']= $recordPerPage * ( ( (int) $frmdata['pageNumber']) - 1);
				$frmdata['to']=$recordPerPage;
	       }
		}	 
	}
}


?>