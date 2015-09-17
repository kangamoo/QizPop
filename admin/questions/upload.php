<?php 

if(!$_FILES['questionImage']['error']){
	$uploaddir = '/home/quiz/uplImages/'; // change this
	
	$file = $_FILES['questionImage'];

	$ext = pathinfo($file['name'], PATHINFO_EXTENSION);
	$ext = strtolower($ext);
	$fileName = uniqid(time(), false).'.'.$ext;
	$destinationfile = $uploaddir . $fileName;
	if(move_uploaded_file($file['tmp_name'], $destinationfile)){
		echo $fileName;
	} else {
		echo 'upload_error';
	}
} else {
	echo 'upload_error';
}

?>
