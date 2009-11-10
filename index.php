<?php 

/**
* @copyright    (c) 2009, Erik Eldridge. All rights reserved.
* @license  code licensed under the BSD License:
* @package  http://github.com/erikeldridge/yapgen2
**/

// BEGIN: config
$feedUrl = 'http://rss.cnn.com/rss/cnn_topstories.rss';
$appTitle = 'app title';
$appDescription = 'Website Description would go here';
$appHeaderImage = 'http://github.com/erikeldridge/yapgen2/blob/master/preview.png';
$appBackgroundImage = 'http://github.com/erikeldridge/yapgen2/blob/master/sprite.png';
// END: config

//BEGIN: XML parser
$insideitem = false;
$tag = "";
$itemTitle = "";
$itemDescription = "";
$itemLink = "";

function startElement($parser, $name, $attrs) {
global $insideitem, $tag, $itemTitle, $itemDescription, $itemLink;
if ($insideitem) {
$tag = $name;
} elseif ($name == "ITEM") {
$insideitem = true;
}
}

function endElement($parser, $name) {
    global $insideitem, $tag, $itemTitle, $itemDescription, $itemLink;
    $article = "<div class='article'>";
    if ($name == "ITEM") {
        print($article);
        printf("<div class='title'><a href='%s'>%s</a></div>", trim($itemLink), htmlspecialchars(trim($itemTitle)) );
        printf('<div class="description">%s</div></div>',$itemDescription);
        $itemTitle = "";
        $itemDescription = "";
        $itemLink = "";
        $insideitem = false;
    }
}

function characterData($parser, $data) {
    global $insideitem, $tag, $itemTitle, $itemDescription, $itemLink;
    if ($insideitem) {
        switch ($tag) {
            case "TITLE":
                $itemTitle .= $data;
                break;
            case "DESCRIPTION":
                $itemDescription .= $data;
                break;
            case "LINK":
                $itemLink .= $data;
            break;
        }
    }
}
//END: XML parser

function loadFeed($url)
{
$ch = curl_init();
$timeout = 5; // set to zero for no timeout
curl_setopt ($ch, CURLOPT_URL, $url);
curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
$file_contents = curl_exec($ch);
curl_close($ch);

return $file_contents;
}

?>

<style type="text/css">
a:link {
    color: #365B8A;
}
a:visited {
    color: #365B8A;
}
a:hover {
    text-decoration: underline;
    color: #660066;
}
a:active {
color: #660066;
}

.description {
    font-size: 125%;
    color: #222222;
}

#header {
    font-size: 12px;
    font-family: Verdana, Arial, Helvetica, sans-serif;
    
    padding: 10px;
    margin-bottom: 10px;
    
    background-image:url(<?= $appBackgroundImage ?>);
    background-repeat:repeat-x;
    background-position:0 -580px;
    height: 100px;
}

#header .colImage {
    width:105px;
    float:left;
    margin-right: 10px;
}

#header .col .headOne {
    font-size: 150%;
    color: #365B8A;
    font-weight: bold;
    margin-bottom: 10px;
}

#header .col .description{
    margin-bottom: 10px;
}

#header .col .grayUrl {
    font-size: 75%;
    color: #ccc;
}

#header hr {
    border-width: 0px;
    border-bottom: 1px solid #ccc;
    margin-top: 10px;
}

#wrapper {
    font-size: 12px;
    font-family: Verdana, Arial, Helvetica, sans-serif;
    padding-left: 10px;
}

#wrapper .article {
    
    color:#FFFFFF;
    margin-bottom:10px;
}

#wrapper .article .title {
    font-weight: bold;
    margin-bottom: 10px;
}

#wrapper .article .description img {
    margin-right:10px;
}

.footer {
    background-image:url(<?= $appBackgroundImage ?>);
    background-repeat:repeat-x;
    background-position:0 -415px;
    height: 70px;
}
</style>

<div id="header">
	<div class="colImage">
	    <img src="<?php echo $appHeaderImage; ?>" width="102" height="102">
	</div>
	<div class="col">
		<div align="left" class="headOne"><yml:a><?php echo $appTitle; ?></yml:a></div>
		<div align="left" class="description"><?php echo $appDescription; ?></div>
		<div align="left" class="grayUrl"> more >></div>
	</div>
    <div style="clear:both;"></div>
    <hr/>
</div>
<div id="wrapper"> 
    <?php
        $data = loadFeed($feedUrl);
        $xml_parser = xml_parser_create();
        xml_set_element_handler($xml_parser, "startElement", "endElement");
        xml_set_character_data_handler($xml_parser, "characterData");
        xml_parse($xml_parser, $data) or die(sprintf("XML error: %s at line %d", xml_error_string(xml_get_error_code($xml_parser)), xml_get_current_line_number($xml_parser)));
        xml_parser_free($xml_parser);
    ?>
</div>
<div class="footer"><br/></div>