<?php
/*session_start();*/
// Config
error_reporting(1);
include('../includes/config.php');
// class gold ly
include('class_manage.php');
// Class manage Variable
$tlca_do = new class_manage;
// Template Variable
$class_member = $tlca_do->load('class_member');
$skin = $tlca_do->skin;
?>