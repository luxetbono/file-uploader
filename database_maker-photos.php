<head>
	<meta charset="UTF-8">

	<title>Database Maker - Photos</title>

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

$mysqli = new mysqli($hostname, $username, $password, $database);

// Folder path.

$folder = '/photos/';
$path = getcwd();
$folder_path = $path . $folder;
$files = scandir($folder_path);

$count = 0;

for ($x = 0; $x < count($files); $x++) {
	
	$ext = end(explode('.', $files[$x]));
	
	if (strtolower ($ext) == 'jpg') {
		
		$image = $files[$x];
		$image = $folder_path . $image;
		
		if (file_exists($image)) {

			$count++;

			/* Read EXIF data. */
			$data = exif_read_data($image, 0, TRUE);

			/* Get appropriate attributes. */
			$File_Name = isset($data['FILE']['FileName']) ? $data['FILE']['FileName'] : "&nbsp;";
			$Title = isset($data["IFD0"]["Title"]) ? preg_replace('/[^(\x20-\x7F)]*/', '', $data["IFD0"]["Title"]) : "";
			$Subject = isset($data["IFD0"]["Subject"]) ? preg_replace('/[^(\x20-\x7F)]*/', '', $data["IFD0"]["Subject"]) : "";
			$Comments = isset($data["IFD0"]["Comments"]) ? preg_replace('/[^(\x20-\x7F)]*/', '', $data["IFD0"]["Comments"]) : "";

			$ISO = isset($data['EXIF']['ISOSpeedRatings']) ? $data['EXIF']['ISOSpeedRatings'] : "";
			$FNumber = isset($data['EXIF']['FNumber']) ? $data['EXIF']['FNumber'] : "";
			$Exposure = isset($data['EXIF']['ExposureTime']) ? $data['EXIF']['ExposureTime'] : "";

			$Height = $data['COMPUTED']['Height'];
			$Width = $data['COMPUTED']['Width'];

			/* Reformat exposure for legibility. */
			if ($Exposure != "") {
				$parts = explode("/", $Exposure);
				$Exposure = implode("/", array(1, $parts[1] / $parts[0]));
			} else {
				$Exposure = "-";
			}

			/* Reformat f-stop for legibility. */
			if ($FNumber != "") {
				$parts = explode("/", $FNumber);
				$FNumber = implode("/", array($parts[0] / $parts[1]));
			} else {
				$FNumber = "-";
			}

			/* Determine orientation. */
			if ($Width > $Height) {
				$Orientation = "L";
			} else {
				$Orientation = "P";
			}

			/* Fetch data stored in database. */

			$query = "SELECT * FROM `media_entries` WHERE `File_Name` = '$File_Name'";

			$result = $mysqli -> query($query);

			$Row = $result -> fetch_assoc();

			$File_Name_STORED = isset($Row['File']) ? $Row['File'] : "&nbsp;";
			$Title_STORED = isset($Row['Title']) ? $Row['Title'] : "&nbsp;";
			$Subject_STORED = isset($Row['Subject']) ? $Row['Subject'] : "&nbsp;";
			$Comments_STORED = isset($Row['Comments']) ? $Row['Comments'] : "&nbsp;";
			$ISO_STORED = isset($Row['ISO']) ? $Row['ISO'] : "&nbsp;";
			$FNumber_STORED = isset($Row['FNumber']) ? $Row['FNumber'] : "&nbsp;";
			$Exposure_STORED = isset($Row['Exposure']) ? $Row['Exposure'] : "&nbsp;";
			$Media_Type_STORED = isset($Row['Media_Type']) ? $Row['Media_Type'] : "0";
			$Permissions = isset($Row['Permissions']) ? $Row['Permissions'] : "Private";
			$Uploaded = isset($Row['Permissions']) ? "&#9729;" : "";

			/* Output acquired data. */

			echo "<div class='entry' id='entry$count'><form action='https://luxetbono.com/work/database_maker-submit.php' method='get'>";

			echo "<button type='button' class='expand'>&#9660;</button>";

			echo "<div class='title data_field'><p>$Title</p><p>$Title_STORED</p> </div>";
			echo "<div class='file_name data_field'>($File_Name)</div>";

			echo "<div class='cloud_permissions'> <div class='is_uploaded'> $Uploaded </div> <input id='permissions_checkbox$count' type='checkbox' name='Permissions' class='permissions_checkbox data_field' value='Public'" . ($Permissions == 'Public' ? 'checked' : '') . "> <label for='permissions_checkbox$count'> Private </label></div>";

			echo "<div class='content'>";
			echo "<div class='subject data_field'><p>$Subject</p><p>$Subject_STORED</p></div>";
			echo "<div class='comments data_field'><p>$Comments</p><p>$Comments_STORED</p></div>";

			echo "<div class='camera_info'>";
			echo "<div class='exposure data_field'><p>$Exposure</p><p>$Exposure_STORED</p> sec</div>";
			echo "<div class='fnumber data_field'>f <p>$FNumber</p><p>$FNumber_STORED</p></div>";
			echo "<div class='ISO data_field'><span> ISO </span><p>$ISO</p><p>$ISO_STORED</p></div>";
			/*
			 * Orientation is image specific and cannot be altered by user without altering the image.
			 * The Orientation field only displays one field; hovering over will not data stored in database.
			 */
			echo "<div class='orientation data_field'>$Orientation</div>";
			echo "</div>";

			echo "</div>";

			echo "<div class='media_type'>
			<select name='Media_Type'>
					<option value='Photography' id='Media_Type_Photography$count'" . (($Media_Type_STORED == 'P' || $Media_Type_STORED != 'V' || $Media_Type_STORED != 'O') ? 'selected' : '') . ">P</option>
					<option value='Video' id='Media_Type_Video$count'" . ($Media_Type_STORED == 'V' ? 'selected' : '') . ">V</option>
					<option value='Other' id='Media_Type_Other$count'" . ($Media_Type_STORED == 'O' ? 'selected' : '') . ">O</option>
			</select>";
			echo "</div>";

			/* entrydetect determines if entry exists. Used in database_maker_submit.php to submit data. */
			if ($Uploaded) {
				$entrydetect = 0;
			} else {
				$entrydetect = 1;
			}

			/*
			 * Data for submission, hidden because of encoding issues.
			 * If workaround found remember to make substitution to non_STORED sections above, css, and database_maker_submit.php page.
			 */
			echo "<div class='data'>
					<input type='text' name='Title_NEW' value='$Title' readonly>
					<input type='text' name='File_Name_NEW' value='$File_Name' readonly>
					<input type='text' name='Subject_NEW' value='$Subject' readonly>
					<input type='text' name='Comments_NEW' value='$Comments' readonly>
					<input type='text' name='Exposure_NEW' value='$Exposure' readonly>
					<input type='text' name='FNumber_NEW' value='$FNumber' readonly>
					<input type='text' name='ISO_NEW' value='$ISO' readonly>
					<input type='text' name='Orientation_NEW' value='$Orientation' readonly>
					<input type='text' name='entrydetect' value=$entrydetect readonly>
					</div>";

			echo "</form>
				<div class='status'></div>
				</div>";

		};
	}
}
?>