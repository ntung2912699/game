<?php
$servername = "localhost";
$username = "root";
$password = "1234";
$dbname = "jxaccount";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
$info=$conn->query("SELECT * FROM adminjx WHERE uid='admin'");
$total=$info->num_rows;
$r_tt=$info->fetch_assoc();
if($total==0){
	echo 'tài khoản không tồn tại';
}else{
	echo $r_tt['uid'];
}
$conn->close();
?>