=== WP Is Connected by Azed ===
Contributors: azeddev
Donate link: http://www.azed-dev.com/
Tags: user, role, connected, not
Requires at least: 3.4
Tested up to: 4.6
Stable tag: 0.1
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl-3.0.html

You want to show specific content for each user role ?

== Description ==

You need to show specific content for each user role ?

You want to display the name of a logged user ("Hello USERNAME")

Two button allow you to generate shortcodes directly in the editor ;)

** SHORTCODES **

** Is connected or not **

* [wisco on] ... CONTENT ... [/wisco]  => the user is connected
* [wisco off] ... CONTENT ... [/wisco]  => the user is not connected
* [wisco on="author"] ... CONTENT ... [/wisco]  => the user is connected and his role is author
* [wisco on="author,administrator,editor"] ... CONTENT ... [/wisco]  => the user is connected and his role is author or administrator or editor (separate each role whith a coma)
* [wisco on="!subscriber,!administrator"] ... CONTENT ... [/wisco]  => the user is connected and his role is not subscriber and not administrator (separate each role whith a coma)
* [wisco id="1,2,3"] ... CONTENT ... [/wisco]  => the user is connected and his ID 1 or 2 or 3 (separate each id whith a coma)

** Display user information **

* [wishow name]  => Display the logged user name
* [wishow email]  => Display the logged user email
* [wishow description]  => Display the logged user description
* [wishow id]  => Display the logged user ID
* [wishow role]  => Display the logged user role
* [wishow website]  => Display the logged user web site url

= Languages =

* Available in ENGLISH
* Available in FRENCH
* .PO available to make your own translation !


== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/wp-is-connected-by-azed` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress
3. It's ready !


== Frequently Asked Questions ==

= Is this plugin easy tu use ? =

Yes, we've made this plugin as simple as possible to allow any user to use it !

== Screenshots ==

1. Button for restricted areas
2. Restricted area filter selection
3. Button for user datas
4. User datas selection

== Changelog ==

= 0.1 =
This version is the first one ! It has been tested over 50 wordpress !
