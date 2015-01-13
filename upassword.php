<?php 
	require "ceksesion.php";  
	if ($login!=true){
		header('Location:index.php');}
	$asal=$_SERVER['HTTP_REFERER'];	
	require "db.php";
?>
	<html>
		<head>
			<title>Ubah password</title>
		<?php require 'head.php'; ?> 
		<script src="jquery/jquery.form-validator.js"></script>
		<style>
			.ui-button {
				background-image:url(icon/header-bg.jpg);}
			.formlogin{
				border:1px solid #666666;
				margin-right:5px;
				margin-bottom:5px;
				font-size: large;
				color:#3399FF;
				height:28px;
				border-radius: 5px;
				width:200px;}
		</style>
		</head>
		<body>
		<?php
		require "top.php"; 
		require "menu.php";
		?>
		<div class="isi">
			<div class="katag"><a href="profile.php">Profil</a></div>
			<div class="katag"><a href="user-transaksi.php">Transaksi</a></div>
			<?php 
			if ($s_pangkat == 'affiliasi'){
				echo "<div class='katag'><a href='komisi.php'>Komisi</a></div> ";
				echo "<div class='katag'><a href='req_payment.php'>Pembayaran Komisi</a></div>";}
			?>
			<hr>
			<b>Ubah Password</b><br /><font color="#FF0000" size="4"><?php echo $_GET['konfirmasi'];?></font> 
			<form method="post" action="verifikasi.php" class="validate">
				<p>Password Lama  <br />
				<input type="password" name="p_lama" class="formlogin" maxlength="32"
				data-validation="length" data-validation-length="4-32" 
				data-validation-error-msg="Password salah"/></p>
				<br>
				<p>Password Baru <br />
				<input type="password" name="p1_baru" class="formlogin" maxlength="32"
				data-validation="length" data-validation-length="4-32" 
				data-validation-error-msg="Password minimal 4 karakter"/></p>
				<p>Password Baru (ulangi)<br />
				<input type="password" name="p2_baru" class="formlogin" maxlength="32"
				data-validation="length" data-validation-length="4-32" 
				data-validation-error-msg="Password minimal 4 karakter"/></p>
				<input type="hidden" name="pengaturan" value="upass">
				<input type="submit" value="Ubah Password" class="formlogin" 
					style="background-color:#0066ff; color:#FFFFFF; cursor:pointer;"
					onmouseover="this.style.background='#FFFFFF';this.style.color='#3399FF';" 
					onmouseout="this.style.background='#0066ff';this.style.color='#FFFFFF';"/>
			</form>
		</div>
		<?php include "footer.php"; ?>
		</body>
	</html>
<script>
	$(function() {
	$( ".katag" ).button();
	});
		
	$.validate({
	});
</script>