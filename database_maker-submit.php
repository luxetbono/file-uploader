<?php

require "media_credentials.php";

$File_name = $_GET["File_Name_NEW"];
$Title = $_GET["Title_NEW"];
$Subject = $_GET["Subject_NEW"];
$Comments = $_GET["Comments_NEW"];
$Exposure = $_GET["Exposure_NEW"];
$FNumber = $_GET["FNumber_NEW"];
$ISO = $_GET["ISO_NEW"];
$Orientation = $_GET["Orientation_NEW"];
$Media_Type = $_GET["Media_Type"];
$entrydetect = $_GET["entrydetect"];
$Permissions = isset($_GET["Permissions"]) ? $_GET["Permissions"] : "Private";

$mysqli = new mysqli($hostname, $username, $password, $database);

/* outputting complete arrays*/
if ($entrydetect == 0) {
	$query = "
	UPDATE media_entries
	SET 
		Title = '$Title',
		Subject='$Subject',
		Comments = '$Comments',
		Exposure = '$Exposure',
		FNumber = '$FNumber',
		ISO = '$ISO',
		Media_Type = '$Media_Type',
		Orientation = '$Orientation',
		Permissions = '$Permissions'
	WHERE File_Name = '$File_name'
	";
	$result = $mysqli -> query($query);

	echo "Entry updated!";

} else {
	$query = "
	INSERT INTO media_entries (File_Name, Title, Subject, Comments, Exposure, FNumber, ISO, Media_Type, Orientation, Permissions)
	VALUES ('$File_name','$Title','$Subject','$Comments','$Exposure','$FNumber','$ISO','$Media_Type', '$Orientation', '$Permissions')
	";
	$result = $mysqli -> query($query);
	echo "New entry filed!";
}
?>