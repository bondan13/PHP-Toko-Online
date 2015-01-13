<?php 
	require "ceksesion.php";
	require "db.php";
?>
<html>
	<head>
		<title>Valiant Technology - Toko komputer</title>
		<?php require "head.php";  ?>
		<script>
			<?php 	if ($_GET['registrasi']=='sukses'){
						echo 'alert("Selamat anda telah terdaftar \n
						Silahkan login untuk akses ke akun anda");
						window.location = "index.php";';}
					if ($_GET['reset']=='sukses'){
						echo 'alert("Password anda telah direset \n 
						kami akan mengirimkan password melalui sms 
						maksimal 1 hari");
						window.location = "index.php";';}
			?>
		</script>
	</head>
	<body>
		<?php
			require "top.php"; 
			require "menu.php"; 
			require "isi.php";
		?>
	</body>
</html>
