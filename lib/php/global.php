<?php

/*

Copyright (C) 2004-2005 Samuel J. Greear. All rights reserved.

Redistribution and use in source and binary forms, with or without
modification, are permitted provided that the following conditions
are met:
1. Redistributions of source code must retain the above copyright
   notice, this list of conditions and the following disclaimer.
2. Redistributions in binary form must reproduce the above copyright
   notice, this list of conditions and the following disclaimer in the
   documentation and/or other materials provided with the distribution.

THIS SOFTWARE IS PROVIDED BY AUTHOR AND CONTRIBUTORS ``AS IS'' AND
ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
ARE DISCLAIMED.  IN NO EVENT SHALL AUTHOR OR CONTRIBUTORS BE LIABLE
FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL
DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS
OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION)
HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY
OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF
SUCH DAMAGE.

$Id: global.php 370 2006-05-27 12:15:19Z sjg $

*/

@define('SITE_BASE', dirname(__FILE__) . '/../..');
@define('SITE_LIB', SITE_BASE . '/lib/php');

if (!isset($_CONF['debug']))
    $_CONF['debug'] = false;
if ($_CONF['debug'] == true) {
    error_reporting(E_ALL);
    if ($_CONF['debug_level'] < 1)
        $_CONF['debug_level'] = 1;
}

$_CONF['form']['method'] = (isset($_CONF['form']['method'])) ? 
                           $_CONF['form']['method'] : 'post';
$_CONF['form']['enctype'] = (isset($_CONF['form']['enctype'])) ? 
                            $_CONF['form']['enctype'] : 'multipart/form-data';
$_CONF['form']['accept-charset'] = (isset($_CONF['form']['accept-charset'])) ? 
                                   $_CONF['form']['accept-charset'] : 'UTF-8';
$_CONF['form']['prefix'] = (isset($_CONF['form']['prefix'])) ? 
                           $_CONF['form']['prefix'] : 'form_';

$_CONF['defaults']['format'] = (isset($_CONF['defaults']['format'])) ?
                               $_CONF['defaults']['format'] : 'xml';
$_CONF['defaults']['page_name'] = (isset($_CONF['defaults']['page_name'])) ?
                                  $_CONF['defaults']['page_name'] : 'index';
$_CONF['defaults']['page_extension'] = (isset($_CONF['defaults']['page_extension'])) ? 
                                       $_CONF['defaults']['page_extension'] : '.page';
$_CONF['defaults']['navigation_name'] = (isset($_CONF['defaults']['navigation_name'])) ? 
                                        $_CONF['defaults']['navigation_name'] : 'navigation';
$_CONF['defaults']['class_extension'] = (isset($_CONF['defaults']['class_extension'])) ? 
                                        $_CONF['defaults']['class_extension'] : '.class';

if (!isset($_CONF['db'])) {
    $_CONF['db']['default']['database'] = 'exhibition';
    $_CONF['db']['default']['hostname'] = 'localhost';
    $_CONF['db']['default']['driver']   = 'mysql';
    $_CONF['db']['default']['username'] = 'exhibition';
    $_CONF['db']['default']['password'] = 'exhibition';
}

$_CONF['namespaces']['exhibition'] = 'http://evilcode.net/exhibition/namespaces/';
$_CONF['namespaces']['wsdl'] = 'http://schemas.xmlsoap.org/wsdl/';
$_CONF['namespaces']['soap'] = 'http://schemas.xmlsoap.org/wsdl/soap/';
$_CONF['namespaces']['xsd'] = 'http://www.w3.org/2001/XMLSchema';
$_CONF['namespaces']['soap-enc'] = 'http://schemas.xmlsoap.org/soap/encoding/';
$_CONF['namespaces']['atom'] = 'http://www.w3.org/2005/Atom';

$_APPREQ['subpage'] = array();
if (isset($_SERVER['REQUEST_URI']))
    $_APPREQ['uri'] = $_SERVER['REQUEST_URI'];
else
    $_APPREQ['uri'] = '/'; // We're a shell script

 // strip off query string
$temp_arr = explode('?', $_APPREQ['uri']);
if (count($temp_arr) > 1) {
  $_APPREQ['uri'] = array_shift($temp_arr);
  $temp_arr       = explode('&', array_shift($temp_arr) );

  foreach ($temp_arr as $queryvariable) {
    list($key, $value) = explode('=', $queryvariable);
    $_APPREQ['query_string'][] = array( 'key' => $key, 'value' => $value );
  }
}

 // ajax handling
if (isset($_GET['ajax']) && $_GET['ajax'] == 'true') {
  // this is implied with a uri starting with '/ajax', the GET is set in .htaccess
  // I know this is hacky, but let's just start with this and polish it later
  $_APPREQ['ajax'] = true;
  $_APPREQ['uri']  = substr($_APPREQ['uri'], 5);
  unset($_GET['ajax']);
} else {
  $_APPREQ['ajax'] = false;
}

 // build the rest of the request uri
$temp_arr = explode('/', $_APPREQ['uri']);

if ($_APPREQ['uri'] == '/')
    $_APPREQ['page'] = '/';
else
    $_APPREQ['page'] = $temp_arr[1];

array_shift($temp_arr);
array_shift($temp_arr);
if (count($temp_arr) == 0 || $temp_arr[0] == "")
    $_APPREQ['subpage'] = NULL;
else
    $_APPREQ['subpage'] = $temp_arr;

  // xhtml is default output
$_APPREQ['format'] = (isset($_CONF['defaults']['format'])) ? $_CONF['defaults']['format'] : 'xhtml';

  // Turn off magic quoting
ini_set('magic_quotes_gpc', 0);
ini_set('magic_quotes_runtime', 0);

 // Do include's that would not otherwise get pulled in
require_once SITE_LIB . '/autoload.php';
require_once SITE_LIB . '/debug.php';

?>
