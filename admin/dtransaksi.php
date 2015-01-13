<?php 
require "ceksesion.php";
require 'db.php'; 
$idt=$_GET['idt'];
$query=mysql_query("Select
						  transaksi.id_transaksi,
						  transaksi.tanggal,
						  transaksi.id_user,
						  transaksi.tujuan,
						  transaksi.status,
						  transaksi.lama_pengiriman,
						  transaksi.nomor_resi,
						  transaksi.tanggal_bayar,
						  transaksi.tanggal_kirim,
						  transaksi.bank,
						  transaksi.harga,
						  transaksi.packing,
						  transaksi.asuransi,
						  transaksi.ongkir,
						  transaksi.id_unik,
						  transaksi.jumlah,
						  transaksi.total_harga,
						  transaksi.id_barang,
						  barang.nm_barang,
						  barang.komisi,
						  barang.stok
					From
						  transaksi Inner Join
						  barang On transaksi.id_barang = barang.id_barang
					Where
				 		 transaksi.id_transaksi = '$idt' LIMIT 1");
			  
		while ($baris =mysql_fetch_array($query)){
		$db_idt=$baris[0];
			if ($baris[1]!=NULL){
			$t_tanggal=date("j F Y", strtotime($baris[1]));}
		$id_u=$baris[2];
		$tujuan=$baris[3];
		$status=$baris[4];
		$lama_krm=$baris[5];
		$resi=$baris[6];
			if ($baris[7]!=NULL){
			$tgl_byr=date("j F Y", strtotime($baris[7]));}
			if ($baris[8]!=NULL){
			$tgl_krm=date("j F Y", strtotime($baris[8]));}
			if($baris[9]=='bni'){
			$bankbni='checked';}
			else if($baris[9]=='bca'){
			$bankbca='checked';}
		$harga=$baris[10];
		$packing=$baris[11];
		$asuransi=$baris[12];
		$ongkir=$baris[13];
		$idunik=$baris[14];
		$jumlah=$baris[15];
		$t_harga=$baris[16];
		$id_b=$baris[17];
		$nm_b=$baris[18];
		$komisi=$baris[19]*$jumlah;
		$stok=$baris[20];
		}
		if ($db_idt==NULL){header ("location:index.php");}
	if ($status=='konfirmasi'){
	$warn=" (User melakukan konfirmasi)";
	$warn2="<tfoot><tr><td colspan='2'><font color='red'>
	Segera check transaksi pada rekening yang diverifikasi</font></td></tr></tfoot>";
	}
	
$query2=mysql_query("select * FROM `komisi` WHERE `id_transaksi` = '$idt'");	
?>

<html>
<head>
<?php require'a_head.php';?>
<link rel="stylesheet" type="text/css" href="../tampilan/style-table.css">
<style>
	.tujuanpengiriman{
	border:1px solid #CCCCCC;
	background:url(../icon/header-bg.jpg); 
	padding:10px; 
	border-radius:10px;
	margin-bottom:3%;
	width:100%;}
</style>
<script>
$(function() {
$( ".tgp" ).datepicker({ dateFormat: "dd MM yy" });
});
</script>
</head>
<body>
<?php 
require 'a_top.php'; 
require 'a_menu.php';
?>

<div class='isi'>
	<div style="float:left; width:45%; margin-left:1%;">
		<div class="tujuanpengiriman">
		<b style="color:#0099FF;">Transaksi</b>
			<table id="rounded-corner">
			<thead>
				<tr>
					<th colspan="3">Detail Transaksi</th>
				</tr>
			</thead>
			<tbody>
			<tr>
			<td>Nomor Transaksi</td>
			<td><?php echo $db_idt; ?></td>
			</tr>
			<tr>
			<td>Tanggal pesan</td>
			<td><?php echo $t_tanggal; ?></td>
			</tr>
			<tr>
			<tr>
			<td>Status pesanan</td>
			<td><?php echo $status; ?></td>
			</tr>
			<tr>
			<td>Barang</td>
			<td><?php echo $nm_b; ?></td>
			</tr>
			<tr>
			<td>Harga</td>
			<td><?php echo "Rp ".number_format($harga,0,',','.'); ?></td>
			</tr>	
			<tr>
			<td>Jumlah</td>
			<td><?php echo $jumlah; ?></td>
			</tr>
			<tr>
			<td>Ongkir</td>
			<td><?php echo "Rp ".number_format($ongkir,0,',','.'); ?></td>
			</tr>
			<tr>
			<tr>
			<td>Asuransi</td>
			<td><?php echo "Rp ".number_format($asuransi,0,',','.'); ?></td>
			</tr>
			<tr>
			<td>Packing</td>
			<td><?php echo "Rp ".number_format($packing,0,',','.'); ?></td>
			</tr>
			
			<td>Id Unik</td>
			<td><?php echo "Rp ".number_format($idunik,0,',','.'); ?></td>
			</tr>
			<tr>
			<td>Total</td>
			<td><b><?php echo "Rp ".number_format($t_harga,0,',','.'); ?></b></td>
			</tr>		
			</tbody>
			</table>
		</div>
		<div class="tujuanpengiriman">
		<b style="color:#0099FF;">Komisi</b>
			<table id="rounded-corner">
			<thead>
				<tr>
					<th>Id User</th>
					<th>Jenis Komisi</th>
					<th>Jumlah</th>
				</tr>
			</thead>
			<tfoot>
				<tr>
				<td colspan="3" align="right">Maksimal komisi &nbsp;&nbsp; 
				<b><?php echo "Rp ".number_format($komisi,0,',','.'); ?></b></td>
				</tr>
			</tfoot>
			<tbody>
			<?php
			while ($hasil2=mysql_fetch_array($query2)){
					echo "<tr>";
					echo "<td>".$hasil2[3]."</td>";
					echo "<td>".$hasil2[2]."</td>";
					echo "<td>Rp ".number_format($hasil2[4],0,',','.')."</td>";
					echo "</tr>";}
			?>
			</tbody>
			</table>
		
		</div>
	</div>
	<div style="float:left; width:45%; margin-left:5%;">
		<div class="tujuanpengiriman" align="justify";>
		<b style="color:#0099FF;">Tujuan pengiriman</b><hr>
		<?php echo $tujuan; ?>
		</div>
	
		<div class="tujuanpengiriman" style="padding-bottom:40px;">
		<b style="color:#0099FF;">Pembayaran</b><b style="color:#FF0000;"><?php echo $warn; ?></b>
		<form method="post" action="verifikasi.php">
		<input type="hidden" value="batal" name="pengaturan">
		<input type="hidden" name="idt" value="<?php echo $idt; ?>">
		<table id="rounded-corner">
			<thead>
				<tr>
					<th colspan="2">Verifikasi Pembayaran
					<input type="submit" value="batalkan konfirmasi" style="float:right;">
					</form>		
				</th>
				</tr>
			</thead>
			<?php echo $warn2;  ?>
			<tbody>
				<form method="post" action="verifikasi.php">
				<input type="hidden" value="<?php echo $idt; ?>" name="idt">
				<input type="hidden" value="lnss" name="pengaturan">
				<tr>
				<td>Tanggal bayar</td>
				<td>
				<input type='text' class='tgp' style="border:1px solid #3399FF; background:none;" 
				name='tgl_byr' value='<?php echo $tgl_byr; ?>'></td>
				</tr>
				<tr>
				<td>Bank</td>
				<td>
				<input type="radio" name="bank" value='BNI' <?php echo $bankbni; ?> ><img src="../icon/bni.jpg"><br>
				<input type="radio" name="bank" value='BCA' <?php echo $bankbca; ?> ><img src="../icon/bca.jpg">
				</td>
				</tr>
			</tbody>
			</table>
			<input type="submit" value="Update" style="float:right; margin-top:10px;">
		</form>
		</div>
		
		<div class="tujuanpengiriman" style="padding-bottom:40px;">
		<b style="color:#0099FF;">Pengiriman</b>
		<form method="post" action="verifikasi.php">
		<input type="hidden" value="<?php echo $idt; ?>" name="idt">
		<input type="hidden" value="kirim" name="pengaturan">
		<table id="rounded-corner">
			<thead>
				<tr>
					<th colspan="2">Informasi Pengiriman</th>
				</tr>
			</thead>
			<tfoot>
				<tr>
				<td colspan="2">barang akan tiba dalam waktu <?php echo $lama_krm; ?> hari</td>
				</tr>
			</tfoot>
			<tbody>
				<tr>
				<td>Tanggal kirim</td>
				<td>
				<input type='text' class='tgp' style="border:1px solid #3399FF; background:none;" 
				name='tgl_krm' value='<?php echo $tgl_krm; ?>'></td>
				</tr>
				<tr>
				<td>No Resi</td>
				<td>
				<input type="text" name="resi" maxlength="20" value="<?php echo $resi; ?>" 
				style="border:1px solid #3399FF; background:none;"  >
				</td>
				</tr>
			</tbody>
			</table>
			<input type="submit" value="Update" style="float:right; margin-top:10px;">
		</form>
		</div>
	</div>


</div>

</body>
</html>
 
