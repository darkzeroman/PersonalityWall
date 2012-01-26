
<?php
// Location of the XML file on the file system
$file = 'pics.xml';
$xml = simplexml_load_file($file);

/* Configuration Start */

$thumb_directory = 'img/thumbs';
$orig_directory = 'img/original';

$stage_width = 800;
// How big is the area the images are scattered on
$stage_height = 350;

/* Configuration end */

$allowed_types = array('jpg', 'jpeg', 'gif', 'png');
$file_parts = array();
$ext = '';
$title = '';
$i = 0;
$tagarray = array('comics', 'blogs', 'news', 'radio');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Typejs" content="text/html; charset=utf-8" />
<title>Personality Wall</title>
<link rel="stylesheet" type="text/css" href="css/wall.css" />
<link rel="stylesheet" type="text/css" href="css/buttons.css" />

<link rel="stylesheet"
	href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.13/themes/ui-darkness/jquery-ui.css"
	type="text/css" media="all" />
<link rel="stylesheet" type="text/css"
	href="fancybox/jquery.fancybox-1.3.4.css" />

<script type="text/javascript"
	src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>
<script type="text/javascript"
	src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.13/jquery-ui.min.js"></script>
<script type="text/javascript" src="fancybox/jquery-css-transform.js"></script>
<script type="text/javascript"
	src="fancybox/jquery-animate-css-rotate-scale.js"></script>
<script type="text/javascript"
	src="fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<script type="text/javascript"
	src="./fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<script type="text/javascript" src="wallbase.js"></script>
<script type="text/javascript" src="wallfunctions.js"></script>
<script type="text/javascript">
var stage_width = <?php  echo $stage_width ?> ;
var stage_height = <?php echo $stage_height ?> ;
var list = [<?php foreach ($tagarray as $i => $value) {echo '\'.'.$value.'\',';	};?>];
$(document).ready(function () {
  
    
    shuffle();

    $(".fancybox").fancybox({
        transitionIn: 'elastic',
        transitionOut: 'elastic',
        titlePosition: 'inside',
        showNavArrows: false,
        centerOnScroll: true,
        hideOnContentClick: true,
        onComplete: resize
    });
  
    $('#shuffleText').click(shuffle);
    $('#sortText').click(sort);
    $('#gridText').click(grid);
    $('#gridSortText').click(gridSort);
    $('#browseText').click(browse);

    
});
		</script>


</head>
<body>

	<div id="main">

		<h1 style="float: left">Personality Wall</h1>
		<div style="text-align: right; float: right">
			<h3>Drag and click on the pictures to view</h3>
			<p>
				<a id="inline" class="fancybox" href="#info">Information</a> | <a
					id="inline" class="fancybox" href="#resources">Resources</a> | <a
					id="inline" " class="fancybox" href="#changes">Changes</a>
			</p>
		</div>
		<!-- Stuff for the Inline Displays -->
		<div style="display: none;">
			<div id="info" class="inline">
				<p>What this stuff does: Blah blah</p>
			</div>
			<div id="resources" class="inline">
				<p>
					<b><u>Here are some of the resources I used:</u> </b>
				</p>
				

					<ul>
						<li><a href="http://www.cssbuttongenerator.com/" target="_blank">CSS
								Button Generator</a> to create the buttons!</li>
						<li><a
							href="http://tutorialzine.com/2009/11/hovering-gallery-css3-jquery/"
							target="_blank">Tutorial Zine</a> as a base to create this page.</li>
						<li><a
							href="http://www.marcofolio.net/webdesign/the_polaroid_photo_viewer_non-full_screen.html"
							target="_blank">Marco Kuiper's Polaroid Example</a> helped with
							some rotation errors.</li>
						<li><a href="http://www.w3schools.com" target="_blank">W3Schools</a>
							for help when my knowledge of CSS/Javascript/HTML needed a little
							review!</li>
						<li><a href="http://fancybox.net/" target="_blank">FancyBox</a>
							for the modal windows.</li>
						<li><a href="http://php.net/manual/en/book.simplexml.php"
							target="_blank">SimpleXML Manual</a> for making the XML aspects.</li>
						<li><a href="http://jsbeautifier.org/" target="_blank"> JS
								Beautifier</a> for help on making the code look pretty.</li>
					</ul>
			
			</div>
			<div id="changes" class="inline">
				<p>
					<b><u>Recent Changes:</u> </b>
				</p>
				<ul>
					<li>Removed click triggers when not in browse mode</li>
				</ul>
			</div>
		</div>


		<table style="margin-left: auto; margin-right: auto;"
			class="text_line">
			<tr>
				<td>
					<div id="shuffleText" class="myButton">Shuffle</div>
				</td>
				<td>
					<div id="sortText" class="myButton">Sort</div>
				</td>
				<td>
					<div id="gridText" class="myButton">Grid</div>
				</td>
				<td>
					<div id="gridSortText" class="myButton">Grid Sort</div>
				</td>
				<td>
					<div id="browseText" class="myButton">Browse</div>
				</td>
			</tr>
		</table>

		<div id="gallery">

		<?php

		/* Opening the thumbnail directory and looping through all the thumbs: */

		$dir_handle = @opendir($thumb_directory) or die("There is an error with the image directory!");

		$i = 1;
		foreach($xml->picture as $node) {
			$file = $node->filename;
			$description = $node->description;
			$link = $node->link;
			$tags = $node->tags;

			//echo $file;
			/* Skipping the system files: */
			if($file=='.' || $file == '..') continue;

			$file_parts = explode('.',$file);
			$ext = strtolower(array_pop($file_parts));

			/* Using the file name (without the extension) as a image title: */
			$title = implode('.',$file_parts);
			$title = htmlspecialchars($title);

			/* If the file extension is allowed: */
			if(in_array($ext,$allowed_types))
			{
					
				/* Outputting each image: */
				$descriptionAndLink = $description." <a href=".$link."\ target=_blank> Link </a>";
					
				echo '
					<div id="pic-'.($i++).'" class="pic '.$tags.'"  style="background:url('.$thumb_directory.'/'.$file.') no-repeat 50% 50%;">
					<a title="'.$descriptionAndLink.'"
					onclick="javascript: this.title=\''.$descriptionAndLink.'\';"
					onMouseOver="javascript: this.title=\''.$description.'\';"
					onMouseOut="javascript: this.title=\''.$descriptionAndLink.'\';"
					class="fancybox" rel="fncbx" href="'.$orig_directory.'/'.$file.'" target="_blank"></a>
					</div>';
			}
		}

		foreach ($tagarray as $i => $value) {
			echo '<div id="pic" title="'.$value.'" class="pic cover '.$value.'Cover '.$value.'"  style="display:none;background:url('.$thumb_directory.'/CoverEmpty.jpg) no-repeat 50% 50%;">
					<br>'.$value.'
					</div>';
		}
		/* Closing the directory */
		closedir($dir_handle);
		?>


		</div>

</body>
</html>
