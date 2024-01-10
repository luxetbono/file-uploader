<?php

$height = "220";
$width = "";

$folder = '/work/photos/'; // Path relative to base url.

require "media_credentials.php";

$mysqli = new mysqli($hostname, $username, $password, $database);

$media = ($_GET["media"]) ? $_GET["media"] : "0";
$group = str_replace("-", " ", ($_GET["group"]) ? $_GET["group"] : "0");
$orientation = ($_GET["orientation"]);

$featured_width = $_GET["featured_width"];


switch ($media) {
	case 'photography' :
		$media = 'P';
		break;
	case 'cinematography' :
		$media = 'V';
		break;
	case 'other' :
		$media = 'O';
		break;
}

/* outputting complete arrays*/
// Rememeber to add buffer div, eg: <div><div class="your-data"></div></div>.

if ($media != "0" && $group != "0") {
	$query = "SELECT * FROM `media_entries` WHERE `Media_Type` = '$media' AND `Subject` = '$group'";
	$result = $mysqli -> query($query);
	if ($result -> num_rows != "0") {
		while ($row = $result -> fetch_array()) {
			$rows[] = $row;
		}
		foreach ($rows as $row) {
			$ext = end(explode('.', $row['File_Name']));
			if (strtolower($ext) == 'php') {
				$filename = $row['File_Name'];
				print "<div><div class='DynamicPHP'>";
				include "$filename";
				print "<script>console.log('PHP: ".$row['File_Name']."');</script>";
				print '</div></div>';
			}
			if (strtolower($ext) == 'jpg') {
				if ($row['Permissions'] == 'Public') {
					print "<div><div class='DynamicImage'>";
					print '<img src="../imagecache/image.php?width=' . $width . '&height=' . $height . '&image=' . $folder . htmlspecialchars($row['File_Name']) . '" alt=".' . $folder . htmlspecialchars($row['File_Name']) . '"  class="entry_image"/ >';
					print "<span class='title data_field'>" . $row['Title'] . "</span>";
					print '</div></div>';
					if ($row['Orientation'] == $orientation) {
						print "<div><div class='DynamicFeatured'><img src='";
						print "/imagecache/image.php?width=" . $featured_width . "&image=" . $folder . htmlspecialchars($row['File_Name']);
						print "'></div></div>";
					}
				}
			}
		}
	}
} else {
	// Your "fail" message here.
	die ;
}

?>