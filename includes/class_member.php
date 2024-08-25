<?php
class class_member extends class_manage{
    function check_login(){
        if(!isset($_COOKIE['user_id'])){
            return 0;
        }else{
            //setcookie('user_id',$_COOKIE['user_id'],time()+3600);
            return $_COOKIE['user_id'];
        }
    }
    ///////////////////////
    function login($conn,$username,$password){
        if(strlen($username)<4){
            return 0;
        }else{
            $info=mysqli_query($conn,"SELECT * FROM account WHERE loginName='$username'");
            $total=mysqli_num_rows($info);
            if($total>0){
                $r_info=mysqli_fetch_assoc($info);
                $pass=md5($password);
                if($pass!=$r_info['password_hash']){
                    return 2;
                }else{
                    $hientai=time();
                    setcookie("user_id",$r_info['accid'],time() + 2593000);
                    return 200;
                }
            }else{
                return 1;
            }
        }
    }
    ///////////////////////
    function login_email($conn,$email,$password){
        if(strlen($email)<4){
            return 0;
        }else{
            $info=mysqli_query($conn,"SELECT * FROM account WHERE cEMail='$email'");
            $total=mysqli_num_rows($info);
            if($total>0){
                $r_info=mysqli_fetch_assoc($info);
                $pass=md5($password);
                if($pass!=$r_info['password_hash']){
                    return 2;
                }else{
                    $hientai=time();
                    $check=$this->load('class_check');
                    setcookie("user_id",$r_info['accid'],time() + 31536000);
                    return 200;
                }
            }else{
                return 1;
            }
        }
    }
    ///////////////////////
    function logout(){
        setcookie("user_id",$_COOKIE['user_id'],time() - 3600);
    }
    ///////////////////////
    function user_info($conn,$user_id){
        $info=mysqli_query($conn,"SELECT * FROM account WHERE accid='$user_id' ORDER BY accid ASC LIMIT 1");
        $total=mysqli_num_rows($info);
        if($total>0){
            $r_info=mysqli_fetch_assoc($info);
            return $r_info;
        }else{
            return '';
        }
    }
}
?>
