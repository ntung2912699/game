<?php
session_start();
include('../includes/tlca_world_admin.php');
include_once("../class.phpmailer.php");
$check=$tlca_do->load('class_check');
$action=addslashes($_REQUEST['action']);
$class_index=$tlca_do->load('class_cpanel');
$skin=$tlca_do->load('class_skin_cpanel');
$class_e_member=$tlca_do->load('class_e_member');
$setting=mysqli_query($conn,"SELECT * FROM index_setting ORDER BY name ASC");
while ($r_s=mysqli_fetch_assoc($setting)) {
	$index_setting[$r_s['name']]=$r_s['value'];
}
if($action=="dangnhap"){
	$username=addslashes(strip_tags($_REQUEST['username']));
	$password=addslashes($_REQUEST['password']);
	$remember=strip_tags(addslashes($_REQUEST['remember']));
	$ketqua=$class_e_member->login($conn,$username,$password,$remember);
	if($ketqua==200){
		$ok=1;
		$thongbao="Đăng nhập thành công";
	}else if($ketqua==0){
		$ok=0;
		$thongbao="Vui lòng nhập username";
	}else if($ketqua==1){
		$ok=0;
		$thongbao="Tài khoản không tồn tại";
	}else if($ketqua==2){
		$ok=0;
		$thongbao="Mật khẩu không chính xác";
	}else{
		$ok=0;
		$thongbao="Gặp lỗi khi xử lý";
	}
	$info=array(
		'ok'=>$ok,
		'thongbao'=>$thongbao
	);
	echo json_encode($info);

}else if($action=='add_post'){
	if(!isset($_COOKIE['emin_id'])){
		$ok=0;
		$thongbao='Bạn chưa đăng nhập';
	}else{
		$tieu_de=addslashes(strip_tags($_REQUEST['tieu_de']));
		$title=addslashes(strip_tags($_REQUEST['title']));
		$cat=addslashes(strip_tags($_REQUEST['cat']));
		$link=addslashes(strip_tags($_REQUEST['link']));
		$description=addslashes(strip_tags($_REQUEST['description']));
		$short_description=addslashes(strip_tags($_REQUEST['short_description']));
		$noidung=addslashes($_REQUEST['noidung']);
	    $duoi = $check->duoi_file($_FILES['file']['name']);
		$thongtin=mysqli_query($conn,"SELECT *, count(*) AS total FROM seo WHERE link='$link'");
		$r_tt=mysqli_fetch_assoc($thongtin);
		if($r_tt['total']==0){
			if(in_array($duoi, array('jpg','jpeg','png','gif'))==true){
				$minh_hoa='/uploads/minh_hoa/'.$check->blank($tieu_de).'-'.time().'.'.$duoi;
			    move_uploaded_file($_FILES['file']['tmp_name'], '..'.$minh_hoa);
				$thongbao='Thêm bài viết thành công';
				$ok=1;
				$minh_hoa=$index_setting['link_img'].''.$minh_hoa;
				mysqli_query($conn,"INSERT INTO post(tieu_de,link,minh_hoa,cat,noidung,short_description,title,description,view,date_post)VALUES('$tieu_de','$link','$minh_hoa','$cat','$noidung','$short_description','$title','$description','0',".time().")");
				mysqli_query($conn,"INSERT INTO seo SET loai='post',link='$link'");
			} else{
				$thongbao='Vui lòng chọn ảnh minh họa';
				$ok=0;
			}
		}else{
			$ok=0;
			$thongbao='Thất bại! Link xem đã tồn tại';
		}
	}
	$info=array(
		'ok'=>$ok,
		'thongbao'=>$thongbao
	);
	echo json_encode($info);
}else if($action=='edit_post'){
	if(!isset($_COOKIE['emin_id'])){
		$ok=0;
		$thongbao='Bạn chưa đăng nhập';
	}else{
		$tieu_de=addslashes(strip_tags($_REQUEST['tieu_de']));
		$title=addslashes(strip_tags($_REQUEST['title']));
		$cat=addslashes(strip_tags($_REQUEST['cat']));
		$link=addslashes(strip_tags($_REQUEST['link']));
		$link_old=addslashes(strip_tags($_REQUEST['link_old']));
		$description=addslashes(strip_tags($_REQUEST['description']));
		$short_description=addslashes(strip_tags($_REQUEST['short_description']));
		$noidung=addslashes($_REQUEST['noidung']);
	    $duoi = $check->duoi_file($_FILES['file']['name']);
	    $id=intval($_REQUEST['id']);
	    $thongtin=mysqli_query($conn,"SELECT *,count(*) AS total FROM post WHERE id='$id'");
	    $r_tt=mysqli_fetch_assoc($thongtin);
	    if($r_tt['total']==0){
	    	$ok=0;
	    	$thongbao='Thất bại! Bài viết không tồn tại';
	    }else{
	    	if($link==$link_old){
				if(in_array($duoi, array('jpg','jpeg','png','gif'))==true){
					$minh_hoa='/uploads/minh_hoa/'.$check->blank($tieu_de).'-'.time().'.'.$duoi;
				    move_uploaded_file($_FILES['file']['tmp_name'], '..'.$minh_hoa);
					$thongbao='Sửa bài viết thành công';
					$ok=1;
					$minh_hoa=$index_setting['link_img'].''.$minh_hoa;
					mysqli_query($conn,"UPDATE post SET tieu_de='$tieu_de',link='$link',minh_hoa='$minh_hoa',cat='$cat',noidung='$noidung',short_description='$short_description',title='$title',description='$description' WHERE id='$id'");
					if(strpos($r_tt['minh_hoa'], $index_setting['link_img'])!==false){
						@unlink(str_replace($index_setting['link_img'], '..', $r_tt['minh_hoa']));
					}else{
						@unlink('..'.$r_tt['minh_hoa']);

					}
				} else{
					mysqli_query($conn,"UPDATE post SET tieu_de='$tieu_de',link='$link',cat='$cat',noidung='$noidung',short_description='$short_description',title='$title',description='$description' WHERE id='$id'");
					$thongbao='Sửa bài viết thành công';
					$ok=1;
				}
	    	}else{
				$thongtin_seo=mysqli_query($conn,"SELECT *, count(*) AS total FROM seo WHERE link='$link'");
				$r_seo=mysqli_fetch_assoc($thongtin_seo);
				if($r_seo['total']==0){
					if(in_array($duoi, array('jpg','jpeg','png','gif'))==true){
						$minh_hoa='/uploads/minh_hoa/'.$check->blank($tieu_de).'-'.time().'.'.$duoi;
					    move_uploaded_file($_FILES['file']['tmp_name'], '..'.$minh_hoa);
						$thongbao='Sửa bài viết thành công';
						$ok=1;
						$minh_hoa=$index_setting['link_img'].''.$minh_hoa;
						mysqli_query($conn,"UPDATE post SET tieu_de='$tieu_de',cat='$cat',link='$link',minh_hoa='$minh_hoa',noidung='$noidung',short_description='$short_description',title='$title',description='$description' WHERE id='$id'");
						if(strpos($r_tt['minh_hoa'], $index_setting['link_img'])!==false){
							@unlink(str_replace($index_setting['link_img'], '..', $r_tt['minh_hoa']));
						}else{
							@unlink('..'.$r_tt['minh_hoa']);

						}
					} else{
						mysqli_query($conn,"UPDATE post SET tieu_de='$tieu_de',cat='$cat',link='$link',noidung='$noidung',short_description='$short_description',title='$title',description='$description' WHERE id='$id'");
						$thongbao='Sửa bài viết thành công';
						$ok=1;
					}
					mysqli_query($conn,"UPDATE seo SET link='$link' WHERE link='$link_old'");
				}else{
					$ok=0;
					$thongbao='Thất bại! Link xem đã tồn tại';
				}

	    	}

	    }
	}
	$info=array(
		'ok'=>$ok,
		'thongbao'=>$thongbao
	);
	echo json_encode($info);
}else if($action=='add_slide'){
	if(!isset($_COOKIE['emin_id'])){
		$ok=0;
		$thongbao='Bạn chưa đăng nhập';
	}else{
		$tieu_de=addslashes(strip_tags($_REQUEST['tieu_de']));
		$link=addslashes(strip_tags($_REQUEST['link']));
		$target=addslashes(strip_tags($_REQUEST['target']));
		$vitri=addslashes(strip_tags($_REQUEST['vitri']));
		$thu_tu=addslashes($_REQUEST['thu_tu']);
		$active=intval($_REQUEST['active']);
	    $duoi = $check->duoi_file($_FILES['file']['name']);
	    if(strlen($tieu_de)<3){
	    	$ok=0;
	    	$thongbao='Vui lòng nhập tiêu đề';
	    }else if(in_array($duoi, array('jpg','jpeg','png','gif'))==false){
	    	$ok=0;
	    	$thongbao='Bạn chưa chọn ảnh minh họa';
	    }else{
			if(in_array($duoi, array('jpg','jpeg','png','gif'))==true){
				$minh_hoa='/uploads/minh_hoa/'.$check->blank($tieu_de).'-'.time().'.'.$duoi;
			    move_uploaded_file($_FILES['file']['tmp_name'], '..'.$minh_hoa);
				$thongbao='Thêm slide thành công';
				$ok=1;
				mysqli_query($conn,"INSERT INTO slide(tieu_de,minh_hoa,link,target,vitri,thu_tu,active)VALUES('$tieu_de','$minh_hoa','$link','$target','$vitri','$thu_tu','$active')");
			} else{
				$thongbao='Vui lòng chọn ảnh minh họa';
				$ok=0;
			}
	    }
	}
	$info=array(
		'ok'=>$ok,
		'thongbao'=>$thongbao
	);
	echo json_encode($info);
}else if($action=='edit_slide'){
	if(!isset($_COOKIE['emin_id'])){
		$ok=0;
		$thongbao='Bạn chưa đăng nhập';
	}else{
		$tieu_de=addslashes(strip_tags($_REQUEST['tieu_de']));
		$link=addslashes(strip_tags($_REQUEST['link']));
		$target=addslashes(strip_tags($_REQUEST['target']));
		$vitri=addslashes(strip_tags($_REQUEST['vitri']));
		$thu_tu=addslashes($_REQUEST['thu_tu']);
		$active=intval($_REQUEST['active']);
	    $duoi = $check->duoi_file($_FILES['file']['name']);
	    $id=intval($_REQUEST['id']);
	    if(strlen($tieu_de)<3){
	    	$ok=0;
	    	$thongbao='Vui lòng nhập tiêu đề';
	    }else{
		    $thongtin=mysqli_query($conn,"SELECT *, count(*) AS total FROM slide WHERE id='$id'");
		    $r_tt=mysqli_fetch_assoc($thongtin);
		    if($r_tt['total']==0){
		    	$ok=0;
		    	$thongbao='Thất bại! Slide này không tồn tại';
		    }else{
				if(in_array($duoi, array('jpg','jpeg','png','gif'))==true){
					$minh_hoa='/uploads/minh_hoa/'.$check->blank($tieu_de).'-'.time().'.'.$duoi;
				    move_uploaded_file($_FILES['file']['tmp_name'], '..'.$minh_hoa);
					$thongbao='Sửa slide thành công';
					$ok=1;
					@unlink('..'.$r_tt['minh_hoa']);
					mysqli_query($conn,"UPDATE slide SET tieu_de='$tieu_de',link='$link',minh_hoa='$minh_hoa', target='$target',vitri='$vitri',thu_tu='$thu_tu',active='$active'  WHERE id='$id'");
				} else{
					mysqli_query($conn,"UPDATE slide SET tieu_de='$tieu_de',link='$link', target='$target',vitri='$vitri',thu_tu='$thu_tu',active='$active'  WHERE id='$id'");
					$thongbao='Sửa slide thành công';
					$ok=1;
				}
		    }
	    }
	}
	$info=array(
		'ok'=>$ok,
		'thongbao'=>$thongbao
	);
	echo json_encode($info);
}else if($action=='add_page'){
	if(!isset($_COOKIE['emin_id'])){
		$ok=0;
		$thongbao='Bạn chưa đăng nhập';
	}else{
		$tieu_de=addslashes(strip_tags($_REQUEST['tieu_de']));
		$title=addslashes(strip_tags($_REQUEST['title']));
		$link=addslashes(strip_tags($_REQUEST['link']));
		$description=addslashes(strip_tags($_REQUEST['description']));
		$noidung=addslashes($_REQUEST['noidung']);
		$thongtin=mysqli_query($conn,"SELECT *, count(*) AS total FROM seo WHERE link='$link'");
		$r_tt=mysqli_fetch_assoc($thongtin);
		if($r_tt['total']==0){
			$thongbao='Thêm page thành công';
			$ok=1;
			mysqli_query($conn,"INSERT INTO page(tieu_de,link,noidung,title,description,view,date_post)VALUES('$tieu_de','$link','$noidung','$title','$description','0',".time().")");
			mysqli_query($conn,"INSERT INTO seo SET loai='page',link='$link'");
		}else{
			$ok=0;
			$thongbao='Thất bại! Link xem đã tồn tại';
		}
	}
	$info=array(
		'ok'=>$ok,
		'thongbao'=>$thongbao
	);
	echo json_encode($info);
}else if($action=='edit_page'){
	if(!isset($_COOKIE['emin_id'])){
		$ok=0;
		$thongbao='Bạn chưa đăng nhập';
	}else{
		$tieu_de=addslashes(strip_tags($_REQUEST['tieu_de']));
		$title=addslashes(strip_tags($_REQUEST['title']));
		$link=addslashes(strip_tags($_REQUEST['link']));
		$link_old=addslashes(strip_tags($_REQUEST['link_old']));
		$description=addslashes(strip_tags($_REQUEST['description']));
		$noidung=addslashes($_REQUEST['noidung']);
	    $id=intval($_REQUEST['id']);
	    $thongtin=mysqli_query($conn,"SELECT *,count(*) AS total FROM page WHERE id='$id'");
	    $r_tt=mysqli_fetch_assoc($thongtin);
	    if($r_tt['total']==0){
	    	$ok=0;
	    	$thongbao='Thất bại! Trang không tồn tại';
	    }else{
	    	if($link==$link_old){
				mysqli_query($conn,"UPDATE page SET tieu_de='$tieu_de',link='$link',noidung='$noidung',title='$title',description='$description' WHERE id='$id'");
				$thongbao='Sửa trang thành công';
				$ok=1;
	    	}else{
				$thongtin_seo=mysqli_query($conn,"SELECT *, count(*) AS total FROM seo WHERE link='$link'");
				$r_seo=mysqli_fetch_assoc($thongtin_seo);
				if($r_seo['total']==0){
					mysqli_query($conn,"UPDATE page SET tieu_de='$tieu_de',link='$link',noidung='$noidung',title='$title',description='$description' WHERE id='$id'");
						$thongbao='Sửa trang thành công';
						$ok=0;
					mysqli_query($conn,"UPDATE seo SET link='$link' WHERE link='$link_old'");
				}else{
					$ok=0;
					$thongbao='Thất bại! Link xem đã tồn tại';
				}

	    	}

	    }
	}
	$info=array(
		'ok'=>$ok,
		'thongbao'=>$thongbao
	);
	echo json_encode($info);
}else if($action=="edit_naptien"){
	$loai=strip_tags($_REQUEST['loai']);
	$card_type=strip_tags($_REQUEST['card_type']);
	$card_pin=strip_tags($_REQUEST['card_pin']);
	$card_serial=strip_tags($_REQUEST['card_serial']);
	$card_price=preg_replace('/[^0-9]/', '', $_REQUEST['card_price']);
	$tinh_trang=intval($_REQUEST['tinh_trang']);
	$id=intval($_REQUEST['id']);
	if(!isset($_COOKIE['emin_id'])){
		$ok=0;
		$thongbao='Bạn chưa đăng nhập';
	}else{
		$thongtin=mysqli_query($conn,"SELECT *, count(*) AS total FROM list_naptien WHERE id='$id'");
		$r_tt=mysqli_fetch_assoc($thongtin);
		if($r_tt['total']>0){
			if($r_tt['tinh_trang']==1){
				$ok=0;
				$thongbao='Giao dịch này đã hoàn thành';
			}else if($r_tt['tinh_trang']==2){
				$ok=0;
				$thongbao='Giao dịch này đã được hủy';
			}else{
				if($tinh_trang==1){
					$thongtin_user=mysqli_query($conn,"SELECT * FROM account WHERE accid='{$r_tt['accid']}'");
					$r_s=mysqli_fetch_assoc($thongtin_user);
					if($r_tt['loai']=='paypal'){
						$moi=$r_tt['card_price']*$index_setting['paypal'] + $r_s['Coin'];
					}else{
						$moi=$r_tt['card_price'] + $r_s['Coin'];
					}
					mysqli_query($conn,"UPDATE account SET Coin='$moi' WHERE accid='{$r_tt['accid']}'");
					mysqli_query($conn,"UPDATE list_naptien SET tinh_trang='$tinh_trang' WHERE id='$id'");
				}else{
					mysqli_query($conn,"UPDATE list_naptien SET tinh_trang='$tinh_trang' WHERE id='$id'");
				}
				$ok=1;
				$thongbao='Chỉnh sửa nạp tiền thành công';
			}

		}else{
			$ok=0;
			$thongbao='Giao dịch không tồn tại';
		}
	}
	$info=array(
		'ok'=>$ok,
		'thongbao'=>$thongbao
	);
	echo json_encode($info);
}else if($action=="edit_profile"){
	$name=strip_tags(addslashes($_REQUEST['name']));
	$mobile=preg_replace('/[^0-9]/', '', $_REQUEST['mobile']);
	if(!isset($_COOKIE['emin_id'])){
		$ok=0;
		$thongbao='Bạn chưa đăng nhập';
	}else{
		if(strlen($name)<2){
			$thongbao="Vui lòng nhập họ và tên";
			$ok=0;
		}else{
			$user_id=$_COOKIE['emin_id'];
			mysqli_query($conn,"UPDATE adminjx SET username='$name',mobile='$mobile' WHERE id='$user_id'");
			$ok=1;
			$thongbao='Sửa thông tin thành công!';
		}
	}
	$info=array(
		'ok'=>$ok,
		'thongbao'=>$thongbao
	);
	echo json_encode($info);

}else if($action=="edit_thanhvien"){
	if(!isset($_COOKIE['emin_id'])){
		$ok=0;
		$thongbao='Bạn chưa đăng nhập';
	}else{
		$email=strip_tags(addslashes($_REQUEST['email']));
		$coin=preg_replace('/[^0-9]/', '', $_REQUEST['coin']);
		$accid=preg_replace('/[^0-9]/', '', $_REQUEST['accid']);
		if(!isset($_COOKIE['emin_id'])){
			$ok=0;
			$thongbao='Bạn chưa đăng nhập';
		}else{
			$thongtin_email=mysqli_query($conn,"SELECT *, count(*) AS total FROM account WHERE cEMail='$email'");
			$r_e=mysqli_fetch_assoc($thongtin_email);
			if($r_e['total']==0){
				mysqli_query($conn,"UPDATE account SET Coin='$coin',cEMail='$email' WHERE accid='$accid'");
				$ok=1;
				$thongbao='Sửa thành viên thành công!';
			}else{
				mysqli_query($conn,"UPDATE account SET Coin='$coin' WHERE accid='$accid'");
				$ok=1;
				$thongbao='Cập nhật coin thành công!';
			}
		}
	}
	$info=array(
		'ok'=>$ok,
		'thongbao'=>$thongbao
	);
	echo json_encode($info);

}else if($action=="edit_setting"){
	$name=preg_replace('/[^0-9a-zA-Z_-]/', '', $_REQUEST['name']);
	$noidung=addslashes($_REQUEST['noidung']);
	if(!isset($_COOKIE['emin_id'])){
		$ok=0;
		$thongbao='Bạn chưa đăng nhập';
	}else{
		mysqli_query($conn,"UPDATE index_setting SET value='$noidung' WHERE name='$name'");
		$ok=1;
		$thongbao='Sửa cài đặt thành công!';
	}
	$info=array(
		'ok'=>$ok,
		'thongbao'=>$thongbao
	);
	echo json_encode($info);

}else if($action=='edit_setting_img'){
	if(!isset($_COOKIE['emin_id'])){
		$ok=0;
		$thongbao='Bạn chưa đăng nhập';
	}else{
	    $duoi = $check->duoi_file($_FILES['file']['name']);
	    $name=addslashes($_REQUEST['name']);
	    $thongtin=mysqli_query($conn,"SELECT *, count(*) AS total FROM index_setting WHERE name='$name'");
	    $r_tt=mysqli_fetch_assoc($thongtin);
	    if($r_tt['total']==0){
	    	$ok=0;
	    	$thongbao='Thất bại! Cài đặt này không tồn tại';
	    }else{
			if(in_array($duoi, array('jpg','jpeg','png','gif'))==true){
				$minh_hoa='/uploads/minh_hoa/'.str_replace('.'.$duoi, '', $_FILES['file']['name']).'-'.time().'.'.$duoi;
			    move_uploaded_file($_FILES['file']['tmp_name'], '..'.$minh_hoa);
				$thongbao='Sửa cài đặt thành công';
				$ok=1;
				@unlink('..'.$r_tt['value']);
				mysqli_query($conn,"UPDATE index_setting SET value='$minh_hoa' WHERE name='$name'");
			} else{
				$thongbao='Thất bại! Vui lòng chọn hình ảnh';
				$ok=0;
			}
	    }
	}
	$info=array(
		'ok'=>$ok,
		'thongbao'=>$thongbao
	);
	echo json_encode($info);
}else if($action=='add_menu'){
	$loai=addslashes($_REQUEST['loai']);
    $tieu_de=addslashes($_REQUEST['tieu_de']);
    $link=addslashes($_REQUEST['link']);
    $target=addslashes($_REQUEST['target']);
    $thu_tu=intval($_REQUEST['thu_tu']);
    $main_id=intval($_REQUEST['main_id']);
    $col=intval($_REQUEST['col']);
    $category=addslashes($_REQUEST['category']);
    $vitri=addslashes($_REQUEST['vitri']);
    $page=addslashes($_REQUEST['page']);
	if(!isset($_COOKIE['emin_id'])){
		$ok=0;
		$thongbao='Bạn chưa đăng nhập';
	}else{
		if($loai=='page'){
			if(strlen($tieu_de)<2){
				$ok=0;
				$thongbao='Thất bại! Hãy nhập tiêu đề';
			}else{
				$ok=1;
				$thongbao='Thêm menu thành công';
				mysqli_query($conn,"INSERT INTO menu (menu_main,menu_tieude,menu_cat,menu_link,menu_target,menu_thutu,menu_loai,menu_col,menu_vitri)VALUES('$main_id','$tieu_de','','$page','$target','$thu_tu','$loai','$col','$vitri')");
			}
		}else if($loai=='category'){
			if(strlen($tieu_de)<2){
				$ok=0;
				$thongbao='Thất bại! Hãy nhập tiêu đề';
			}else{
				$thongtin=mysqli_query($conn,"SELECT *, count(*) AS total FROM category WHERE cat_id='$category' ORDER BY cat_id DESC LIMIT 1");
				$r_tt=mysqli_fetch_assoc($thongtin);
				if($r_tt['total']>0){
					$ok=1;
					$thongbao='Thêm menu thành công';
					mysqli_query($conn,"INSERT INTO menu (menu_main,menu_tieude,menu_cat,menu_link,menu_target,menu_thutu,menu_loai,menu_col,menu_vitri)VALUES('$main_id','$tieu_de','$category','/the-loai/{$r_tt['cat_blank']}.html','$target','$thu_tu','$loai','$col','$vitri')");
				}else{
					$ok=0;
					$thongbao='Thất bại! Thể loại được chọn không tồn tại';

				}
			}
		}else{
			if(strlen($tieu_de)<2){
				$ok=0;
				$thongbao='Thất bại! Hãy nhập tiêu đề';
			}else{
				$ok=1;
				$thongbao='Thêm menu thành công';
				mysqli_query($conn,"INSERT INTO menu (menu_main,menu_tieude,menu_cat,menu_link,menu_target,menu_thutu,menu_loai,menu_col,menu_vitri)VALUES('$main_id','$tieu_de','','$link','$target','$thu_tu','$loai','$col','$vitri')");
			}
		}
	}
	$info=array(
		'ok'=>$ok,
		'thongbao'=>$thongbao
	);
	echo json_encode($info);

}else if($action=='edit_menu'){
	$loai=addslashes($_REQUEST['loai']);
    $tieu_de=addslashes($_REQUEST['tieu_de']);
    $link=addslashes($_REQUEST['link']);
    $target=addslashes($_REQUEST['target']);
    $thu_tu=intval($_REQUEST['thu_tu']);
    $main_id=intval($_REQUEST['main_id']);
    $col=intval($_REQUEST['col']);
    $category=addslashes($_REQUEST['category']);
    $vitri=addslashes($_REQUEST['vitri']);
    $page=addslashes($_REQUEST['page']);
    $id=intval($_REQUEST['id']);
	if(!isset($_COOKIE['emin_id'])){
		$ok=0;
		$thongbao='Bạn chưa đăng nhập';
	}else{
		if($loai=='page'){
			if(strlen($tieu_de)<2){
				$ok=0;
				$thongbao='Thất bại! Hãy nhập tiêu đề';
			}else{
				$ok=1;
				$thongbao='sửa menu thành công';
				mysqli_query($conn,"UPDATE menu SET menu_main='$main_id',menu_tieude='$tieu_de',menu_cat='',menu_link='$page',menu_target='$target',menu_thutu='$thu_tu',menu_col='$col',menu_loai='$loai',menu_vitri='$vitri' WHERE menu_id='$id'");
			}
		}else if($loai=='category'){
			if(strlen($tieu_de)<2){
				$ok=0;
				$thongbao='Thất bại! Hãy nhập tiêu đề';
			}else{
				$thongtin=mysqli_query($conn,"SELECT *, count(*) AS total FROM category WHERE cat_id='$category' ORDER BY cat_id DESC LIMIT 1");
				$r_tt=mysqli_fetch_assoc($thongtin);
				if($r_tt['total']>0){
					$ok=1;
					$thongbao='Sửa menu thành công';
					mysqli_query($conn,"UPDATE menu SET menu_main='$main_id',menu_tieude='$tieu_de',menu_cat='$category',menu_link='/the-loai/{$r_tt['cat_blank']}.html',menu_target='$target',menu_thutu='$thu_tu',menu_col='$col',menu_loai='$loai',menu_vitri='$vitri' WHERE menu_id='$id'");
				}else{
					$ok=0;
					$thongbao='Thất bại! Thể loại được chọn không tồn tại';

				}
			}
		}else{
			if(strlen($tieu_de)<2){
				$ok=0;
				$thongbao='Thất bại! Hãy nhập tiêu đề';
			}else{
				$ok=1;
				$thongbao='Sửa menu thành công';
				mysqli_query($conn,"UPDATE menu SET menu_main='$main_id',menu_tieude='$tieu_de',menu_cat='',menu_link='$link',menu_target='$target',menu_thutu='$thu_tu',menu_col='$col',menu_loai='$loai',menu_vitri='$vitri' WHERE menu_id='$id'");
			}
		}
	}
	$info=array(
		'ok'=>$ok,
		'thongbao'=>$thongbao
	);
	echo json_encode($info);

}else if($action=='add_support'){
    $tieu_de=addslashes($_REQUEST['tieu_de']);
    $link=addslashes($_REQUEST['link']);
    $target=addslashes($_REQUEST['target']);
    $thu_tu=intval($_REQUEST['thu_tu']);
	if(!isset($_COOKIE['emin_id'])){
		$ok=0;
		$thongbao='Bạn chưa đăng nhập';
	}else{
		if(strlen($tieu_de)<2){
			$ok=0;
			$thongbao='Thất bại! Hãy nhập tiêu đề';
		}else{
			$ok=1;
			$thongbao='Thêm hỗ trợ thành công';
			mysqli_query($conn,"INSERT INTO support (tieu_de,link,thu_tu,target)VALUES('$tieu_de','$link','$thu_tu','$target')");
		}
	}
	$info=array(
		'ok'=>$ok,
		'thongbao'=>$thongbao
	);
	echo json_encode($info);

}else if($action=='edit_support'){
    $tieu_de=addslashes($_REQUEST['tieu_de']);
    $link=addslashes($_REQUEST['link']);
    $target=addslashes($_REQUEST['target']);
    $thu_tu=intval($_REQUEST['thu_tu']);
    $id=intval($_REQUEST['id']);
	if(!isset($_COOKIE['emin_id'])){
		$ok=0;
		$thongbao='Bạn chưa đăng nhập';
	}else{
		if(strlen($tieu_de)<2){
			$ok=0;
			$thongbao='Thất bại! Hãy nhập tiêu đề';
		}else{
			$ok=1;
			$thongbao='Sửa hỗ trợ thành công';
			mysqli_query($conn,"UPDATE support SET tieu_de='$tieu_de',link='$link',thu_tu='$thu_tu',target='$target' WHERE id='$id'");
		}
	}
	$info=array(
		'ok'=>$ok,
		'thongbao'=>$thongbao
	);
	echo json_encode($info);

}else if($action=="add_naptien"){
	$username=strip_tags($_REQUEST['username']);
	$coin=preg_replace('/[^0-9]/', '', $_REQUEST['coin']);
	$coin=$coin;
	$loai=strip_tags($_REQUEST['loai']);
	$hientai=time();
	if(!isset($_COOKIE['emin_id'])){
		$ok=0;
		$thongbao='Bạn chưa đăng nhập';
	}else{
		if($username==''){
			$ok=0;
			$thongbao='Vui lòng nhập thành viên nạp';
		}else{
			$thongtin=mysqli_query($conn,"SELECT *,count(*) AS total FROM account WHERE loginName='$username' ORDER BY accid DESC LIMIT 1");
			$r_tt=mysqli_fetch_assoc($thongtin);
			if($r_tt['total']==0){
				$ok=0;
				$thongbao='Thất bại! Tài khoản không tồn tại';
			}else{
				$ok=1;
				$thongbao="Thêm giao dịch mới thành công";
				$thongtin_coin=mysqli_query($conn,"SELECT *,count(*) AS total FROM jxsf8_paycoin WHERE account='$username'");
				$r_c=mysqli_fetch_assoc($thongtin_coin);
				if($r_c['total']==0){
					$sodu=$coin;
					mysqli_query($conn,"INSERT INTO jxsf8_paycoin SET account='$username',jbcoin='$sodu'");
				}else{
					$sodu=$coin + $r_c['jbcoin'];
					mysqli_query($conn,"UPDATE jxsf8_paycoin SET jbcoin='$sodu' WHERE account='$username'");
				}
				mysqli_query($conn,"INSERT INTO list_naptien SET accid='{$r_tt['accid']}',loai='$loai',card_type='',card_pin='',card_serial='',card_price='$coin',noidung='',tinh_trang='1',tranid='',code='1',date_post='$hientai'");

			}
		}
	}
	$info=array(
		'ok'=>$ok,
		'thongbao'=>$thongbao
	);
	echo json_encode($info);

}else if($action=="add_theloai"){
	$cat_tieude=strip_tags($_REQUEST['cat_tieude']);
	$cat_title=strip_tags($_REQUEST['cat_title']);
	$cat_description=strip_tags($_REQUEST['cat_description']);
	$cat_thutu=intval($_REQUEST['cat_thutu']);
	$cat_blank=addslashes($_REQUEST['cat_blank']);
	$cat_main=intval($_REQUEST['cat_main']);
	$cat_icon=addslashes($_REQUEST['cat_icon']);
	$cat_index=intval($_REQUEST['cat_index']);
	if(!isset($_COOKIE['emin_id'])){
		$ok=0;
		$thongbao='Bạn chưa đăng nhập';
	}else{
		if($cat_tieude==''){
			$ok=0;
			$thongbao='Vui lòng nhập tiêu đề';
		}else{
			$thongtin_seo=mysqli_query($conn,"SELECT count(*) AS total FROM seo WHERE link='$cat_blank' ORDER BY id DESC LIMIT 1");
			$r_seo=mysqli_fetch_assoc($thongtin_seo);
			if($r_seo['total']>0){
				$ok=0;
				$thongbao='Thất bại! Link xem đã tồn tại';
			}else{
				$ok=1;
				$thongbao="Thêm thể loại thành công";
				mysqli_query($conn,"INSERT INTO category(cat_tieude,cat_blank,cat_title,cat_main,cat_description,cat_index,cat_thutu,cat_icon)VALUES('$cat_tieude','$cat_blank','$cat_title','$cat_main','$cat_description','$cat_index','$cat_thutu','$cat_icon')");
				mysqli_query($conn,"INSERT INTO seo (loai,link)VALUES('category','$cat_blank')");

			}
		}
	}
	$info=array(
		'ok'=>$ok,
		'thongbao'=>$thongbao
	);
	echo json_encode($info);

}else if($action=="edit_theloai"){
	$cat_tieude=strip_tags($_REQUEST['cat_tieude']);
	$cat_title=strip_tags($_REQUEST['cat_title']);
	$cat_description=strip_tags($_REQUEST['cat_description']);
	$link_old=addslashes($_REQUEST['link_old']);
	$cat_thutu=intval($_REQUEST['cat_thutu']);
	$cat_blank=addslashes($_REQUEST['cat_blank']);
	$cat_id=intval($_REQUEST['cat_id']);
	$cat_main=intval($_REQUEST['cat_main']);
	$cat_icon=addslashes($_REQUEST['cat_icon']);
	$cat_index=intval($_REQUEST['cat_index']);
	if(!isset($_COOKIE['emin_id'])){
		$ok=0;
		$thongbao='Bạn chưa đăng nhập';
	}else{
		if($cat_tieude==''){
			$ok=0;
			$thongbao='Vui lòng nhập tiêu đề';
		}else{
			if($cat_blank==$link_old){
				$ok=1;
				$thongbao="Sửa thể loại thành công";
				mysqli_query($conn,"UPDATE category SET cat_tieude='$cat_tieude',cat_main='$cat_main',cat_blank='$cat_blank',cat_title='$cat_title',cat_description='$cat_description',cat_thutu='$cat_thutu',cat_icon='$cat_icon',cat_index='$cat_index' WHERE cat_id='$cat_id'");

			}else{
				$thongtin_seo=mysqli_query($conn,"SELECT count(*) AS total FROM seo WHERE link='$cat_blank' ORDER BY id DESC LIMIT 1");
				$r_seo=mysqli_fetch_assoc($thongtin_seo);
				if($r_seo['total']>0){
					$ok=0;
					$thongbao='Thất bại! Link xem đã tồn tại';

				}else{
					$ok=1;
					$thongbao="Sửa thể loại thành công";
					mysqli_query($conn,"UPDATE category SET cat_tieude='$cat_tieude',cat_blank='$cat_blank',cat_main='$cat_main',cat_title='$cat_title',cat_description='$cat_description',cat_thutu='$cat_thutu',cat_icon='$cat_icon' WHERE cat_id='$cat_id'");
					mysqli_query($conn,"UPDATE seo SET link='$cat_blank',cat_index='$cat_index' WHERE link='$link_old'");
				}

			}
		}
	}
	$info=array(
		'ok'=>$ok,
		'thongbao'=>$thongbao
	);
	echo json_encode($info);

}else if($action=="change_password"){
	$old_pass=addslashes($_REQUEST['old_pass']);
	$pass=md5($old_pass);
	$new_pass=addslashes($_REQUEST['new_pass']);
	$confirm=addslashes($_REQUEST['confirm']);
	if(!isset($_COOKIE['emin_id'])){
		$ok=0;
		$thongbao='Bạn chưa đăng nhập';
	}else{
		if(strlen($new_pass)<6){
			$thongbao="Mật khẩu mới phải dài từ 6 ký tự";
			$ok=0;
		}else if($new_pass!=$confirm){
			$thongbao="Nhập lại mật khẩu mới không khớp";
			$ok=0;
		}else{
			$user_id=$_COOKIE['emin_id'];
			$thongtin=mysqli_query($conn,"SELECT *,count(*) AS total FROM adminjx WHERE id='$user_id'");
			$r_tt=mysqli_fetch_assoc($thongtin);
			if($r_tt['pwd']!=$pass){
				$ok=0;
				$thongbao="Mật khẩu hiện tại không đúng";
			}else{
				$password=md5($new_pass);
				mysqli_query($conn,"UPDATE adminjx SET pwd='$password' WHERE id='$user_id'");
				$ok=1;
				$thongbao='Đổi mật khẩu thành công';

			}
		}
	}
	$info=array(
		'ok'=>$ok,
		'thongbao'=>$thongbao
	);
	echo json_encode($info);

}else if($action=='del'){
	$loai=addslashes($_REQUEST['loai']);
	$id=preg_replace('/[^0-9a-z]/', '', $_REQUEST['id']);
	if(!isset($_COOKIE['emin_id'])){
		$ok=0;
		$thongbao='Bạn chưa đăng nhập';
	}else{
		if($loai=='category'){
			$thongtin=mysqli_query($conn,"SELECT *,count(*) AS total FROM category WHERE cat_id='$id'");
			$r_tt=mysqli_fetch_assoc($thongtin);
			if($r_tt['total']==0){
				$ok=0;
				$thongbao='Thể loại không tồn tại';
			}else{
				$ok=1;
				$thongbao='Xóa thể loại thành công';
				mysqli_query($conn,"DELETE FROM category WHERE cat_id='$id'");
				mysqli_query($conn,"DELETE FROM seo WHERE link='{$r_tt['cat_blank']}'");
			}
		}else if($loai=='menu'){
			$thongtin=mysqli_query($conn,"SELECT *,count(*) AS total FROM menu WHERE menu_id='$id'");
			$r_tt=mysqli_fetch_assoc($thongtin);
			if($r_tt['total']==0){
				$ok=0;
				$thongbao='Menu không tồn tại';
			}else{
				$ok=1;
				$thongbao='Xóa menu thành công';
				mysqli_query($conn,"DELETE FROM menu WHERE menu_id='$id'");
			}
		}else if($loai=='baiviet'){
			$thongtin=mysqli_query($conn,"SELECT *,count(*) AS total FROM post WHERE id='$id'");
			$r_tt=mysqli_fetch_assoc($thongtin);
			if($r_tt['total']==0){
				$ok=0;
				$thongbao='Bài viết không tồn tại';
			}else{
				$ok=1;
				$thongbao='Xóa bài viết thành công';
				mysqli_query($conn,"DELETE FROM post WHERE id='$id'");
				if(strpos($r_tt['minh_hoa'], $index_setting['link_img'])!==false){
					@unlink(str_replace($index_setting['link_img'], '..', $r_tt['minh_hoa']));
				}else{
					@unlink('..'.$r_tt['minh_hoa']);
				}
			}
		}else if($loai=='slide'){
			$thongtin=mysqli_query($conn,"SELECT *,count(*) AS total FROM slide WHERE id='$id'");
			$r_tt=mysqli_fetch_assoc($thongtin);
			if($r_tt['total']==0){
				$ok=0;
				$thongbao='Slide không tồn tại';
			}else{
				$ok=1;
				$thongbao='Xóa Slide thành công';
				mysqli_query($conn,"DELETE FROM slide WHERE id='$id'");
				@unlink('..'.$r_tt['minh_hoa']);
			}
		}else if($loai=='contact'){
			$thongtin=mysqli_query($conn,"SELECT *,count(*) AS total FROM contact WHERE id='$id'");
			$r_tt=mysqli_fetch_assoc($thongtin);
			if($r_tt['total']==0){
				$ok=0;
				$thongbao='Liên hệ không tồn tại';
			}else{
				$ok=1;
				$thongbao='Xóa liên hệ thành công';
				mysqli_query($conn,"DELETE FROM contact WHERE id='$id'");
			}
		}else if($loai=='support'){
			$thongtin=mysqli_query($conn,"SELECT *,count(*) AS total FROM support WHERE id='$id'");
			$r_tt=mysqli_fetch_assoc($thongtin);
			if($r_tt['total']==0){
				$ok=0;
				$thongbao='Dữ liệu không tồn tại';
			}else{
				$ok=1;
				$thongbao='Xóa hỗ trợ thành công';
				mysqli_query($conn,"DELETE FROM support WHERE id='$id'");
			}
		}else if($loai=='page'){
			$thongtin=mysqli_query($conn,"SELECT *,count(*) AS total FROM page WHERE id='$id'");
			$r_tt=mysqli_fetch_assoc($thongtin);
			if($r_tt['total']==0){
				$ok=0;
				$thongbao='Trang không tồn tại';
			}else{
				$ok=1;
				$thongbao='Xóa trang thành công';
				mysqli_query($conn,"DELETE FROM page WHERE id='$id'");
			}
		}else if($loai=='naptien'){
			$thongtin=mysqli_query($conn,"SELECT *,count(*) AS total FROM list_naptien WHERE id='$id'");
			$r_tt=mysqli_fetch_assoc($thongtin);
			if($r_tt['total']==0){
				$ok=0;
				$thongbao='Giao dịch không tồn tại';
			}else{
				$ok=1;
				$thongbao='Xóa giao dịch thành công';
				mysqli_query($conn,"DELETE FROM list_naptien WHERE id='$id'");
			}
		}else if($loai=='thanhvien'){
			$thongtin=mysqli_query($conn,"SELECT *,count(*) AS total FROM account WHERE accid='$id'");
			$r_tt=mysqli_fetch_assoc($thongtin);
			if($r_tt['total']==0){
				$ok=0;
				$thongbao='Thành viên không tồn tại';
			}else{
				$ok=1;
				$thongbao='Xóa thành viên thành công';
				mysqli_query($conn,"DELETE FROM account WHERE accid='$id'");
				mysqli_query($conn,"DELETE FROM list_naptien WHERE accid='$id'");
			}
		}
	}
	$info=array(
		'ok'=>$ok,
		'thongbao'=>$thongbao
	);
	echo json_encode($info);

}else if($action=='upload_tinymce'){
	if(!isset($_COOKIE['emin_id'])){
		$ok=0;
		$thongbao='Bạn chưa đăng nhập';
		$minh_hoa='';
	}else{
		$filename = $_FILES['file']['name'];
		$duoi = $check->duoi_file($_FILES['file']['name']);
		if(in_array($duoi, array('jpg','jpeg','png','gif'))==true){
			$minh_hoa='/uploads/minh_hoa/'.$check->blank($filename).'-'.time().'.'.$duoi;
		    move_uploaded_file($_FILES['file']['tmp_name'], '..'.$minh_hoa);
			$thongbao='Upload ảnh thành công';
			$ok=1;
			$minh_hoa=$index_setting['link_img'].''.$minh_hoa;
		} else{
			$thongbao='Vui lòng chọn ảnh minh họa';
			$ok=0;
			$minh_hoa='';
		}
	}
	$info=array(
		'ok'=>$ok,
		'thongbao'=>$thongbao,
		'minh_hoa'=>$minh_hoa
	);
	echo json_encode($info);

}else if($action=='timkiem'){
	$key=addslashes(strip_tags($_REQUEST['key']));
	$list=$class_index->list_kq_timkiem($conn,$key);
	$list='	<tr>
				<th style="text-align: center;width: 50px;" class="hide_mobile">STT</th>
				<th style="text-align: center;width: 120px;" class="hide_mobile">Minh họa</th>
				<th style="text-align: left;">Tiêu đề</th>
				<th style="text-align: left;">Chap mới</th>
				<th style="text-align: left;" class="hide_mobile">Cập nhật</th>
				<th style="text-align: center;width: 100px;" class="hide_mobile">View</th>
				<th style="text-align: center;width: 150px;">Hành động</th>
			</tr>'.$list;
	$info=array(
		'ok'=>1,
		'list'=>$list
	);
	echo json_encode($info);
}else if($action=='goi_y'){
	$tieu_de=strip_tags(addslashes($_REQUEST['tieu_de']));
	$cat=strip_tags(addslashes($_REQUEST['cat']));
	$cat='cat'.$cat;
	$thongtin=mysqli_query($conn,"SELECT id,tieu_de FROM sanpham WHERE MATCH(tieu_de) AGAINST('$tieu_de') AND MATCH(category) AGAINST('$cat') ORDER BY gia ASC");
	while($r_tt=mysqli_fetch_assoc($thongtin)){
		$list.='<li value="'.$r_tt['id'].'"><span>'.$r_tt['tieu_de'].'</span></li>';
	}
	$info=array(
		'ok'=>1,
		'list'=>$list
	);
	echo json_encode($info);
}else if($action=='check_blank'){
	$link=$check->blank($_REQUEST['link']);
	$thongtin=mysqli_query($conn,"SELECT count(*) AS total FROM seo WHERE link='$link'");
	$r_tt=mysqli_fetch_assoc($thongtin);
	if($r_tt['total']>0){
		$ok=0;
	}else{
		$ok=1;
	}
	$info=array(
		'ok'=>$ok,
		'link'=>$link
	);
	echo json_encode($info);
}else if($action=='check_link'){
	$link=$_REQUEST['link'];
	$thongtin=mysqli_query($conn,"SELECT count(*) AS total FROM seo WHERE link='$link'");
	$r_tt=mysqli_fetch_assoc($thongtin);
	if($r_tt['total']>0){
		$ok=0;
	}else{
		$ok=1;
	}
	$info=array(
		'ok'=>$ok,
		'link'=>$link
	);
	echo json_encode($info);
}else{
	echo "Không có hành động nào được xử lý";
}
?>