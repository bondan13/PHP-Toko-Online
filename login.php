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
		Login
	</title>
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
			<b>LOGIN</b> <br /><br /><font color="#FF0000" size="4"><?php echo $_GET['konfirmasi'];?></font> 
			<form method="post" action="vlogin.php">
				<input type="hidden" name="link_b" value="<?php echo $asal; ?>">
				<p>Nomor Handphone <br />
				<input type="text" name="notelp" class="formlogin" maxlength="12"
					value="" maxlength="12" data-validation="kaki" 
					data-validation-error-msg="Nomor handphone salah"></p>
				<p>Password<br />
				<input type="password" name="password" class="formlogin"
					data-validation="length" data-validation-length="4-32" 
					data-validation-error-msg="Password salah" maxlength="32"/></p>
				<input type="submit" value="Login" class="formlogin" 
					style="background-color:#0066ff; color:#FFFFFF; cursor:pointer;"
					onmouseover="this.style.background='#FFFFFF';this.style.color='#3399FF';" 
					onmouseout="this.style.background='#0066ff';this.style.color='#FFFFFF';"/>
			</form>
			<font size="2">Belum punya account? <a href="daftar.php">Daftar disini.</a><br />
				<?php
					if (isset($_GET['konfirmasi'])){
					echo "Atau ke layanan&nbsp;<a href='lupapass.php'>Lupa password. </a>";} 
				?>
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