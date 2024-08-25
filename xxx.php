<?php
session_start();
include('./includes/tlca_world.php');
$thongtin=mysqli_query($conn,"SELECT * FROM account ");
while($r_tt=mysqli_fetch_assoc($thongtin)){
	echo $r_tt['loginName'].'<br>';
	
}
?>