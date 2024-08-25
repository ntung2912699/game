<?php
session_start();
include('./includes/tlca_world.php');
$check=$tlca_do->load('class_check');
$class_index=$tlca_do->load('class_index');
$class_member=$tlca_do->load('class_member');
$param_url = parse_url($_SERVER['REQUEST_URI']);
parse_str($param_url['query'], $url_query);
$page=addslashes($url_query['page']);
$sort=addslashes($url_query['sort']);
if(!isset($_COOKIE['user_id'])){
	$thongbao="Bạn chưa đăng nhập...";
	$replace=array(
		'title'=>'Đang chuyển hướng',
		'description'=>$index_setting['description'],
		'thongbao'=>$thongbao,
		'link'=>'/dang-nhap.html'
	);
	echo $skin->skin_replace('skin/chuyenhuong',$replace);
	exit();
}
$setting=mysqli_query($conn,"SELECT * FROM index_setting ORDER BY name ASC");
while ($r_s=mysqli_fetch_assoc($setting)) {
	$index_setting[$r_s['name']]=$r_s['value'];
}
$page=intval($page);
if($page>1){
	$page=$page;
	$title_page=' - Page '.$page;
}else{
	$page=1;
	$title_page='';
}
if(!isset($_COOKIE['user_id'])){
	$box_account=$skin->skin_normal('skin/box_account_left_logout');
}else{
	$box_account=$skin->skin_normal('skin/box_account_left');
}
$user_info=$class_member->user_info($conn,$_COOKIE['user_id']);
$menu=json_decode($class_index->list_menu($conn),true);
$limit=50;
$thongke=mysqli_query($conn,"SELECT *,count(*) AS total FROM list_naptien WHERE accid='{$_COOKIE['user_id']}'");
$r_tk=mysqli_fetch_assoc($thongke);
$total_page=ceil($r_tk['total']/$limit);
$phantrang=$class_index->phantrang($page,$total_page,'/lich-su-nap.html');
$list_naptien=json_decode($class_index->list_naptien($conn,$_COOKIE['user_id'],$page,$limit),true);
$slide=json_decode($class_index->list_slide($conn),true);
$replace=array(
	'header'=>$skin->skin_normal('skin/header'),
	'topbar'=>$skin->skin_normal('skin/topbar'),
	'box_menu'=>$skin->skin_normal('skin/box_menu'),
	'box_left'=>$skin->skin_normal('skin/box_left'),
	'box_right'=>$skin->skin_normal('skin/box_right'),
	'footer'=>$skin->skin_normal('skin/footer'),
	'script_footer'=>$skin->skin_normal('skin/script_footer'),
	'box_slide'=>$skin->skin_normal('skin/box_slide_category'),
	'box_account_left'=>$box_account,
	'title'=>'Lịch sử nạp thẻ',
	'description'=>$index_setting['description'],
	'site_name'=>$index_setting['site_name'],
	'limit'=>$limit,
	'list_sukien_right'=>$class_index->list_right($conn,2,5),
	'list_tintuc_right'=>$class_index->list_right($conn,1,5),
	'list_camnang_right'=>$class_index->list_right($conn,4,5),
	'list_support'=>$class_index->list_support($conn),
	'list_category'=>$class_index->list_category($conn),
	'slide_detail'=>$slide['slide_detail'],
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
	'link_forum'=>$index_setting['link_forum'],
	'logo'=>$index_setting['logo'],
	'logo_footer'=>$index_setting['logo_footer'],
	'logo_center'=>$index_setting['logo_center'],
	'list_lichsu'=>$list_naptien['list'],
	'phantrang'=>$phantrang
	);
echo $skin->skin_replace('skin/lich_su_nap',$replace);
?>