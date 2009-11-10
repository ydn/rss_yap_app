<?php 

$insideitem = false;
$tag = "";
$title = "";
$description = "";
$link = "";



function startElement($parser, $name, $attrs) {
global $insideitem, $tag, $title, $description, $link;
if ($insideitem) {
$tag = $name;
} elseif ($name == "ITEM") {
$insideitem = true;
}
}

function endElement($parser, $name) {
    global $insideitem, $tag, $title, $description, $link;
    $article = "<div class='article'>";
    if ($name == "ITEM") {
        print($article);
        printf("<div class='title'><a href='%s'>%s</a></div>", trim($link), htmlspecialchars(trim($title)) );
        printf('<div class="description">%s</div></div>',$description);
        $title = "";
        $description = "";
        $link = "";
        $insideitem = false;
    }
}

function characterData($parser, $data) {
    global $insideitem, $tag, $title, $description, $link;
    if ($insideitem) {
        switch ($tag) {
            case "TITLE":
                $title .= $data;
                break;
            case "DESCRIPTION":
                $description .= $data;
                break;
            case "LINK":
                $link .= $data;
            break;
        }
    }
}

function loadFeed($url)
{
// SET UP THE CURL  - http://rss.netflix.com/QueueRSS?id=P5865869263438512554124161626579012
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


#header {
    font-size: 12px;
    padding: 30px 0;
    margin-bottom: 30px;
    position:relative;
    background-image:url('http://yap-studio.com/apps/rss/assets/gsprite_mod_default_103008.gif');
    background-repeat:repeat-x;
    background-position:0 -580px;
    height: 100px;
    border-bottom: 1px solid #ccc;
}

#header .colImage {
    width:105px;
    float:left;
    margin-right: 30px;
}


#header .col {
    color:blue;
}

#wrapper {
    font-size: 12px;
}

.headOne {
    font-size: 150%;
    color: #365B8A;
    font-weight: bold;
    width: 260px;	
    padding:5px;
    margin:3px 3px 10px 3px;
}

.description {
    font-size: 125%;
    color: #222222;
}

.grayUrl {
    font-size: 75%;
    color: #888888;
    width: 260px;
}

span.bottom {
    position:absolute;
    left:3px;
    bottom:3px;
    padding:5px;
}

.article {
    font-family: Verdana, Arial, Helvetica, sans-serif;
    color:#FFFFFF;
    margin-bottom:20px;
}

.article .title {
    font-weight: bold;
}

.article .description {
margin-right:30px;
}

.footer {
    background-image:url('http://yap-studio.com/apps/rss/assets/gsprite_mod_default_103008.gif');
    background-repeat:repeat-x;
    background-position:0 -400px;
    height:80px;
}
</style>

<?php
$title = 'app title';
$url = 'http://rss.news.yahoo.com/rss/topstories';
$siteImage = 'http://yap-studio.com/apps/rss/assets/NoPreview.png';
?>

<div id="header">
	<div class="colImage"><img src="<?php echo $siteImage; ?>" width="102" height="102"></div>
    	<div class="col">
    		<div align="left" class="headOne"><a href="<?php echo $url; ?>"><?php echo $title; ?></a></div>
    		<div align="left" class="description">Website Description would go here</div>
    		<div align="left" class="grayUrl"> more >></div>
    	</div>
	    <div style="clear:both;">
	</div>
</div>

<div id="wrapper"> 
    <?php

    $data = loadFeed($url);

    $xml_parser = xml_parser_create();
    xml_set_element_handler($xml_parser, "startElement", "endElement");
    xml_set_character_data_handler($xml_parser, "characterData");
    xml_parse($xml_parser, $data) or die(sprintf("XML error: %s at line %d", xml_error_string(xml_get_error_code($xml_parser)), xml_get_current_line_number($xml_parser)));
    xml_parser_free($xml_parser);
    ?>
</div>

<div class="footer">
	<div class="yahooLogo"><!-- <img src="http://yap-studio.com/sports/images/yahoo_logo.png"> --></div>
</div>
