<?php
require 'ceksesion.php';
if ($login != 'true'){
	header ("location:login.php");}
require 'db.php';
$nama=$_POST['nama'];
$alamat=$_POST['alamat'];
$lokasi=$_POST['lokasi'];
$notelp=$_POST['notelp'];
$idb = $_POST['idb'];
$jml = $_POST['jumlah'];
$idl=$_POST['idl'];


if (strlen($nama) <4){
	header ("location:pesan.php?idb=".$idb."&jml=".$jml."&err=nama");}
else if ($alamat==NULL || $alamat==''){
	header ("location:pesan.php?idb=".$idb."&jml=".$jml."&err=alamat");}
else if ($lokasi==NULL || $lokasi==''){
	header ("location:pesan.php?idb=".$idb."&jml=".$jml."&err=Kecamatan Kabupaten/Kota");}
else if (strlen($notelp)<10){
	header ("location:pesan.php?idb=".$idb."&jml=".$jml."&err=handphone");}
else if (is_numeric($notelp)){
	$notelp_db=@mysql_fetch_row(@mysql_query("SELECT notelp FROM user WHERE notelp = '$notelp' AND id_user != '$s_uid'"));
	if($notelp_db > 0){
		header ("location:pesan.php?idb=".$idb."&jml=".$jml."&err=phone");}
	else{$truephone='benar';}}
	
if (strlen($notelp)>9 && strlen($nama) >3 && $truephone=='benar' && $jml>0 && $jml<=99 && $idb>0){
	
	$query1=@mysql_query("SELECT `nm_barang`, `harga`, `stok`, `berat`, `panjang`,`lebar`,`tinggi`, `asuransi`, `packing_kayu`
						FROM barang WHERE id_barang='$idb' ");
	while ($hasil=mysql_fetch_array($query1)){
			$namabarang=$hasil[0];
			$harga=$hasil[1];
			$stok=$hasil[2];
			$berat=$hasil[3];
			$panjang=$hasil[4];
			$lebar=$hasil[5];
			$tinggi=$hasil[6];
			$asuransi=$hasil[7];
			$packing_kayu=$hasil[8];}
	
	if ($idl!=NULL){
	@mysql_query("UPDATE user SET notelp='$notelp', nama='$nama', alamat='$alamat', id_kota='$idl' WHERE id_user='$s_uid'");
	$_SESSION['d_nama']=$nama;
	$idla=$idl;}
	
	if ($idl==NULL) {
	@mysql_query("UPDATE user SET notelp='$notelp', nama='$nama', alamat='$alamat' WHERE id_user='$s_uid'");
	$_SESSION['d_nama']=$nama;
	$query3=mysql_query("SELECT `id_kota` FROM `user` WHERE id_user='$s_uid'");
	$idla=@mysql_result($query3,0,0);}
	
	if ($idla!=NULL){
	$query4=@mysql_query("SELECT `harga_ongkir`,`waktu_tiba` FROM `ongkir` WHERE `id_ongkir`='$idla'");
	$ongkir=@mysql_result($query4,0,0);
	$waktu_tiba=@mysql_result($query4,0,1);}
	
	if ($packing_kayu=='y'){
		$totalberat=ceil((($panjang*$jml)+12)*($lebar+10)*($tinggi+10)/ 6000);
		$query5=@mysql_query("SELECT harga FROM packing WHERE berat='$totalberat' LIMIT 1");
		$total_packing=@mysql_result($query5,0,0);}
	else {$totalberat=ceil($berat*$jml);
		$total_packing=0;}
	
	$query6=@mysql_query("SELECT `tanggal`, `id_unik` FROM transaksi ORDER BY `id_transaksi` DESC LIMIT 1");
	$tanggal_sebelum=@mysql_result($query6,0,0);
	$id_unik_lama=@mysql_result($query6,0,1);
	
	$hari=date("Y-m-d");
	if ($hari > $tanggal_sebelum)
		{$id_unik=1;}
	else {$id_unik=$id_unik_lama+1;}
	
	
	$totalharga=$harga*$jml;

	if ($asuransi=='y'){
		$asurans=ceil(($totalharga/1000000)*2);
		$total_asuransi=($asurans*1000)+5000;}
	else {$total_asuransi=0;}
	
	$total_ongkir=$ongkir*$totalberat;
	$jumlah=$totalharga+$total_ongkir+$total_packing+$total_asuransi+$id_unik;
	
	if 		(isset($_COOKIE['creff'])){
			$creff=$_COOKIE['creff'];}
			
	else if (!isset($_COOKIE['creff'])){
			$query="Select
					  komisi.id_referral
					From
					  komisi Inner Join
					  transaksi On komisi.id_transaksi =
					  transaksi.id_transaksi
					Where
					  transaksi.id_user = '16' and jenis='beli'
					Order By
					  komisi.id_transaksi desc
					Limit 1";
								  
			$hasil=@mysql_query($query);
			$creff=@mysql_result($hasil,0,0);
			if ($creff == NULL){
								$query2="Select
										  komisi.id_referral
										From
										  komisi Inner Join
										  transaksi On komisi.id_transaksi =
										  transaksi.id_transaksi
										Where
										  transaksi.id_user = '$s_uid' and jenis='daftar'
										Order By
										  komisi.id_transaksi desc
										Limit 1";
													  
								$hasil=@mysql_query($query2);
								$creff=@mysql_result($hasil,0,0);}
			}
	else {
		$creff = NULL;
	}

	@mysql_query("INSERT INTO `transaksi` (`tanggal`, `id_user`, `id_barang`, `harga`, `jumlah`, `id_unik`, 
	`ongkir`, `asuransi`, `packing`, `total_harga`,  `lama_pengiriman`, `status`,`tujuan` ) 
	VALUES (now(), '$s_uid', '$idb', '$harga', '$jml', '$id_unik', '$total_ongkir', '$total_asuransi', 
	'$total_packing', '$jumlah', '$waktu_tiba', 'pesan','<b>$nama</b><br>$alamat<br><br>$lokasi<br><br>Telp $notelp')");
	$idt=@mysql_insert_id(); 
	
	if ($creff != NULL and $creff >0 ){
		@mysql_query ("INSERT INTO `komisi` (`id_komisi`,`id_transaksi`, `jenis`, `id_referral`) 
		VALUES (NULL, '$idt', 'beli', '$creff')");}
	$queryd=@mysql_query("SELECT `id_refferal` FROM `user` WHERE `id_user`= '$s_uid' LIMIT 1;");	
	while ($hasil=@mysql_fetch_array($queryd)){
		$reff_d=$hasil[0];}
	if ($reff_d != NULL and $reff_d >0){
		@mysql_query ("INSERT INTO `komisi` (`id_komisi`, `id_transaksi`, `jenis`, `id_referral`) 
		VALUES (NULL, '$idt', 'daftar', '$reff_d')");}
	header ("location:pembelian.php?idt=".$idt);

}
?>