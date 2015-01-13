<?php
require 'ceksesion.php';
require 'db.php';
if ($login!='true'){header ("location:login.php");}
	if (isset ($_POST['idb']) && isset($_POST['jumlah']) ){
		$idb=$_POST['idb'];
		$jumlah=$_POST['jumlah'];}
	else{
	$idb=$_GET['idb'];
	$jumlah=$_GET['jml'];
	$error=$_GET['err'];}
	
	$query3= @mysql_query("select * from user where id_user = '$s_uid' LIMIT 1");
		$alamat=@mysql_result($query3,0,4);
		$id_kota=@mysql_result($query3,0,5);
		$no_telp=@mysql_result($query3,0,1);
	$query4= @mysql_query("select nama from kota where id_wilayah = '$id_kota' ");
		$kota=@mysql_result($query4,0,0);
	
	if ($alamat==NULL){
		$a_border=1;
		$toltipa='title="Untuk memudahkan pengiriman, tulis alamat dengan lengkap"';}
	if ($kota==NULL){
		$b_border=1;
		$toltip="title='Autocomplete, tulis minimal 4 karakter'";}
	if ($s_nama==NULL){
		$c_border=1;}
	if ($no_telp==NULL){
		$d_border=1;}	
	if (isset($error)){
		if ($error=='phone'){
		$ket=" (Nomor handphone sudah terdaftar di akun lain)";}
		else{$ket=" (Form ".$error." harus diisi)";}}
	
	?>
	<html>
	<head>
		<title>
			Tujuan pengiriman
		</title>
	<?php require "head.php";  ?>
	<style>
	.judul{
		font-size:18px;
		font-weight:bold;
		margin-bottom:10px;}
	
	.tujuanpengiriman{
		border:1px solid #CCCCCC;
		background:url(icon/header-bg.jpg); 
		padding:10px; 
		padding-bottom:0px;
		border-radius:10px;
		width:350px;
		float:left;
		margin-right:50px}
	
	.formpesan{
		background:url(icon/header-bg.jpg); 
		border:0px;
		border-radius:5px;}
	
	#alamat{
		border:<?php echo $a_border; ?>px solid #CCCCCC;
		font-size:12px;
		margin-bottom:5px;
		width:350px; 
		height:50px;
		font-family:Geneva, Arial, Helvetica, sans-serif;}
	
	.ui-autocomplete-loading {
		background: white url('images/ui-anim_basic_16x16.gif') right center no-repeat;}
	</style>
	
	<script>
		$(function() {
		$( "#kabupaten" ).autocomplete({
		minLength: 4,
		source: "lokasi.php",
			select: function(event, ui) { 
				$("#searchField").val(ui.item.id);
				$("#searchForm").submit(); }
		});
		});

		$(function() {
		$( document ).tooltip();
		});
	</script>
	
	</head>
	<body>
	<?php 
		require "top.php"; 
		require "menu.php";
	?>
	<div class="isi">
	<div class="judul">Tujuan Pengiriman <font color="#FF0000"><?php echo $ket; ?></font></div>
	<form method="post" action="vtransaksi.php" name="harga">
		<div class="tujuanpengiriman">
			<font size="2">
					<input type="hidden" name="jumlah" value="<?php echo $jumlah; ?>">
					<input type="hidden" name="idb" value="<?php echo $idb; ?>">
					<input class="formpesan" type="text" name="nama" value="<?php echo $s_nama; ?>" 
					style="font-size:14px; font-weight:bold; width:350px; border:<?php echo $c_border; ?>px solid #CCCCCC;">	
					<br>
					Alamat</b><br>
					<textarea id="alamat" class="formpesan" 
					name="alamat" <?php echo $toltipa; ?>><?php echo $alamat; ?></textarea>			
					<br>
					Kecamatan, Kabupaten/Kota</b>
					<div class="ui-widget">
					<input class="formpesan" id="kabupaten" type="text" <?php echo $toltip; ?>
					style="border:<?php echo $b_border; ?>px solid #CCCCCC; width:350px; margin-bottom:10px;" 
					value="<?php echo $kota; ?>" name="lokasi">
					<input id="searchField" type="hidden" name="idl">
					</div>
					Handphone &nbsp;
					<input class="formpesan" type="text" name="notelp" 
					value="<?php echo $no_telp; ?>" style="width:272px; border:<?php echo $d_border; ?>px solid #CCCCCC;">
				
			</font>
		</div>
	
		<font size="2">
		<b>Catatan</b>
			<ul type="square" style="color:#666666;">
			<li >Klik untuk mengedit data diri</li>
			<li >Mohon untuk mengisi data dengan benar dan lengkap.</li>
			<li >Kami tidak bertanggung jawab apabila ada kesalahan pengiriman.</li>
			
			</ul>
		</font>
		
			<div align="right" style="margin-top:70px;"><input type="submit" value="Lanjutkan" id="searchForm"></div>
		</form>		
	</div>
	</body>
	<?php include 'footer.php'; ?>
	</html>