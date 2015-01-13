<?php 
require "ceksesion.php";  
require "db.php";
?>
	<html>
	<head>
		<title>Affiliasi</title>
	<?php require 'head.php'; ?> 
	<style>
		.formlogin{
			border:1px solid #666666;
			margin-right:5px;
			margin-bottom:5px;
			font-size: large;
			color:#3399FF;
			height:28px;
			border-radius: 5px;}
	</style>
	</head>
	<body>
	<?php
	require "top.php"; 
	?>
	<div class="isi" style="width:94.5%;">
<h3>Apa itu Affiliate Program </h3><hr>
<p align="justify">Affiliate program atau dalam Bahasa Indonesia biasa disebut dengan program afiliasi atau kemitraan adalah suatu teknik marketing dimana penjual bekerjasama dengan pemasar melalui website pemasar. Dalam prakteknya para pemasar mendapatkan link khusus yang sudah diberi tracking (pelacak) sehingga setiap transaksi yang dating dari pemasar akan diketahui oleh system afiliasi penjual. Jika penjualan memenuhi kriteria afiliasi maka pemasar akan mendapatkan komisi dari penjualan tersebut. Komisi penjualan biasanya berupa persentasi dari harga barang yang telah terjual. Dalam kasus program afiliasi P.T. Valiant Technology, komisi yang diberikan bervariasi tergantung dari produk yang dijual.</p>
<h3>Bagaimana cara kerja Program Affiliate ini? </h3><hr>
<p align="justify">Andi mempunyai sebuah website yaitu ANDI-DOMAIN.COM dan Andi ingin memperoleh tambahan penghasilan dari websitenya tersebut. Andi memutuskan untuk bergabung dengan program affiliate kami. Dari banyaknya produk yang kami tawarkan Andi memutuskan untu mempromosikan produk gadget di websitenya tersebut.<br><br>

Putri bermaksud akan membeli tablet untuk kuliah. Putri lalu mencari informasi tablet murah yang tersedia di pasaran di internet. Putri menemukan website andi dan membaca artikel review di website Andi. Putri tertarik dan memutuskan membeli tablet tersebut dengan meng-klik banner di website Andi. Dalam kasus ini, Andi sebagai affiliate/marketing akan mendapatkan komisi atas pembelian yang dilakukan Putri.</p>
		<hr>
	<?php 	
		if ($login==true){ 
			if ($s_pangkat != 'affiliasi') {?> 
			
			<form method="post" action="verifikasi.php">
			<input type="hidden" value="reg_affiliasi" name="pengaturan">
			<input type="checkbox" name="term"> Saya tertarik untuk menjadi mitra affiliasi
			<?php if ($_GET['daftar'] == 'gagal'){
			echo "<font color='red'>Kolom ini harus dichecklist</font> ";} ?><br>
			<input type="submit" value="Daftar menjadi mitra affiliasi" class="formlogin" 
				style="background-color:#0066ff; color:#FFFFFF; cursor:pointer;"
				onmouseover="this.style.background='#FFFFFF';this.style.color='#3399FF';" 
				onmouseout="this.style.background='#0066ff';this.style.color='#FFFFFF';" />
			</form>
	<?php 
			}else {echo "Anda sudah terdaftar sebagai mitra affiliasi";}
		} 
		else {echo "Anda harus mendaftar sebagai member untuk menjadi mitra affiliasi <a href='daftar.php'> daftar disini </a>";}
	?>
	</div>
	<div class="isi" style="width:94.5%; font-size:12px; margin-top:20px;" align="center">
	<p>&copy; P.T. VALIANT TECHNOLOGY<br />Jl Kelapa Nias Raya No.62 Kelapa Gading - Jakarta timur
	<br> Kode Pos (14240) Telp : 021-51128266</p>
	</div>
	</body>
	</html>