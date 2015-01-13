<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<style>
.formlogin
{
border:1px solid #666666;
margin-right:5px;
margin-bottom:5px;
font-size: large;
color:#3399FF;
height:28px;
border-radius: 5px;
width:100%;
}
.logins{
margin-top:20%; 
margin-left:40%; 
width:20%; 
background:#0099FF; 
padding:10px; 
border-radius:10px;
color:#FFFFFF;
font-size:18px;}
</style>	
 
</head>

<body>
<div class="logins">
<b><font color='white'><?php $error=$_GET['konfirmasi'];
echo "$error"; ?></font></b>
<form action="vlogin.php" method="post">
Username<br /><input type="text" name="aname" maxlength="32" class="formlogin" /><br />
Password<br /><input type="password" name="apass" class="formlogin" /><br />
<input type="submit" name="submit" value="Login"/ style="float:right"><br />

</form>
</div>

</body>
</html>
