<?php
require 'ceksesion.php';
require 'db.php';	
if ($login!='true'){header('Location:login.php');}	
if ($s_pangkat!='affiliasi'){header('Location:profile.php');}				
//=====================================================================halaman
	$itemperpage=15;
	if (isset($_GET['h'])){
		$hal=$_GET['h'];
		$posisi=($hal-1)*$itemperpage;}
	else if (empty($_GET['h'])){
		$hal=1;
		$posisi=0;}
//=====================================================================halaman
$query=@mysql_query("Select Distinct
					  bayar_komisi.tgl_pengajuan,
					  bayar_komisi.jumlah,
					  bayar_komisi.tgl_dibayar,
					  bayar_komisi.status,
					  bayar_komisi.id_bayar_k
					From
					  bayar_komisi Inner Join
					  komisi On bayar_komisi.id_bayar_k = komisi.id_bk
					Where
					  komisi.id_referral = '$s_uid' 
					ORDER BY bayar_komisi.tgl_pengajuan DESC 
					LIMIT $posisi,$itemperpage ");

//=====================================================================halaman
$jumlahdata=@mysql_num_rows(mysql_query("SELECT  id_bayar_k FROM bayar_komisi WHERE bayar_komisi.id_refferal='$s_uid'"));
$jumlahhalaman=ceil($jumlahdata/$itemperpage);
//=====================================================================halaman	
?>
<html>
	<head>
		<title>Pembayaran komisi</title>
	<?php require'head.php'; ?>
	<link rel="stylesheet" type="text/css" href="tampilan/style-table.css">
	<script>
		$(function() {
		$( ".katag" ).button();
		});
	</script>
	</head>
	<body>
	<?php 
	require 'top.php';
	require 'menu.php'; 
	?> 
	<div class="isi">
	<div class="katag"><a href="profile.php">Profil </a></div> <div class="katag"><a href="user-transaksi.php">Transaksi</a></div>
		<?php 
		if ($s_pangkat == 'affiliasi'){
			echo "<div class='katag'><a href='komisi.php'>Komisi</a></div> ";
			echo "<div class='katag'><a href='req_payment.php'>Pembayaran Komisi</a></div>";}
		?>
	<hr>
	<table id="rounded-corner" summary="2007 Major IT Companies' Profit">
		<thead>
			<tr>
				<th width="100">Tgl pengajuan</th>
				<th width="100">Jumlah</th>
				<th width="80">Tgl dibayar</th>
				<th width="80">Status</th>
			</tr>
		</thead>
			<tbody>
			<?php 
			while ($baris=@mysql_fetch_array($query)){
				echo "<tr>";
				echo "<td >".date("j F Y", strtotime($baris[0]))."</td>";
				echo "<td >Rp ".number_format($baris[1],0,',','.')."</td>";
				echo "<td >";
				if ($baris[2]!=NULL){
					echo date("j F Y", strtotime($baris[2]));}
				echo "</td><td >".$baris[3]."</td>";
				echo "</tr>";}
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
						echo "<a href='".$_SERVER['HTTP_SERVER']."/design/komisi.php'>first</a>";}
						
					if ($jumlahhalaman>1){
						for ($i=$blockhal; $i<=$itemblok; $i++){
							echo "<a class='paging' href='".$_SERVER['HTTP_SERVER'].
							"/design/komisi.php?h=".$i."'>".$i."</a>";}
						}
							
					if ($jumlahhalaman>5 && $jumlahhalaman-2 > $hal){
						echo "<a href='".$_SERVER['HTTP_SERVER']."/design/komisi.php?h=".$jumlahhalaman."'>last</a>";}		
					echo "</div></div>";	
	//=====================================================================halaman
	?>
	</div>
	<?php include "footer.php"; ?>
	</body>
</html>