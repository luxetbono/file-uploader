<html>

<head>
	<meta charset="UTF-8">

	<title>Database Maker</title>

	<link rel="stylesheet" type="text/css" href="https://luxetbono.com/css/database_maker.css">
	<link rel="icon" type="image/x-icon" href="https://luxetbono.com/favicon.ico">

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>

	<script src="https://luxetbono.com/javascript/database_maker.js"></script>
	<script src="https://luxetbono.com/javascript/database_maker-submission.js"></script>

	<link href='https://fonts.googleapis.com/css?family=Advent+Pro:700,600,400,200' rel='stylesheet' type='text/css'>
</head>

<body>
	<?php include 'upload_form.php'; ?>
	<div id="radio-media">
		<form id="radio-media-form">
			<label for="photos">
			<input type="radio" name="media" id="photos" value="photos">
			<span>Photos</span>
			</label>
			<label for="files">
			<input type="radio" name="media" id="files" value="files">
			<span>Files</span>
			</label>
		</form>
	</div>

	<div id='key'>
		<p>Key</p>
		<div>
		<hr>
			<p>All changes are updated immediately.</p>
			<div id="permissions">
				<p>Public</p>
				<p>Private</p>
				<p>Image visible/invisible on site.</p>
			</div>
			<div id="media">
				<div>Photography</div>
				<div>Video</div>
				<div>Other</div>
				<p><b>Media types.</b> Hover over text for descriptions.</p>
			</div>
			<div><p>Cloud &#9729; indicates content is in the database.</p></div>
			<p>For more information about photos click the triangle in the upper right corner of an entry.</p>
		</div>
		<div>
			<b>NOTE: If including images with files, make sure the tag in the file matches the tag in the photo.</b>
			<ol>
				<section>
					<b>Photos</b>
					<li>Set tag for photo. Us the properties dialog on your computer.</li>
					<li>Upload a photo (FTP or form above).</li>
					<li>Load Photo form.</li>
					<li>Set type: Photo, Video, or Other.</li>
					<li>Make public when ready.</li>
				</section>
			</ol>
			<ol>
				<section>
					<b>Files</b>
					<li>Upload a file (FTP).</li>
					<li>Load File form.</li>
					<li>Add tag in the square text box.</li>
					<li>Set type: Photo, Video, or Other.</li>
					<li>Make public when ready.</li>
				</section>
			</ol>
		</div>
	</div>

	<div id="container">
		Select an option (Photos, Files) from above.
	</div>
</body>
</html>