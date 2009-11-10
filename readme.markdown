# RSS YAP app

A simple framework for generating a Yahoo! Application Platform application from an RSS feed

## Installation

* Click the `download` button above - OR - 
* Clone this repository: `git clone git://github.com/ydn/rss_yap_app.git`

## Usage

### Requirements

* PHP 5.2

### Initialization

* Upload this directory to your server
* Create a new YAP application
* Set the "Application URL" of the app to point to the location of this directory on your server
* Set the "Small View Default Content" to:

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
        <yml:include replace="loading">
           <div id="loading">Loading ...</div>
        </yml:include>   
        
* Click the "Save" button
* Click the "Preview" button to see your app

### Customization

#### Setting the feed url

* Open index.php in a text editor
* Set the "$feedUrl" variable at the top of the file to point to the RSS feed of your choice, e.g. "http://sports.yahoo.com/sow/rss.xml"
* Save the file and reload the app
* Note: by default, yapgen only handles RSS syntax.  Also, some feeds may require special handling.

## License

* Copyright: (c) 2009, Yahoo! Inc. All rights reserved.
* License: code licensed under the BSD License:
* Package: http://github.com/ydn/rss_yap_app
