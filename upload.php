<?php
if(isset($_FILES["file"]["type"])) {
	$validextensions = array("jpeg", "jpg", "png");
	$temporary = explode(".", $_FILES["file"]["name"]);
	$file_extension = end($temporary);
	
	if ((($_FILES["file"]["type"] == "image/png") || ($_FILES["file"]["type"] == "image/jpg") || ($_FILES["file"]["type"] == "image/jpeg")
) && ($_FILES["file"]["size"] < 5242880)//Approx. 5mb files can be uploaded.
&& in_array($file_extension, $validextensions)) {
		if ($_FILES["file"]["error"] > 0)
		{
			echo "Return Code: " . $_FILES["file"]["error"] . "<br/><br/>";
		} else {
			if (file_exists("uploads/" . $_FILES["file"]["name"])) {
				echo $_FILES["file"]["name"] . " <span id='invalid'><b>already exists.</b></span> ";
			} else {
				$sourcePath = $_FILES['file']['tmp_name']; // Storing source path of the file in a variable
				$targetPath = "uploads/".$_FILES['file']['name']; // Target path where file is to be stored
				move_uploaded_file($sourcePath,$targetPath) ; // Moving Uploaded file
				echo "<span id='success'>Image Uploaded Successfully...!!</span><br/>";
				echo "<br/><b>File Name:</b> " . $_FILES["file"]["name"] . "<br>";
				echo "<b>Type:</b> " . $_FILES["file"]["type"] . "<br>";
				echo "<b>Size:</b> " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
				echo "<b>Temp file:</b> " . $_FILES["file"]["tmp_name"] . "<br>";

				// Get color data from each pixel in uploaded image		
	
				$pixel_array = [];
			
				$imagick = new \Imagick(realpath($targetPath));
				$imageIterator = $imagick->getPixelIterator();

				foreach ($imageIterator as $row => $pixels) { /* Loop through pixel rows */
					foreach ($pixels as $column => $pixel) { /* Loop through the pixels in the row (columns) */
						
						//array_push($pixel_array, $pixel->getColor());
						$pixelColors = $pixel->getColor();
						$rgbaString = $pixelColors['r'] . "," . 
									  $pixelColors['g'] . "," . 
									  $pixelColors['b'] . "," . 
									  $pixelColors['a'];
						if ($pixelColors['a'] <= 0) {
							$rgbaString = "0";
						}

						array_push($pixel_array, ["rgba" => $rgbaString]);
					}
					$imageIterator->syncIterator(); /* Sync the iterator, this is important to do on each iteration */
				}

				$json_data = '{"pixels":' . json_encode($pixel_array) . '}';
				$filename = explode(".", $_FILES["file"]["name"], 2);
				$base_filename = $filename[0];			
	
				// Write color data to json file
				$fp = fopen('./spritemaps/' . $base_filename . '.json', 'w');				
				fwrite($fp, $json_data);
				fclose($fp);

			}
		}
	} else {
		echo "<span id='invalid'>***Invalid file Size or Type***<span>";
	}
}
?>
