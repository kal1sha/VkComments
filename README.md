#include('ApiVK.php');
//APP_ID, SECRET
#$public = new ApiVK(id, 'token'); 
#$public->getAccessData();
#$public->setAccessData('fd6cc777fc82efaafc82efaabffcadf547efc82fc87c72c3efaaca6d0f05431', '1268ef268beeba1c53'); 
# example
	//print_r($public->init('topic-42086143_27140112'));	
	//print_r($public->init('photo32385245_149496627'));
	//print_r($public->init('photo-42086143_288908405'));
	//print_r($public->init('wall32385245_289'));
	//print_r($public->init('wall-42086143_1'));

#==================================================================

// curl vk api
include('CApiVK.php');
$token = 'token;
$public = new CApiVK($token);
print_r($public->init('wall-42086143_1'));
print_r($public->init('wall32385245_289'));
print_r($public->init('photo-42086143_288908405'));
print_r($public->init('photo32385245_149496627'));
print_r($public->init('topic-42086143_27140112'));
