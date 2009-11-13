<?php

//BEGIN: config

//the url of the feed to use
$feedUrl = 'http://news.discovery.com/rss/news/';

//the name of the template to use
$template = 'standard';

//END: config

//render template
require "templates/$template.php";

?>