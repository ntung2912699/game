<?php
session_start();
include('./includes/tlca_world.php');
$check=$tlca_do->load('class_check');
$class_index=$tlca_do->load('class_index');
$param_url = parse_url($_SERVER['REQUEST_URI']);
parse_str($param_url['query'], $url_query);
$page=addslashes($url_query['page']);
$sort=addslashes($url_query['sort']);
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
$link=addslashes(strip_tags($_REQUEST['blank']));
$thongtin=mysqli_query($conn,"SELECT *,count(*) AS total FROM category WHERE cat_blank='$link'");
$r_tt=mysqli_fetch_assoc($thongtin);
if($r_tt['total']==0){
	$thongbao="Dữ liệu không tồn tại...";
	$replace=array(
		'title'=>'Đang chuyển hướng',
		'description'=>$index_setting['description'],
		'thongbao'=>$thongbao,
		'link'=>'/'
	);
	echo $skin->skin_replace('skin/chuyenhuong',$replace);
	exit();
}
if(!isset($_COOKIE['user_id'])){
	$box_account=$skin->skin_normal('skin/box_account_left_logout');
}else{
	$box_account=$skin->skin_normal('skin/box_account_left');
}
$cat=$r_tt['cat_id'];
$limit=10;
$thongke=mysqli_query($conn,"SELECT *,count(*) AS total FROM post WHERE FIND_IN_SET($cat,cat)>0");
$r_tk=mysqli_fetch_assoc($thongke);
$total_page=ceil($r_tk['total']/$limit);
$phantrang=$class_index->phantrang($page,$total_page,'/the-loai/'.$link.'.html');
$list_baiviet=json_decode($class_index->list_tintuc($conn,$cat,$page,$limit),true);
$menu=json_decode($class_index->list_menu($conn),true);
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
	'title'=>$r_tt['cat_title'].''.$title_page,
	'description'=>$r_tt['cat_description'],
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
	'slide_detail'=>$slide['slide_detail'],
	'text_footer'=>$index_setting['text_footer'],
	'text_about'=>$index_setting['text_about'],
	'link_xem'=>$index_setting['link_domain'].'the-loai/'.$link.'.html',
	'link_forum'=>$index_setting['link_forum'],
	'link_fb'=>$index_setting['link_fb'],
	'photo'=>$index_setting['photo'],
	'logo'=>$index_setting['logo'],
	'logo_footer'=>$index_setting['logo_footer'],
	'logo_center'=>$index_setting['logo_center'],
	'tieu_de'=>$r_tt['cat_tieude'],
	'list_baiviet'=>$list_baiviet['list'],
	'list_sukien_right'=>$class_index->list_right($conn,2,5),
	'list_tintuc_right'=>$class_index->list_right($conn,1,5),
	'list_camnang_right'=>$class_index->list_right($conn,4,5),
	'list_support'=>$class_index->list_support($conn),
	'list_category'=>$class_index->list_category($conn),
	'phantrang'=>$phantrang
	);
echo $skin->skin_replace('skin/category',$replace);
?>