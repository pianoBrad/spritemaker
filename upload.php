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


				$allColors = [];
				// Grab palette for colors used in sprite 
				foreach ($imageIterator as $row => $pixels) {
					foreach ($pixels as $column => $pixel) {
						$rgbaString = getRgbaString($pixel->getColor(), $pixel->getColor(true));
						array_push($allColors, $rgbaString);
					}
					$imageIterator->syncIterator();
				}
				$unique_colors = array_unique($allColors);
				$colors = array_values($unique_colors);

				// Create array for rows for each pixel
				$pixel_rows = [];
				foreach ($imageIterator as $row => $pixels) {
					$colors_row = "";
					foreach($pixels as $column => $pixel) {
						$rgba_string = getRgbaString($pixel->getColor(), $pixel->getColor(true));		
	
						$color_key = array_search($rgba_string, $colors);
						$colors_row .= $color_key;
						
					}
					array_push($pixel_rows, $colors_row);
					$imageIterator->syncIterator();	
				}
				
				$json_data = '{"rows":' . json_encode($pixel_rows) . "," . 
							 '"colors":' . json_encode($colors) . '}';

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

function getRgbaString($rgbaArray, $rgbaArrayNormalized) {
	$rgbaString = $rgbaArray['r'] . "," .
                  $rgbaArray['g'] . "," .
                  $rgbaArray['b'] . "," .
                  round($rgbaArrayNormalized['a'], 2);
    
	$rgbaString = "rgba(" . $rgbaString . ")";
	return $rgbaString;
}

?>
