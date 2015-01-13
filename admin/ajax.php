<?php
if(isset($_GET['t']) and $_GET['t'] == "ajax"){
	include('db.php');
	$t_width = 175; // Maximum thumbnail width
	$t_height = 150; // Maximum thumbnail height
	$path="../gambar/";
	extract($_GET);
	$ratio = ($t_width/$w);
	$nw = ceil($w * $ratio);
	$nh = ceil($h * $ratio);
	$nimg = imagecreatetruecolor($nw,$nh);
	$im_src = imagecreatefromjpeg($path.$img);
	imagecopyresampled($nimg,$im_src,0,0,$x1,$y1,$nw,$nh,$w,$h);
	$new_name = str_replace ('.','s.',$img);
	imagejpeg($nimg,$path.$new_name,90);
	$valid_formats = array("jpg", "png", "gif", "bmp");
	$id_image= str_replace ($valid_formats,'',$img);
	mysql_query("UPDATE foto SET foto_kecil='$new_name' WHERE id_foto='$id_image'");
	$query=mysql_query("select id_barang from foto where id_foto='$id_image'");
	$id_barang=@mysql_result($query,0,0);
	header ("location:tambahgambar.php?idb=$id_barang");
	}
else {
	header ("location:index.php");}
?>