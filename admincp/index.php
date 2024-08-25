<?php
session_start();
include('../includes/tlca_world_admin.php');
$check=$tlca_do->load('class_check');
$class_index=$tlca_do->load('class_cpanel');
$param_url = parse_url($_SERVER['REQUEST_URI']);
parse_str($param_url['query'], $url_query);
$page=addslashes($url_query['page']);
$skin=$tlca_do->load('class_skin_cpanel');
if(intval($page)<1){
	$page=1;
}else{
	$page=intval($page);
}
if(isset($_REQUEST['action'])){
	$action=addslashes($_REQUEST['action']);
}else{
	$action='dashboard';
}
if(!isset($_COOKIE['emin_id'])){
	$thongbao="Bạn chưa đăng nhập.<br>Đang chuyển hướng tới trang đăng nhập...";
	$replace=array(
		'title'=>'Bạn chưa đăng nhập...',
		'description'=>$index_setting['description'],
		'thongbao'=>$thongbao,
		'link_chuyen'=>'/admincp/login'
	);
	echo $skin->skin_replace('skin_cpanel/chuyenhuong',$replace);
	exit();
}
$user_id=$_COOKIE['emin_id'];
$class_e_member=$tlca_do->load('class_e_member');
$user_info=$class_e_member->user_info($conn,$user_id);
$tach_name=explode(' ', $user_info['name']);
$name=$tach_name[count($tach_name) -1];
$setting=mysqli_query($conn,"SELECT * FROM index_setting ORDER BY name ASC");
while ($r_s=mysqli_fetch_assoc($setting)) {
	$index_setting[$r_s['name']]=$r_s['value'];
}
$thaythe=array(
	'header'=>$skin->skin_normal('skin_cpanel/header'),
	'box_menu'=>$skin->skin_normal('skin_cpanel/box_menu'),
	'footer'=>$skin->skin_normal('skin_cpanel/footer'),
	'box_script_footer'=>$skin->skin_normal('skin_cpanel/box_script_footer'),
	'description'=>$index_setting['description'],
	'site_name'=>$index_setting['site_name'],
	//'phantrang'=>$class_index->phantrang($page,$total_page,'/'),
	'phantrang'=>'',
	'fullname'=>$user_info['name'],
	'email'=>$user_info['email'],
	'point'=>$user_info['user_money'],
	'name'=>$name,
	'avatar'=>$user_info['avatar']
);
if($action=='profile'){
	$thaythe['title']='Profile';
	$thaythe['title_action']='Profile';
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/profile',$user_info);
}else if($action=='change_password'){
	$thaythe['title']='Change Password';
	$thaythe['title_action']='Change Password';
	$bien=array(
		'phantrang'=>$class_index->phantrang($page,$total,10,'/admincp/list-nhac')
	);
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/change_password',$bien);
}else if($action=='list_slide'){
	$thaythe['title']='Danh sách slide';
	$thaythe['title_action']='Danh sách slide';
	$limit=100;
	$thongke=mysqli_query($conn,"SELECT count(*) AS total FROM slide");
	$r_tk=mysqli_fetch_assoc($thongke);
	$total_page=ceil($r_tk['total']/$limit);
	$bien=array(
		'list_slide'=>$class_index->list_slide($conn,$page,$limit),
		'phantrang'=>$class_index->phantrang($page,$total_page,'/admincp/list-slide')
	);
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/list_slide',$bien);
}else if($action=='add_slide'){
	$thaythe['title']='Thêm slide mới';
	$thaythe['title_action']='Thêm slide mới';
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/add_slide',$r_tt);
}else if($action=='edit_slide'){
	$thaythe['title']='Chỉnh sửa slide';
	$thaythe['title_action']='Chỉnh sửa slide';
	$id=preg_replace('/[^0-9]/', '', $url_query['id']);
	$thongtin=mysqli_query($conn,"SELECT *, count(*) AS total FROM slide WHERE id='$id'");
	$r_tt=mysqli_fetch_assoc($thongtin);
	if($r_tt['total']==0){
		$thongbao="Slide không tồn tại...";
		$replace=array(
			'title'=>'Slide không tồn tại...',
			'description'=>$index_setting['description'],
			'thongbao'=>$thongbao,
			'link_chuyen'=>'/admincp/list-slide'
		);
		echo $skin->skin_replace('skin_cpanel/chuyenhuong',$replace);
		exit();
	}
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/edit_slide',$r_tt);
}else if($action=='list_support'){
	$thaythe['title']='Danh sách hỗ trợ';
	$thaythe['title_action']='Danh sách hỗ trợ';
	$limit=100;
	$thongke=mysqli_query($conn,"SELECT count(*) AS total FROM support");
	$r_tk=mysqli_fetch_assoc($thongke);
	$total_page=ceil($r_tk['total']/$limit);
	$bien=array(
		'list_support'=>$class_index->list_support($conn,$page,$limit),
		'phantrang'=>$class_index->phantrang($page,$total_page,'/admincp/list-support')
	);
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/list_support',$bien);
}else if($action=='add_support'){
	$thaythe['title']='Thêm hỗ trợ mới';
	$thaythe['title_action']='Thêm hỗ trợ mới';
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/add_support',$r_tt);
}else if($action=='edit_support'){
	$thaythe['title']='Chỉnh sửa hỗ trợ';
	$thaythe['title_action']='Chỉnh sửa hỗ trợ';
	$id=preg_replace('/[^0-9]/', '', $url_query['id']);
	$thongtin=mysqli_query($conn,"SELECT *, count(*) AS total FROM support WHERE id='$id'");
	$r_tt=mysqli_fetch_assoc($thongtin);
	if($r_tt['total']==0){
		$thongbao="Dữ liệu không tồn tại...";
		$replace=array(
			'title'=>'Slide không tồn tại...',
			'description'=>$index_setting['description'],
			'thongbao'=>$thongbao,
			'link_chuyen'=>'/admincp/list-support'
		);
		echo $skin->skin_replace('skin_cpanel/chuyenhuong',$replace);
		exit();
	}
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/edit_support',$r_tt);
}else if($action=='list_naptien-moi'){
	$thaythe['title']='Nạp tiền mới';
	$thaythe['title_action']='Nạp tiền mới';
	$limit=100;
	$thongke=mysqli_query($conn,"SELECT count(*) AS total FROM list_naptien WHERE tinh_trang='0'");
	$r_tk=mysqli_fetch_assoc($thongke);
	$total_page=ceil($r_tk['total']/$limit);
	$bien=array(
		'list_naptien'=>$class_index->list_naptien($conn,0,$page,$limit),
		'phantrang'=>$class_index->phantrang($page,$total_page,'/admincp/list-naptien-moi')
	);
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/list_naptien-moi',$bien);
}else if($action=='list_naptien-hoanthanh'){
	$thaythe['title']='Nạp tiền hoàn thành';
	$thaythe['title_action']='Nạp tiền hoàn thành';
	$limit=100;
	$thongke=mysqli_query($conn,"SELECT count(*) AS total FROM list_naptien WHERE tinh_trang='1'");
	$r_tk=mysqli_fetch_assoc($thongke);
	$total_page=ceil($r_tk['total']/$limit);
	$bien=array(
		'list_naptien'=>$class_index->list_naptien($conn,1,$page,$limit),
		'phantrang'=>$class_index->phantrang($page,$total_page,'/admincp/list-naptien-hoanthanh')
	);
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/list_naptien-hoanthanh',$bien);
}else if($action=='list_naptien-huy'){
	$thaythe['title']='Nạp tiền đã hủy';
	$thaythe['title_action']='Nạp tiền đã hủy';
	$limit=100;
	$thongke=mysqli_query($conn,"SELECT count(*) AS total FROM list_naptien WHERE tinh_trang='2'");
	$r_tk=mysqli_fetch_assoc($thongke);
	$total_page=ceil($r_tk['total']/$limit);
	$bien=array(
		'list_naptien'=>$class_index->list_naptien($conn,2,$page,$limit),
		'phantrang'=>$class_index->phantrang($page,$total_page,'/admincp/list-naptien-huy')
	);
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/list_naptien-huy',$bien);
}else if($action=='list_thanhvien'){
	$thaythe['title']='Danh sách thành viên';
	$thaythe['title_action']='Danh sách thành viên';
	$limit=100;
	$thongke=mysqli_query($conn,"SELECT count(*) AS total FROM account");
	$r_tk=mysqli_fetch_assoc($thongke);
	$total_page=ceil($r_tk['total']/$limit);
	$bien=array(
		'list_thanhvien'=>$class_index->list_thanhvien($conn,0,$page,$limit),
		'phantrang'=>$class_index->phantrang($page,$total_page,'/admincp/list-thanhvien')
	);
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/list_thanhvien',$bien);
}else if($action=='edit_thanhvien'){
	$thaythe['title']='Chỉnh sửa thành viên';
	$thaythe['title_action']='Chỉnh sửa thành viên';
	$id=preg_replace('/[^0-9]/', '', $url_query['id']);
	$thongtin=mysqli_query($conn,"SELECT *, count(*) AS total FROM account WHERE accid='$id'");
	$r_tt=mysqli_fetch_assoc($thongtin);
	if($r_tt['total']==0){
		$thongbao="Thành viên không tồn tại.<br>Đang chuyển hướng tới danh sách thành viên...";
		$replace=array(
			'title'=>'Thành viên không tồn tại...',
			'description'=>$index_setting['description'],
			'thongbao'=>$thongbao,
			'link_chuyen'=>'/admincp/list-thanhvien'
		);
		echo $skin->skin_replace('skin_cpanel/chuyenhuong',$replace);
		exit();
	}
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/edit_thanhvien',$r_tt);
}else if($action=='edit_naptien'){
	$thaythe['title']='Chỉnh sửa nạp tiền';
	$thaythe['title_action']='Chỉnh sửa nạp tiền';
	$id=preg_replace('/[^0-9]/', '', $url_query['id']);
	$thongtin=mysqli_query($conn,"SELECT *, count(*) AS total FROM list_naptien WHERE id='$id'");
	$r_tt=mysqli_fetch_assoc($thongtin);
	if($r_tt['total']==0){
		$thongbao="Giao dịch không tồn tại...";
		$replace=array(
			'title'=>'Giao dịch không tồn tại...',
			'description'=>$index_setting['description'],
			'thongbao'=>$thongbao,
			'link_chuyen'=>'/admincp/list-naptien-moi'
		);
		echo $skin->skin_replace('skin_cpanel/chuyenhuong',$replace);
		exit();
	}
	if($r_tt['tinh_trang']==1){
		$r_tt['option_active']='<option value="1" selected="selected">Hoàn thành</option><option value="2">Đã hủy</option><option value="0">Chưa hoàn thành</option>';
	}else if($r_tt['tinh_trang']==2){
		$r_tt['option_active']='<option value="1">Hoàn thành</option><option value="2"  selected="selected">Đã hủy</option><option value="0">Chưa hoàn thànhh</option>';
	}else{
		$r_tt['option_active']='<option value="1">Hoàn thành</option><option value="2">Đã hủy</option><option value="0" selected="selected">Chưa hoàn thành</option>';
	}
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/edit_naptien',$r_tt);
}else if($action=='edit_setting'){
	$thaythe['title']='Chỉnh sửa cài đặt';
	$thaythe['title_action']='Chỉnh sửa cài đặt';
	$id=preg_replace('/[^0-9a-zA-Z_-]/', '', $url_query['id']);
	$kieu=preg_replace('/[^0-9a-zA-Z_-]/', '', $url_query['loai']);
	$thongtin=mysqli_query($conn,"SELECT *, count(*) AS total FROM index_setting WHERE name='$id'");
	$r_tt=mysqli_fetch_assoc($thongtin);
	if($r_tt['total']==0){
		$thongbao="Mục cài đặt không tồn tại...";
		$replace=array(
			'title'=>'Mục cài đặt không tồn tại...',
			'description'=>$index_setting['description'],
			'thongbao'=>$thongbao,
			'link_chuyen'=>'/admincp/list-setting'
		);
		echo $skin->skin_replace('skin_cpanel/chuyenhuong',$replace);
		exit();
	}
	if($kieu=='img'){
		$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/edit_setting_img',$r_tt);
	}else{
		$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/edit_setting',$r_tt);
	}
}else if($action=='list_theloai'){
	$thaythe['title']='Danh sách thể loại';
	$thaythe['title_action']='Danh sách thể loại';
	$limit=50;
	$thongke=mysqli_query($conn,"SELECT count(*) AS total FROM category");
	$r_tk=mysqli_fetch_assoc($thongke);
	$total_page=ceil($r_tk['total']/$limit);
	$bien=array(
		'list_theloai'=>$class_index->list_category($conn,$page,$limit),
		'phantrang'=>$class_index->phantrang($page,$total_page,'/admincp/list-theloai')
	);
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/list_theloai',$bien);
}else if($action=='add_naptien'){
	$thaythe['title']='Thêm giao dịch mới';
	$thaythe['title_action']='Thêm giao dịch mới';
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/add_naptien',$r_tt);
}else if($action=='add_theloai'){
	$thaythe['title']='Thêm thể loại';
	$thaythe['title_action']='Thêm thể loại';
	$r_tt['option_main']=$class_index->list_option_main($conn,'');
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/add_theloai',$r_tt);
}else if($action=='edit_theloai'){
	$thaythe['title']='Chỉnh sửa thể loại';
	$thaythe['title_action']='Chỉnh sửa thể loại';
	$id=preg_replace('/[^0-9]/', '', $url_query['id']);
	$thongtin=mysqli_query($conn,"SELECT *, count(*) AS total FROM category WHERE cat_id='$id'");
	$r_tt=mysqli_fetch_assoc($thongtin);
	if($r_tt['total']==0){
		$thongbao="Thể loại không tồn tại...";
		$replace=array(
			'title'=>'Thể loại không tồn tại...',
			'description'=>$index_setting['description'],
			'thongbao'=>$thongbao,
			'link_chuyen'=>'/admincp/list-theloai'
		);
		echo $skin->skin_replace('skin_cpanel/chuyenhuong',$replace);
		exit();
	}
	$r_tt['option_main']=$class_index->list_option_main($conn,$r_tt['cat_main']);
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/edit_theloai',$r_tt);
}else if($action=='list_menu'){
	$thaythe['title']='Danh sách menu';
	$thaythe['title_action']='Danh sách menu';
	$limit=100;
	$thongke=mysqli_query($conn,"SELECT count(*) AS total FROM menu");
	$r_tk=mysqli_fetch_assoc($thongke);
	$total_page=ceil($r_tk['total']/$limit);
	$bien=array(
		'list_menu'=>$class_index->list_menu($conn,$page,$limit),
		'phantrang'=>$class_index->phantrang($page,$total_page,'/google/list-menu')
	);
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/list_menu',$bien);
}else if($action=='add_menu'){
	$thaythe['title']='Thêm menu mới';
	$thaythe['title_action']='Thêm menu mới';
	$r_tt['option_category']=$class_index->list_option_category($conn,'');
	$r_tt['option_main']=$class_index->list_option_main_menu($conn,'');

	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/add_menu',$r_tt);
}else if($action=='edit_menu'){
	$thaythe['title']='Chỉnh sửa menu';
	$thaythe['title_action']='Chỉnh sửa menu';
	$id=preg_replace('/[^0-9]/', '', $url_query['id']);
	$thongtin=mysqli_query($conn,"SELECT *, count(*) AS total FROM menu WHERE menu_id='$id'");
	$r_tt=mysqli_fetch_assoc($thongtin);
	if($r_tt['total']==0){
		$thongbao="Menu này không tồn tại...";
		$replace=array(
			'title'=>'Menu không tồn tại...',
			'description'=>$index_setting['description'],
			'thongbao'=>$thongbao,
			'link_chuyen'=>'/admincp/list-menu'
		);
		echo $skin->skin_replace('skin_cpanel/chuyenhuong',$replace);
		exit();
	}
	$r_tt['option_category']=$class_index->list_option_category($conn,'');
	$r_tt['option_main']=$class_index->list_option_main_menu($conn,$r_tt['menu_main']);
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/edit_menu',$r_tt);
}else if($action=='list_post' OR $action=='dashboard'){
	$thaythe['title']='Danh sách bài viết';
	$thaythe['title_action']='Danh sách bài viết';
	$limit=10;
	$thongke=mysqli_query($conn,"SELECT count(*) AS total FROM post");
	$r_tk=mysqli_fetch_assoc($thongke);
	$total_page=ceil($r_tk['total']/$limit);
	$bien=array(
		'list_baiviet'=>$class_index->list_baiviet($conn,$page,$limit),
		'phantrang'=>$class_index->phantrang($page,$total_page,'/admincp/list-post')
	);
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/list_post',$bien);
}else if($action=='add_post'){
	$thaythe['title']='Thêm bài viết mới';
	$thaythe['title_action']='Thêm bài viết mới';
	$r_tt['option_category']=$class_index->list_div_category($conn,'');
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/add_post',$r_tt);
}else if($action=='edit_post'){
	$thaythe['title']='Chỉnh sửa bài viết';
	$thaythe['title_action']='Chỉnh sửa bài viết';
	$id=preg_replace('/[^0-9]/', '', $url_query['id']);
	$thongtin=mysqli_query($conn,"SELECT *, count(*) AS total FROM post WHERE id='$id'");
	$r_tt=mysqli_fetch_assoc($thongtin);
	if($r_tt['total']==0){
		$thongbao="Bài viết không tồn tại...";
		$replace=array(
			'title'=>'Bài viết không tồn tại...',
			'description'=>$index_setting['description'],
			'thongbao'=>$thongbao,
			'link_chuyen'=>'/admincp/list-post'
		);
		echo $skin->skin_replace('skin_cpanel/chuyenhuong',$replace);
		exit();
	}
	$r_tt['option_category']=$class_index->list_div_category($conn,$r_tt['cat']);
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/edit_post',$r_tt);
}else if($action=='list_page'){
	$thaythe['title']='Danh sách trang';
	$thaythe['title_action']='Danh sách trang';
	$limit=10;
	$thongke=mysqli_query($conn,"SELECT count(*) AS total FROM page");
	$r_tk=mysqli_fetch_assoc($thongke);
	$total_page=ceil($r_tk['total']/$limit);
	$bien=array(
		'list_page'=>$class_index->list_page($conn,$page,$limit),
		'phantrang'=>$class_index->phantrang($page,$total_page,'/admincp/list-page')
	);
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/list_page',$bien);
}else if($action=='add_page'){
	$thaythe['title']='Thêm trang mới';
	$thaythe['title_action']='Thêm trang mới';
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/add_page',$r_tt);
}else if($action=='edit_page'){
	$thaythe['title']='Chỉnh sửa trang';
	$thaythe['title_action']='Chỉnh sửa trang';
	$id=preg_replace('/[^0-9]/', '', $url_query['id']);
	$thongtin=mysqli_query($conn,"SELECT *, count(*) AS total FROM page WHERE id='$id'");
	$r_tt=mysqli_fetch_assoc($thongtin);
	if($r_tt['total']==0){
		$thongbao="Trang không tồn tại...";
		$replace=array(
			'title'=>'Trang không tồn tại...',
			'description'=>$index_setting['description'],
			'thongbao'=>$thongbao,
			'link_chuyen'=>'/admincp/list-page'
		);
		echo $skin->skin_replace('skin_cpanel/chuyenhuong',$replace);
		exit();
	}
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/edit_page',$r_tt);
}else if($action=='contact_detail'){
	$thaythe['title']='Chi tiết liên hệ';
	$thaythe['title_action']='Chi tiết liên hệ';
	$id=preg_replace('/[^0-9]/', '', $url_query['id']);
	$thongtin=mysqli_query($conn,"SELECT *, count(*) AS total FROM contact WHERE id='$id' ORDER BY id DESC LIMIT 1");
	$r_tt=mysqli_fetch_assoc($thongtin);
	if($r_tt['total']==0){
		$thongbao="Liên hệ không tồn tại...";
		$replace=array(
			'title'=>'Liên hệ không tồn tại...',
			'description'=>$index_setting['description'],
			'thongbao'=>$thongbao,
			'link_chuyen'=>'/admincp/list-contact'
		);
		echo $skin->skin_replace('skin_cpanel/chuyenhuong',$replace);
		exit();
	}
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/contact_detail',$r_tt);
}else if($action=='list_setting'){
	$thaythe['title']='Danh sách cài đặt';
	$thaythe['title_action']='Danh sách cài đặt';
	$limit=100;
	$thongke=mysqli_query($conn,"SELECT count(*) AS total FROM index_setting");
	$r_tk=mysqli_fetch_assoc($thongke);
	$total_page=ceil($r_tk['total']/$limit);
	$bien=array(
		'list_setting'=>$class_index->list_setting($conn,$page,$limit),
		'phantrang'=>$class_index->phantrang($page,$total_page,'/admincp/list-setting')
	);
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/list_setting',$bien);
}else{

}
echo $skin->skin_replace('skin_cpanel/index',$thaythe);
?>