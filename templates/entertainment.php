<?php

//config
$feedUrl = 'http://news.discovery.com/rss/news/';

//parse xml
$feed = simplexml_load_file($feedUrl);

//format data & set default values to keep template uncluttered
$data = array(
    'header' => array(
        'logo' => array(
            'link' => $feed->channel->image->link,
            'url' => $feed->channel->image->url
        )
    ),
    'navigation' => array(),
    'body' => array(
        'left' => array(
            'top' => array(
                'category' => '',
                'items' => array()
            ),
            'bottom' => array(
                'category' => '',
                'items' => array()
            )
        ),
        'right' => array(
            'category' => '',
            'items' => array()
        )
    )
);

//define navigation elements
foreach($feed->channel->children('http://www.yahoo.com/y-namespace')->navigations->navigation as $navigation){
    $data['navigation'][] = array(
        'title' => $navigation->attributes()->title,
        'url' => $navigation->attributes()->url
    );
}

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
    if('top' == $item->category->attributes()->domain){
        $data['body']['left']['top']['category'] = $item->category;
        $data['body']['left']['top']['items'][] = array(
            'image' => $image,
            'title' => $item->title,
            'link' => $item->link,
            'description' => $item->description,
            'pubDate' => $item->pubDate,
        );
    } elseif('bottom' == $item->category->attributes()->domain){
        $data['body']['left']['bottom']['category'] = $item->category;
        $data['body']['left']['bottom']['items'][] = array(
            'image' => $image,
            'title' => $item->title,
            'link' => $item->link,
            'description' => $item->description,
            'pubDate' => $item->poubDate,
        );
    } elseif('media' == $item->category->attributes()->domain){
        $data['body']['right']['category'] = $item->category;
        $data['body']['right']['items'][] = array(
            'image' => $image,
            'description' => $item->description,
            'pubDate' => $item->poubDate,
        );
    }
}

//END: preprocess feed data so template isn't too complicated to read

?>

<style>
/* wrap app to limit style bleeding from parent */
.wrapper {
    
    /* define app-global settings */
    font-family: arial;
    font-size: 12pt;
    color: #000;
}

/* default tag settings */
.wrapper a {
    
    /* we don't ever want links underlined */
    text-decoration: none;
}
.wrapper ul {
    padding: 0;
    margin: 0;
    
    /* remove li bullet points*/
    list-style: none;
}

/* styles for area above nav */
.wrapper .header .logo {
   background-color: #3E1651;
   padding: 10px;
}
.wrapper .header .logo .label {
    color: #fff;
    margin-top: 10px;
    
    /* align label and image right in header (see img styling below) */
    float: right;
    
    /* put some space btwn label and img */
    margin-right: 10px;
}
.wrapper .header .logo img {
    float: right;
    
    /* img is linked, but we don't want the border around it */
    border: none;
}

/* navigation styles */
.wrapper .header .navigation {
   padding: 10px;
}
.wrapper .header .navigation .label {
    margin-right: 10px;
    color: #ccc;
    
    /* align label next to ul (see below) */
    float: left;
}
.wrapper .header .navigation ul {
    
    /* remove li bullet points*/
    list-style: none;
    
    /* align ul next to label */
    display: inline;
}
.wrapper .header .navigation li {
    font-weight: bold;
    
    /* add a bit of white space btwn nav items */
    margin-right: 10px;
    
    /* display items horizontally */
    float: left;
}
.wrapper .body .category {
    font-weight: bold;
    margin-bottom: 10px;
    text-transform: uppercase;
}
.wrapper .body .title {
    font-weight: bold;
}

/* left column */
.wrapper .body .left {
    float: left;
    width: 65%;
    padding-left: 10px;
}
.wrapper .body .left li {
    margin-bottom: 10px;
}
.wrapper .body .left .description {
    color: #ccc;
    margin-bottom: 10px;
}
.wrapper .body .left .pubDate {
    color: #ccc;
}
.wrapper .body .left .top {
    margin-bottom: 10px;
}

/* right column */
.wrapper .body .right {
    float: right;
    width: 32%;
}
.wrapper .body .right li {
    margin-bottom: 10px;
}
</style>

<div class="wrapper">
    <div class="header">
        <div class="logo">
            <a href="<?= $data['header']['logo']['link'] ?>" class="image"><img src="<?= $data['header']['logo']['url'] ?>"/></a>
        
            <!-- kludge: put label below image to correct funky floating  -->
            <span class="label">Go to: </span>
        
            <div style="clear:both"></div>
        </div>
        <div class="navigation">
            <span class="label">Visit: </span>
            <ul>
                <? foreach($data['navigation'] as $item): ?>
                    <li>
                        <a href="<?= $item['url'] ?>"><?= $item['title'] ?></a>
                    </li>
                <? endforeach ?>
            </ul>
            <div style="clear:both"></div>
        </div>
    </div>
    <div class="body">
        
        <!-- left column -->
        <div class="left">
            <div class="top">
                <div class="category">
                    <?= $data['body']['left']['top']['category'] ?>
                </div>
                <ul>
                   <? foreach($data['body']['left']['top']['items'] as $item): ?> 
                        <li>
                            <a href="<?= $item['link'] ?>" class="title"><?= $item['title'] ?></a>
                            <div class="description"><?= $item['description'] ?></div>
                            <div class="pubDate"><?= $item['pubDate'] ?></div>
                        </li>
                    <? endforeach ?>
                </ul>
            </div>
            <div class="bottom">
                <div class="category">
                    <?= $data['body']['left']['bottom']['category'] ?>
                </div>
                <ul>
                   <? foreach($data['body']['left']['bottom']['items'] as $item): ?> 
                        <li>
                            <a href="<?= $item['link'] ?>" class="title"><?= $item['title'] ?></a>
                            <div class="description"><?= $item['description'] ?></div>
                            <div class="pubDate"><?= $item['pubDate'] ?></div>
                        </li>
                    <? endforeach ?>
                </ul>
            </div>
        </div>
        
        <!-- right column -->      
        <div class="right">
            <div class="category">
                <?= $data['body']['right']['category'] ?>
            </div>
            <ul>
               <? foreach($data['body']['right']['items'] as $item): ?> 
                    <li>
                        <? if($item['image']): ?>
                            <div class="image">
                                <img src="<?= $item['image']['url'] ?>"/>
                            </div>
                        <? endif ?>
                        <a href="<?= $item['link'] ?>" class="title"><?= $item['description'] ?></a>
                    </li>
                <? endforeach ?>
            </ul>
        </div>
        <div style="clear:both"></div>
    </div>
</div>