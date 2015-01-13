<?php
include'ceksesion.php';
include 'db.php';
$pengaturan=$_POST['pengaturan'];
$getp=$_GET['pengaturan'];

if($pengaturan== NULL && $getp==NULL){header('Location:.');}

if ($pengaturan=='komentar'){
	$komentar=$_POST['komentar'];
	$idb=$_POST['idb'];
	if($komentar != NULL && $idb >0){
		@mysql_query("INSERT INTO `komentar` (`id_komentar`, `id_barang`, `id_user`,
		`tanggal`, `komentar`, `status`) VALUES (NULL, '$idb', '$s_uid', now(), '$komentar', 'm');");
						
		echo '<script>alert("Komentar anda telah masuk dan sedang dimoderasi");
			window.location = "'. $_SERVER['HTTP_REFERER'].'";</script>';}
	else {header('Location: ' . $_SERVER['HTTP_REFERER']);}
	}

if ($pengaturan=='konfirmasi'){
	$bank=$_POST['bank'];
	$idt=$_POST['idt'];
	if($bank == 'BNI' || $bank == 'BCA'){
		@mysql_query("UPDATE `transaksi` SET `status` = 'konfirmasi', `bank`= '$bank', 
		`tanggal_bayar` = now() WHERE `transaksi`.`id_transaksi` ='$idt' 
		AND `transaksi`.`id_user` = '$s_uid' ;");}
	header('Location: ' . $_SERVER['HTTP_REFERER']);}
	
if ($pengaturan=='upass'){
	$p_lama=$_POST['p_lama'];
	$p1_baru=$_POST['p1_baru'];
	$p2_baru=$_POST['p2_baru'];
	if (strlen ($p_lama)>3 && strlen ($p1_baru)>3 && strlen ($p2_baru)>3){
		$hasil=@mysql_query("SELECT password FROM user WHERE id_user = '$s_uid' ;");
		$d_p_lama=@mysql_result($hasil,0,0);
		if (md5($p_lama)==$d_p_lama && $p1_baru==$p2_baru){
			$p_baru=md5($p1_baru);
			@mysql_query("UPDATE `user` SET `password` = '$p_baru' WHERE `id_user` ='$s_uid';");
			header('Location:profile.php?upass=sukses');}
		else {header('Location:profile.php?upass=gagal');}}
	else {header('Location:profile.php?upass=gagal');}}
	
if ($pengaturan=='reqpass'){
	$notelp=$_POST['notelp'];
	if (strlen ($notelp)>9 && is_numeric($notelp)){
		$hasil=@mysql_query("SELECT id_user FROM user WHERE notelp = '$notelp' ;");
		$id_user=@mysql_result($hasil,0,0);
		if ($id_user != NULL && $id_user != '' && $id_user > 0){
			$passwor=rand(1000, 999999);
			$password=md5($passwor);
			@mysql_query("INSERT INTO req_pass VALUES (NULL, '$id_user', '$passwor')");
			@mysql_query("UPDATE user SET password = '$password' WHERE id_user = '$id_user'");
			header('Location:index.php?reset=sukses');}
		else {header('Location:lupapass.php?reset=gagal');}}
	else {header('Location:lupapass.php?reset=salah');}}

if ($pengaturan=='reg_affiliasi'){
	$term=$_POST['term'];
	$pangkats=mysql_result(@mysql_query ("SELECT  pangkat FROM user WHERE `id_user` ='$s_uid'"),0,0);
	if ($term=='on' && $pangkats=='user'){
		@mysql_query ("UPDATE  `user` SET  `pangkat` =  'affiliasi' WHERE  `id_user` ='$s_uid'");
		@mysql_query ("INSERT INTO refferal VALUES ('$s_uid',NULL,NULL)");
		$_SESSION['d_pangkat']='affiliasi';
		header('Location:profile.php');}
	else {header('Location:req_affiliasi.php?daftar=gagal');}}
	
if ($getp=='req_payment'){
	$jkomisi=@mysql_result(mysql_query
		("SELECT SUM(jumlah) FROM komisi WHERE jumlah > 0 AND status='valid' AND id_referral= 	'$s_uid'"),0,0);
	if ($jkomisi >= 50000){
		@mysql_query("INSERT INTO `bayar_komisi` VALUES (NULL, now(), '$jkomisi', 'diajukan', NULL);");
		$idbk=mysql_insert_id();
		@mysql_query("UPDATE komisi SET id_bk='$idbk', status='diajukan' 
		WHERE jumlah > 0 AND status='valid' AND id_referral='$s_uid'");}
	header('Location: ' . $_SERVER['HTTP_REFERER']);}
?>