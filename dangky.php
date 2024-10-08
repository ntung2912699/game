<?php
session_start();
include('./includes/tlca_world.php');
$check=$tlca_do->load('class_check');
$class_index=$tlca_do->load('class_index');
$param_url = parse_url($_SERVER['REQUEST_URI']);
parse_str($param_url['query'], $url_query);
$page=addslashes($url_query['page']);
$sort=addslashes($url_query['sort']);
if(isset($_COOKIE['user_id'])){
	$thongbao="Bạn đã đăng nhập...";
	$replace=array(
		'title'=>'Đang chuyển hướng',
		'description'=>$index_setting['description'],
		'thongbao'=>$thongbao,
		'link'=>'/thong-tin.html'
	);
	echo $skin->skin_replace('skin/chuyenhuong',$replace);
	exit();
}
$setting=mysqli_query($conn,"SELECT * FROM index_setting ORDER BY name ASC");
while ($r_s=mysqli_fetch_assoc($setting)) {
	$index_setting[$r_s['name']]=$r_s['value'];
}
$limit=30;
$menu=json_decode($class_index->list_menu($conn),true);
$replace=array(
	'header'=>$skin->skin_normal('skin/header'),
	'topbar'=>$skin->skin_normal('skin/topbar'),
	'footer'=>$skin->skin_normal('skin/footer'),
	'script_footer'=>$skin->skin_normal('skin/script_footer'),
	'box_slide'=>$skin->skin_normal('skin/box_slide'),
	'title'=>'Đăng ký tài khoản',
	'description'=>$index_setting['description'],
	'site_name'=>$index_setting['site_name'],
	'limit'=>$limit,
	'menu_left'=>$menu['menu_left'],
	'menu_right'=>$menu['menu_right'],
	'menu_tintuc'=>$menu['tintuc'],
	'menu_camnang'=>$menu['camnang'],
	'menu_canbiet'=>$menu['canbiet'],
	'menu_congdong'=>$menu['congdong'],
	'menu_footer'=>$menu['footer'],
	'menu_hotro'=>$menu['hotro'],
	'text_footer'=>$index_setting['text_footer'],
	'text_about'=>$index_setting['text_about'],
	'link_xem'=>$index_setting['link_domain'],
	'link_contact'=>$index_setting['link_contact'],
	'link_trailer'=>$index_setting['link_trailer'],
	'photo'=>$index_setting['photo'],
	'logo'=>$index_setting['logo'],
	'logo_footer'=>$index_setting['logo_footer'],
	'logo_center'=>$index_setting['logo_center'],
	);
echo $skin->skin_replace('skin/dangky',$replace);
?>