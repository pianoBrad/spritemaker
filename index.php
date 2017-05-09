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
			<!-- idea, add a second canvas and stack for background -->
			<!-- add 3rd canvas for UI/etc/etc -->
			<canvas id="canvas" width="300" height="300"></canvas>
		</div>
		<div class="creator-ui">
			<h3 class="section-title">Skin Color</h3>
			<ul class="skin-color">
				<li><a href="#">next</a></li>
			</ul>
		</div>
	</div>

	
	<script>
	<?php 
		echo("var sprites_body = [];");		
		echo("var sprites_head = [];");
		echo("var sprites_leg_left = [];");
		echo("var sprites_leg_right = [];");
		echo("var sprites_hat = [];");

		//This whole thing will probably be json calls on js side instead of php scandirs, in practice
		$json_dir = './spritemaps/mage/body';
		$json_dir_files = scandir($json_dir);

		$files_exist = false;

		create_sprite_arrays($json_dir, $json_dir_files, "sprites_body");

		$json_dir = './spritemaps/mage/head';
		$json_dir_files = scandir($json_dir);

		create_sprite_arrays($json_dir, $json_dir_files, "sprites_head");

		$json_dir = './spritemaps/mage/legs/left';
		$json_dir_files = scandir($json_dir);

		create_sprite_arrays($json_dir, $json_dir_files, "sprites_leg_left");

		$json_dir = './spritemaps/mage/legs/right';
		$json_dir_files = scandir($json_dir);

		create_sprite_arrays($json_dir, $json_dir_files, "sprites_leg_right");	

		$json_dir = './spritemaps/mage/hat';
		$json_dir_files = scandir($json_dir);

		create_sprite_arrays($json_dir, $json_dir_files, "sprites_hat");

		function create_sprite_arrays($json_dir, $json_dir_files, $array_name) {
			foreach ($json_dir_files as $row => $name) {
				if (strpos($name, '.json') !== false) {
					$files_exist = true;

					$json_url = $json_dir . '/' . $name;
					$json_contents = file_get_contents($json_url);

					echo("{$array_name}.push(" . $json_contents . ");");
				}
			}
		}

		if (!$files_exist) {
		}
	?>
	</script>

	<script src="js/canvas.js"></script>

	<?php 
		function import_sprites($dir, $array_name) {
			echo("var {$array_name} = [];");
		
			$json_dir_files = scandir($dir);

			$files_exist = false;
			foreach($json_dir_files as $row => $name) {
				if (strpos($name, '.json') !== false) {
					$files_exist = true;

					$json_url = $json_dir . '/' . $name;
					$json_contents = file_get_contents($json_url);

					$cho("sprites.push(" . $json_contents . ");");
				}
			}	
		}
	?>

</body>

</html>
