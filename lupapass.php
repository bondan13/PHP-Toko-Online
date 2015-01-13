<?php 
	require "ceksesion.php";  
		if ($login==true){
			header('Location:index.php');}
	$asal=$_SERVER['HTTP_REFERER'];	
	require "db.php";
?>
<html>
	<head>
	<title>
		Lupa password
	</title>
		<?php require 'head.php'; ?> 
		<script src="jquery/jquery.form-validator.js"></script>
		<script>
		<?php 	
			if ($_GET['reset']=='salah'){
				echo 'alert("Nomor handphone salah");
				window.location = "lupapass.php";';}
			if ($_GET['reset']=='gagal'){
				echo 'alert("Nomor handphone tidak terdaftar");
					window.location = "lupapass.php";';}
		?>
		</script>
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
			<b>Lupa password</b> <br /><br /><font color="#FF0000" size="4"></font> 
			<font size="2" color="#666666">
			Password anda akan dikirim melalui SMS. <br>
			SMS akan dikirim maksimal 1 hari setelah request password.<br><br>
			</font>
			<form method="post" action="verifikasi.php">
			<input type="hidden" name="pengaturan" value="reqpass">
				<p>Nomor Handphone <br />
				<input type="text" name="notelp" class="formlogin" maxlength="12"
					value="" maxlength="12" data-validation="kaki" 
					data-validation-error-msg="Nomor handphone salah"></p>

				<input type="submit" value="Reset password" class="formlogin" 
					style="background-color:#0066ff; color:#FFFFFF; cursor:pointer;"
					onmouseover="this.style.background='#FFFFFF';this.style.color='#3399FF';" 
					onmouseout="this.style.background='#0066ff';this.style.color='#FFFFFF';"/>
			</form>
			<font size="2">Belum punya account? <a href="daftar.php">Daftar disini.</a><br />
			</font>
		</div>
		<?php include "footer.php"; ?>
	</body>
</html>
<script>
    $.formUtils.addValidator({
        name : 'swephone',
        validatorFunction : function(tele) {
            var numPlus = tele.match(/\+/g);
            var numHifen = tele.match(/-/g);

            if ((numPlus !== null && numPlus.length > 1) || (numHifen !== null && numHifen.length > 1)) {
                return false;
            }
            if (numPlus !== null && tele.indexOf('+') !== 0) {
                return false;
            }

            tele = tele.replace(/([-|\+])/g, '');
            return tele.length > 8 && tele.match(/[^0-9]/g) === null;
        },
        errorMessage : '',
        errorMessageKey: 'badTelephone'
    });

    $.formUtils.addValidator({
        name : 'kaki',
        validatorFunction : function(number) {
		 if (!$.formUtils.validators.validate_swephone.validatorFunction(number)) {
                return false;
            }

            number = number.replace(/[^0-9]/g, '');
            var begin = number.substring(0, 1);

            if (number.length < 10 && begin !== '0') {
                return false;
            } 
            
            return begin === '0';
        },
        errorMessage : '',
        errorMessageKey: 'badTelephone'
    });
	
	$.validate({
	});
</script>