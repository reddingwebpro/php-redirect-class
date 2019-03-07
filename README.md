# php-redirect
This class is designed to help you create your own internal redirect link function. This can be used to perform other actions before a user actually leaves your site. This could include logging this action, triggering an alert message, or something else. 

## Impact on SEO
When Google is evaluating inbound and outbound links, using a tool like this will obfuscate the redirect chain, because this URL will be seen as the destination of your internal links. This may or may not be your intended action. If you really want the external links to really know what page sent them along to them, you'll want to use another method such as Javascript. However, in other cases, you might not want to directly reveal the source for the redirect. For example, lets say you run a web based email application, and you don't want the external links to see the referral source of the user's webmail URL. 

## Configuration
In the constructor change the following variable:
* $this->secret should be some random, secret padding to secure your page (see security below)
* $this->redirectUrl should be the full url that will call the redirect method

## Security
To prevent PageRank hijacking you'll want to make sure that you secure your links with a secret padding. This padding is added to the url to create a MD5 hash to prevent basic PageRank hijacks, which can provide SEO performance perks for the bad guys. Doesn't necessarily negatively affect you (unless it links out to known really bad site), but it can help other businesses who are trying to use your good reputation to help them. Simply set the secret variable to anything you want, it stays hidden from the user and is never exposed, just be sure to change it from the example provided here.

## Example Provided - explained - index.php
In the example provided we place two different invocations of the class into a single file for simple demonstration purposes. Here we check to see if the $_GET['url'] was set, and if so, we then call the redirect() method. Otherwise we'll provide a simple link to the phpclasses.org website, showing how the generateRedirect() method works. In a production environment what you'd likely do is have these two control points separated out into different parts of code or file. For example, as part of your VIEW you might use the generateUrl() to create your external links, while the redirects are actually processed by a different URL, for example https://links.domain.com. Additionally, not included here is that instead of simply failing out when no $_GET['url'] is passed, you might display a message to people who are following back a referral URL, so you can explain how visitors were redirected to their site.

## License
GNU General Public License v3.0 (GNU GPLv3)
http://www.gnu.org/licenses/gpl-3.0-standalone.html
