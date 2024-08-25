<?php
include('../includes/tlca_world_admin.php');
if(isset($_COOKIE['emin_id']) AND intval($_COOKIE['emin_id'])>0){
	$class_e_member=$tlca_do->load('class_e_member');
	$class_e_member->logout();
	$thongbao="Đăng xuất tài khoản thành công.";
	$skin=$tlca_do->load('class_skin_cpanel');
	$replace=array(
		'title'=>'Đăng xuất tài khoản...',
		'description'=>$index_setting['description'],
		'thongbao'=>$thongbao,
		'link_chuyen'=>'/admincp/login'
	);
	echo $skin->skin_replace('skin_cpanel/chuyenhuong',$replace);
}else{
	$thongbao="Hiện tại bạn chưa đăng nhập.";
	$skin=$tlca_do->load('class_skin_cpanel');
	$replace=array(
		'title'=>'Đăng xuất tài khoản...',
		'description'=>$index_setting['description'],
		'thongbao'=>$thongbao,
		'link_chuyen'=>'/admincp/login'
	);
	echo $skin->skin_replace('skin_cpanel/chuyenhuong',$replace);
}
?>