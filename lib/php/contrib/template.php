<?

/*
Usage:
$vars['PRICE'] = $product['single_price'];
$vars['RETAIL'] = $product['sugg_retail'];
template("/user/store/cat_browse_page.tpl", $vars);
*/

function template($name, $vars = "")  {
    global $TEMPLATE_DIR;

    if (!($fp = @fopen($TEMPLATE_DIR . $name, "r")))  {
        err(__FILE__, __LINE__, "Error reading template file" .
            " $TEMPLATE_DIR$name");
    }
    while (!feof($fp))
        $data = fread($fp, 4096);
    fclose($fp);

    $vars['PHP_SELF'] = $_SERVER['PHP_SELF'];
    $vars['SUBMIT_METHOD'] = SMETHOD;

    foreach($vars as $k => $v)  {
        $keys[] = "\{$k}";
        $vals[] = $v;
    }

    $data = str_replace($keys, $vals, $data);

      // Strip HTML comments
    $data = preg_replace("/<!---.*--->/s", "", $data);

    echo $data;
}

?>
