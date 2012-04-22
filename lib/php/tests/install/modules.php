<?php

define('TEST_BASE', SITE_BASE . '/lib/php/tests');
define('INSTMOD_BASE', TEST_BASE . '/install/modules');


$dir_handle = opendir(INSTMOD_BASE);
/*
if (!$this->DirHandle) {
    $this->Error = "Could not open directory: $dir";
    throw new Exception($this->Error);
}
*/

$found = array();
$found['required'] = array();
$found['optional'] = array();

$not_found = array();
$not_found['required'] = array();
$not_found['optional'] = array();

while (($filename = readdir($dir_handle)) !== false) {

    $tmpfname = INSTMOD_BASE . '/' . $filename;
    if (!is_dir($tmpfname)) {
        include($tmpfname);

        $installed = true;

        if (isset($functions) && is_array($functions))
            foreach ($functions as $function)
                if (!function_exists($function)) {
                    $installed = false;
                    continue;
                }

        if (isset($classes) && is_array($classes))
            foreach ($classes as $class)
                if (!class_exists($class)) {
                    $installed = false;
                    continue;
                }

        if ($installed == true)
            $found[$importance][$module] = $comment;
        else
            $not_found[$importance][$module] = $comment;
    }
}


print 'Required module failure list:<br/>';
foreach ($not_found['required'] as $key => $value)
    print '<b>' . $key . '</b> - ' . $value . '<br/>';

print '<br/>Optional module failure list:<br/>';
foreach ($not_found['optional'] as $key => $value)
    print '<b>' . $key . '</b> - ' . $value . '<br/>';

print '<br/>Required module success list:<br/>';
foreach ($found['required'] as $key => $value)
    print '<b>' . $key . '</b> - ' . $value . '<br/>';

print '<br/>Optional module success list:<br/>';
foreach ($found['optional'] as $key => $value)
    print '<b>' . $key . '</b> - ' . $value . '<br/>';


exit();

?>
