
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" dir="rtl" lang="fa-IR" xml:lang="fa-IR">
<head>
  <title>پرداخت آنلاین</title>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <style>
  
*{
  font-family: tahoma;
  font-size: 11px;
  padding: 0;
  margin: 0;

}

body{
  background: #F0F0F0  ;
  line-height:1.6em;
  color:#7F7F7F
}

a{
  text-decoration: none;
  color:#454545;
  

}
a:hover
{
  color:#727272
}
#header
{

  margin:0px auto 0px auto;
  height:150px;
  background:#24C7E3


}
#content
{
  width:950px;
  
  background:white url(img/menu2.png) repeat-x top;
  border:1px solid #D2D7DB;
  margin:0 auto;
  padding:6px;
  border-radius:8px;
  min-height:400px;
  position:relative;
  top:-50px
}
input,textarea ,select
{
padding:3px;
border-radius:3px;
border:1px solid rgb(190,190,190);
margin:2px;
}
#loginbot
{
background:#3EA9F8 ;
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
width:160px;

}
option
{
	padding:2px 6px;
}

.menu
{
  width:950px;
  padding:4px;
  margin:0 auto;
  height:80px;

}
/*pagenumber*/
  .pagenumber
  {
	padding:4px;
	
  }
.pagenumber li{
  float:right;
  display:inline-block;
   margin:2px 1px 1px 2px;
   
   background:rgb(250,250,250);
   border-radius:2px;
   border:1px solid rgb(245,245,245)
  
}
.pagenumber  li:hover{
    border:1px solid rgb(230,230,230)
}
.pagenumber a{
  display:inline-block;
  padding:2px 5px;
    
}

li.inpage{
  color:black;
  font-weight:bold;
  text-decoration:underline;
  background:rgb(240,240,240);
  border-radius:4px;
}

.pagenumber .dotedli{
	border:none;
	background:white
}
.pagenumber .dotedli:hover{
	border:none;
	background:white 
}
ul
{
  list-style:none;
  margin-right:600px;
  margin-top:50px;
}
.mm li
{
  float:right;
}
.mm a
{
  display:inline-block;
  padding:2px 5px;
  margin-right:5px;
  background:#1698AF;
  color:white;
  border-radius:4px;
  border-bottom:1px solid #127E92
}
.mm a:hover
{
  background:#12798B  ;
}

table
{
	border:1px solid gray;
}

td
{
	padding:1px 2px ;
	border:1px solid rgb(240,240,240);
}

  </style>
</head>
<body>
<div style='height:6px;width:100%;background:#20D0F0'></div>
<div style='height:1px;width:100%;background:#1796AC;'></div>
<div id=header>
            <div class=menu>
                <ul class=mm>
				
				<?php if($this->main->_is_admin()) : ?>
                    <li><a href="<?php echo site_url() ?>">صفحه اصلی</a></li>
					<li><a href="<?php echo site_url('admin/index') ?>">مدیریت</a></li>
					<li><a href="<?php echo site_url('admin/report') ?>">گزارش گیری</a></li>
					<li><a href="<?php echo site_url('admin/logout') ?>">خروج</a></li>              
                    
				<?php else : ?>
					<li><a href="<?php echo site_url() ?>">صفحه اصلی</a></li>
					<li><a href="<?php echo site_url('login/index') ?>">ورود به مدیریت</a></li>
				
				<?php endif ; ?>
				
                </ul>
            </div>
</div>
<div id=content> » <b>
لیست تراکنش ها  </b>
<br><br>

<table width='100%'>
			<tr>
				<td>ردیف</td>
				<td>شناسه پیگیری پرداخت</td>
				<td>مبلغ </td>
				<td>نام</td>
				<td>تلفن</td>
				<td>ایمیل</td>
				<td>زمان </td>
				<td> وضعیت</td>
				<td>توضیحات</td>
			</tr>
<?php foreach((array)$items as $item): ?>
			<tr>
				<td valign=top ><?php echo $item->id ?></td>
				<td valign=top ><?php echo $item->au ?></td>
				<td valign=top ><?php echo $item->price ?> تومان</td>
				<td valign=top ><?php echo $item->name ?></td>
				<td valign=top ><?php echo $item->phone ?></td>
				<td valign=top ><?php echo $item->email ?></td>
				<td valign=top dir=ltr ><?php echo pdate('Y/m/d (H:i)',$item->time) ?></td>
				<td valign=top align=center ><?php echo $item->status==1?'<b style="color:green">OK':'<b style="color:red">X'; ?></b></td>
				<td valign=top ><?php echo nl2br($item->description) ?></td>
				
			</tr>

<?php endforeach; ?>
		</table>
		
		<?php echo $pagenumber ?>

</div>

</body>
</html>










