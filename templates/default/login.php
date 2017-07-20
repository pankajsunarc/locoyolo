<!DOCTYPE HTML>
<html>
<?php echo 'hi';?>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
		<title>Online Examination</title>
		<style>
		@font-face {
	 	font-family: "font1";
	  	src: url("<?php echo ROOTURL;?>/css/fonts/BebasNeue.otf");
	  	src: local("☺"),
		url("<?php echo ROOTURL;?>/css/fonts/BebasNeue.otf") format("woff"),
		url ("<?php echo ROOTURL;?>/css/fonts/BebasNeue.otf") format("opentype"),
		url("<?php echo ROOTURL;?>/css/fonts/BebasNeue.otf") format("svg");
	}
	{
		margin: 0;
		padding: 0;
	}


	header, footer, aside, nav, article {
		display: block;
	}

	body {
			margin: 0 auto;

			font: 13px/22px Helvetica, Arial, sans-serif;
			background:#f1f1f1 ;
		}
	header{
	min-height:35px; background-color:#066a75; color:#fff; font:"Times New Roman", Times, serif; font-size:100%; padding:3px;
	opacity: 0.7; box-shadow:0px 0px 5px #333;
    filter: alpha(opacity=40); /* For IE8 and earlier */}
	#logo{padding:0.4em; padding-top:0.5em}
	#logo a{ color:#fff;  font:"Courier New", Courier, monospace; font-size:1.4em; text-decoration:none;}
	#user_detail{ float:right;width: 150px; cursor:pointer}
	#user_detail img { background:#fff; border:solid 2px #fff}
	.user_name{ padding:0.5em; padding-top:0.5em; font:"Courier New", Courier, monospace; font-weight:bold; font-size:1em;}

	 #hr{ width:75%; height:1px; margin:auto; background:#99bcc1; margin-bottom:30px}
	#logo{ float:left; width:200px}
	.user_img{ float:left; width:50px}

	.user_img img { border:2px solid #fff;
	background:none repeat scroll 0 0 #fff}
	.user_class{ float:left; width:150px; padding:0.5em; background:#fff;}
	#right_sec{width:900px; height:100%; min-height:600px; float:right;}
	#left_sec{ width:100px; height:100%; min-height:600px; background:#FFf; float:left}
	#main_sec { width:100%; background:#ccc;}
	#left_sec ul{ width:100px; display: inline}
	#left_sec ul li { display: block; text-decoration:none; height:33px; width:50px; overflow:hidden; margin-top:5px; box-shadow:0px 0px 2px #666; font-weight:bold; padding-left:15px; padding-top:10px; background-color:#fff; position:relative; border-right: solid 1px #666; list-style-type: none;
	-webkit-transition: width 1.1s; /* For Safari 3.1 to 6.0 */
    transition: width 1.1s;}
	.li1{ background-image:url(<?php echo ROOTURL;?>/css/images/icons.png); height:35px;padding-left:14px;width:30px; position:relative; background-position: -12px -12px, center center;
    background-repeat: no-repeat; color:#000; padding-left:10px;float:right}
	.li2{ background-image:url(<?php echo ROOTURL;?>/css/images/icons.png);  background-position: -11px -46px, center center;
    background-repeat: no-repeat; height:35px;padding-left:14px;width:30px; position:relative; background-repeat: no-repeat; color:#000; padding-left:10px;float:right}
	.li3{ background-image:url(<?php echo ROOTURL;?>/css/images/icons.png); height:35px;padding-left:14px;width:30px; position:relative; background-position: -11px -84px, center center;
    background-repeat: no-repeat; color:#000; padding-left:10px;float:right}
	.li4{ background-image:url(<?php echo ROOTURL;?>/css/images/icons.png); height:35px;padding-left:14px;width:30px; position:relative; background-position: -11px -170px, center center;
    background-repeat: no-repeat; color:#000; padding-left:10px;float:right}
	.li5{ background-image:url(<?php echo ROOTURL;?>/css/images/icons.png); height:35px;padding-left:14px;width:30px; position:relative; background-position: -11px -296px, center center;
    background-repeat: no-repeat; color:#000; padding-left:10px;float:right}
	.li6{ background-image:url(<?php echo ROOTURL;?>/css/images/icons.png); height:35px;padding-left:14px;width:30px; position:relative; background-position: -12px -214px, center center;
    background-repeat: no-repeat; color:#000; padding-left:10px;float:right}
	.li7{ background-image:url(<?php echo ROOTURL;?>/css/images/icons.png); height:35px;padding-left:14px;width:30px; position:relative; background-position: -11px -128px, center center;
    background-repeat: no-repeat; color:#000; padding-left:10px;float:right}
	.li8{ background-image:url(<?php echo ROOTURL;?>/css/images/icons.png); height:35px;padding-left:14px;width:30px; position:relative; background-position: -11px -333px, center center;
    background-repeat: no-repeat; color:#000; padding-left:10px;float:right}
	.li9{ background-image:url(<?php echo ROOTURL;?>/css/images/icons.png); height:35px;padding-left:14px;width:30px; position:relative; background-position: -11px -367px, center center;
    background-repeat: no-repeat; color:#000; padding-left:10px;float:right}
	.li10{ background-image:url(<?php echo ROOTURL;?>/css/images/icons.png); height:35px;padding-left:14px;width:30px; position:relative; background-position: -11px -258px, center center;
    background-repeat: no-repeat; color:#000; padding-left:10px;float:right}
	#left_sec ul li:hover{ width:160px; color:#000; overflow:hidden}
	/*.li1:hover{   background-position:  112px -3px, center center;
    background-repeat: no-repeat; color:#000}
	.li2:hover{   background-position:  112px -44px, center center;
    background-repeat: no-repeat;}
	.li3:hover{   background-position: 112px -90px, center center;
    background-repeat: no-repeat;}
	.li4:hover{   background-position:  112pxx -282px, center center;
    background-repeat: no-repeat;}
	.li5:hover{   background-position:  112px -181px, center center;
    background-repeat: no-repeat;}
	.li6:hover{   background-position:  112px -320px, center center;
    background-repeat: no-repeat;}
	.li7:hover{   background-position:  112px -234px, center center;
    background-repeat: no-repeat;}
	.li8:hover{   background-position:  112px -133px, center center;
    background-repeat: no-repeat;}
	.li9:hover{   background-position:  112px -362px, center center;
    background-repeat: no-repeat;}
	.li10:hover{   background-position: 112px -362px, center center;
    background-repeat: no-repeat;}*/
	.li_text1{ width:0; position:absolute; float:left; overflow:hidden;-webkit-transition: width 0.9s; /* For Safari 3.1 to 6.0 */
    transition: width 0.9s;}
	#left_sec ul li:hover .li_text1{ width:90%; float:left; overflow:hidden}
	#account_sec{width:900px;min-height:300px;background:#fff ;float:left; margin-top:5px}
	.exam_box{min-height:70px; width:150px;box-shadow:0px 0px 3px #666;background:#f1f1f1;margin:20px;padding-top:45px;float:left;text-align:center;color:#066a75;font-size:1.5em;font-weight:bold}
	.green_head{height:20px;width:200px;text-align:center;background:#066a75 no-repeat; background-size:25px;background-position:6px 2px; background-image: url(<?php echo ROOTURL;?>/css/images/5.png);color:#fff;font-size:1.2em;  opacity: 0.7;padding:5px;font-weight:bold;box-shadow:-1px 1px 2px #666}
	.green_head_wrp{width:100%}
	@media only screen
	and (min-device-width : 310px)
	and (max-device-width : 359px) {

		header #headtext{ width:275px; font-size:1.4em}
	}
	@media only screen
	and (min-device-width : 321px)
	and (max-device-width : 550px) {

		header #headtext{ width:270px; font-size:1.4em}
	}
	@media only screen
	and (min-device-width : 551px)
	and (max-device-width : 768px) {


		.header #headtext{ width:325px; font-size:1.6em}
	}
</style>
<script type="text/javascript">
 document.createElement('header');
 document.createElement('nav');
 document.createElement('menu');
 document.createElement('section');
 document.createElement('article');
 document.createElement('aside');
 document.createElement('footer');
</script>
	<script>
	$( document ).ready(function() {
	$('#profile_sec').css('display','none');
	$('#user_detail').click(function(){
		 $( "#profile_sec" ).slideToggle( "slow");

	});
	$('#edit_name_sec').css('display','none');
	$('#name_edit_button').click(function(){
		 $( "#edit_name_sec" ).slideToggle( "slow");


	});
	$('#cross_button').click(function(){
		 $("#edit_name_sec").slideUp("slow");
	});
	});

	</script>	<script>  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');  ga('create', 'UA-54129281-1', 'auto');  ga('send', 'pageview');</script>
	</head>
	<body>
		<header>
			<div id="logo">
				<a>Assessall</a>
			</div>
			<div id="user_detail">
				<div class="user_img">
					<img height="30" width="30" src="<?php echo ROOTURL;?>/css/images/no_image.gif"/>
				</div>
				<div class="user_name">Rahul</div>
			</div>

		</header>
		<!----------------------------------->
		<div id='profile_sec' style="height:200px;
		 display:none; position:absolute; right:0px;
		  width:350px; float:right;background:#fff;border:solid 2px #066a75;
		  border-top:none;margin-right:10px">
 			 <div style="width:40%;height:200px;float:left">
     			 <div style="height:160px; width:100%;">
        			 <img  style="height:120px; width:100px;border:solid 2px #066a75;
					 margin:12%"
            		 src="http://sunwindows:1234/assessall/css/images/no_image.gif">
      			</div>
      			<div style="height:50px;width:100%; text-align:center;">
         		 <a style="color:#fff;background:#066a75;padding:0.5em 1em;font-size:1em;
				 font-weight:bold;test-decortion:none;">View Profile</a>
    		   </div>
  			</div>

			<div style='width:59%;height:160px;float:right; '>
     			<div>
					<h4> Name: Rahul Gahlot </h4>
      				<h4> Age: 22 </h4>
          			<h4> Course: Bank PO </h4>
				 </div>
  			</div>
   			<div style="height:50px;width:100%; text-align:center;">
          		<a style="color:#fff;background:#066a75;padding:0.5em 1em;
				font-size:1em;font-weight:bold;test-decortion:none;">Log Out</a>
      		</div>
		</div>
		<!-------------------------------------------->

		<section id="main_sec" style='overflow:visible'>
			<div id="left_sec">
				<ul>

					<li id="li_1"><div class="li_text1">Dashboard</div><div class="li1"></div></li>
					<li id="li_2"><div class="li_text1">Online&nbsp;Exam</div><div class="li2"></div></li>
					<li id="li_3"><div class="li_text1">My&nbsp;Account</div><div class="li3"></div></li>
					<li id="li_4"><div class="li_text1">Upload&nbsp;Documents</div><div class="li4"></div></li>
					<li id="li_5"><div class="li_text1">Exam&nbsp;Reports</div><div class="li5"></div></li>
					<li id="li_6"><div class="li_text1">Buy&nbsp;Package&nbsp;Online</div><div class="li6"></div></li>
					<li id="li_7"><div class="li_text1">Message</div><div class="li7"></div></li>
					<li id="li_8"><div class="li_text1">Share&nbsp;With&nbsp;Friend</div><div class="li8"></div></li>
					<li id="li_9"><div class="li_text1">Letest&nbsp;News</div><div class="li9"></div></li>
					<li id="li_10"><div class="li_text1">Download&nbsp;Docs</div><div class="li10"></div></li>
				</ul>
			</div>
			<div id="right_sec">

				<div id="account_sec">
				<div class="green_head_wrp"><div class="green_head">Account Overview</div></div>
  <div style="width:30%;float:left;height:250px;">
    <div style="height:180px;width:150px;margin:auto;">
      <img width="130px" height="150px" src="http://sunwindows:1234/assessall/css/images/no_image.gif" style="border:solid 2px #066a75;margin:20px 8px">
      <div style="width:auto;padding:5px;text-align:center;margin:auto;background:#066a75;height:20px"><a style="color:#fff;font-weight:bold;">Change Image</a></div>
  </div>


			</div>
   <div style="width:65%; height:auto;min-height:250px;float:left;margin-bottom:10px;">
     <div style="height:30px;width:70%;border-bottom:solid 1px #ccc;margin:auto;margin-top:10px;font-weight:bold;"><span style="color:#066a75">Name:</span> Rahul Gahlot<div id="name_edit_button" style="height: 30px; width: 40px; float: right; background: url(&quot;http://sunwindows:1234/assessall/css/images/edit_icon.png&quot;) no-repeat scroll 23px 0px / 15px 15px transparent;"></div></div>
<div id="edit_name_sec" style="height:150px;width:70%;background:#f1f1f1;margin:auto;box-shadow:0px 0px 3px #666;">
  <form>
    <input  id="cross_button"  type="button" style="float: right; height: 30px; width: 30px; border: medium none; background: url(&quot;http://sunwindows:1234/assessall/css/images/cross_2.png&quot;) no-repeat scroll 10px 2px / 15px 20px transparent;">
  </form>
</div>

<div style="width: 70%; border-bottom: 1px solid rgb(204, 204, 204); margin: 10px auto auto; font-weight: bold; min-height: 30px;"><span style="color:#066a75">Mobile:</span> 895511553<div style="height: 30px; width: 40px; float: right; background: url(&quot;http://sunwindows:1234/assessall/css/images/edit_icon.png&quot;) no-repeat scroll 23px 0px / 15px 15px transparent;"></div></div>
<div style="height:30px;width:70%;border-bottom:solid 1px #ccc;margin:auto;margin-top:10px;font-weight:bold;"><span style="color:#066a75">Gander:</span> Male<div style="height: 30px; width: 40px; float: right; background: url(&quot;http://sunwindows:1234/assessall/css/images/edit_icon.png&quot;) no-repeat scroll 23px 0px / 15px 15px transparent;"></div></div>
<div style="width: 70%; border-bottom: 1px solid rgb(204, 204, 204); margin: 10px auto auto; font-weight: bold; min-height: 30px;"><span style="color:#066a75">Address:</span>  Behind Gyatri Temple, Old GInani, Bikaner<div style="height: 30px; width: 40px; float: right; background: url(&quot;http://sunwindows:1234/assessall/css/images/edit_icon.png&quot;) no-repeat scroll 23px 0px / 15px 15px transparent;"></div></div>

<div style="width: 70%; border-bottom: 1px solid rgb(204, 204, 204); margin: 10px auto auto; font-weight: bold; min-height: 30px;"><span style="color:#066a75">Username:</span> jbr.rahul<div style="height: 30px; width: 40px; float: right; background: url(&quot;http://sunwindows:1234/assessall/css/images/edit_icon.png&quot;) no-repeat scroll 23px 0px / 15px 15px transparent;"></div></div>
  <div style="width: 70%; border-bottom: 1px solid rgb(204, 204, 204); margin: 10px auto auto; font-weight: bold; min-height: 30px;"><span style="color:#066a75">Password:</span>  ******<div style="height: 30px; width: 40px; float: right; background: url(&quot;http://sunwindows:1234/assessall/css/images/edit_icon.png&quot;) no-repeat scroll 23px 0px / 15px 15px transparent;"></div></div>


</div></div>



			</div>
    	</section>
	</body>

</html>


</body>
</html>
</body>