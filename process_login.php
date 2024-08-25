<?php
include('./includes/config.php');
$username=addslashes(strip_tags($_REQUEST['username']));
$password=addslashes(strip_tags($_REQUEST['password']));
$thongtin=mysqli_query($conn,"SELECT *,count(*) AS total FROM account WHERE loginName='$username'");
$r_tt=mysqli_fetch_assoc($thongtin);
if($r_tt['total']>0){
    $pass=md5($password);
    if($pass!=$r_tt['password_hash']){
		$ok=0;
		$thongbao='Mật khẩu không đúng';
    }/*else if($r_tt['active']==0){
		$ok=0;
		$thongbao='Tài khoản của bạn chưa kích hoạt';
    }else if($r_tt['active']==2){
		$ok=0;
		$thongbao='Tài khoản của bạn đang tạm khóa';
    }*/else{
        $hientai=time();
        setcookie("user_id",$r_tt['accid'],time() + 2593000,'/');
		$ok=1;
		$thongbao='Đang nhập thành công';
    }
}else{
	$ok=0;
	$thongbao='Tài khoản không tồn tại trên hệ thống';
}
$info=array(
	'ok'=>$ok,
	'thongbao'=>$thongbao
);
echo json_encode($info);
?>