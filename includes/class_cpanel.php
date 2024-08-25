 <?php
 class class_cpanel extends class_manage
 {
    ///////////////////
    function list_menu($conn,$page,$limit){
        $skin=$this->load('class_skin_cpanel');
        $check=$this->load('class_check');
        $start=$page*$limit - $limit;
        $i=$start;
        $thongtin=mysqli_query($conn,"SELECT * FROM menu ORDER BY menu_vitri ASC,menu_main ASC, menu_thutu ASC LIMIT $start,$limit");
        while($r_tt=mysqli_fetch_assoc($thongtin)){
            $r_tt['blank']=$check->blank($r_tt['post_tieude']);
            $i++;
            $r_tt['i']=$i;
            if($r_tt['menu_vitri']=='tintuc'){
                $r_tt['menu_main']='Menu tin tức';
            }else if($r_tt['menu_vitri']=='camnang'){
                $r_tt['menu_main']='Menu cẩm nang';
            }else if($r_tt['menu_vitri']=='canbiet'){
                $r_tt['menu_main']='Menu cần biết';
            }else if($r_tt['menu_vitri']=='congdong'){
                $r_tt['menu_main']='Menu cộng đồng';
            }else if($r_tt['menu_vitri']=='hotro'){
                $r_tt['menu_main']='Menu hỗ trợ';
            }else if($r_tt['menu_vitri']=='footer'){
                $r_tt['menu_main']='Menu cuối trang';
            }else{
            }
            $list.=$skin->skin_replace('skin_cpanel/box_action/tr_menu',$r_tt);
        }
        return $list;
    }
    ////////////////////
    function list_category($conn,$page,$limit){
        $skin=$this->load('class_skin_cpanel');
        $check=$this->load('class_check');
        $start=$page*$limit - $limit;
        $i=$start;
        $thongtin=mysqli_query($conn,"SELECT * FROM category ORDER BY cat_main ASC, cat_thutu ASC LIMIT $start,$limit");
        while($r_tt=mysqli_fetch_assoc($thongtin)){
            $r_tt['blank']=$check->blank($r_tt['post_tieude']);
            $i++;
            $r_tt['i']=$i;
            if($r_tt['cat_icon']==''){
                $r_tt['cat_icon']='<span class="icon"><i class="icon icon-movie"></i></span>';
            }
            $list.=$skin->skin_replace('skin_cpanel/box_action/tr_category',$r_tt);
        }
        return $list;
    }
    ///////////////////
    function list_thanhvien($conn,$active,$page,$limit){
        $skin=$this->load('class_skin_cpanel');
        $check=$this->load('class_check');
        $start=$page*$limit - $limit;
        $thongtin=mysqli_query($conn,"SELECT account.*,jxsf8_paycoin.jbcoin AS coin FROM account LEFT JOIN jxsf8_paycoin ON account.accid=jxsf8_paycoin.accid ORDER BY account.accid DESC LIMIT $start,$limit");
        $i=$start;
        while($r_tt=mysqli_fetch_assoc($thongtin)){
            $i++;
            $r_tt['i']=$i;
            $r_tt['coin']=number_format($r_tt['coin']);
            $list.=$skin->skin_replace('skin_cpanel/box_action/tr_thanhvien',$r_tt);
        }
        return $list;
    }
    ///////////////////
    function list_naptien($conn,$tinh_trang,$page,$limit){
        $skin=$this->load('class_skin_cpanel');
        $check=$this->load('class_check');
        $start=$page*$limit - $limit;
        $thongtin=mysqli_query($conn,"SELECT * FROM list_naptien LEFT JOIN account ON account.accid=list_naptien.accid WHERE list_naptien.tinh_trang='$tinh_trang' ORDER BY list_naptien.id DESC LIMIT $start,$limit");
        $i=$start;
        while($r_tt=mysqli_fetch_assoc($thongtin)){
            $i++;
            $r_tt['i']=$i;
            if($r_tt['loai']=='paypal'){
                $r_tt['card_price']='$'.number_format($r_tt['card_price']);
            }else{
                $r_tt['card_price']=number_format($r_tt['card_price']).' VNĐ';
            }
            $r_tt['date_post']=date('h:i:s d/m/Y',$r_tt['date_post']);
            if($tinh_trang==1){
                $list.=$skin->skin_replace('skin_cpanel/box_action/tr_naptien',$r_tt);
            }else if($tinh_trang==2){
                $list.=$skin->skin_replace('skin_cpanel/box_action/tr_naptien_huy',$r_tt);
            }else{
                $list.=$skin->skin_replace('skin_cpanel/box_action/tr_naptien_moi',$r_tt);
            }
        }
        return $list;
    }
    ///////////////////
    function list_support($conn,$page,$limit){
        $skin=$this->load('class_skin_cpanel');
        $check=$this->load('class_check');
        $start=$page*$limit - $limit;
        $i=$start;
        $thongtin=mysqli_query($conn,"SELECT * FROM support ORDER BY thu_tu ASC LIMIT $start,$limit");
        while($r_tt=mysqli_fetch_assoc($thongtin)){
            $i++;
            $r_tt['i']=$i;
            $list.=$skin->skin_replace('skin_cpanel/box_action/tr_support',$r_tt);
        }
        return $list;
    }
    ///////////////////
    function list_timkiem($conn,$page,$limit){
        $skin=$this->load('class_skin_cpanel');
        $check=$this->load('class_check');
        $start=$page*$limit - $limit;
        $i=$start;
        $thongtin=mysqli_query($conn,"SELECT * FROM timkiem ORDER BY id ASC LIMIT $start,$limit");
        while($r_tt=mysqli_fetch_assoc($thongtin)){
            $i++;
            $r_tt['i']=$i;
            if(strpos($r_tt['ip_address'], ',')!==false){
                $tach_ip=explode(',', $r_tt['ip_address']);
                $r_tt['total_ip']=count($tach_ip);
            }else{
                $r_tt['total_ip']=1;
            }
            $list.=$skin->skin_replace('skin_cpanel/box_action/tr_timkiem',$r_tt);
        }
        return $list;
    }
    ///////////////////
    function list_option_category($conn,$id){
        $skin=$this->load('class_skin_cpanel');
        $check=$this->load('class_check');
        $thongtin=mysqli_query($conn,"SELECT * FROM category ORDER BY cat_thutu ASC");
        while($r_tt=mysqli_fetch_assoc($thongtin)){
            $r_tt['blank']=$check->blank($r_tt['post_tieude']);
            $i++;
            if($r_tt['cat_id']==$id){
                $list.='<option value="'.$r_tt['cat_id'].'" selected>'.$r_tt['cat_tieude'].'</option>';
            }else{
                $list.='<option value="'.$r_tt['cat_id'].'">'.$r_tt['cat_tieude'].'</option>';
            }
        }
        return $list;
    }
    ///////////////////
    function list_option_tacgia($conn,$id){
        $skin=$this->load('class_skin_cpanel');
        $check=$this->load('class_check');
        $thongtin=mysqli_query($conn,"SELECT * FROM tac_gia ORDER BY tieu_de ASC");
        while($r_tt=mysqli_fetch_assoc($thongtin)){
            $i++;
            if($r_tt['id']==$id){
                $list.='<option value="'.$r_tt['id'].'" selected>'.$r_tt['tieu_de'].'</option>';
            }else{
                $list.='<option value="'.$r_tt['id'].'">'.$r_tt['tieu_de'].'</option>';
            }
        }
        return $list;
    }
    //////////////////////////////////////////////////////////////////
    function list_div_category($conn,$category){
        $tach_category=explode(',', $category);
        $thongtin=mysqli_query($conn,"SELECT * FROM category ORDER BY cat_thutu ASC");
        while($r_tt=mysqli_fetch_assoc($thongtin)){
            if(in_array($r_tt['cat_id'], $tach_category)==true){
                $list.='<div class="li_input" id="input_'.$r_tt['cat_id'].'"><input type="checkbox" name="category[]" value="'.$r_tt['cat_id'].'" checked> '.$r_tt['cat_tieude'].'</div>';
            }else{
                $list.='<div class="li_input" id="input_'.$r_tt['cat_id'].'"><input type="checkbox" name="category[]" value="'.$r_tt['cat_id'].'"> '.$r_tt['cat_tieude'].'</div>';
            }
        }
        return $list;
    }
    //////////////////////////////////////////////////////////////////
    function list_div_category_tintuc($conn,$category){
        $tach_category=explode(',', $category);
        $thongtin=mysqli_query($conn,"SELECT * FROM category_tintuc ORDER BY cat_thutu ASC");
        while($r_tt=mysqli_fetch_assoc($thongtin)){
            if(in_array($r_tt['cat_id'], $tach_category)==true){
                $list.='<div class="li_input" id="input_'.$r_tt['cat_id'].'"><input type="checkbox" name="category[]" value="'.$r_tt['cat_id'].'" checked> '.$r_tt['cat_tieude'].'</div>';
            }else{
                $list.='<div class="li_input" id="input_'.$r_tt['cat_id'].'"><input type="checkbox" name="category[]" value="'.$r_tt['cat_id'].'"> '.$r_tt['cat_tieude'].'</div>';
            }
        }
        return $list;
    }
    ///////////////////
    function list_option_main_menu($conn,$id){
        $skin=$this->load('class_skin_cpanel');
        $check=$this->load('class_check');
        $thongtin=mysqli_query($conn,"SELECT * FROM menu WHERE menu_main='0' AND menu_vitri='top' ORDER BY menu_thutu ASC");
        while($r_tt=mysqli_fetch_assoc($thongtin)){
            $thongtin_sub=mysqli_query($conn,"SELECT * FROM menu WHERE menu_main='{$r_tt['menu_id']}' ORDER BY menu_thutu ASC");
            $total_sub=mysqli_num_rows($thongtin_sub);
            if($total_sub==0){
                $list_sub='';
            }else{
                while($r_s=mysqli_fetch_assoc($thongtin_sub)){
                    if($r_s['menu_id']==$id){
                        $list_sub.='<option value="'.$r_s['menu_id'].'" disabled selected>-- '.$r_s['menu_tieude'].'</option>';
                    }else{
                        $list_sub.='<option value="'.$r_s['menu_id'].'" disabled>-- '.$r_s['menu_tieude'].'</option>';
                    }
                }
            }
            $i++;
            if($r_tt['menu_id']==$id){
                $list.='<option value="'.$r_tt['menu_id'].'" selected>'.$r_tt['menu_tieude'].'</option>'.$list_sub;
            }else{
                $list.='<option value="'.$r_tt['menu_id'].'">'.$r_tt['menu_tieude'].'</option>'.$list_sub;
            }
            unset($list_sub);
        }
        return $list;
    }
/*    ///////////////////
    function list_option_category($conn,$id){
        $skin=$this->load('class_skin_cpanel');
        $check=$this->load('class_check');
        $thongtin=mysqli_query($conn,"SELECT * FROM category WHERE cat_main='0' ORDER BY cat_thutu ASC");
        while($r_tt=mysqli_fetch_assoc($thongtin)){
            $thongtin_sub=mysqli_query($conn,"SELECT * FROM category WHERE cat_main='{$r_tt['cat_id']}' ORDER BY cat_thutu ASC");
            $total_sub=mysqli_num_rows($thongtin_sub);
            if($total_sub==0){
                $list_sub='';
            }else{
                while($r_s=mysqli_fetch_assoc($thongtin_sub)){
                    $thongtin_sub_sub=mysqli_query($conn,"SELECT * FROM category WHERE cat_main='{$r_s['cat_id']}' ORDER BY cat_thutu ASC");
                    $total_sub_sub=mysqli_num_rows($thongtin_sub_sub);
                    if($total_sub_sub==0){
                        $list_sub_sub='';
                    }else{
                        while($r_ss=mysqli_fetch_assoc($thongtin_sub_sub)){
                            if($r_ss['cat_id']==$id){
                                $list_sub_sub.='<option value="'.$r_ss['cat_id'].'" selected>---- '.$r_ss['cat_tieude'].'</option>';
                            }else{
                                $list_sub_sub.='<option value="'.$r_ss['cat_id'].'">---- '.$r_ss['cat_tieude'].'</option>';
                            }
                        }
                    }
                    if($r_s['cat_id']==$id){
                        $list_sub.='<option value="'.$r_s['cat_id'].'" selected>-- '.$r_s['cat_tieude'].'</option>'.$list_sub_sub;
                    }else{
                        $list_sub.='<option value="'.$r_s['cat_id'].'">-- '.$r_s['cat_tieude'].'</option>'.$list_sub_sub;
                    }
                    unset($list_sub_sub);
                }
            }
            $i++;
            if($r_tt['cat_id']==$id){
                $list.='<option value="'.$r_tt['cat_id'].'" selected>'.$r_tt['cat_tieude'].'</option>'.$list_sub;
            }else{
                $list.='<option value="'.$r_tt['cat_id'].'">'.$r_tt['cat_tieude'].'</option>'.$list_sub;
            }
            unset($list_sub);
        }
        return $list;
    }*/
    ///////////////////
    function list_option_tintuc($conn,$id){
        $skin=$this->load('class_skin_cpanel');
        $check=$this->load('class_check');
        $thongtin=mysqli_query($conn,"SELECT * FROM category_tintuc WHERE cat_main='0' ORDER BY cat_thutu ASC");
        while($r_tt=mysqli_fetch_assoc($thongtin)){
            $thongtin_sub=mysqli_query($conn,"SELECT * FROM category_tintuc WHERE cat_main='{$r_tt['cat_id']}' ORDER BY cat_thutu ASC");
            $total_sub=mysqli_num_rows($thongtin_sub);
            if($total_sub==0){
                $list_sub='';
            }else{
                while($r_s=mysqli_fetch_assoc($thongtin_sub)){
                    $thongtin_sub_sub=mysqli_query($conn,"SELECT * FROM category_tintuc WHERE cat_main='{$r_s['cat_id']}' ORDER BY cat_thutu ASC");
                    $total_sub_sub=mysqli_num_rows($thongtin_sub_sub);
                    if($total_sub_sub==0){
                        $list_sub_sub='';
                    }else{
                        while($r_ss=mysqli_fetch_assoc($thongtin_sub_sub)){
                            if($r_ss['cat_id']==$id){
                                $list_sub_sub.='<option value="'.$r_ss['cat_id'].'" selected>---- '.$r_ss['cat_tieude'].'</option>';
                            }else{
                                $list_sub_sub.='<option value="'.$r_ss['cat_id'].'">---- '.$r_ss['cat_tieude'].'</option>';
                            }
                        }
                    }
                    if($r_s['cat_id']==$id){
                        $list_sub.='<option value="'.$r_s['cat_id'].'" selected>-- '.$r_s['cat_tieude'].'</option>'.$list_sub_sub;
                    }else{
                        $list_sub.='<option value="'.$r_s['cat_id'].'">-- '.$r_s['cat_tieude'].'</option>'.$list_sub_sub;
                    }
                    unset($list_sub_sub);
                }
            }
            $i++;
            if($r_tt['cat_id']==$id){
                $list.='<option value="'.$r_tt['cat_id'].'" selected>'.$r_tt['cat_tieude'].'</option>'.$list_sub;
            }else{
                $list.='<option value="'.$r_tt['cat_id'].'">'.$r_tt['cat_tieude'].'</option>'.$list_sub;
            }
            unset($list_sub);
        }
        return $list;
    }
    ///////////////////
    function list_option_sanpham($conn,$id){
        $skin=$this->load('class_skin_cpanel');
        $check=$this->load('class_check');
        $thongtin=mysqli_query($conn,"SELECT * FROM category_sanpham WHERE cat_main='0' ORDER BY cat_thutu ASC");
        while($r_tt=mysqli_fetch_assoc($thongtin)){
            $thongtin_sub=mysqli_query($conn,"SELECT * FROM category_sanpham WHERE cat_main='{$r_tt['cat_id']}' ORDER BY cat_thutu ASC");
            $total_sub=mysqli_num_rows($thongtin_sub);
            if($total_sub==0){
                $list_sub='';
            }else{
                while($r_s=mysqli_fetch_assoc($thongtin_sub)){
                    $thongtin_sub_sub=mysqli_query($conn,"SELECT * FROM category_sanpham WHERE cat_main='{$r_s['cat_id']}' ORDER BY cat_thutu ASC");
                    $total_sub_sub=mysqli_num_rows($thongtin_sub_sub);
                    if($total_sub_sub==0){
                        $list_sub_sub='';
                    }else{
                        while($r_ss=mysqli_fetch_assoc($thongtin_sub_sub)){
                            if($r_ss['cat_id']==$id){
                                $list_sub_sub.='<option value="'.$r_ss['cat_id'].'" selected>---- '.$r_ss['cat_tieude'].'</option>';
                            }else{
                                $list_sub_sub.='<option value="'.$r_ss['cat_id'].'">---- '.$r_ss['cat_tieude'].'</option>';
                            }
                        }
                    }
                    if($r_s['cat_id']==$id){
                        $list_sub.='<option value="'.$r_s['cat_id'].'" selected>-- '.$r_s['cat_tieude'].'</option>'.$list_sub_sub;
                    }else{
                        $list_sub.='<option value="'.$r_s['cat_id'].'">-- '.$r_s['cat_tieude'].'</option>'.$list_sub_sub;
                    }
                    unset($list_sub_sub);
                }
            }
            $i++;
            if($r_tt['cat_id']==$id){
                $list.='<option value="'.$r_tt['cat_id'].'" selected>'.$r_tt['cat_tieude'].'</option>'.$list_sub;
            }else{
                $list.='<option value="'.$r_tt['cat_id'].'">'.$r_tt['cat_tieude'].'</option>'.$list_sub;
            }
            unset($list_sub);
        }
        return $list;
    } 
    ///////////////////
    function list_option_main($conn,$id){
        $skin=$this->load('class_skin_cpanel');
        $check=$this->load('class_check');
        $thongtin=mysqli_query($conn,"SELECT * FROM category WHERE cat_main='0' ORDER BY cat_thutu ASC");
        while($r_tt=mysqli_fetch_assoc($thongtin)){
            $thongtin_sub=mysqli_query($conn,"SELECT * FROM category WHERE cat_main='{$r_tt['cat_id']}' ORDER BY cat_thutu ASC");
            $total_sub=mysqli_num_rows($thongtin_sub);
            if($total_sub==0){
                $list_sub='';
            }else{
                while($r_s=mysqli_fetch_assoc($thongtin_sub)){
                    $thongtin_sub_sub=mysqli_query($conn,"SELECT * FROM category WHERE cat_main='{$r_s['cat_id']}' ORDER BY cat_thutu ASC");
                    $total_sub_sub=mysqli_num_rows($thongtin_sub_sub);
                    if($total_sub_sub==0){
                        $list_sub_sub='';
                    }else{
                        while($r_ss=mysqli_fetch_assoc($thongtin_sub_sub)){
                            if($r_ss['cat_id']==$id){
                                $list_sub_sub.='<option value="'.$r_ss['cat_id'].'" selected disabled>---- '.$r_ss['cat_tieude'].'</option>';
                            }else{
                                $list_sub_sub.='<option value="'.$r_ss['cat_id'].'" disabled>---- '.$r_ss['cat_tieude'].'</option>';
                            }
                        }
                    }
                    if($r_s['cat_id']==$id){
                        $list_sub.='<option value="'.$r_s['cat_id'].'" selected>-- '.$r_s['cat_tieude'].'</option>'.$list_sub_sub;
                    }else{
                        $list_sub.='<option value="'.$r_s['cat_id'].'">-- '.$r_s['cat_tieude'].'</option>'.$list_sub_sub;
                    }
                    unset($list_sub_sub);
                }
            }
            $i++;
            if($r_tt['cat_id']==$id){
                $list.='<option value="'.$r_tt['cat_id'].'" selected>'.$r_tt['cat_tieude'].'</option>'.$list_sub;
            }else{
                $list.='<option value="'.$r_tt['cat_id'].'">'.$r_tt['cat_tieude'].'</option>'.$list_sub;
            }
            unset($list_sub);
        }
        return $list;
    }
    ///////////////////
    function list_option_main_auto($conn,$id){
        $tach_id=explode(',', $id);
        $skin=$this->load('class_skin_cpanel');
        $check=$this->load('class_check');
        $thongtin=mysqli_query($conn,"SELECT * FROM category WHERE cat_main='0' ORDER BY cat_thutu ASC");
        while($r_tt=mysqli_fetch_assoc($thongtin)){
            $thongtin_sub=mysqli_query($conn,"SELECT * FROM category WHERE cat_main='{$r_tt['cat_id']}' ORDER BY cat_thutu ASC");
            $total_sub=mysqli_num_rows($thongtin_sub);
            if($total_sub==0){
                $list_sub='';
                if($r_tt['cat_id']==$id){
                    $list.='<option value="'.$r_tt['cat_id'].'" selected>'.$r_tt['cat_tieude'].'</option>'.$list_sub;
                }else{
                    $list.='<option value="'.$r_tt['cat_id'].'">'.$r_tt['cat_tieude'].'</option>'.$list_sub;
                }
            }else{
                while($r_s=mysqli_fetch_assoc($thongtin_sub)){
                    $thongtin_sub_sub=mysqli_query($conn,"SELECT * FROM category WHERE cat_main='{$r_s['cat_id']}' ORDER BY cat_thutu ASC");
                    $total_sub_sub=mysqli_num_rows($thongtin_sub_sub);
                    if($total_sub_sub==0){
                        $list_sub_sub='';
                        if($r_s['cat_id']==$tach_id[0]){
                            $list_sub.='<option value="'.$r_s['cat_id'].'" selected>-- '.$r_s['cat_tieude'].'</option>'.$list_sub_sub;
                        }else{
                            $list_sub.='<option value="'.$r_s['cat_id'].'">-- '.$r_s['cat_tieude'].'</option>'.$list_sub_sub;
                        }
                    }else{
                        while($r_ss=mysqli_fetch_assoc($thongtin_sub_sub)){
                            if($r_ss['cat_id']==$tach_id[0]){
                                $list_sub_sub.='<option value="'.$r_ss['cat_id'].'" selected>---- '.$r_ss['cat_tieude'].'</option>';
                            }else{
                                $list_sub_sub.='<option value="'.$r_ss['cat_id'].'">---- '.$r_ss['cat_tieude'].'</option>';
                            }
                        }
                        if($r_s['cat_id']==$tach_id[0]){
                            $list_sub.='<option value="'.$r_s['cat_id'].'" selected>-- '.$r_s['cat_tieude'].'</option>'.$list_sub_sub;
                        }else{
                            $list_sub.='<option value="'.$r_s['cat_id'].'">-- '.$r_s['cat_tieude'].'</option>'.$list_sub_sub;
                        }
                    }
                    unset($list_sub_sub);
                }
                if($r_tt['cat_id']==$tach_id[0]){
                    $list.='<option value="'.$r_tt['cat_id'].'" selected>'.$r_tt['cat_tieude'].'</option>'.$list_sub;
                }else{
                    $list.='<option value="'.$r_tt['cat_id'].'">'.$r_tt['cat_tieude'].'</option>'.$list_sub;
                }
            }
            unset($list_sub);
        }
        return $list;
    }
    ///////////////////
    function list_option_baiviet($conn,$user_id,$id){
        $skin=$this->load('class_skin_cpanel');
        $check=$this->load('class_check');
        $thongtin=mysqli_query($conn,"SELECT * FROM baiviet WHERE user_id='$user_id' ORDER BY tieu_de ASC");
        while($r_tt=mysqli_fetch_assoc($thongtin)){
            if($r_tt['id']==$id){
                $list.='<option value="'.$r_tt['id'].'" selected>'.$r_tt['tieu_de'].'</option>';
            }else{
                $list.='<option value="'.$r_tt['id'].'">'.$r_tt['tieu_de'].'</option>';
            }
        }
        return $list;
    }
    ///////////////////
    function list_baiviet($conn,$page,$limit){
        $skin=$this->load('class_skin_cpanel');
        $check=$this->load('class_check');
        $start=$page*$limit - $limit;
        $thongtin=mysqli_query($conn,"SELECT * FROM post ORDER BY id DESC LIMIT $start,$limit");
        $i=$start;
        while($r_tt=mysqli_fetch_assoc($thongtin)){
            $i++;
            $r_tt['i']=$i;
            $r_tt['view']=number_format($r_tt['view']);
            $list.=$skin->skin_replace('skin_cpanel/box_action/tr_baiviet',$r_tt);
        }
        return $list;
    }
    ///////////////////
    function list_page($conn,$page,$limit){
        $skin=$this->load('class_skin_cpanel');
        $check=$this->load('class_check');
        $start=$page*$limit - $limit;
        $thongtin=mysqli_query($conn,"SELECT * FROM page ORDER BY id DESC LIMIT $start,$limit");
        $i=$start;
        while($r_tt=mysqli_fetch_assoc($thongtin)){
            $i++;
            $r_tt['i']=$i;
            $r_tt['view']=number_format($r_tt['view']);
            $list.=$skin->skin_replace('skin_cpanel/box_action/tr_page',$r_tt);
        }
        return $list;
    }
    ///////////////////
    function list_kq_timkiem($conn,$key){
        $skin=$this->load('class_skin_cpanel');
        $check=$this->load('class_check');
        $thongtin=mysqli_query($conn,"SELECT * FROM truyen WHERE tieu_de LIKE '%$key%' ORDER BY tieu_de ASC");
        $i=0;
        while($r_tt=mysqli_fetch_assoc($thongtin)){
            $i++;
            $r_tt['i']=$i;
            $r_tt['luot_xem']=number_format($r_tt['luot_xem']);
            $r_tt['update_post']=date('H:i:s d/m/Y',$r_tt['update_post']);
            $list.=$skin->skin_replace('skin_cpanel/box_action/tr_truyen',$r_tt);
        }
        mysqli_free_result($thongtin);
        if($i==0){
            $list='<center>Không có kết quả</center>';
        }
        return $list;
    }
    ///////////////////
    function list_slide($conn,$page,$limit){
        $skin=$this->load('class_skin_cpanel');
        $check=$this->load('class_check');
        $start=$page*$limit - $limit;
        $thongtin=mysqli_query($conn,"SELECT * FROM slide ORDER BY vitri ASC,thu_tu ASC LIMIT $start,$limit");
        $i=$start;
        while($r_tt=mysqli_fetch_assoc($thongtin)){
            $i++;
            $r_tt['i']=$i;
            $vitri=intval($r_tt['vitri']);
            if($vitri==1){
                $r_tt['vi_tri']='Slide home 1';
            }else if($vitri==2){
                $r_tt['vi_tri']='Slide home 2';
            }else if($vitri==3){
                $r_tt['vi_tri']='Slide detail';
            }
            $list.=$skin->skin_replace('skin_cpanel/box_action/tr_slide',$r_tt);
        }
        return $list;
    }
//////////////////////////////////////////////////////////////////
    function list_setting($conn,$page,$limit){
        $tlca_skin_cpanel=$this->load('class_skin_cpanel');
        $check=$this->load('class_check');
        $start=$page*$limit-$limit;
        $i=$start;
        $thongtin=mysqli_query($conn,"SELECT * FROM index_setting ORDER BY name DESC LIMIT $start,$limit");
        while($r_tt=mysqli_fetch_assoc($thongtin)){
            $i++;
            $r_tt['i']=$i;
            if($r_tt['kieu']=='img'){
                $r_tt['value']='<img src="'.$r_tt['value'].'" style="max-width:300px;">';

            }else{
                $r_tt['value']=$check->words($r_tt['value'],200);
            }
            if($r_tt['loai']=='img'){
                $list.=$tlca_skin_cpanel->skin_replace('skin_cpanel/box_action/tr_setting_img',$r_tt);
            }else{
                $list.=$tlca_skin_cpanel->skin_replace('skin_cpanel/box_action/tr_setting',$r_tt);
            }
        }
        return $list;
    }
    ///////////////////////
    function phantrang($page, $total, $link) {
        if ($total <= 1) {
            return '';
        } else {
            if($total==2){
                if($page<$total){
                    return '<div class=pagination><div class="pagination-custom"><span>1</span><a href="'.$link.'?page=2">2</a><a href="'.$link.'?page=2">Next</a></div></div>';
                }else if($page==$total){
                    return '<div class=pagination><div class="pagination-custom"><a href="'.$link.'?page=1">Prev</a><a href="'.$link.'?page=1">1</a><span>2</span></div></div>';
                }else{
                    return '<div class=pagination><div class="pagination-custom"><a href="'.$link.'?page=1">1</a><a href="'.$link.'?page=2">2</a></div></div>';
                }
            }else if($total==3){
                if($page==1){
                    return '<div class=pagination><div class="pagination-custom"><span>1</span><a href="'.$link.'?page=2">2</a><a href="'.$link.'?page=3">3</a><a href="'.$link.'?page=2">Next</a></div></div>';
                }else if($page==2){
                    return '<div class=pagination><div class="pagination-custom"><a href="'.$link.'?page=1">Prev</a><a href="'.$link.'?page=1">1</a><span>2</span><a href="'.$link.'?page=3">3</a><a href="'.$link.'?page=3">Next</a></div></div>';
                }else if($page==3){
                    return '<div class=pagination><div class="pagination-custom"><a href="'.$link.'?page=2">Prev</a><a href="'.$link.'?page=1">1</a><a href="'.$link.'?page=2">2</a><span>3</span></div></div>';
                }else{
                    return '<div class=pagination><div class="pagination-custom"><a href="'.$link.'?page=1">1</a><a href="'.$link.'?page=2">2</a><a href="'.$link.'?page=3">3</a></div></div>';
                }
            }else if($total==4){
                if($page==1){
                    return '<div class=pagination><div class="pagination-custom"><span>1</span> . . . <a href="'.$link.'?page=4">4</a><a href="'.$link.'?page=2">Next</a></div></div>';
                }else if($page==2){
                    return '<div class=pagination><div class="pagination-custom"><a href="'.$link.'?page=1">Prev</a><a href="'.$link.'?page=1">1</a><span>2</span> . . . <a href="'.$link.'?page=4">4</a><a href="'.$link.'?page=3">Next</a></div></div>';
                }else if($page==3){
                    return '<div class=pagination><div class="pagination-custom"><a href="'.$link.'?page=2">Prev</a><a href="'.$link.'?page=1">1</a> . . . <span>3</span><a href="'.$link.'?page=4">4</a><a href="'.$link.'?page=4">Next</a></div></div>';
                }else if($page==4){
                    return '<div class=pagination><div class="pagination-custom"><a href="'.$link.'?page=3">Prev</a><a href="'.$link.'?page=1">1</a> . . . <span>4</span></div></div>';
                }else{
                    return '<div class=pagination><div class="pagination-custom"><a href="'.$link.'?page=1">1</a><a href="'.$link.'?page=2">2</a><a href="'.$link.'?page=3">3</a><a href="'.$link.'?page=4">4</a></div></div>';
                }
            }else{
                if($page==1){
                    return '<div class=pagination><div class="pagination-custom"><span>1</span> . . . <a href="'.$link.'?page='.$total.'">'.$total.'</a><a href="'.$link.'?page=2">Next</a></div></div>';
                }else if($page==2){
                    return '<div class=pagination><div class="pagination-custom"><a href="'.$link.'?page=1">Prev</a><a href="'.$link.'?page=1">1</a><span>2</span> . . . <a href="'.$link.'?page='.$total.'">'.$total.'</a><a href="'.$link.'?page=3">Next</a></div></div>';
                }else if($page==3){
                    return '<div class=pagination><div class="pagination-custom"><a href="'.$link.'?page=2">Prev</a><a href="'.$link.'?page=1">1</a> . . . <span>3</span><a href="'.$link.'?page='.$total.'">'.$total.'</a><a href="'.$link.'?page=4">Next</a></div></div>';
                }else if($page<=$total - 2){
                    $back=$page-1;
                    $next=$page+1;
                    return '<div class=pagination><div class="pagination-custom"><a href="'.$link.'?page='.$back.'">Prev</a><a href="'.$link.'?page=1">1</a> . . . <span>'.$page.'</span> . . . <a href="'.$link.'?page='.$total.'">'.$total.'</a><a href="'.$link.'?page='.$next.'">Next</a></div></div>';
                }else if($page<$total - 1){
                    $back=$page-1;
                    $next=$page+1;
                    return '<div class=pagination><div class="pagination-custom"><a href="'.$link.'?page='.$back.'">Prev</a><a href="'.$link.'?page=1">1</a> . . . <span>'.$page.'</span><a href="'.$link.'?page='.$total.'">'.$total.'</a><a href="'.$link.'?page='.$next.'">Next</a></div></div>';
                }else if($page==$total - 1){
                    $back=$page-1;
                    $next=$page+1;
                    return '<div class=pagination><div class="pagination-custom"><a href="'.$link.'?page='.$back.'">Prev</a><a href="'.$link.'?page=1">1</a> . . . <span>'.$page.'</span><a href="'.$link.'?page='.$total.'">'.$total.'</a><a href="'.$link.'?page='.$next.'">Next</a></div></div>';
                }else if($page==$total){
                    $back=$page-1;
                    $next=$page+1;
                    return '<div class=pagination><div class="pagination-custom"><a href="'.$link.'?page='.$back.'">Prev</a><a href="'.$link.'?page=1">1</a> . . . <a href="'.$link.'?page='.$back.'">'.$back.'</a><span>'.$page.'</span></div></div>';
                }else{
                    $k=$total-1;
                    return '<div class=pagination><div class="pagination-custom"><a href="'.$link.'?page=1">1</a><a href="'.$link.'?page=2">2</a> . . . <a href="'.$link.'?page='.$k.'">'.$k.'</a><a href="'.$link.'?page='.$total.'">'.$total.'</a></div></div>';
                }
            }
        }
    }
    ///////////////////////
    function phantrang_timkiem($page, $total, $link) {
        if ($total <= 1) {
            return '';
        } else {
            if($total==2){
                if($page<$total){
                    return '<div class=pagination><div class="pagination-custom"><span>1</span><a href="'.$link.'&page=2">2</a><a href="'.$link.'&page=2">Next</a></div></div>';
                }else if($page==$total){
                    return '<div class=pagination><div class="pagination-custom"><a href="'.$link.'&page=1">Prev</a><a href="'.$link.'&page=1">1</a><span>2</span></div></div>';
                }else{
                    return '<div class=pagination><div class="pagination-custom"><a href="'.$link.'&page=1">1</a><a href="'.$link.'&page=2">2</a></div></div>';
                }
            }else if($total==3){
                if($page==1){
                    return '<div class=pagination><div class="pagination-custom"><span>1</span><a href="'.$link.'&page=2">2</a><a href="'.$link.'&page=3">3</a><a href="'.$link.'&page=2">Next</a></div></div>';
                }else if($page==2){
                    return '<div class=pagination><div class="pagination-custom"><a href="'.$link.'&page=1">Prev</a><a href="'.$link.'&page=1">1</a><span>2</span><a href="'.$link.'&page=3">3</a><a href="'.$link.'&page=3">Next</a></div></div>';
                }else if($page==3){
                    return '<div class=pagination><div class="pagination-custom"><a href="'.$link.'&page=2">Prev</a><a href="'.$link.'&page=1">1</a><a href="'.$link.'&page=2">2</a><span>3</span></div></div>';
                }else{
                    return '<div class=pagination><div class="pagination-custom"><a href="'.$link.'&page=1">1</a><a href="'.$link.'&page=2">2</a><a href="'.$link.'&page=3">3</a></div></div>';
                }
            }else if($total==4){
                if($page==1){
                    return '<div class=pagination><div class="pagination-custom"><span>1</span> . . . <a href="'.$link.'&page=4">4</a><a href="'.$link.'&page=2">Next</a></div></div>';
                }else if($page==2){
                    return '<div class=pagination><div class="pagination-custom"><a href="'.$link.'&page=1">Prev</a><a href="'.$link.'&page=1">1</a><span>2</span> . . . <a href="'.$link.'&page=4">4</a><a href="'.$link.'&page=3">Next</a></div></div>';
                }else if($page==3){
                    return '<div class=pagination><div class="pagination-custom"><a href="'.$link.'&page=2">Prev</a><a href="'.$link.'&page=1">1</a> . . . <span>3</span><a href="'.$link.'&page=4">4</a><a href="'.$link.'&page=4">Next</a></div></div>';
                }else if($page==4){
                    return '<div class=pagination><div class="pagination-custom"><a href="'.$link.'&page=3">Prev</a><a href="'.$link.'&page=1">1</a> . . . <span>4</span></div></div>';
                }else{
                    return '<div class=pagination><div class="pagination-custom"><a href="'.$link.'&page=1">1</a><a href="'.$link.'&page=2">2</a><a href="'.$link.'&page=3">3</a><a href="'.$link.'&page=4">4</a></div></div>';
                }
            }else{
                if($page==1){
                    return '<div class=pagination><div class="pagination-custom"><span>1</span> . . . <a href="'.$link.'&page='.$total.'">'.$total.'</a><a href="'.$link.'&page=2">Next</a></div></div>';
                }else if($page==2){
                    return '<div class=pagination><div class="pagination-custom"><a href="'.$link.'&page=1">Prev</a><a href="'.$link.'&page=1">1</a><span>2</span> . . . <a href="'.$link.'&page='.$total.'">'.$total.'</a><a href="'.$link.'&page=3">Next</a></div></div>';
                }else if($page==3){
                    return '<div class=pagination><div class="pagination-custom"><a href="'.$link.'&page=2">Prev</a><a href="'.$link.'&page=1">1</a> . . . <span>3</span><a href="'.$link.'&page='.$total.'">'.$total.'</a><a href="'.$link.'&page=4">Next</a></div></div>';
                }else if($page<=$total - 2){
                    $back=$page-1;
                    $next=$page+1;
                    return '<div class=pagination><div class="pagination-custom"><a href="'.$link.'&page='.$back.'">Prev</a><a href="'.$link.'&page=1">1</a> . . . <span>'.$page.'</span> . . . <a href="'.$link.'&page='.$total.'">'.$total.'</a><a href="'.$link.'&page='.$next.'">Next</a></div></div>';
                }else if($page<$total - 1){
                    $back=$page-1;
                    $next=$page+1;
                    return '<div class=pagination><div class="pagination-custom"><a href="'.$link.'&page='.$back.'">Prev</a><a href="'.$link.'&page=1">1</a> . . . <span>'.$page.'</span><a href="'.$link.'&page='.$total.'">'.$total.'</a><a href="'.$link.'&page='.$next.'">Next</a></div></div>';
                }else if($page==$total - 1){
                    $back=$page-1;
                    $next=$page+1;
                    return '<div class=pagination><div class="pagination-custom"><a href="'.$link.'&page='.$back.'">Prev</a><a href="'.$link.'&page=1">1</a> . . . <span>'.$page.'</span><a href="'.$link.'&page='.$total.'">'.$total.'</a><a href="'.$link.'&page='.$next.'">Next</a></div></div>';
                }else if($page==$total){
                    $back=$page-1;
                    $next=$page+1;
                    return '<div class=pagination><div class="pagination-custom"><a href="'.$link.'&page='.$back.'">Prev</a><a href="'.$link.'&page=1">1</a> . . . <a href="'.$link.'&page='.$back.'">'.$back.'</a><span>'.$page.'</span></div></div>';
                }else{
                    $k=$total-1;
                    return '<div class=pagination><div class="pagination-custom"><a href="'.$link.'&page=1">1</a><a href="'.$link.'&page=2">2</a> . . . <a href="'.$link.'&page='.$k.'">'.$k.'</a><a href="'.$link.'&page='.$total.'">'.$total.'</a></div></div>';
                }
            }
        }
    }
//////////////////////////////////////////////////////////////////
    function thanhvien_info($conn,$id){
        $thongtin=mysqli_query($conn,"SELECT * FROM user_info WHERE user_id='$id'");
        $total=mysqli_num_rows($thongtin);
        if($total=="0"){
            $r_tt='';
        }else{
            $r_tt=mysqli_fetch_assoc($thongtin);
        }
        return $r_tt;
    }
//////////////////////////////////////////////////////////////////
    function my_info($conn){
        $thongtin=mysqli_query($conn,"SELECT * FROM e_min WHERE username='{$_SESSION['e_name']}'");
        $r_tt=mysqli_fetch_assoc($thongtin);
        return $r_tt;
    }   
//////////////////////////////////////////////////////////////////
}
?>
