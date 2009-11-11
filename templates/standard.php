<!--
- This is a template for rendering a standard RSS 2.0 feed.
- This file assumes a variable named $feed has been defined.
-->

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
.wrapper .body li .image {
    margin-right: 10px;
    
    /* align img left of text content */
    float: left;
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
.wrapper .body li .pubDate {
    color: #ccc;
    float: right;
}
</style>

<div class="wrapper">
    <div class="header">
        <div class="logo">
            <a href="<?php echo $feed->channel->link ?>" class="title"><?php echo $feed->channel->title ?></a>
        </div>
    </div>
    <ul class="body">
        <?php foreach($feed->channel->item as $item): ?>
            <li>
                
                <!-- if there is an image defined, display it -->
                <?php if($item->children('http://search.yahoo.com/mrss/')->content): ?>
                    <div class="image">
                        <img src="<?php echo $item->children('http://search.yahoo.com/mrss/')->content->attributes()->url ?>"/>
                    </div>
                <?php endif ?>
                
                <?php if($item->category): ?>
                    <div class="category"><?php echo $item->category ?></div>
                <?php endif ?>
                <a href="<?php echo $item->link ?>" class="title"><?php echo $item->title ?></a>
                <div class="description"><?php echo $item->description ?></div>
                <div class="pubDate"><?php echo $item->pubDate ?></div>
                <div style="clear:both"></div>
            </li>
        <?php endforeach ?>
    </ul>
</div>