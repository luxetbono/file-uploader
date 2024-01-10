<?php

require "media_credentials.php";

$conn = new mysqli($servername, $username, $password, $database);

$media = ($_GET["media"]) ? $_GET["media"] : "0";
 
// Check connection
if ($conn->connect_error) {
     die("Connection failed: " . $conn->connect_error);
}

switch ($media) {
	case 'photography':
		$media = 'P';
		break;
	case 'cinematography':
		$media = 'V';
		break;
	case 'other':
		$media = 'O';
		break;
}

$query = "SELECT DISTINCT `Subject` FROM `media_entries` WHERE `Media_Type` = '$media' AND `Permissions` = 'Public' ORDER BY `Subject` ASC";

$result = $conn->query($query);

if ($result->num_rows > 0) {
     // output data of each row
     print_r ("<option value='' selected='selected'>" . $result->num_rows ." results </option>");
     while($row = $result->fetch_assoc()) {
         print_r ("<option value='" . str_replace(" ", "-", $row['Subject']) . "'>"  . $row['Subject']  . "</option>");
     }
} else {
	if($media == "PT") {
		print_r ("<option value=''> See Below </option>");
	} else {
		print_r ("<option value=''> 0 results </option>");
	}
}

$conn->close();
?>