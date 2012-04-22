<?php

function __autoload($classname) {
    global $_CONF;

      // XXX: move dirs to global config
    $dirs = Array(SITE_LIB => Array('db', 'xml', 'xml/form', 'xml/layout', 'xml/soap', 'xml/atom', 'network'),
                  SITE_BASE . '/private/php' => Array('db', 'misc'));
    $class_extension = $_CONF['defaults']['class_extension'];

    $classname = strtolower($classname);
    $filename = SITE_LIB . '/' . $classname . $class_extension;
    $found = false;

    if (!file_exists($filename)) {
        foreach ($dirs as $basedir => $basedirs) {
            foreach ($basedirs as $value) {
                $filename = $basedir . '/' . $value . '/' .  $classname . $class_extension;
                if (file_exists($filename)) {
                    $found = true;
                    break;
                }
                $found = false;
            }
            if ($found == true)
                break;
        }
    } else {
        $found = true;
    }

    if ($found == true)
        require_once($filename);
    else
        return false;

    return true;
}

?>
