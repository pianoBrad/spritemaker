<!doctype html>
<head>
<meta charset="utf-8">

<!-- the title tag should be 60 characters or less -->
<title>Sprite Maker: Add Sprite</title>
 

<!-- meta description must be limited to 160 characters or less -->
<meta name="description" content="Upload pixel graphics to be converted to JSON.">
 

<meta name="author" content="Brad Phillips">

<link href='http://fonts.googleapis.com/css?family=Roboto+Condensed|Open+Sans+Condensed:300' rel='stylesheet' type='text/css'>
<link href="css/style.css" rel="stylesheet" type="text/css"> 

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="js/scripts.js"></script>

</head>

<body>
	<div class="main">
		<h1>Sprite Maker: Image Upload</h1><br/>
		<hr>
		<form id="uploadimage" action="" method="post" enctype="multipart/form-data">
			<div id="image_preview"><img id="previewing" src="noimage.png" /></div>
			<hr id="line">
			<div id="selectImage">
				<label>Select Your Image</label><br/>
				<input type="file" name="file" id="file" required />
				<input type="submit" value="Upload" class="submit" />
			</div>
		</form>
	</div>
	<h4 id='loading' >loading..</h4>
	<div id="message"></div>
</body>

</html>
