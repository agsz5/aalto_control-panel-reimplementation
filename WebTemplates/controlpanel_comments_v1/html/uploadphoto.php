<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
//properties of the uploaded file
$name = $_FILES["myfile"]["name"];
$type = $_FILES["myfile"]["type"];
$size = $_FILES["myfile"]["size"];
$temp = $_FILES["myfile"]["tmp_name"];
$error = $_FILES["myfile"]["error"];  // 0 if everything is clear...

//echo $temp;

//check for errors
if ($error > 0)
	die ("Error uploading file! Code $error.");
	else
	{
		//conditions for the file ... e.g. if you don't want jpeg images the condition is ($type =="image/jpeg")
		if ( ($type !="image/jpeg")&&($type !="image/png") )
			die ("$type File type not supported");
		else{
		//---learning tip:   move_uploaded_file(filename, destination)
		$name = preg_replace('/\s+/', '', $name);
		$timestamp = time();
		$uniquename = $timestamp."_".$name;

		$id = 	$_POST['id'];
		$title = 		$_POST['title'];
		$excerpt = 	$_POST['excerpt'];
		$file_path = "../../AaltoGlobalImpact.OIP/MediaContent/".$uniquename;
		$imagetag ="<img src='".$file_path."' style='height: 100%; width: auto;'>";

		move_uploaded_file($temp, "../../AaltoGlobalImpact.OIP/MediaContent/".$uniquename);

        /* Calculate and store the Photo dimensions, later to be used to form proper Content-Cards*/
		        $photoDimensions = getimagesize($file_path);
                $photoWidth = $photoDimensions[0];
                $photoHeight = $photoDimensions[1];
                $photoRatio=210/$photoWidth;
                $CalculatedPhotoHeight=round($photoHeight*$photoRatio);

                $file = "json/site_settings.json";
                $json = json_decode(file_get_contents($file), true);
                $new_item= array("path"=> $file_path, "originalWidth"=>$photoWidth, "originalHeight"=>$photoHeight, "calculatedPhotoHeight"=>$CalculatedPhotoHeight);
                array_push($json["UploadedPhotos"], $new_item);
                file_put_contents($file, json_encode($json));
        /* Ends the calculation and storage the Photo dimensions, later to be used to form proper Content-Cards*/
                echo $file_path;
		}
	}

?>