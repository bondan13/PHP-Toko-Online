<?php
require 'ceksesion.php';
require 'db.php';
$id_user=$_GET['idu'];
//=====================================================================halaman
	$itemperpage=5;
	if (isset($_GET['h'])){
		$hal=$_GET['h'];
		$posisi=($hal-1)*$itemperpage;}
	else if (empty($_GET['h'])){
		$hal=1;
		$posisi=0;}
//=====================================================================halaman
if	(isset($_GET['c'])){
	$opsi=$_GET['c'];
	if ($opsi=='komisi'){
		$query=@mysql_query("SELECT id_komisi,id_transaksi,jenis,jumlah,status
					FROM komisi
					WHERE  jumlah > 0 AND id_referral= '$id_user'
			  		ORDER BY id_transaksi DESC LIMIT $posisi,$itemperpage ");
		$jumlahdata=@mysql_num_rows(mysql_query("SELECT id_komisi FROM komisi 
		WHERE  jumlah > 0 AND id_referral= '$id_user'"));}
		
	if ($opsi=='payment'){
		$query=@mysql_query("Select DISTINCT
							  bayar_komisi.id_bayar_k,
							  komisi.id_referral,
							  bayar_komisi.tgl_pengajuan,
							  bayar_komisi.jumlah,
							  bayar_komisi.status,
							  bayar_komisi.tgl_dibayar
							From
							  bayar_komisi Inner Join
							  komisi On bayar_komisi.id_bayar_k = komisi.id_bk
							WHERE komisi.id_referral='$id_user'
							ORDER BY bayar_komisi.tgl_pengajuan DESC LIMIT $posisi,$itemperpage ");
		$jumlahdata=@mysql_num_rows(mysql_query("SELECT  id_bayar_k FROM bayar_komisi 
		WHERE bayar_komisi.id_refferal='$id_user'"));}
	$link="&c=".$opsi;}
else{
$query=mysql_query("Select transaksi.id_transaksi, transaksi.tanggal, barang.nm_barang, transaksi.status, transaksi.jumlah
					From
					barang Inner Join transaksi On transaksi.id_barang = barang.id_barang WHERE id_user='$id_user' ORDER BY 		            		transaksi.tanggal desc LIMIT $posisi,$itemperpage");
$jumlahdata=mysql_num_rows(mysql_query("SELECT id_transaksi FROM transaksi WHERE id_user='$id_user'")); }
//=====================================================================halaman
$jumlahhalaman=ceil($jumlahdata/$itemperpage);
//===========================================================halaman	

	$request=@mysql_query("Select Distinct
							  bayar_komisi.id_bayar_k,
							  bayar_komisi.tgl_pengajuan,
							  bayar_komisi.jumlah							  
							  From
								 bayar_komisi Inner Join
								 komisi On bayar_komisi.id_bayar_k = komisi.id_bk
							  WHERE komisi.id_referral='$id_user' AND bayar_komisi.status = 'diajukan' LIMIT 1");
		$id_bayar=@mysql_result($request,0,0);
		$tgl_pengajuan=@mysql_result($request,0,1);
		$jumlah=@mysql_result($request,0,2);
	$query3= @mysql_query("select * from user where id_user = '$id_user' LIMIT 1");
		$nama=@mysql_result($query3,0,3);
		$alamat=@mysql_result($query3,0,4);
		$id_kota=@mysql_result($query3,0,5);
		$no_telp=@mysql_result($query3,0,1);
		$id_reff=@mysql_result($query3,0,6);
		$pangkat=@mysql_result($query3,0,7);

	$query4= mysql_query("select nama from kota where id_wilayah = '$id_kota' ");
		$kota=@mysql_result($query4,0,0);
	
	$query5= @mysql_query("select * from refferal where id_user = '$id_user' LIMIT 1");
		$norek=@mysql_result($query5,0,1);
		$rekbank=@mysql_result($query5,0,2);	
	
	if ($alamat==NULL){
		$a_border=1;}
	if ($kota==NULL){
		$b_border=1;}
	if ($nama==NULL){
		$c_border=1;}
	if ($no_telp==NULL){
		$d_border=1;}	
	
	?>
	<html>
	<head>
	<?php require "a_head.php";  ?>
	<link rel="stylesheet" type="text/css" href="../tampilan/style-table.css">
	<style>
	.tujuanpengiriman{
	border:1px solid #CCCCCC;
	background:url(icon/header-bg.jpg); 
	padding:10px; 
	border-radius:10px;
	width:45%;
	float:left;}
	
	.formpesan{
	background:url(icon/header-bg.jpg); 
	border:0px;
	border-radius:5px;}
	
	#alamat{
	border:<?php echo $a_border; ?>px solid #CCCCCC;
	font-size:12px;
	margin-bottom:5px;
	width:100%; 
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
		$( ".tgp" ).datepicker({ dateFormat: "dd MM yy" });
		});
	</script>
		
	</head>
	<body>
	<?php 
	require "a_top.php"; 
	require "a_menu.php";
	?>
	<div class="isi">
		<div class="tujuanpengiriman" style="margin-right:10px; font-size:14px;">
		<?php echo "<b>".$nama."</b><br><br>"; 
			  echo "Alamat<br>".$alamat."<br><br>";
			  echo "Kecamatan, Kabupaten/Kota<br>".$kota."<br><br>";
			  echo "Hp ".$no_telp; ?>
		</div>
		<div class="tujuanpengiriman">
		<table id="rounded-corner">
				<tr>
					<td>User Type</td>
					<td>
					<?php echo $pangkat;
					if ($pangkat != 'non aktif'){
						echo " <a href='verifikasi.php?idu=".$id_user."&p=user&opsi=nonaktif'>&nbsp;&nbsp;[non aktifkan]</a>"; }
					if ($pangkat == 'non aktif'){
						echo " <a href='verifikasi.php?idu=".$id_user."&p=user&opsi=aktif'>&nbsp;&nbsp;[aktifkan]</a>"; }?>
					</td>
				</tr>
				<?php 
				if ($id_reff != NULL){
					echo "<tr><td>Daftar melalui</td><td><a href='d-user.php?idu=".$id_reff."'>".$id_reff."</a></td></tr>";}
				
				if ($norek != NULL ){
					echo "<tr><td>No rekening</td><td>".$norek."</td></tr>";
					echo "<tr><td>Bank</td><td>".$rekbank."</td></tr>";}?>
		</table>
		</table>
		</div>
	

			<?php if($id_bayar != NULL){?>
			<div class="tujuanpengiriman">
				<table id="rounded-corner"><thead><tr><th >
					<?php echo "<b>".$nama. "</b> Mengajukan pebayaran komisi sebesar Rp ".number_format($jumlah,0,',','.')." 
					pada ".date("j F Y", strtotime($tgl_pengajuan)); ?>
					</th></tr><tbody><tr><td>
					<form method="post" action="verifikasi.php">
					<input type="hidden" name="idp" value="<?php echo $id_bayar; ?>">
					<input type="hidden" name="pengaturan" value="bayar_k">
					Tgl <input type="text" name="tgl_bayar_k" class="tgp" style="width:42%;"> 
					<input type="submit" value="bayar" name="opsi">
					<input type="submit" value="tolak" name="opsi">
					</form>
					</td></tr></tbody>
				</thead></table>
			</div>				
			<?php }?>

			
	</div>
	<div class="isi" style="margin-left:20%; margin-top:10px;">	
	<div style="float:left; width:auto; margin-bottom:15px;">
	<a class='createuser' href="d-user.php?idu=<?php echo $id_user; ?>"> Transaksi</a>
	<a class='createuser' href="d-user.php?idu=<?php echo $id_user; ?>&c=komisi"> Komisi</a>
	<a class='createuser' href="d-user.php?idu=<?php echo $id_user; ?>&c=payment"> Pembayaran Komisi</a>
	</div>
	<table id="rounded-corner">
<?php 
if ($opsi=='komisi'){ ?>
		<thead>
			<tr>
				<th >No Faktur</th>
				<th >Jenis Komisi</th>
				<th >Jumlah</th>
				<th>Status</th>

			</tr>
		</thead>
		<tbody>
			<?php						
			while ($baris =@mysql_fetch_array($query)){	
				echo "<tr>";
				echo "<td><a href='../admin/dtransaksi.php?idt=".$baris[1]."'>".$baris[1]."</a></td>";	
				echo "<td >".$baris[2]."</td>";
				echo "<td >Rp ".number_format($baris[3],0,',','.')."</td>";
				echo "<td>";
				if ($baris[4] == 'valid'){
					echo $baris[4]."<a href='verifikasi.php?idk=".$baris[0]."&p=komisi&opsi=tdkvalid'>
					&nbsp;&nbsp;[batalkan]</a>"; }
				if ($baris[4] == 'ditolak'){
					echo $baris[4]."<a href='verifikasi.php?idk=".$baris[0]."&p=komisi&opsi=valid'>
					&nbsp;&nbsp;[ini valid]</a>"; }
				if ($baris[4] == 'dibayar'){
					echo $baris[4];}	
				if ($baris[4] == 'diajukan'){
					echo $baris[4];}				
				echo "</td>";
				echo "</tr>";}
}
if ($opsi=='payment'){ ?>
		<thead>
			<tr>
				<th width="100">Tgl pengajuan</th>
				<th width="100">Jumlah</th>
				<th width="80">Status</th>
				<th width="80">Tgl dibayar</th>
				

			</tr>
		</thead>
		<tbody>
			<?php						
			while ($baris =@mysql_fetch_array($query)){	
				echo "<tr>";
				echo "<td >".date("j F Y", strtotime($baris[2]))."</td>";
				echo "<td >Rp ".number_format($baris[3],0,',','.')."</td>";
				echo "<td >".$baris[4]."</td><td>";
				if ($baris[5]!=NULL){
					echo date("j F Y", strtotime($baris[5]));}
				echo "</td>";
				echo "</tr>";}
}
else if ($opsi=='') { ?>
    <thead>
    	<tr>
        	<th scope="col" class="rounded-company" width="100">Tanggal</th>
            <th scope="col" class="rounded-q1" width="100">ID Transaksi</th>
            <th scope="col" class="rounded-q2">Barang</th>
            <th scope="col" class="rounded-q3" width="100">Jumlah</th>
            <th scope="col" class="rounded-q4" width="100">Status</th>
        </tr>
    </thead>
	<tbody>
<?php 
	while ($baris=@mysql_fetch_array($query)){
		echo "<tr>";
		echo "<td>".date("j F Y", strtotime($baris[1]))."</td>";
		echo "<td>".$baris[0]."</td>";
		echo "<td>".substr($baris[2], 0, 45)."</td>";
		echo "<td>".$baris[4]."</td>";
		echo "<td>".$baris[3]."</td>";
		echo "</tr>";}
}
?>
    </tbody>
</table>
<?php
//=====================================================================halaman				
				echo "<div align='center' style='width:100%; float:inherit; margin-top:10px;'>";
				if ($hal<=3){
					$blockhal=1;}
					else if ($hal==$jumlahhalaman-1 && $jumlahhalaman>5){
					$blockhal=$hal-3;}
					else if ($hal==$jumlahhalaman && $jumlahhalaman>5){
					$blockhal=$hal-4;}
					else {
					$blockhal=$hal-2;}
					
					
				if ($jumlahhalaman<=3){
					$itemblok=$jumlahhalaman;}
					else if ($hal==$jumlahhalaman-1){
					$itemblok=$hal+1;}
					else if ($hal==$jumlahhalaman){
					$itemblok=$hal;}
					else if ($jumlahhalaman==4){
					$itemblok=4;}
					else if ($hal <=3 && $jumlahhalaman>4){
					$itemblok=5;}
					else{
					$itemblok=$hal+2;}
					
				echo "<div class='paging'>";
				
				if ($hal>3){
					echo "<a href='".$_SERVER['HTTP_SERVER']."/design/admin/d-user.php?idu=".$id_user."'>first</a>";}
					
				if ($jumlahhalaman>1){
					for ($i=$blockhal; $i<=$itemblok; $i++){
						echo "<a class='paging' href='".$_SERVER['HTTP_SERVER'].
						"/design/admin/d-user.php?idu=".$id_user.$link."&h=".$i."'>".$i."</a>";}
					}
						
				if ($jumlahhalaman>5 && $jumlahhalaman-2 > $hal){
					echo "<a href='".$_SERVER['HTTP_SERVER']."/design/admin/d-user.php?idu=".$id_user.$link."&h=".$jumlahhalaman."'>last</a>";}		
				echo "</div></div>";	
//=====================================================================halaman
?>
	</div>
	</body>
	</html>
<script>
$(function() {
$( ".katag" ).button();
});
</script>
