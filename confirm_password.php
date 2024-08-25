<?php
session_start();
include('./includes/tlca_world.php');
$check=$tlca_do->load('class_check');
$class_index=$tlca_do->load('class_index');
$param_url = parse_url($_SERVER['REQUEST_URI']);
parse_str($param_url['query'], $url_query);
$email=addslashes($url_query['email']);
$token=addslashes($url_query['token']);
$thongtin=mysqli_query($conn,"SELECT *, count(*) AS total FROM forgot_password WHERE email='$email' AND code_active='$token'");
$r_tt=mysqli_fetch_assoc($thongtin);
if($r_tt['total']==0){
	$thongbao="Link không tồn tại hoặc đã được sử dụng...";
	$replace=array(
		'title'=>'Đang chuyển hướng',
		'description'=>$index_setting['description'],
		'thongbao'=>$thongbao,
		'link'=>'/'
	);
	echo $skin->skin_replace('skin/chuyenhuong',$replace);
}else{
	$pass=md5($r_tt['password']);
	mysqli_query($conn,"UPDATE account SET password_hash='$pass' WHERE cEMail='$email'");
	mysqli_query($conn,"DELETE FROM forgot_password WHERE email='$email'");
	$thongbao="Kích hoạt mật khẩu mới thành công...";
	$replace=array(
		'title'=>'Đang chuyển hướng',
		'description'=>$index_setting['description'],
		'thongbao'=>$thongbao,
		'link'=>'/dang-nhap.html'
	);
	echo $skin->skin_replace('skin/chuyenhuong',$replace);
}
?>