<!doctype html>
<head>
<meta charset="utf-8">

<!-- the title tag should be 60 characters or less -->
<title>Sprite Maker</title>
 

<!-- meta description must be limited to 160 characters or less -->
<meta name="description" content="Sprite Maker">
 

<meta name="author" content="Brad Phillips">

<link href='http://fonts.googleapis.com/css?family=Roboto+Condensed|Open+Sans+Condensed:300' rel='stylesheet' type='text/css'>
<link href="css/style.css" rel="stylesheet" type="text/css">

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="js/easeljs-NEXT.min.js"></script>

</head>

<body onload="init();">
	<div class="main">
		<h1>Sprite Maker</h1><br/>
		
		<div id="canvas-wrap">
			<canvas id="canvas" width="230" height="230"></canvas>
		</div>
	</div>

	
	<script>
	<?php 
		echo("var sprites = [];");		

		$json_dir = './spritemaps';
		$json_dir_files = scandir($json_dir);

		$files_exist = false;

		foreach ($json_dir_files as $row => $name) {
			if (strpos($name, '.json') !== false) {
				$files_exist = true;

				$json_url = $json_dir . '/' . $name;
				$json_contents = file_get_contents($json_url);
			
				//print($json_contents);
				echo("sprites.push(" . $json_contents . ");");
			}
		}

		if (!$files_exist) {
		}
	?>
	</script>

	<script src="js/canvas.js"></script>

</body>

</html>
