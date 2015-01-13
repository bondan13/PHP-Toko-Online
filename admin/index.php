<?php 
require 'ceksesion.php';
require 'db.php';
$j_pesan=@mysql_num_rows(mysql_query("SELECT `id_transaksi` FROM `transaksi` WHERE `tanggal` < NOW() - INTERVAL 2 DAY AND `status` = 'pesan'"));

$j_konfir=@mysql_num_rows(mysql_query("SELECT `id_transaksi` FROM `transaksi` WHERE `status` = 'konfirmasi'"));

$req_pass=@mysql_num_rows(mysql_query("SELECT `id_req_pass` FROM `req_pass` "));

$komentar=@mysql_num_rows(mysql_query("SELECT `id_komentar` FROM `komentar` WHERE status='m'"));

?>
<html>
<head>
<?php require 'a_head.php';?>
<script>
	$( document ).ready(function() {
	$('#konfirm').on('click', function () {
			return confirm('Order akan dihapus dari database.');
		});
	});
</script>
</head>
<body>
<?php 
require 'a_top.php';
require 'a_menu.php';
?>
<div class="isi">
	<div style="float:left; width:auto; margin-bottom:15px;">

	<?php 
		if ($j_pesan > 0){
			echo "<a id='konfirm' class='createuser' href='verifikasi.php?p=transaksi&opsi=del'>
			Ada ".$j_pesan." pesanan yang tidak ditindak lanjuti lebih dari 24 jam  [Hapus]</a><br><br>";}
		if ($j_konfir > 0){
			echo "<a class='createuser' href='transaksi.php?c=konfirmasi'>
			Ada ".$j_konfir." konfirmasi pembayaran belum diverifikasi [Proses]</a><br><br>";}
		if ($req_pass > 0){
			echo "<a class='createuser' href='req_pass.php'>
			Ada ".$req_pass." user mengajukan lupa password [Proses]</a><br><br>";}
		if ($komentar > 0){
			echo "<a class='createuser' href='komentar.php?c=moderasi'>
			Ada ".$komentar." komentar masuk </a><br><br>";}
	?>
	</div>	
</div>
</body>
</html>

