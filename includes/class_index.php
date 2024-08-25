<?php
class class_index extends class_manage{
    function list_menu($conn){
        $skin=$this->load('class_skin');
        $check=$this->load('class_check');
        $thongtin=mysqli_query($conn,"SELECT * FROM menu ORDER BY menu_thutu ASC");
        $list=array();
        while($r_tt=mysqli_fetch_assoc($thongtin)){
            $list[$r_tt['menu_vitri']].='<li><a href="'.$r_tt['menu_link'].'" class="" target="'.$r_tt['menu_target'].'">'.$r_tt['menu_tieude'].'</a></li>';
        }
        return json_encode($list);
    }
    //////////////////////////////
    function list_tintuc($conn,$cat,$page,$limit){
        $skin=$this->load('class_skin');
        $check=$this->load('class_check');
        $start=$page*$limit - $limit;
        $thongtin=mysqli_query($conn,"SELECT * FROM post 
          WHERE FIND_IN_SET('$cat', cat) > 0 
          ORDER BY id DESC 
          LIMIT $start, $limit");
        $i=0;
        while($r_tt=mysqli_fetch_assoc($thongtin)){
            $i++;
            $r_tt['short_description']=$check->words($r_tt['short_description'],35);
            $list.=$skin->skin_replace('skin/box_li/li_tintuc',$r_tt);
        }
        mysqli_free_result($thongtin);
        $info=array(
            'total'=>$i,
            'list'=>$list,
        );
        return json_encode($info);
    }
    //////////////////////////////
    function list_right($conn,$cat,$limit){
        $skin=$this->load('class_skin');
        $check=$this->load('class_check');
        $thongtin=mysqli_query($conn,"SELECT * FROM post WHERE FIND_IN_SET($cat,cat)>0 ORDER BY id DESC LIMIT $limit");
        $i=0;
        while($r_tt=mysqli_fetch_assoc($thongtin)){
            $i++;
            $r_tt['update_post']=$check->date_update($r_tt['update_post']);
            $list.=$skin->skin_replace('skin/box_li/li_right',$r_tt);
        }
        mysqli_free_result($thongtin);
        return $list;
    }
    //////////////////////////////
    function list_left($conn,$cat,$limit){
        $skin=$this->load('class_skin');
        $check=$this->load('class_check');
        $thongtin=mysqli_query($conn,"SELECT * FROM post WHERE FIND_IN_SET($cat,cat)>0 ORDER BY id DESC LIMIT $limit");
        $i=0;
        while($r_tt=mysqli_fetch_assoc($thongtin)){
            $i++;
            $r_tt['update_post']=$check->date_update($r_tt['update_post']);
            $list.=$skin->skin_replace('skin/box_li/li_tintuc',$r_tt);
        }
        mysqli_free_result($thongtin);
        return $list;
    }
    //////////////////////////////
    function list_support($conn){
        $skin=$this->load('class_skin');
        $check=$this->load('class_check');
        $thongtin=mysqli_query($conn,"SELECT * FROM support ORDER BY thu_tu ASC");
        $i=0;
        while($r_tt=mysqli_fetch_assoc($thongtin)){
            $i++;
            $list.=$skin->skin_replace('skin/box_li/li_support',$r_tt);
        }
        mysqli_free_result($thongtin);
        return $list;
    }
    //////////////////////////////
    function list_category($conn){
        $skin=$this->load('class_skin');
        $check=$this->load('class_check');
        $thongtin=mysqli_query($conn,"SELECT * FROM category ORDER BY cat_thutu ASC");
        $i=0;
        while($r_tt=mysqli_fetch_assoc($thongtin)){
            $i++;
            $list.=$skin->skin_replace('skin/box_li/li_category',$r_tt);
        }
        mysqli_free_result($thongtin);
        return $list;
    }
    //////////////////////////////
    function list_content_index($conn,$cat,$limit){
        $skin=$this->load('class_skin');
        $check=$this->load('class_check');
        $thongtin=mysqli_query($conn,"SELECT * FROM post WHERE FIND_IN_SET($cat,cat)>0 ORDER BY id DESC LIMIT $limit");
        $i=0;
        while($r_tt=mysqli_fetch_assoc($thongtin)){
            $i++;
            $r_tt['date_post']=date('d/m',$r_tt['date_post']);
            $list.=$skin->skin_replace('skin/box_li/li_content_index',$r_tt);
        }
        mysqli_free_result($thongtin);
        return $list;
    }
    //////////////////////////////
    function list_slide($conn){
        $skin=$this->load('class_skin');
        $check=$this->load('class_check');
        $thongtin=mysqli_query($conn,"SELECT * FROM slide WHERE active='1' ORDER BY thu_tu ASC");
        $i=0;
        while($r_tt=mysqli_fetch_assoc($thongtin)){
            $i++;
            if($r_tt['vitri']==1){
                $list['slide_home_1'].=$skin->skin_replace('skin/box_li/li_slide_home_1',$r_tt);
            }else if($r_tt['vitri']==2){
                $list['slide_home_2'].=$skin->skin_replace('skin/box_li/li_slide_home_2',$r_tt);
                $list['tieude_home_2'].="'".$r_tt['tieu_de']."',";
            }else if($r_tt['vitri']==3){
                $list['slide_detail'].=$skin->skin_replace('skin/box_li/li_slide_detail',$r_tt);
            }else{

            }
        }
        $list['tieude_home_2']=substr($list['tieude_home_2'], 0,-1);
        mysqli_free_result($thongtin);
        return json_encode($list);
    }
    //////////////////////////////
    function list_naptien($conn,$accid,$page,$limit){
        $skin=$this->load('class_skin');
        $check=$this->load('class_check');
        $start=$page*$limit - $limit;
        $thongtin=mysqli_query($conn,"SELECT * FROM list_naptien WHERE accid='$accid' ORDER BY id DESC LIMIT $start,$limit");
        $i=0;
        while($r_tt=mysqli_fetch_assoc($thongtin)){
            $i++;
            $r_tt['date_post']=date('d/m/Y',$r_tt['date_post']);
            if($r_tt['tinh_trang']==1){
                $r_tt['tinh_trang']='Hoàn thành';
            }else if($r_tt['tinh_trang']==0){
                $r_tt['tinh_trang']='Đang xử lý';
            }else if($r_tt['tinh_trang']==2){
                $r_tt['tinh_trang']='Đã hủy';
            }else{
                $r_tt['tinh_trang']='Không hợp lệ';
            }
            $r_tt['card_price']=number_format($r_tt['card_price']);
            $list.=$skin->skin_replace('skin/box_li/li_lichsu',$r_tt);
        }
        mysqli_free_result($thongtin);
        $info=array(
            'total'=>$i,
            'list'=>$list,
        );
        return json_encode($info);
    }
    //////////////////////////////
    function list_lienquan($conn,$id,$cat,$limit){
        $skin=$this->load('class_skin');
        $check=$this->load('class_check');
        if(strpos($cat, ',')!==false){
            $tach_cat=explode(',', $cat);
            $total_cat=count($tach_cat);
            for ($i=0; $i < $total_cat ; $i++) { 
                if($i==0){
                    $where.="(FIND_IN_SET($tach_cat[$i],cat)>0 ";
                }else{
                    if($tach_cat[$i]==''){

                    }else{
                        $where.="OR FIND_IN_SET($tach_cat[$i],cat)>0 ";
                    }
                }
            }
            $where=$where.")";
        }else{
            $where="FIND_IN_SET($cat,cat)>0";
        }
        $thongtin=mysqli_query($conn,"SELECT * FROM post WHERE $where AND id!='$id' ORDER BY id DESC LIMIT $limit");
        while($r_tt=mysqli_fetch_assoc($thongtin)){
            $list.=$skin->skin_replace('skin/box_li/li_lienquan',$r_tt);
        }
        mysqli_free_result($thongtin);
        return $list;
    }
    ///////////////////
    function list_timkiem($conn,$key,$page,$limit){
        $start=$page*$limit - $limit;
        $skin=$this->load('class_skin');
        $check=$this->load('class_check');
        $thongtin=mysqli_query($conn,"SELECT * FROM truyen WHERE tieu_de LIKE '%$key%' AND chap!='' ORDER BY tieu_de ASC LIMIT $start,$limit");
        $i=0;
        while($r_tt=mysqli_fetch_assoc($thongtin)){
            $i++;
            $r_tt['luot_xem']=number_format(intval($r_tt['luot_xem']));
            if($r_tt['hot']==1){
                $r_tt['hot']='<span class="chap_status">hot</span>';
            }else{
                $r_tt['hot']='';
            }
            $r_tt['update_post']=$check->date_update($r_tt['update_post']);
            $list.=$skin->skin_replace('skin/box_li/li_truyen',$r_tt);
        }
        mysqli_free_result($thongtin);
        if($i==0){
            $list='<center>Không có kết quả</center>';
        }
        $info=array(
            'total'=>$i,
            'list'=>$list,
        );
        return json_encode($info);
    }
    ///////////////////////
    function phantrang($page, $total, $link) {
        if ($total <= 1) {
            return '';
        } else {
            if($total==2){
                if($page<$total){
                    return '<div class="phantrang"><div class="pagination-custom"><span>1</span><a href="'.$link.'?page=2">2</a><a href="'.$link.'?page=2">Next</a></div></div>';
                }else if($page==$total){
                    return '<div class="phantrang"><div class="pagination-custom"><a href="'.$link.'?page=1">Prev</a><a href="'.$link.'?page=1">1</a><span>2</span></div></div>';
                }else{
                    return '<div class="phantrang"><div class="pagination-custom"><a href="'.$link.'?page=1">1</a><a href="'.$link.'?page=2">2</a></div></div>';
                }
            }else if($total==3){
                if($page==1){
                    return '<div class="phantrang"><div class="pagination-custom"><span>1</span><a href="'.$link.'?page=2">2</a><a href="'.$link.'?page=3">3</a><a href="'.$link.'?page=2">Next</a></div></div>';
                }else if($page==2){
                    return '<div class="phantrang"><div class="pagination-custom"><a href="'.$link.'?page=1">Prev</a><a href="'.$link.'?page=1">1</a><span>2</span><a href="'.$link.'?page=3">3</a><a href="'.$link.'?page=3">Next</a></div></div>';
                }else if($page==3){
                    return '<div class="phantrang"><div class="pagination-custom"><a href="'.$link.'?page=2">Prev</a><a href="'.$link.'?page=1">1</a><a href="'.$link.'?page=2">2</a><span>3</span></div></div>';
                }else{
                    return '<div class="phantrang"><div class="pagination-custom"><a href="'.$link.'?page=1">1</a><a href="'.$link.'?page=2">2</a><a href="'.$link.'?page=3">3</a></div></div>';
                }
            }else if($total==4){
                if($page==1){
                    return '<div class="phantrang"><div class="pagination-custom"><span>1</span> . . . <a href="'.$link.'?page=4">4</a><a href="'.$link.'?page=2">Next</a></div></div>';
                }else if($page==2){
                    return '<div class="phantrang"><div class="pagination-custom"><a href="'.$link.'?page=1">Prev</a><a href="'.$link.'?page=1">1</a><span>2</span> . . . <a href="'.$link.'?page=4">4</a><a href="'.$link.'?page=3">Next</a></div></div>';
                }else if($page==3){
                    return '<div class="phantrang"><div class="pagination-custom"><a href="'.$link.'?page=2">Prev</a><a href="'.$link.'?page=1">1</a> . . . <span>3</span><a href="'.$link.'?page=4">4</a><a href="'.$link.'?page=4">Next</a></div></div>';
                }else if($page==4){
                    return '<div class="phantrang"><div class="pagination-custom"><a href="'.$link.'?page=3">Prev</a><a href="'.$link.'?page=1">1</a> . . . <span>4</span></div></div>';
                }else{
                    return '<div class="phantrang"><div class="pagination-custom"><a href="'.$link.'?page=1">1</a><a href="'.$link.'?page=2">2</a><a href="'.$link.'?page=3">3</a><a href="'.$link.'?page=4">4</a></div></div>';
                }
            }else{
                if($page==1){
                    return '<div class="phantrang"><div class="pagination-custom"><span>1</span> . . . <a href="'.$link.'?page='.$total.'">'.$total.'</a><a href="'.$link.'?page=2">Next</a></div></div>';
                }else if($page==2){
                    return '<div class="phantrang"><div class="pagination-custom"><a href="'.$link.'?page=1">Prev</a><a href="'.$link.'?page=1">1</a><span>2</span> . . . <a href="'.$link.'?page='.$total.'">'.$total.'</a><a href="'.$link.'?page=3">Next</a></div></div>';
                }else if($page==3){
                    return '<div class="phantrang"><div class="pagination-custom"><a href="'.$link.'?page=2">Prev</a><a href="'.$link.'?page=1">1</a> . . . <span>3</span><a href="'.$link.'?page='.$total.'">'.$total.'</a><a href="'.$link.'?page=4">Next</a></div></div>';
                }else if($page<=$total - 2){
                    $back=$page-1;
                    $next=$page+1;
                    return '<div class="phantrang"><div class="pagination-custom"><a href="'.$link.'?page='.$back.'">Prev</a><a href="'.$link.'?page=1">1</a> . . . <span>'.$page.'</span> . . . <a href="'.$link.'?page='.$total.'">'.$total.'</a><a href="'.$link.'?page='.$next.'">Next</a></div></div>';
                }else if($page<$total - 1){
                    $back=$page-1;
                    $next=$page+1;
                    return '<div class="phantrang"><div class="pagination-custom"><a href="'.$link.'?page='.$back.'">Prev</a><a href="'.$link.'?page=1">1</a> . . . <span>'.$page.'</span><a href="'.$link.'?page='.$total.'">'.$total.'</a><a href="'.$link.'?page='.$next.'">Next</a></div></div>';
                }else if($page==$total - 1){
                    $back=$page-1;
                    $next=$page+1;
                    return '<div class="phantrang"><div class="pagination-custom"><a href="'.$link.'?page='.$back.'">Prev</a><a href="'.$link.'?page=1">1</a> . . . <span>'.$page.'</span><a href="'.$link.'?page='.$total.'">'.$total.'</a><a href="'.$link.'?page='.$next.'">Next</a></div></div>';
                }else if($page==$total){
                    $back=$page-1;
                    $next=$page+1;
                    return '<div class="phantrang"><div class="pagination-custom"><a href="'.$link.'?page='.$back.'">Prev</a><a href="'.$link.'?page=1">1</a> . . . <a href="'.$link.'?page='.$back.'">'.$back.'</a><span>'.$page.'</span></div></div>';
                }else{
                    $k=$total-1;
                    return '<div class="phantrang"><div class="pagination-custom"><a href="'.$link.'?page=1">1</a><a href="'.$link.'?page=2">2</a> . . . <a href="'.$link.'?page='.$k.'">'.$k.'</a><a href="'.$link.'?page='.$total.'">'.$total.'</a></div></div>';
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
                    return '<div class="phantrang"><div class="pagination-custom"><span>1</span><a href="'.$link.'&page=2">2</a><a href="'.$link.'&page=2">Next</a></div></div>';
                }else if($page==$total){
                    return '<div class="phantrang"><div class="pagination-custom"><a href="'.$link.'&page=1">Prev</a><a href="'.$link.'&page=1">1</a><span>2</span></div></div>';
                }else{
                    return '<div class="phantrang"><div class="pagination-custom"><a href="'.$link.'&page=1">1</a><a href="'.$link.'&page=2">2</a></div></div>';
                }
            }else if($total==3){
                if($page==1){
                    return '<div class="phantrang"><div class="pagination-custom"><span>1</span><a href="'.$link.'&page=2">2</a><a href="'.$link.'&page=3">3</a><a href="'.$link.'&page=2">Next</a></div></div>';
                }else if($page==2){
                    return '<div class="phantrang"><div class="pagination-custom"><a href="'.$link.'&page=1">Prev</a><a href="'.$link.'&page=1">1</a><span>2</span><a href="'.$link.'&page=3">3</a><a href="'.$link.'&page=3">Next</a></div></div>';
                }else if($page==3){
                    return '<div class="phantrang"><div class="pagination-custom"><a href="'.$link.'&page=2">Prev</a><a href="'.$link.'&page=1">1</a><a href="'.$link.'&page=2">2</a><span>3</span></div></div>';
                }else{
                    return '<div class="phantrang"><div class="pagination-custom"><a href="'.$link.'&page=1">1</a><a href="'.$link.'&page=2">2</a><a href="'.$link.'&page=3">3</a></div></div>';
                }
            }else if($total==4){
                if($page==1){
                    return '<div class="phantrang"><div class="pagination-custom"><span>1</span> . . . <a href="'.$link.'&page=4">4</a><a href="'.$link.'&page=2">Next</a></div></div>';
                }else if($page==2){
                    return '<div class="phantrang"><div class="pagination-custom"><a href="'.$link.'&page=1">Prev</a><a href="'.$link.'&page=1">1</a><span>2</span> . . . <a href="'.$link.'&page=4">4</a><a href="'.$link.'&page=3">Next</a></div></div>';
                }else if($page==3){
                    return '<div class="phantrang"><div class="pagination-custom"><a href="'.$link.'&page=2">Prev</a><a href="'.$link.'&page=1">1</a> . . . <span>3</span><a href="'.$link.'&page=4">4</a><a href="'.$link.'&page=4">Next</a></div></div>';
                }else if($page==4){
                    return '<div class="phantrang"><div class="pagination-custom"><a href="'.$link.'&page=3">Prev</a><a href="'.$link.'&page=1">1</a> . . . <span>4</span></div></div>';
                }else{
                    return '<div class="phantrang"><div class="pagination-custom"><a href="'.$link.'&page=1">1</a><a href="'.$link.'&page=2">2</a><a href="'.$link.'&page=3">3</a><a href="'.$link.'&page=4">4</a></div></div>';
                }
            }else{
                if($page==1){
                    return '<div class="phantrang"><div class="pagination-custom"><span>1</span> . . . <a href="'.$link.'&page='.$total.'">'.$total.'</a><a href="'.$link.'&page=2">Next</a></div></div>';
                }else if($page==2){
                    return '<div class="phantrang"><div class="pagination-custom"><a href="'.$link.'&page=1">Prev</a><a href="'.$link.'&page=1">1</a><span>2</span> . . . <a href="'.$link.'&page='.$total.'">'.$total.'</a><a href="'.$link.'&page=3">Next</a></div></div>';
                }else if($page==3){
                    return '<div class="phantrang"><div class="pagination-custom"><a href="'.$link.'&page=2">Prev</a><a href="'.$link.'&page=1">1</a> . . . <span>3</span><a href="'.$link.'&page='.$total.'">'.$total.'</a><a href="'.$link.'&page=4">Next</a></div></div>';
                }else if($page<=$total - 2){
                    $back=$page-1;
                    $next=$page+1;
                    return '<div class="phantrang"><div class="pagination-custom"><a href="'.$link.'&page='.$back.'">Prev</a><a href="'.$link.'&page=1">1</a> . . . <span>'.$page.'</span> . . . <a href="'.$link.'&page='.$total.'">'.$total.'</a><a href="'.$link.'&page='.$next.'">Next</a></div></div>';
                }else if($page<$total - 1){
                    $back=$page-1;
                    $next=$page+1;
                    return '<div class="phantrang"><div class="pagination-custom"><a href="'.$link.'&page='.$back.'">Prev</a><a href="'.$link.'&page=1">1</a> . . . <span>'.$page.'</span><a href="'.$link.'&page='.$total.'">'.$total.'</a><a href="'.$link.'&page='.$next.'">Next</a></div></div>';
                }else if($page==$total - 1){
                    $back=$page-1;
                    $next=$page+1;
                    return '<div class="phantrang"><div class="pagination-custom"><a href="'.$link.'&page='.$back.'">Prev</a><a href="'.$link.'&page=1">1</a> . . . <span>'.$page.'</span><a href="'.$link.'&page='.$total.'">'.$total.'</a><a href="'.$link.'&page='.$next.'">Next</a></div></div>';
                }else if($page==$total){
                    $back=$page-1;
                    $next=$page+1;
                    return '<div class="phantrang"><div class="pagination-custom"><a href="'.$link.'&page='.$back.'">Prev</a><a href="'.$link.'&page=1">1</a> . . . <a href="'.$link.'&page='.$back.'">'.$back.'</a><span>'.$page.'</span></div></div>';
                }else{
                    $k=$total-1;
                    return '<div class="phantrang"><div class="pagination-custom"><a href="'.$link.'&page=1">1</a><a href="'.$link.'&page=2">2</a> . . . <a href="'.$link.'&page='.$k.'">'.$k.'</a><a href="'.$link.'&page='.$total.'">'.$total.'</a></div></div>';
                }
            }
        }
    }
}
?>

