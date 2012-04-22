<?php
# evilcode.net
# site configuration settings
# $Id$

$_CONF['defaults']['format']             = (isset($_GET['format'])) ? $_GET['format'] : 'xhtml';
$_CONF['defaults']['page_name']          = 'index';
$_CONF['defaults']['page_extension']     = '.page';
$_CONF['defaults']['base_namespace_url'] = 'http://www.evilcode.net/Exhibition/namespaces/';

$_CONF['debug']       = false;
$_CONF['debug_level'] = 3;

$_CONF['db'] = array();
$_CONF['db']['default']['driver']     = 'mysql';
$_CONF['db']['default']['hostname']   = 'sql.evilcode.net';
$_CONF['db']['default']['username']   = 'evilcode';
$_CONF['db']['default']['password']   = 'ev1lc0de';
$_CONF['db']['default']['database']   = 'evilcode';
$_CONF['db']['default']['persistant'] = true;


require_once SITE_BASE . '/lib/php/global.php';
require_once SITE_BASE . '/private/php/application.php';

?>
