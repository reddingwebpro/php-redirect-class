<?php
/**
 * Copyright (c) 2019. ReddingWebPro / Jason J. Olson, This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU General Public License as published by the Free Software Foundation version 3
 * of the License.
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without
 * even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License
 * for more details. You should have received a copy of the GNU General Public License along with this program.  If not,
 * see <https://www.gnu.org/licenses/>.
 */

/**
 * Created by ReddingWebPro/ReddingWebDev
 * User: Jason J. Olson
 * License: GNU GPLv3
 * GitHub: https://github.com/reddingwebpro/php-redirect-class
 * Date: 3/6/2019
 */

namespace RedWebDev;


class redirect
{
    function __construct()
    {
        $this->secret = 'abc123'; // TODO: change this to something secret; security related.
        $this->redirectUrl = 'https://redirect.domain.com'; // TODO: change this to your redirect domain.
    }
    
    /**
     * generateRedirect is used to create a redirect link from a provided URL
     *
     * @param   string $url This is the url to redirect the clinet to
     *
     * @return  string       This is the url you would provide to the end user in <a href>
     */
    function generateRedirect($url)
    {
        $hash = md5($this->secret . $url);
        $url = urlencode($url);
        
        return $this->redirectUrl . "?url=" . $url . "&key=" . $hash;
        
    }
    
    /**
     * validateRedirect is used to handle the redirect and will automatically pass the appropriate HTTP headers.
     * It is important that no other HTML output is passed to the browser before calling this method.
     * No params are passed to it directly, but it does GET the HTTP data from the URL.
     * @return bool The method will return true however since this invokes a redirect and a die()
     */
    function redirect()
    {
        @$hash = $_GET['key'];
        @$url = $_GET['url'];
        if (md5($this->secret . $url) !== $hash) {
            header("HTTP/1.1 403 Forbidden");
            die();
        }
        
        // once you get here you might want to do some other function/task
        
        $ref = $_SERVER['HTTP_REFERER'];
        if ($this->urlExists($url)) {
            header("HTTP/1.1 301 Moved Permanently");
            header("Location: " . $url);
            die();
        } else {
            header("HTTP/1.1 301 Moved Permanently");
            header("Refresh:2; url=$ref");
            echo "<h1>Error:</h1>Sorry, the page link is no longer valid, and you will be returned the referring page in a moment.";
            die();
        }
        
        return true;
    }
    
    /**
     * urlExsists is a quick and dirty way to check to see if the URL exists by checking if there is a DNS entry for the URL,
     * that way we don't accidentally redirect someone to a broken link. It also provide you a method to catch any possible
     * broken links, at least to the extent of dead websites.
     *
     * @param $url      this is the URL to be checked
     *
     * @return bool     returns true only if there is a valid A record for the website hostname
     */
    function urlExists($url)
    {
        $test = false;
        @$dns = parse_url($url);
        @$dns = dns_get_record($dns['host']);
        if (@$dns[0]) $test = true;
        
        return $test;
    }
    
    
}