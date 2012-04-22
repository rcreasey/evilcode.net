<?

/*
 * Cookie format for cart contents:
 * product_id-quantity_product_id-quantity ...
 */

class Cart  {

    var $items;
    var $cookie;
    var $status = "empty";

    function cart()  {
          // Local cookie must be set first, required by cookie_decode()
        if (isset($_COOKIE['cart_items']))
            $this->status = "in_use";
        else
            return;

        $this->cookie = $_COOKIE['cart_items'];
        $this->cookie_decode();
    }

      /*
       * Add item to cart, if item exists in cart the newly passed in quantity
       * value becomes the new quantity value in the cart.
       */
    function add_item($product_id, $quantity)  {

          // Cart is empty, add item 0
        if ($this->status == "empty")  {
            $this->items[0][0] = $product_id;
            $this->items[0][1] = $quantity;
            $this->cookie_encode();

            $this->status = "in_use";

            return;
        }

          // Not empty, see if product exists in cart, update quantity
        foreach ($this->items as $key => $item)  {
            if ($item[0] == $product_id)  {

                $this->item[$key][1] = $quantity;
                $this->cookie_encode();
                return;
            }
        }

          // Add item to cart
        $item = array($product_id, $quantity);
        $this->items[] = $item;
        $this->cookie_encode();
    }

    function update_quantity($product_id, $quantity)  {
        if ($this->status != "empty")
            foreach ($this->items as $key => $item)  {
                if ($item[0] == $product_id)  {
                    if ($quantity == 0)
                        unset($this->items[$key]);
                    else
                        $this->items[$key][1] = $quantity;

                    $this->cookie_encode();
                    return;
                }
            }
          // We shouldn't be here, really, add the item?  Sure, why not!
        $this->add_item($product_id, $quantity);
    }

    function get_items()  {
        if ($this->status == "empty")
            return false;
        else
            return $this->items;
    }

    function cookie_set()  {
        setcookie("cart_items", $this->cookie);
    }

    function cookie_encode()  {

        $num_elements = count($this->items);
        $i = 1;
        foreach ($this->items as $item)  {
            if ($i < $num_elements)
                $temp_cookie .= $item[0] . "-" . $item[1] . "_";
            else
                $temp_cookie .= $item[0] . "-" . $item[1];

            $i++;
        }

        $this->cookie = $temp_cookie;        
    }

    function cookie_decode()  {
        $array = split('_', $this->cookie);
        foreach ($array as $item)  {
            $this->items[] = split('-', $item);
        }
    }

    function clear()  {
        $this->items = "";
        $this->cookie_encode();
        $this->status = "empty";
    }

}

?>
