<?php

/**
 * This is a template for rendering a standard RSS 2.0 feed.
 */

$feedUrl = 'http://rss.news.yahoo.com/rss/world';

//fetch rss xml using curl, which is more commonly available than simplexml_load_file
$ch = curl_init($feedUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$xmlString = curl_exec($ch);
curl_close($ch);

//parse xml
$feed = simplexml_load_string($xmlString);

//format data & set default values to keep template uncluttered
$data = array(
    'header' => array(
        'title' => $feed->channel->title,
        'link' => $feed->channel->link
    ),
    'body' => array()
);

//define list items
foreach($feed->channel->item as $item){
    
    //extract image info, if defined
    $image = null;
    
    if(isset($item->children('http://search.yahoo.com/mrss/')->content)){
        $image = array(
            'url' => $item->children('http://search.yahoo.com/mrss/')->content->attributes()->url
        );
    }
    
    //package item data
    $data['body'][] = array(
        'image' => $image,
        'category' => array(
            'text' => $item->category
        ),
        'title' => $item->title,
        'link' => $item->link,
        'description' => $item->description,
        'pubDate' => $item->pubDate,
    );
}
?>

<style>
/* wrap app to limit style bleeding from parent */
.wrapper {
    
    /* define app-global settings */
    font-family: arial;
    font-size: 12pt;
}
.wrapper a {
    
    /* we don't ever want links underlined */
    text-decoration: none;
}
.wrapper .header .logo {
   background-color: #ccc;
   padding: 10px;
}
.wrapper .header .logo .title {
    color: #fff;
    font-size: 150%;
    font-weight: bold;
}
.wrapper .body {
    
    /* remove whitespace above list */
    margin-top: 0px;
    
    /* add whitespace around list */
    padding: 10px;
}
.wrapper .body li {
    margin-bottom: 10px;
    
    /* remove li bullet points*/
    list-style: none;

    /* display separator under each item */
    border-bottom: 1px solid #ccc;
    
    /* add whitespace above bottom separator */
    padding-bottom: 10px;
}
.wrapper .body li .category {
    font-weight: bold;
    margin-bottom: 10px;
}
.wrapper .body li .title {
    font-weight: bold;
    margin-bottom: 10px;
    
    /* title is an a-tag.  display block so we can add a margin to it */
    display: block;
}
.wrapper .body li .description {
    margin-bottom: 10px;
    color: #ccc;
}
.wrapper .body li .description img {
    margin-right: 10px;
}
.wrapper .body li .pubDate {
    color: #ccc;
    float: right;
}
</style>

<div class="wrapper">
    <div class="header">
        <div class="logo">
            <a href="<?= $data['header']['link'] ?>" class="title"><?= $data['header']['title'] ?></a>
        </div>
    </div>
    <ul class="body">
        <? foreach($data['body'] as $item): ?>
            <li>              
                <a href="<?= $item['link'] ?>" class="title"><?= $item['title'] ?></a>

                <!-- use image embedded in description instead of the media:content -->  
                <div class="description"><?= $item['description'] ?></div>
                
                <div class="pubDate"><?= $item['pubDate'] ?></div>
                <div style="clear:both"></div>
            </li>
        <? endforeach ?>
    </ul>
</div>
