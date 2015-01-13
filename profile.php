<?php
require 'ceksesion.php';
if ($login!='true'){ header ("location:login.php"); }

	require 'db.php';
	$query3= @mysql_query("select * from user where id_user = '$s_uid' LIMIT 1");
		$alamat=@mysql_result($query3,0,4);
		$id_kota=@mysql_result($query3,0,5);
		$no_telp=@mysql_result($query3,0,1);
	$query4= @mysql_query("select * from kota where id_wilayah = '$id_kota' ");
		$idl=@mysql_result($query4,0,0);
		$kota=@mysql_result($query4,0,1);
	
	if ($s_pangkat == 'affiliasi'){
		$query5= @mysql_query("select * from refferal where id_user = '$s_uid' ");
			$norek=@mysql_result($query5,0,1);
			$bank=@mysql_result($query5,0,2);
		if ($norek==NULL){
		$e_border=1;
		$toltipe='title="nomor rekening bank anda"';}
		if ($bank==NULL){
		$f_border=1;
		$toltipf='title="nama bank anda"';}}
		
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
	
	?>
	<html>
	<head>
		<title>
			<?php echo $s_nama; ?> profile
		</title>
	<?php require "head.php";  ?>
	<style>
	.tujuanpengiriman{
		border:1px solid #CCCCCC;
		background:url(icon/header-bg.jpg); 
		padding:10px; 
		padding-bottom:0px;
		border-radius:10px;
		width:350px;
		float:left;
		margin-right:50px;
		margin-bottom:50px;}
	
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
		font-family:Geneva, Arial, Helvetica, sans-serif;
		}
	
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
		$( ".katag" ).button();
		});
	
		$(function() {
		$( document ).tooltip();
		});
		
		<?php if ($_GET['edit']=='gagal_notelp'){
					echo 'alert("Nomor telepon sudah terdaftar oleh akun lain");';}
		?>
	</script>
	
	</head>
	<body>
	<?php 
	require "top.php"; 
	require "menu.php";
	?>
	<div class="isi">
	<div class="katag">Profil</div> <div class="katag"><a href="user-transaksi.php">Transaksi</a></div>	
	<?php 
	if ($s_pangkat == 'affiliasi'){
	echo "<div class='katag'><a href='komisi.php'>Komisi</a></div> ";
	echo "<div class='katag'><a href='req_payment.php'>Pembayaran Komisi</a></div>";}
	
	if ($_GET['upass'] != NULL){
		if ($_GET['upass']=='sukses'){
			echo "<font color='red'> Password berhasil diubah</font>";}
		else{echo "<font color='red'> Password gagal diubah</font>";}
	}?>
	<hr>
		<div class="tujuanpengiriman">
			<font size="2">
				<form method="post" action="submit.php">
					<input type="hidden" name="pengaturan" value="edit-profile">
					<input class="formpesan" type="text" name="nama" maxlength="40" value="<?php echo $s_nama; ?>" 
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
					<input class="formpesan" type="text" name="notelp" maxlength="12" 
					value="<?php echo $no_telp; ?>" style="width:272px; border:<?php echo $d_border; ?>px solid #CCCCCC;">
					<?php if ($s_pangkat == 'affiliasi'){ ?>
					No rekening &nbsp;
					<input class="formpesan" type="text" name="norek" maxlength="20" 
					value="<?php echo $norek; ?>" <?php echo $toltipe; ?> 
					style="width:269px; border:<?php echo $e_border; ?>px solid #CCCCCC;">
					Bank <input class="formpesan" type="text" name="bank" maxlength="15" 
					value="<?php echo $bank; ?>" <?php echo $toltipf; ?> 
					style="width:315px; border:<?php echo $f_border; ?>px solid #CCCCCC;">
					<?php } ?>
					<br><input type="submit" value="Simpan" class="katag" 
					style="font-size:12px; color:#000000; float:right; margin-bottom:10px;">
				</form>
			</font>		
		</div>
		
		<font size="2">
		<b>Catatan</b>
			<ul type="square" style="color:#666666;">
			<li >Klik untuk mengedit data diri</li>
			<li >Mohon untuk mengisi data dengan benar dan lengkap.</li>
			<li>Agar lebih mudah dalam pengiriman barang, sebaiknya sertakan nama jalan, 
			nama perumahan, desa/kelurahan, gang, RT, RW, dan nomor rumah pada kolom alamat.</li>
			<li> Kamu dapat mengubah password <a href="upassword.php">disini.</a></li>
			</ul>
		</font>	
	</div>
	<?php include 'footer.php'; ?>
	</body>
	</html>

