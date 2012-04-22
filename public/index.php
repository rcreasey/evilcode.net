<?php
# evilcode.net
# $Id$

@define('SITE_BASE', dirname(__FILE__) . '/..');
require_once SITE_BASE . '/private/php/global.php';

$site = new UserApp();
$site->PrepareContent();
$site->Render();

?>
