# Yahoo! Application Platform (YAP) RSS application generator

A simple framework for generating a Yahoo! Application Platform application from an RSS feed

## Preamble

This document is intended to address two typical use cases: 

1. "Porting" an app based on a Yahoo! Front Door XSL-based template
2. Creating a new YAP app based on a standard RSS feed

Installation and usage instructions follow, but in brief, this framework operates by consuming a given feed, parsing the feed data using PHP's SimpleXML library, and passing the parsed data to a PHP/HTML/CSS template for rendering.  In an app's description, the location of the framework is given as the base URL for the app, and the output from the template is returned back to YAP for display.

## Installation

1. Obtain the source code:
 * Click the _download_ button on the Github project page (github.com/erikeldridge/rssyapgen), pick a compression, and save the file.  
 OR 
 * Clone this repository: `git clone git://github.com/erikeldridge/rssyapgen.git`
2. Upload the project to a server accessible by YAP

## Usage

### Requirements

* PHP 5.2 with SimpleXML

### Initialization

1. Create a new YAP application
2. Set the _Application URL_ of the app to point to the location of this directory on your server
3. Set the _Small View Default Content_ to:

        <style>
        #loading {
           font-size: 12px;
           font-family: Verdana, Arial, Helvetica, sans-serif;
           margin: 10px;
           background-image: url(http://l.yimg.com/a/i/ww/met/anim_loading_sm_082208.gif);
           background-repeat: no-repeat;
           padding-left: 30px;
           height: 16px;
        }
        </style>
        <yml:include replace="loading" params="index.php">
           <div id="loading">Loading ...</div>
        </yml:include>   
        
4. Click the "Save" button
5. Click the "Preview" button to see your app

### Customization

#### Setting the feed url

1. Open index.php in a text editor
2. Set the `$feedUrl` variable at the top of the file to point to the RSS 2.0 feed of your choice, e.g. _http://sports.yahoo.com/sow/rss.xml_
3. Save the file and reload the app
4. Note: by default, rssyapgen only handles RSS 2.0 syntax.  Some feeds may require special handling.

#### Defining special handling for a feed

If you feed uses custom xml namespaces, such as "y:navigation", "y:search", etc., you'll need to create a custom template to render the feed as follows:

1. Copy _templates/basic.php_ as another file.  For this example we'll call the file _special.php_ and save it in the _templates_ directory.
2. Open _special.php_ in a text editor.
3. Templates use standard PHP [_alternate syntax_](http://us2.php.net/manual/en/control-structures.alternative-syntax.php) and short tags. Edit the styling, markup, and templating to match the structure of your feed.
4. Edit _index.php_:
 * Set the _feedUrl_ variable to point to the new feed.
 * Set the _templatePath_ variable to point to _templates/special.php_.
5. Save the file back to your server.
6. Refresh your app to see the changes. 

## License

* Copyright: (c) 2009, Yahoo! Inc. All rights reserved.
* License: code licensed under the BSD License.  See [license.markdown](http://github.com/erikeldridge/rssyapgen/blob/master/license.markdown)
* Package: http://github.com/erikeldridge/rssyapgen