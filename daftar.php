<?php 
	require "ceksesion.php";  
	if ($login==true){
		header('Location:index.php');}
	require "db.php";
?>
<html>
	<head>
		<title>
		Daftar akun baru
		</title>
			<?php require 'head.php'; ?> 
		<script src="jquery/jquery.form-validator.js"></script>
		<script>
			<?php 
			if ($_GET['registrasi']=='gagal'){
					echo 'alert("Registrasi gagal");';}
			if ($_GET['registrasi']=='notelp'){
					echo 'alert("Nomor handphone yang anda masukkan sudah terdaftar");';}
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
		<b>Pendaftaran akun baru</b> <br /><br /><font color="#FF0000" size="4"><?php echo $_GET['konfirmasi'];?></font> 
		<form method="post" action="submit.php" class="validate">
				<input type="hidden" name="pengaturan" value="daftar">
			<p>Nomor Handphone <br />
				<input type="text" name="notelp" class="formlogin" maxlength="12" data-validation="kaki"
				data-validation-error-msg="Nomor handphone salah">
			</p>
			<p>Password <br>
				<input type="password" name="password" class="formlogin" 
				data-validation="length" data-validation-length="4-32" 
				data-validation-error-msg="Password harus 4-32 karakter" maxlength="32"/>
			</p>
			<p>Nama Lengkap <br />
				<input type="text" name="nama" maxlength="40" class="formlogin"  
				data-validation="length" data-validation-length="4-32" 
				data-validation-error-msg="Nama harus 4 - 40 karakter"/>
			</p>
			
				<input type="submit" value="Daftar" class="formlogin" 
				style="background-color:#0066ff; color:#FFFFFF; cursor:pointer;"
				onmouseover="this.style.background='#FFFFFF';this.style.color='#3399FF';" 
				onmouseout="this.style.background='#0066ff';this.style.color='#FFFFFF';" />
			
		</form>
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



