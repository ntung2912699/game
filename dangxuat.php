<?php
include('./includes/tlca_world.php');
$limit=30;
if(isset($_COOKIE['user_id']) AND intval($_COOKIE['user_id'])>0){
	$class_member->logout();
	$thongbao="Đăng xuất thành công.";
	$replace=array(
		'title'=>'Đăng xuất tài khoản...',
		'description'=>$index_setting['description'],
		'thongbao'=>$thongbao,
		'link'=>'/'
	);
	echo $skin->skin_replace('skin/chuyenhuong',$replace);
}else{
	$thongbao="Bạn chưa đăng nhập.";
	$replace=array(
		'title'=>'Đăng xuất tài khoản...',
		'description'=>$index_setting['description'],
		'thongbao'=>$thongbao,
		'link'=>'/'
	);
	echo $skin->skin_replace('skin/chuyenhuong',$replace);
}
?>