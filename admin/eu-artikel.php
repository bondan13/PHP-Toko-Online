<?php
require "ceksesion.php";
require "db.php";
$idb=$_POST['idb'];
$namabarang=$_POST['namabarang'];
$deskripsi=$_POST['deskripsi'];
$id_katagori=$_POST['id_katagori'];
$harga=$_POST['harga'];
$komisi=$_POST['komisi'];
$stok=$_POST['stok'];
$berat=$_POST['berat'];
$asuransi=$_POST['asuransi'];
$packing=$_POST['packing'];
$panjang=$_POST['panjang'];
$lebar=$_POST['lebar'];
$tinggi=$_POST['tinggi'];
$pengaturan=$_POST['pengaturan'];



$script=array('<span id="sceditor-start-marker" class="sceditor-selection sceditor-ignore" style="line-height: 0; display: none;"></span>','<span id="sceditor-end-marker" class="sceditor-selection sceditor-ignore" style="line-height: 0; display: none;"></span>','<span class="sceditor-selection sceditor-ignore" style="line-height: 0; display: none;" id="sceditor-end-marker"></span>','<span class="sceditor-selection sceditor-ignore" style="line-height: 0; display: none;" id="sceditor-start-marker"></span>');
$rew_deskripsi=str_replace($script,'',$deskripsi);
$rew_deskripsi5=str_replace("'","&acute;",$rew_deskripsi);

$judulkecil=strtolower($namabarang);
$simbol=array('"','-','`',',','.','%');
$link2=str_replace($simbol,'',$judulkecil);
$simbol2=array('  ',' ');
$link=str_replace($simbol2,'-',$link2);

if($pengaturan=='insert'){
	mysql_query ("INSERT INTO `ragnarok`.`barang` (`id_barang`, `nm_barang`, 
	`link`, `deskripsi`, `id_katagori`, `harga`, `komisi`, `stok`, 
	`berat`, `panjang`, `lebar`, `tinggi`, `asuransi`, `packing_kayu`) VALUES (NULL, '$namabarang', '$link', '$rew_deskripsi5', 
	'$id_katagori', '$harga', '$komisi', '$stok', '$berat', '$panjang', '$lebar', '$tinggi', '$asuransi', '$packing')");

	$idb=mysql_insert_id();}

if ($pengaturan=='update'){
	mysql_query ("UPDATE  `ragnarok`.`barang` SET `nm_barang`='$namabarang', 
					`deskripsi`='$rew_deskripsi5', `link`='$link', `id_katagori`='$id_katagori', 
					`harga` = '$harga', `komisi` = '$komisi', `stok`='$stok', `berat`='$berat', 
					`panjang`='$panjang', `lebar`='$lebar', `tinggi`='$tinggi', `asuransi`='$asuransi', 
					`packing_kayu`='$packing', `publish`='y' WHERE  `barang`.`id_barang` ='$idb'");}		
unset ($_POST);
header ("location:tambahgambar.php?idb=$idb");
?>
