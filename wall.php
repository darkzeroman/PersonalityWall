
<?php
// Location of the XML file on the file system
$file = 'pics.xml';
$xml = simplexml_load_file($file);

/* Configuration Start */

$thumb_directory = 'img/thumbs';
$orig_directory = 'img/original';

$stage_width = 600;
// How big is the area the images are scattered on
$stage_height = 300;

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
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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
<script type="text/javascript" src="script.js"></script>
<script type="text/javascript">
$(document).ready(function () {
    var stage_width = <?php  echo $stage_width ?> ;
    var stage_height = <?php echo $stage_height ?> ;
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

    function resize() {
        //alert('lol');
        //$.fancybox.resize();
    };

    function shuffle() {
        $('.cover').animate({
            opacity: 0.0
        });
        $(".pic").not('.cover').each(function () {
            var left = Math.floor(Math.random() * stage_width);
            var top = Math.floor(Math.random() * stage_height);
            rot = Math.floor(Math.random() * 80) - 40;
            myAnimate(this, left, top, rot);
        });
        // do stuff when DOM is ready
    };
	var list = [<?php foreach ($tagarray as $i => $value) {echo '\'.'.$value.'\',';	};?>];

    function grid() {
        $('.cover').animate({
            opacity: 0.0
        });

        var maxCols = Math.floor(stage_width / 100);
        $('.pic').not('.cover').each(function (index, value) {
            var row = index % maxCols;
            var col = Math.floor(index / maxCols);
            var rot = 0;
            var left = row * 113;
            var top = col * 120;
            myAnimate(this, left, top, rot);
        });
    };

    function sort() {
        $('.cover').animate({
            opacity: 1.0
        });
        $.each(list, function (index, value) {

            var left = 35 + (stage_width) / (list.length - 1) * (index);
            var top = Math.floor(Math.random() * stage_height);
            $(value).each(function () {
                if ($(this).is('.cover')) {
                    rot = 0;
                    myAnimate(this, left, top, rot);
                } else {
                    rot = Math.floor(Math.random() * 80) - 40;
                    myAnimate(this, left, top, rot);
                };
            });
        });
        findMaxZ();
    };

    function gridSort() {
        $('.cover').animate({
            opacity: 1.0
        });
        $.each(list, function (index, value) {
            left = 113 * index;
            //$(value).filter('.cover').animate({left:left, top:0},1000,function(){});
            myAnimate($(value).filter('.cover'), left, 0, 0);
            $(value).not('.cover').each(function (index2, value2) {
                rot = 0;
                left = 113 * index;
                var top = 115 + (120 * index2);
                //alert(index2);
                myAnimate(this, left, top, rot);
            });
        });
    };

    function myAnimate(obj, left, top, rot) {
        $(obj).animate({
            left: left,
            top: top,
            rotate: rot + 'deg',
            '-webkit-transform': 'rotate(' + rot + 'deg)',
            // safari only
            '-moz-transform': 'rotate(' + rot + 'deg)',
            // firefox only
            'tranform': 'rotate(' + rot + 'deg)',
            // added in case CSS3 is standard
            zIndex: 1
        }, 1000, function () {});
    };

    function findMaxZ() { /* Executed on image click */
        $.each(list, function (index, value) {
            var maxZ = 0; /* Find the max z-index property: */
            //alert(value);
            $(value).each(function () {
                var thisZ = parseInt($(this).css('zIndex'))
                if (thisZ > maxZ) maxZ = thisZ;
            });
            $(value + 'Cover').css({
                zIndex: maxZ + 1
            });
            //alert(maxZ);
        });
    };
    $('#shuffleText').click(shuffle);
    $('#sortText').click(sort);
    $('#gridText').click(grid);
    $('#gridSortText').click(gridSort);

    
});
		</script>
</head>
<body>

	<div id="main">

		<h1 style="float: left">Personality Wall</h1>
		<div style="text-align: right; float: right">
			<h3>Drag and click on the pictures to view</h3>
			<p>
				<a id="inline" class="fancybox" href="#data">Resources I used</a>
			</p>
		</div>
		<div style="display: none;">
			<div id="data">
				<p><b><u>Here are some of the resources I used:</u></b> <br><br>
					<ul>
						<li><a href="http://www.cssbuttongenerator.com/">CSS Button
								Generator</a> to create the buttons!</li>
						<li><a href="http://tutorialzine.com/2009/11/hovering-gallery-css3-jquery/">Tutorial Zine</a> as a base to create this page</li>
						<li><a href="http://www.marcofolio.net/webdesign/the_polaroid_photo_viewer_non-full_screen.html">Marco Kuiper's Polaroid Example</a> helped with some rotation errors</li>
						<li><a href="http://www.w3schools.com">W3Schools</a> for help when my knowledge CSS/Javascript/HTML needed a little review!</li>
						<li><a href="http://fancybox.net/">FancyBox</a> for the modal windows.</li>
						<li><a href="http://php.net/manual/en/book.simplexml.php">SimpleXML Manual</a> for making the XML aspects.</li>
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
			</tr>
		</table>

		<div id="gallery">

		<?php

		/* Opening the thumbnail directory and looping through all the thumbs: */

		$dir_handle = @opendir($thumb_directory) or die("There is an error with your image directory!");

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

			/* Using the file name (withouth the extension) as a image title: */
			$title = implode('.',$file_parts);
			$title = htmlspecialchars($title);

			/* If the file extension is allowed: */
			if(in_array($ext,$allowed_types))
			{
					
				/* Outputting each image: */
				$descriptionAndLink = $description." <a href=".$link."\> Link </a>";
					
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
			echo '<div id="pic" class="pic cover '.$value.'Cover '.$value.'"  style="px;background:url('.$thumb_directory.'/CoverEmpty.jpg) no-repeat 50% 50%;">
					<br>'.$value.'
					</div>';
		}
		/* Closing the directory */
		closedir($dir_handle);
		?>


		</div>

</body>
</html>
