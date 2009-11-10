# YAPgen

A simple framework for generating a Yahoo! Application Platform application from an RSS feed

## Installation

* Click the `download` button above - OR - 
* Clone this repository: `git clone git://github.com/erikeldridge/yapgen2.git`

## Usage

### Requirements

* PHP 5.2

### Initialization

* Upload this directory to your server
* Create a new YAP application
* Set the "Application URL" of the app to point to the location of this directory on your server
* Set the "Small View Default Content" to:

        <yml:include>Loading ...</yml:include>
        
* Click the "Save" button
* Click the "Preview" button to see your app

### Customization

#### Setting the feed url

* Open index.php in a text editor
* Set the "$feedUrl" variable at the top of the file to point to the RSS feed of your choice
* Save the file and reload the app
