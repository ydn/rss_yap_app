# RSS-based applications for the Yahoo! Application Platform (YAP) 

## Preamble

_rss\_yap\_app_ is a collection of examples for generating a [Yahoo! Application Platform](http://developer.yahoo.com/yap) application from an RSS feed.  This document is intended to describe usage of this project for two common scenarios: 

1. "Porting" an app based on a [Yahoo! Front Door XSL-based template](http://public.yahoo.com/~jchu/) to YAP
2. Creating a new YAP app based on a standard RSS feed

_rss\_yap\_app_ operates by consuming a given feed, parsing the feed data using PHP's SimpleXML library, and passing the parsed data to a PHP/HTML/CSS template for rendering.  In an app's description, the location of the template to use is given as the base URL for the app, and the output from the template is returned back to YAP for display.  Detailed installation and usage instructions are given below.

## Prerequisites

* PHP 5.2 with the following enabled:
   * [SimpleXML](http://us2.php.net/simplexml)
   * The [short form](http://www.php.net/manual/en/ini.core.php) of PHP's open tags
* A server that can serve content to YAP, i.e., a server accessible via a valid url and capable of receiving POST requests.

## Steps for creating an RSS-based application for YAP

1. Obtain a local copy of this project:
 * Click the _download_ button on the [Github project page](http://github.com/ydn/rss_yap_app), pick a compression, and save the file.  
 OR 
 * Clone this repository: `git clone git://github.com/ydn/rss_yap_app.git`
2. Upload the project to your server
3. Create a new YAP application using the [YDN dashboard](http://developer.yahoo.com/dashboard)
4. Set the _Application URL_ of the app to point to the location of the _{template}.php_ file in the project directory on your server, e.g. _http://example.com/rss\_yap\_app/standard.php_
5. Set the _Small View Default Content_ to:

        <style>
        #loading {
           font-size: 12px;
           font-family: Verdana, Arial, Helvetica, sans-serif;
           margin: 10px;
           
           <!-- the standard yap loading animation -->
           background-image: url(http://l.yimg.com/a/i/ww/met/anim_loading_sm_082208.gif);
           
           background-repeat: no-repeat;
           padding-left: 30px;
           height: 16px;
        }
        </style>
        
        <!-- replace the element 'loading' w/ the content returned from the yml:include call -->
        <yml:include replace="loading">
           <div id="loading">Loading ...</div>
        </yml:include>   
        
6. Click the _Preview_ button to see your app

### Customization

#### Using a standard RSS 2.0 feed

1. Open _standard.php_ in a text editor
2. Set the `$feedUrl` variable at the top of the file to point to the feed of your choice, e.g. _http://sports.yahoo.com/sow/rss.xml_.  
3. Save the file and reload the app
4. Note: As is, _standard.php_ only handles RSS 2.0 syntax.  Some feeds may require special handling.

#### Defining special handling for a feed

If you are "porting" an existing Yahoo! Front Doors template app, or if your feed uses custom xml namespaces, you may need to create a custom template to render the feed.  Here are instructions for doing so:

1. Copy _templates/basic.php_ as another file.  For this example we'll call the file _special.php_.
2. Open _special.php_ in a text editor.
3. Note: templates use PHP's [_alternate syntax_](http://us2.php.net/manual/en/control-structures.alternative-syntax.php). Edit the preprocessing, styling, and markup to match the structure of your feed.
4. Save the file back to your server.
5. Edit your app in the [YDN dashboard](http://developer.yahoo.com/dashboard) and set the base to _{your domain}/{path to rss\_yap\_app}/special.php_
6. Refresh your app to see the changes. 

## License

* Copyright: (c) 2009, Yahoo! Inc. All rights reserved.
* License: code licensed under the BSD License.  See [license.markdown](http://github.com/ydn/rss_yap_app/blob/master/license.markdown)
* Package: [http://github.com/ydn/rss\_yap_app](http://github.com/ydn/rss_yap_app)