# PS PHPCaptcha WP
## Simple PHP-GD based captcha to replace tracking prone systems like Google recaptcha

* Contributors: pstimpel
* Donate link: https://www.paypal.me/redzoneaction
* Tags: comments, spam, captcha, recaptcha-replacement
* Requires at least: 4.0.0
* Requires PHP: 5.6
* Tested up to: 5.0.0
* Stable tag: trunk
* License: GPLv2 or later
* License URI: http://www.gnu.org/licenses/gpl-2.0.html
* Plugins homepage: https://wordpress.org/plugins/ps-phpcaptcha/
* Developers Wordpress home: https://profiles.wordpress.org/pstimpel
* Developers homepage: https://wp.peters-webcorner.de/
* Repository at Wordpress.org: http://plugins.svn.wordpress.org/ps-phpcaptcha/
* Github repository: https://github.com/pstimpel/psphpcaptchawp

### Description

If you are keen to provide your users kind of a tracking free environment, you would have to remove
Google Recaptcha and other cloud based Captcha solutions from your Wordpress installation.

PS PHPCaptcha WP does not use any remote resources. This makes it fully GDPR compliant without any need to mention it
in your privacy policy.

To generate the image this plugin does not need to use the Wordpress database and therefore IO of the database is very low.
This very important if you run a site with high traffic.

### System requirements:
* Wordpress up and running
* PHP5 or PHP7 installed
* PHP-GD installed and activated
* uses PHP sessions

For setup of the Plugin just follow these 3 easy steps.

### Installation by using Wordpress

1. Go to the Plugin installation page, search for **PS PHPCaptcha WP**
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Configure the plugin using the provided settings page

### Installation by downloading from Github

1. go to releases of github repo and download the zip
1. create a folder called **psphpcaptchawp** in your **wordpress/wp-content/plugins** directory 
1. unzip the content of the downloaded zip file into a folder, and move the content of that folder into your plugins/psphpcaptchawp directory of your wordpress installation
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Configure the plugin using the provided settings page

### Frequently Asked Questions 

#### I followed your instructions, but do not see the Captcha image in the comment form 

Probably you are logged into your wordpress installation having admin rights. In this case, the Captcha does not show.
Of course, commenting works without solving the Captcha in this case.

### Screenshots

/assets/screenshot-1.png

This plugin will create a captcha displaying a text, with the try to confuse OCR by drawing some random lines.

/assets/screenshot-2.png

It integrates in the comment form below each Wordpress post

/assets/screenshot-3.png

If the commenting user fails to solve it, an error message appears

/assets/screenshot-4.png

The behavior of the image can be set in the settings area of Wordpress

### Changelog

#### 1.1.0 
* added multisite support
* asset files had wrong mimetype

#### 1.0.0
* initial version
* Languages: en, de


