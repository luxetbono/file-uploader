<!doctype html>
<html lang="en">
<head>
	<?php include $_SERVER['DOCUMENT_ROOT'] . '/php/metadata_read.php'; ?>
    
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
    
    <script type="text/javascript" src="../javascript/subpage-header.js"></script>
    <script type="text/javascript" src="../javascript/work.js"></script>
    <script type="text/javascript" src="../javascript/work-form-submission.js"></script>
    
    <link rel="stylesheet" type="text/css" href="../css/subpage_header.css">
    <link rel="stylesheet" type="text/css" href="../css/work.css">
    
    <?php include "../php/fonts.php" ?>
	<?php include_once('../php/analyticstracking.php') ?>
    
</head>
<body>
    <?php
        $mediums = array('photography', 'cinematography', 'other');
        if(isset($_GET['media'])){
            if(in_array($_GET['media'], $mediums)){
                $URLmedium = $_GET['media'];
            } else {
                $URLmedium = 'unknown';
            }
        } else {
            $URLmedium = '';
        }
        if(isset($_GET['group'])){
            $URLgroup = $_GET['group'];
        } else {
            $URLgroup =  '';
        }
    ?>
    <?php include "../php/subpage_header.php" ?>
    <form action="work-sql_connect.php" method="get">
		<input type="number" name="featured_width">
 		<input type="radio" name="orientation" value="P" selected>
 		<input type="radio" name="orientation" value="L">
        <select id="groupmenu" name="group">
            <!-- Menu inserted dynamically. -->
        </select>
        <select id="mediamenu" name="media">
            <option value="default">Medium</option>
            <option value="photography">Photography</option>
            <option value="cinematography">Cinematography</option>
            <option value="other">Programming/Design/More</option>
        </select>
    </form>
	<div id="welcome">&gt; Select a medium.</div>
	<div id="count" class="featured"></div>
	<div id="featured" class="featured content"><div><!-- DynamicFeatured image inserted here. --></div></div>
	<span id="progressbar" class="featured"></span>
	<div id="image-skip"><a href="#cinema">Skip to Images</a></div>
	<div id="pvp-container">
		<div id="featured-placeholder" class="content"></div>
		<div id="gallery" class="content">
			<!-- DynamicImage content inserted here. -->
		</div>
	</div>
	<a name="cinema">
	<div id="cinema_viewer"><span>Click to Close</span><div></div></div>
</body>
</html>