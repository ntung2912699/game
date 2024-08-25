<?php
	$tlca_data = array();
//	$tlca_data['server'] = '45.119.215.18';
//	$tlca_data['dbuser'] = 'huubinh';
//	$tlca_data['dbpassword'] = 'huubinh1';
//	$tlca_data['dbname'] = 'jxaccount';
	$tlca_data['server'] = 'localhost';
	$tlca_data['dbuser'] = 'root';
	$tlca_data['dbpassword'] = '';
	$tlca_data['dbname'] = 'jxaccount';
	date_default_timezone_set('Asia/Saigon');
	 //Connect 
	$conn = mysqli_connect($tlca_data['server'],$tlca_data['dbuser'],$tlca_data['dbpassword'],$tlca_data['dbname']);
	// Template config
	@define('skin_name','skin');
	@define('skin_ext','.tpl');
?>
