<?php
$target_dir = "photos/";
$uploadFail = array();
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if submit button clicked.
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	// Check if image file is a actual image or fake image
	if(isset($_POST["submit"])) {
		$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
		if($check !== false) {
			$uploadOk = 1;
		} else {
			$uploadFail[] = "File is not an image.";
			$uploadOk = 0;
		}
	}
	// Check if file already exists
	if (file_exists($target_file)) {
		$uploadFail[] = "File already exists. (<a href='https://luxetbono.com/work/photos/".$_FILES["fileToUpload"]["name"]."'>". basename( $_FILES["fileToUpload"]["name"])."</a>)";
		$uploadOk = 0;
	}
	// Check file size
	/*
	if ($_FILES["fileToUpload"]["size"] > 500000) {
		echo "Sorry, your file is too large.";
		$uploadOk = 0;
	}
	*/
	// Allow certain file formats
	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
	&& $imageFileType != "gif" ) {
		$uploadFail[] = "Only JPG, JPEG, PNG & GIF files are allowed.";
		$uploadOk = 0;
	}
	// Check if $uploadOk is set to 0 by an error
	if ($uploadOk == 0) {
		$uploadFail[] = "Your file was not uploaded.";
	// if everything is ok, try to upload file
	} else {
		if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
			$uploadSuccess = "The file <a href='https://luxetbono.com/work/photos/".$_FILES["fileToUpload"]["name"]."'>". basename($_FILES["fileToUpload"]["name"]). "</a> has been uploaded.";
		} else {
			$uploadFail[] = "There was an error uploading your file.";
		}
	}
}
?>

<html>
<head>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	<script src="https://luxetbono.com/javascript/upload_form.js"></script>
	
	 <link rel="stylesheet" type="text/css" href="https://luxetbono.com/css/upload_form.css">
</head>
<body>
	<div id="formContainer">
		<form action="" method="post" enctype="multipart/form-data" id="uploadImage">
			<div id="fileText">Select Image</div>
			<input type="file" name="fileToUpload" id="fileToUpload">
			<input type="submit" value="Upload Image" name="submit" disabled>
		</form>

		<?php
		if($uploadSuccess){
			echo "<div id='uploadSuccess'>$uploadSuccess</div>";
		} elseif ($uploadFail) {
			echo "<div id='uploadFail'><h1>!Error[".sizeOf($uploadFail)."]</h1><ul>";
			for($i=0; $i <= sizeOf($uploadFail)-1; $i++){
				echo "<li>$uploadFail[$i]</li>";
			}
			echo "</ul></div>";
		}
		?>
	</div>
</body>
</html>