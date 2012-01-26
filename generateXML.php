<?php
$dataXML = new SimpleXMLElement("<data></data>");


$thumb_directory = 'img/thumbs';
$allowed_types=array('jpg','jpeg','gif','png');
$file_parts=array();
$ext='';
$title='';
$i=0;
$dir_handle = @opendir($thumb_directory) or die("There is an error with your image directory!");


while ($file = readdir($dir_handle))
{
	/* Skipping the system files: */
	if($file=='.' || $file == '..') continue;

	$file_parts = explode('.',$file);
	$ext = strtolower(array_pop($file_parts));

	/* If the file extension is allowed: */
	if(in_array($ext,$allowed_types))
	{
		$picture = $dataXML->addChild('picture','');

		$picture->addChild('filename',$file);
		$picture->addChild('description','theDescription');
		$picture->addChild('link','http://example.com');
		$picture->addChild('tag','');



	}
}





//Format XML to save indented tree rather than one line
$dom = new DOMDocument('1.0');
$dom->preserveWhiteSpace = false;
$dom->formatOutput = true;
$dom->loadXML($dataXML->asXML());
//Echo XML - remove this and following line if echo not desired
//echo $dom->saveXML();
//Save XML to file - remove this and following line if save not desired
$dom->save('pics_new.xml');

Header('Content-type: text/xml');
echo $dataXML->asXML();

?>
