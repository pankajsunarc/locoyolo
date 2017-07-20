<?php

//if($CFG->template!='changepwd/change.php')
//{
//    include_once(TEMP."/"."header.php");
//}

if(isset($CFG->template))
{
	include_once(TEMP."/".$CFG->template);
}
else
{
	include_once(TEMP."/"."home.php");
}

if($CFG->template!='changepwd/change.php')
{
	include_once(TEMP."/"."footer.php");
}
?>
