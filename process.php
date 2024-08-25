<?php
include('./includes/tlca_world.php');
$check=$tlca_do->load('class_check');
$action=addslashes($_REQUEST['action']);
$class_index=$tlca_do->load('class_index');
$setting=mysqli_query($conn,"SELECT * FROM index_setting ORDER BY name ASC");
while ($r_s=mysqli_fetch_assoc($setting)) {
	$index_setting[$r_s['name']]=$r_s['value'];
}
if($action=='quen_matkhau'){
	$email=addslashes(strip_tags($_REQUEST['email']));
	if($check->check_email($email)==false){
		$ok=0;
		$thongbao='Email không đúng định dạng';
	}else{
		$thongtin_email=mysqli_query($conn,"SELECT *,count(*) AS total FROM account WHERE cEMail='$email'");
		$r_tt=mysqlI_fetch_assoc($thongtin_email);
		if($r_tt['total']==0){
			$ok=0;
			$thongbao='Email không tồn tại trên hệ thống';
		}else{
			include_once("./class.phpmailer.php");
			$code_active=$check->random_string(10);
			$passnew=$check->random_number(8);
			$link_active=$index_setting['link_domain'].'confirm_password.php?email='.$email.'&token='.$code_active;
			$thaythe_mail=array(
				'email'=>$email,
				'link_active'=>$link_active,
				'name'=>$r_tt['name'],
				'passnew'=>$passnew
			);
			$mailer = new PHPMailer(); // khởi tạo đối tượng
			$mailer->IsSMTP(); // gọi class smtp để đăng nhập
			$mailer->CharSet="utf-8"; // bảng mã unicode
			$mailer->SMTPAuth = true; // gửi thông tin đăng nhập
			$mailer->SMTPSecure = "ssl"; // Giao thức SSL
			$mailer->Host = 'smtp.gmail.com'; // SMTP của GMAIL
			$mailer->Port = '465'; // cổng SMTP
			$mailer->Username = 'hotrokiemthetuhai@gmail.com'; // GMAIL username
			$mailer->Password = 'tfigvtkvnvnqceda'; // GMAIL password
			$mailer->FromName = 'Hỗ trợ kiếm thế'; // tên người gửi
			$mailer->From ='hotrokiemthetuhai@gmail.com'; // mail người gửi
			$mailer->AddAddress($email,$r_tt['loginName']); //thêm mail của admin
			$mailer->Subject = 'Lấy lại mật khẩu';
			$mailer->IsHTML(true); //Bật HTML không thích thì false
			$mailer->Body = 'Mật khẩu mới của bạn tại '.$index_setting['link_domain'].' là: '.$passnew.', vui lòng bấm vào link <a href="'.$link_active.'">'.$link_active.'</a> để xác nhận thay đổi';
			if($mailer->Send()==true){
				mysqli_query($conn,"INSERT INTO forgot_password (email,password,code_active,date_post)VALUES('$email','$passnew','$code_active',".time().")");
				$ok=1;
				$thongbao='Mật khẩu đã được gửi tới email của bạn!';
			}else{
				$ok=0;
				$thongbao='Gặp lỗi trong quá trình gửi mail';
			}
		}
	}
	$info=array(
		'ok'=>$ok,
		'thongbao'=>$thongbao
	);
	echo json_encode($info);
}else if($action=='register'){
	$username=addslashes(strip_tags($_REQUEST['username']));
	$password=addslashes(strip_tags($_REQUEST['password']));
	$email=addslashes(strip_tags($_REQUEST['email']));
	$captcha=addslashes(strip_tags($_REQUEST['ma_bao_mat']));
	require_once 'napthe/securimage/securimage.php';
	$securimage = new Securimage();
	if ($securimage->check($captcha) == false) {
	     echo json_encode(array('ok' => 0, 'thongbao' => "Bạn nhập sai mã bảo mật"));
	     exit();
	}
	if(strlen($username)<4){
		$ok=0;
		$thongbao='Tài khoản không đúng';
	}else if(strlen($password)<6){
		$ok=0;
		$thongbao='Mật khẩu dài từ 6 ký tự';
	}else if($check->check_email($email)==false){
		$ok=0;
		$thongbao='Email không đúng định dạng';
	}else{
		$thongtin_taikhoan=mysqli_query($conn,"SELECT *, count(*) AS total FROM account WHERE loginName='$username' ORDER BY accid DESC LIMIT 1");
		$r_tk=mysqli_fetch_assoc($thongtin_taikhoan);
		if($r_tk['total']>0){
			$ok=0;
			$thongbao='Tài khoản đã tồn tại trên hệ thống';
		}else{
			$thongtin_email=mysqli_query($conn,"SELECT *, count(*) AS total FROM account WHERE cEMail='$email' ORDER BY accid DESC LIMIT 1");
			$r_e=mysqli_fetch_assoc($thongtin_email);
			if($r_e['total']>0){
				$ok=0;
				$thongbao='Email đã tồn tại trên hệ thống';
			}else{
				$pass=md5($password);
				$thongtin_end=mysqli_query($conn,"SELECT * FROM account ORDER BY accid DESC LIMIT 1");
				$r_end=mysqli_fetch_assoc($thongtin_end);
				$new_id=$r_end['accid'] + 1;
				//mysqli_query($conn,"INSERT INTO account(loginName,password_hash,xu,Coin,safecode,cEMail,cRealName,cQuestion,cAnswer,checkMember,LockState,lockpasssword) VALUES('$username','$pass','0','0','0','$email','','','','0','0','0')");
				mysqli_query($conn,"INSERT INTO `account` VALUES ('$new_id','$username', '$pass', '0', '0', null, '$email', null, null, null, null, '1', '0', '0')");
				$ok=1;
				$thongbao='Đăng ký tài khoản thành công';
			}

		}
	}
	$info=array(
		'ok'=>$ok,
		'thongbao'=>$thongbao
	);
	echo json_encode($info);
}else if($action=='profile'){
	$email=addslashes(strip_tags($_REQUEST['email']));
	$cmnd=addslashes(strip_tags($_REQUEST['cmnd']));
	if (!isset($_COOKIE['user_id'])) {
	     echo json_encode(array('ok' => 0, 'thongbao' => "Bạn chưa đăng nhập"));
	     exit();
	}
	if($check->check_email($email)==false){
		$ok=0;
		$thongbao='Email không đúng định dạng';
	}else{
		$user_info=$class_member->user_info($conn,$_COOKIE['user_id']);
		$thongtin_email=mysqli_query($conn,"SELECT *, count(*) AS total FROM account WHERE cEMail='$email' ORDER BY accid DESC LIMIT 1");
		$r_e=mysqli_fetch_assoc($thongtin_email);
		if($r_e['total']>0 AND $user_info['cEMail']!=$email){
			$ok=0;
			$thongbao='Email đã tồn tại trên hệ thống';
		}else{
			mysqli_query($conn,"UPDATE account SET cRealName='$cmnd',cEMail='$email' WHERE accid='{$_COOKIE['user_id']}'");
			$ok=1;
			$thongbao='Lưu thông tin thành công';
		}
	}
	$info=array(
		'ok'=>$ok,
		'thongbao'=>$thongbao
	);
	echo json_encode($info);
}else if($action=='doi_matkhau'){
	$password_new=addslashes(strip_tags($_REQUEST['password_new']));
	$password_new2=addslashes(strip_tags($_REQUEST['password_new2']));
	$password_old=addslashes(strip_tags($_REQUEST['password_old']));
	if (!isset($_COOKIE['user_id'])) {
	     echo json_encode(array('ok' => 0, 'thongbao' => "Bạn chưa đăng nhập"));
	     exit();
	}
	$user_info=$class_member->user_info($conn,$_COOKIE['user_id']);
	$pass_old=md5($password_old);
	if($pass_old!=$user_info['password_hash']){
		$ok=0;
		$thongbao='Thất bại! Sai mật khẩu hiện tại';
	}else if(strlen($password_new)<6){
		$ok=0;
		$thongbao='Thất bại! Mật khẩu mới phải từ 6 ký tự';
	}else if($password_new!=$password_new2){
		$ok=0;
		$thongbao='Nhập lại mật khẩu mới không khớp';
	}else{
		$pass=md5($password_new);
		mysqli_query($conn,"UPDATE account SET password_hash='$pass' WHERE accid='{$_COOKIE['user_id']}'");
		$ok=1;
		$thongbao='Đổi mật khẩu thành công';
	}
	$info=array(
		'ok'=>$ok,
		'thongbao'=>$thongbao
	);
	echo json_encode($info);
}else if($action=='napthe'){
	$APIKEY = $index_setting['api_key'];   //truy cập https://thecaosieure.com/profile để lấy
	$mathe = addslashes(strip_tags($_REQUEST['pin']));
	$serial_the = addslashes(strip_tags($_REQUEST['seri'])); // string
	$menh_gia = intval($_REQUEST['price_guest']); // interger
	$card_type = intval($_REQUEST['card_type_id']); // interger
	if($card_type==1){
		$the='Viettel';
	}else if($card_type==2){
		$the='Mobiphone';
	}else if($card_type==3){
		$the='Vinaphone';
	}else if($card_type==6){
		$the='VietnamMobile';
	}else{
		$the='Không rõ';
	}
	$cardType=$the ; // "Viettel" hoặc "Mobifone" hoặc "VietnamMobile"
	$taikhoan_tcsr = $index_setting['api_user'];
	$captcha = $_POST['ma_bao_mat'];
	$transId=rand(1000000, 100000000);
	$note = 'Nạp thẻ cào '.$the.', mệnh giá '.$price_guest;
	require_once 'napthe/securimage/securimage.php';
	$securimage = new Securimage();
	if(!isset($_COOKIE['user_id'])){
	     echo json_encode(array('code' => 1, 'msg' => "Bạn chưa đăng nhập tài khoản"));
	     exit();		
	}
	if ($securimage->check($captcha) == false) {
	     echo json_encode(array('code' => 1, 'msg' => "Sai mã bảo mật"));
	     exit();
	}
	$link_get = "https://thecaosieure.com/gachthe?account=".$taikhoan_tcsr."&cardType=".$cardType . "&transId=".$transId
	. "&cardCode=" . $mathe	. "&APIKey=" . $APIKEY  . "&cardSerial=" . $serial_the. "&cardAmount=" . $menh_gia;
	$xxx=$check->curl($link_get);
	$return= json_decode($xxx,true);
	// nap the thanh cong
	$accid=$_COOKIE['user_id'];
	$hientai=time();
	$code=$return['errorCode'];
	if($code ==1) {
	    echo json_encode(array('code' => 0, 'msg' => "Nạp thẻ thành công mệnh giá " .  $menh_gia));
	    mysqli_query($conn,"INSERT INTO list_naptien SET accid='$accid',loai='card',card_type='$the',card_pin='$mathe',card_serial='$serial_the',card_price='$menh_gia',noidung='$note',tinh_trang='1',tranid='$transId',code='$code',date_post='$hientai'");
	    $user_info=$class_member->user_info($conn,$accid);
	    $sodu=$user_info['Coin']+$menh_gia;
	    mysqli_query($conn,"UPDATE account SET Coin='$sodu' WHERE accid='$accid'");
	}else if($code ==99) {
	    echo json_encode(array('code' => 0, 'msg' => "Đã thực hiện! Hệ thống đang xử lý"));
	    mysqli_query($conn,"INSERT INTO list_naptien SET accid='$accid',loai='card',card_type='$the',card_pin='$mathe',card_serial='$serial_the',card_price='$menh_gia',noidung='$note',tinh_trang='0',tranid='$transId',code='$code',date_post='$hientai'");
	}
	else {
	    // get thong bao loi
	    echo json_encode(array('code' => 1, 'msg' => $return['msg']));
	    mysqli_query($conn,"INSERT INTO list_naptien SET accid='$accid',loai='card',card_type='$the',card_pin='$mathe',card_serial='$serial_the',card_price='$menh_gia',noidung='$note',tinh_trang='0',tranid='$transId',code='$code',date_post='$hientai'");
	}
}else if($action=='check_naptien'){
	$code=$_REQUEST['errorCode'];
	$data=$_REQUEST['data'];
	$transId=$_REQUEST['transId'];
	$msg=$_REQUEST['msg'];
	if($code == '1'){
		$tach_data=explode('|', $data);
		$price=$tach_data[1];
		//Thẻ nạp thành công
		$thongtin_nap=mysqli_query($conn,"SELECT *,count(*) AS total FROM list_naptien WHERE tranid='$transId'");
		$r_n=mysqli_fetch_assoc($thongtin_nap);
		if($r_n['total']>0 AND $r_n['tinh_trang']==0){
			$thongtin_thanhvien=mysqli_query($conn,"SELECT * FROM account WHERE accid='{$r_n['accid']}'");
			$r_tv=mysqli_fetch_assoc($thongtin_thanhvien);
		    $sodu=$r_tv['Coin']+$price;
		    mysqli_query($conn,"UPDATE account SET Coin='$sodu' WHERE accid='$accid'");
		    mysqli_query($conn,"UPDATE list_naptien SET tinh_trang='1' WHERE id='{$r_n['id']}'");
		}
	} else {
	}

}else if($action=='lienhe'){
	$name=addslashes(strip_tags($_REQUEST['name']));
	$email=addslashes(strip_tags($_REQUEST['email']));
	$subject=addslashes(strip_tags($_REQUEST['subject']));
	$message=addslashes(strip_tags($_REQUEST['message']));
	if($name==''){
		$ok=0;
		$thongbao='Vui lòng nhập tên của bạn';
	}else if($email==''){
		$ok=0;
		$thongbao='Vui lòng nhập địa chỉ email';
	}else if($subject==''){
		$ok=0;
		$thongbao='Vui lòng nhập chủ đề';
	}else if($message==''){
		$ok=0;
		$thongbao='Vui lòng nhập nội dung';
	}elseif(time() - $_SESSION['contact']<15){
		$ok=0;
		$thongbao='Bạn thực hiện quá nhanh';
	}else{
		$ok=1;
		mysqli_query($conn,"INSERT INTO contact (name,email,subject,message,date_post)VALUES('$name','$email','$subject','$message',".time().")");
		$_SESSION['contact']=time();
		$thongbao='Cảm ơn bạn! Việc liên hệ đã thành công!';
	}
	$info=array(
		'ok'=>$ok,
		'thongbao'=>$thongbao
	);
	echo json_encode($info);

}else{
	echo "Không có hành động nào được xử lý";
}
?>