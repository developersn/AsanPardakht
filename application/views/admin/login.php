<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" dir="rtl" lang="fa-IR" xml:lang="fa-IR">
<head>
  <title>ورود</title>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <style>
  
*{
  font-family: tahoma;
  font-size: 8pt;
  padding: 0;
  margin: 0;

}

body{
  background: rgb(243, 243, 243) url('<?php echo base_url() ?>sysfile/bg.png') ;
  line-height:1.6em;
  color:#4A4A4A
}

a{
  text-decoration: none;
  color:#6B6B6B;
  

}
a:hover
{
  color:#FF5615
}
#header
{
  width:400px;
  margin:4px auto 0px auto;
  height:120px;
  background: url(<?php echo base_url() ?>sysfile/logo.gif) no-repeat center top;

}
#login
{
  width:360px;
  
  background:white url(<?php echo base_url() ?>sysfile/menu.png) repeat-x top;
  border:1px solid #D2D7DB;
  margin:0 auto;
  padding:6px;
  border-radius:8px;
  box-shadow:0 0 5px 2px #D2D7DB;
}
input
{
padding:3px;
border-radius:3px;
border:1px solid rgb(190,190,190);
margin:2px;
}
#loginbot
{
background:#3EA9F8 url(<?php echo base_url() ?>sysfile/reza.png) repeat-x top;
color:white;
border:1px solid #59B5FC;
}
.err{
border:1px solid #FFFF00;
padding:3px;
border-radius:5px;
margin:2px;
background:#FFFFAE;
color:#1C1C00
}
.captchashow{
height:27px;
width:200px;
background:  url('<?php echo site_url('/captcha/make/login') ?>') no-repeat center left;
}
  </style>
</head>
<body>

<div id=header>
              
</div>
<div id=login> 

<?php echo ( !empty($_GET['m']))?'<div class=err>'.l($_GET['m']).'</div>':'' ; ?>
<form action='<?php echo site_url('login/'); ?>' method=post>
نام کاربری : <br><input type=text name=user_name size=30 dir=ltr />
<br>
کلمه عبور  : <br><input type=password name=pass size=30 dir=ltr />
<br>
کد امنیتی : <div class=captchashow>
<input type=text name=capt size=10 dir=ltr />
</div>

<input type=submit value=' ورود به مدیریت ' id=loginbot  >


</form>

</div>

</body>
</html>
