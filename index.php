<?php
#include('ApiVK.php');
//APP_ID, SECRET
#$public = new ApiVK(3287085, 'ZfOU3XaYLpPYVINzsXZ5'); 
#$public->getAccessData();
#$public->setAccessData('fd6cc777fc821faafc82efaabffcadf547efc82fc87c72c3efaaca6d0f05432', '1228ef268beeba1c52'); 
# example
	//print_r($public->init('topic-42086143_27140112'));	
	//print_r($public->init('photo32385245_149496627'));
	//print_r($public->init('photo-42086143_288908405'));
	//print_r($public->init('wall32385245_289'));
	//print_r($public->init('wall-42086143_1'));

#==================================================================

// curl vk api
include('CApiVK.php');
$token = 'b8110d90b81d6703b81d670907b831f9dcbb816b80a4f9772319e6ae69e64f0';
$public = new CApiVK($token);
#print_r($public->init('wall-42086143_1'));
#print_r($public->init('wall32385245_289'));
#print_r($public->init('photo-42086143_288908405'));
#print_r($public->init('photo32385245_149496627'));
print_r($public->init('topic-42086143_27140112'));
?>	
