<head>
	<meta charset="UTF-8">

	<title>Database Maker - Files</title>

	<link rel="stylesheet" type="text/css" href="../css/database_maker.css">

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>

	<script src="https://luxetbono.com/javascript/database_maker.js"></script>
	<script src="https://luxetbono.com/javascript/database_maker-submission.js"></script>

	<link href='https://fonts.googleapis.com/css?family=Advent+Pro:700,600,400,200' rel='stylesheet' type='text/css'>
</head>

<?php

require "media_credentials.php";

$entrydetect = 0;

// Connect to the database
$mysqli = new mysqli($hostname, $username, $password, $database);

// Folder path.
$urlpath = 'https://www.luxetbono.com/work/projects/'; // For storing paths relative to URL, not file path on server. Keeps database clean and transferable between hosting services. 

$folder = '/projects/';

$path = getcwd();
$folder_path = $path . $folder;
$files = scandir($folder_path); // This section is for file detection.

$count = 0;

for ($x = 0; $x < count($files); $x++) {
	
	$ext = end(explode('.', $files[$x]));

	if (strtolower ($ext) == 'php') {

		$php_file = $files[$x];
		$urlpathfile = $php_file;
		$urlpathfile = $urlpath . $urlpathfile;
		$php_file = $folder_path . $php_file;
		
		if (file_exists($php_file)) {

			$count++;

			$php_file = trim($php_file, '.');

			/* Fetch data stored in database. */

			$query = "SELECT * FROM `media_entries` WHERE `File_Name` = '$urlpathfile'";

			$result = $mysqli -> query($query);

			$Row = $result -> fetch_assoc();

			$File_Name_STORED = isset($Row['File']) ? $Row['File'] : "&nbsp;";
			$Media_Type_STORED = isset($Row['Media_Type']) ? $Row['Media_Type'] : "0";
			$Subject_STORED = isset($Row['Subject']) ? $Row['Subject'] : "&nbsp;";
			$Permissions = isset($Row['Permissions']) ? $Row['Permissions'] : "Private";
			$Uploaded = isset($Row['Permissions']) ? "&#9729;" : "";

			/* Output acquired data. */

			echo "<div class='entry entryPHP' id='entry$count'><form action='https://luxetbono.com/work/database_maker-submit.php' method='get'>";
			echo "<div class='title data_field'>$urlpathfile</div>";
			echo "<div class='cloud_permissions'> <div class='is_uploaded'> $Uploaded </div> <input id='permissions_checkbox$count' type='checkbox' name='Permissions' class='permissions_checkbox data_field' value='Public'" . ($Permissions == 'Public' ? 'checked' : '') . "> <label for='permissions_checkbox$count'> Private </label></div>";

			echo "<div class='content'>";

			echo "<input type='text' class='subject' name='Subject_NEW' value='$Subject_STORED'>";

			echo "<div class='media_type'>
					<input name='Media_Type' id='Media_Type_Photography$count' type='radio' value='Photography'" . ($Media_Type_STORED == 'Photography' ? 'checked' : '') . ">
					<label for='Media_Type_Photography$count'>Photography</label>
					<input name='Media_Type' id='Media_Type_Video$count' type='radio' value='Video'" . ($Media_Type_STORED == 'Video' ? 'checked' : '') . ">
					<label for='Media_Type_Video$count'>Video</label>
					<input name='Media_Type' id='Media_Type_Other$count' type='radio' value='Other'" . (($Media_Type_STORED != 'Photography' || $Media_Type_STORED != 'Video' || $Media_Type_STORED == 'Other') ? 'checked' : '') . ">
					<label for='Media_Type_Other$count'>Other</label>";

			echo "</div>";

			echo "</div>";

			/* entrydetect determines if entry exists. Used in database_maker_submit.php to submit data. */
			if ($Uploaded) {
				$entrydetect = 0;
			} else {
				$entrydetect = 1;
			}

			/*
			 * Data for submission, hidden because of encoding issues.
			 * If workaround found remember to make substitution to non_STORED sections above, css, and database_maker-submit.php page.
			 */
			echo "<div class='data'>
					<input type='text' name='Title_NEW' value='' readonly>
					<input type='text' name='File_Name_NEW' value='' readonly>
					<!-- Subject portion located above. -->
					<input type='text' name='Comments_NEW' value='' readonly>
					<input type='text' name='Exposure_NEW' value='' readonly>
					<input type='text' name='FNumber_NEW' value='' readonly>
					<input type='text' name='ISO_NEW' value='' readonly>
					<input type='text' name='Orientation_NEW' value='N' readonly>
					<input type='text' name='File_Name_NEW' value='$urlpathfile' readonly>
					<input type='text' name='entrydetect' value=$entrydetect readonly>
					</div>";

			// The status class is a placeholder is for status text. An alert updates users that an entry has been updated / added.

			echo "</form>";

			echo "</form>
				<div class='status'></div>
				</div>";

		}
	}
}
?>