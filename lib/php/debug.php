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

$Id: debug.php 288 2006-01-03 00:50:47Z ryan $

*/

/*
<debug>
  <array type="php">
    <name></name>
    <variable>
      <name></name>
      <value></value>
    </variable>
    <array>
      <name></name>
      <variable>
        <name></name>
        <value></value>
      </variable>
    </array>
  </array>
  <array type="app">
    <name></name>
    ...
  </array>
  <string type="app">blabla</string>
  <string type="info">blabla</string>
  <string type="php">blabla</string>
</debug>
*/

$_DEBUG = Array();
for ($i = 0; $i < 10; $i++)
    $_DEBUG[$i] = Array();
global $_DEBUG;

function ex_debug($str, $level=1) {
    global $_DEBUG;
    $_DEBUG[$level][] = $str;
}

$_INFO = Array();
global $_INFO;

function ex_info($str) {
    global $_INFO;
    $_INFO[] = $str;
}

class Debug extends XMLement {

    function __construct() {
        parent::__construct('debug', NULL, 'debug');

        global $_CONF, $_APPREQ, $_FORM, $_DEBUG, $_INFO;

        $level = $_CONF['debug_level'];

        $this->BuildStrings($_INFO, 'info');

        if ($level >= 1) {
            $this->BuildArray($_GET, 'GET', 'php');
            $this->BuildArray($_POST, 'POST', 'php');
            $this->BuildArray($_FILES, 'FILES', 'php');
            $this->BuildArray($_SESSION, 'SESSION', 'php');
            $this->BuildStrings($_DEBUG[1], 'app');
        }
        if ($level >= 2) {
              // Application-specific
            $this->BuildArray($_APPREQ, 'APPREQ', 'app');
            $this->BuildArray($_CONF, 'CONF', 'app');
            $this->BuildArray($_FORM, 'FORM', 'app');
            $this->BuildStrings($_DEBUG[2], 'app');
        }
        if ($level >= 3)
            $this->BuildStrings($_DEBUG[3], 'app');
        if ($level >= 4)
            $this->BuildArray($_SERVER, 'SERVER', 'php');
    }

    function BuildStrings($strarr, $type, $level=NULL) {
        if ($level == NULL)
            foreach ($strarr as $key => $value) {
                $element = $this->ForkChild('string', $value);
                $element->SetAttribute('type', $type);
                $this->AddChild($element);
            }
    }

    function BuildVariable($name, $value) {
        $element = $this->ForkChild('variable');
        $element->AddElement('name', (string)$name);
        $element->AddElement('value', (string)$value);
        return $element;
    }

    function BuildArray($array, $name=NULL, $type=NULL, $parent=NULL) {
        if (!is_array($array)) {
            return false; }
        if (count($array) == 0)
            return false;

        $element = $this->ForkChild('array');
        if ($name != NULL)
            $element->AddElement('name', $name);
        if ($type != NULL)
            $element->SetAttribute('type', $type);

        foreach ($array as $name => $value) {
            if ($this->BuildArray($value, $name, NULL, $element) == false) {
                if (is_array($value))
                    $value = 'Empty Array';
                $variable = $this->BuildVariable($name, $value);
                $element->AddChild($variable);
            }
        }

        if ($parent == NULL)
            $this->AddChild($element);
        else
            $parent->AddChild($element);

        return true;
    }
}

// XXX: Temporary
function backtrace($backtrace)
{
   $output = "<div class=\"backtrace\">\n";
   $output .= "<b class=\"header\">Backtrace:</b><br />\n";
//   $backtrace = debug_backtrace();

   foreach ($backtrace as $bt) {
       $args = '';
       if (is_array($bt['args']))
       foreach ($bt['args'] as $a) {
           if (!empty($args)) {
               $args .= ', ';
           }
           switch (gettype($a)) {
           case 'integer':
           case 'double':
               $args .= $a;
               break;
           case 'string':
               $a = htmlspecialchars(substr($a, 0, 64)).((strlen($a) > 64) ? '...' : '');
               $args .= "\"$a\"";
               break;
           case 'array':
               $args .= 'Array('.count($a).')';
               break;
           case 'object':
               $args .= 'Object('.get_class($a).')';
               break;
           case 'resource':
               $args .= 'Resource('.strstr($a, '#').')';
               break;
           case 'boolean':
               $args .= $a ? 'True' : 'False';
               break;
           case 'NULL':
               $args .= 'Null';
               break;
           default:
               $args .= 'Unknown';
           }
       }
       if (!array_key_exists('class', $bt)) $bt['class'] = '';
       if (!array_key_exists('type', $bt)) $bt['type'] = '';
       if (!array_key_exists('function', $bt)) $bt['function'] = '';
       $output .= "<br />\n";
       $output .= "<b>file:</b> {$bt['line']} - {$bt['file']}<br />\n";
       $output .= "<b>call:</b> {$bt['class']}{$bt['type']}{$bt['function']}($args)<br />\n";
   }
   $output .= "</div>\n";
   return $output;
}

?>
