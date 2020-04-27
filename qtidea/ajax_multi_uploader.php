<?php
$task = PGRequest::GetCmd('task', '');

if ($task == 'unlinkFile'){
	$fileRemove = $_REQUEST['filenameRemove'];
	$field	= $_REQUEST['field'];
	$table = $_REQUEST['table'];
	$value = $_REQUEST['value'];
	$where = $_REQUEST['where'];
	
	$query = 'UPDATE '.$table.' SET '.$field.'="'.$value.'" WHERE '.$where;
	$database->db_query($query);
	
	$link = PG_ROOT."/images/".str_replace('admin_', '', $page.'s')."/".$fileRemove;
	if(@unlink($link)){
		echo 'Xóa file '.$fileRemove.' thành công !';
	}else{
		echo 'Xóa file '.$fileRemove.' không thành công !';
	}
	echo "<br />"; die;
}
if ($task == 'ajaxMultiUpload'){
	$alias	= convertKhongdau(PGRequest::getVar('alias', ''));
	$set_alias	= generateSlug($alias, strlen($alias));
			
	$uploadPath	= $_REQUEST['ax-file-path'];
	$fileName	= $set_alias."-".time().".jpg";
	//$fileName	= $_REQUEST['ax-file-name'];
	$currByte	= $_REQUEST['ax-start-byte'];
	$maxFileSize= $_REQUEST['ax-maxFileSize'];
	$html5fsize	= $_REQUEST['ax-fileSize'];
	$isLast		= $_REQUEST['isLast'];
	
	//if set generates thumbs only on images type files
	$thumbHeight	= $_REQUEST['ax-thumbHeight'];
	$thumbWidth		= $_REQUEST['ax-thumbWidth'];
	//$thumbWidth		= $setting['resize_image_normal'];
	$thumbPostfix	= $_REQUEST['ax-thumbPostfix'];
	$thumbPath		= $_REQUEST['ax-thumbPath'];
	$thumbFormat	= $_REQUEST['ax-thumbFormat'];
	
	$allowExt	= (empty($_REQUEST['ax-allow-ext']))?array():explode('|', $_REQUEST['ax-allow-ext']);
	$uploadPath	.= (!in_array(substr($uploadPath, -1), array('\\','/') ) )?DIRECTORY_SEPARATOR:'';//normalize path
	
	if(!file_exists($uploadPath) && !empty($uploadPath))
	{
		mkdir($uploadPath, 0777, true);
	}
	
	if(!file_exists($thumbPath) && !empty($thumbPath))
	{
		mkdir($thumbPath, 0777, true);
	}
	
	
	//with gd library
	
	
	
	if(isset($_FILES['ax-files'])) 
	{
		//for eahc theorically runs only 1 time, since i upload i file per time
	    foreach ($_FILES['ax-files']['error'] as $key => $error)
	    {
			if ($error == UPLOAD_ERR_OK)
	        {
	        	$newName = !empty($fileName)? $fileName:$_FILES['ax-files']['name'][$key];
	        	$fullPath = checkFilename($newName, $_FILES['ax-files']['size'][$key]);
	        	
	        	if($fullPath)
	        	{
					move_uploaded_file($_FILES['ax-files']['tmp_name'][$key], $fullPath);
					if(!empty($thumbWidth) || !empty($thumbHeight))
						createThumbGD($fullPath, $thumbPath, $thumbPostfix, $thumbWidth, $thumbHeight, $thumbFormat);
						
					$json = json_encode(array('name'=>basename($fullPath), 'size'=>filesize($fullPath), 'status'=>'uploaded', 'info'=>'File uploaded'));
					echo $json;
	        	}
	        }
	        else
	        {
	        	$json = json_encode(array('name'=>basename($_FILES['ax-files']['name'][$key]), 'size'=>$_FILES['ax-files']['size'][$key], 'status'=>'error', 'info'=>$error));
	        	echo $json;	
	        }
	    }
	    die;
	}
	elseif(isset($_REQUEST['ax-file-name'])) 
	{
		//check only the first peice
		$fullPath = ($currByte!=0) ? $uploadPath.$fileName:checkFilename($fileName, $html5fsize);
		
		if($fullPath)
		{
			$flag			= ($currByte==0) ? 0:FILE_APPEND;
			$receivedBytes	= file_get_contents('php://input');
			//strange bug on very fast connections like localhost, some times cant write on file
			//TODO future version save parts on different files and then make join of parts
		    while(@file_put_contents($fullPath, $receivedBytes, $flag) === false)
		    {
		    	usleep(50);
		    }
		    
		    if($isLast=='true')
		    {
		    	createThumbGD($fullPath, $thumbPath, $thumbPostfix, $thumbWidth, $thumbHeight, $thumbFormat);
		    }
		    $json = json_encode(array('name'=>basename($fullPath), 'size'=>$currByte, 'status'=>'uploaded', 'info'=>'File/chunk uploaded'));
		    echo $json;
		}
		die;
	}
}	
?>