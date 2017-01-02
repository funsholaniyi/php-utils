<?php
/**
 * Created by PhpStorm.
 * User: Funsho Olaniyi
 * Date: 02/01/2017
 * Time: 02:41 AM
 */


/**
 * order an array by values in its key
 * @param $array
 * @param string $pointer
 * @param string $order
 * @return mixed
 */
function order_array_by_key_values($array, $pointer, $order = 'desc')
{
    if (!empty($array)) {
        $subarray = array();
        foreach ($array as $key => $row) {
            $subarray[$key] = $row[$pointer];
        }

        if ($order == 'desc') {
            array_multisort($subarray, SORT_DESC, $array);
        } else {
            array_multisort($subarray, SORT_ASC, $array);
        }
    }

    return $array;
}

/**
 * limits number of items that can be generated from an array
 * @param $array
 * @param $offset
 * @param $length
 * @return array|bool
 */
function limit_array($array, $offset, $length)
{
    if (!empty($array)) {
        $array = array_slice($array, $offset, $length);
        return $array;
    }
    return false;

}


/**
 * filters array output by set of conditions
 * @param $array
 * @param $conditions
 * @param string $limit
 * @return mixed
 */
function filter_array($array, $conditions, $limit = '')
{
    $filter_key = array_keys($conditions)[0];
    $filter_value = $conditions[$filter_key];
    foreach ($array as $key => $value) {
        if (is_array($value)) {
            if ($value[$filter_key] == $filter_value) {
                unset($array[$key]);
            }
        } else {
            if (($key == $filter_key) && ($value == $filter_value)) {
                unset($array[$key]);
            }
        }
    }
    if (is_int($limit)) {
        array_splice($array, $limit);
    }
    return $array;
}

/**
 * @param $array
 * @param $primarykey
 * @param array $primarykeyvalue
 * @return mixed
 */
function unset_array_by_primary($array, $primarykey, $primarykeyvalue = array())
{
    foreach ($array as $key => $innerarray) {
        $unique = $innerarray[$primarykey];
        if (in_array($unique, $primarykeyvalue)) {
            unset($array[$key]);
        }
    }
    return $array;
}



/**
 * @param $array
 * @param string $primary
 * @return array
 */
function make_array_unique($array, $primary = '')
{
    $log = array();
    if (!empty($array)) {
        foreach ($array as $key => $innerarray) {
            if (!is_array($innerarray)) {
                return array_unique($array);
            } else {
                $unique = $innerarray[$primary];
                if (in_array($unique, $log)) {
                    unset($array[$key]);
                }
                $log[] = $unique;
            }
        }
    }

    return $array;
}

/**
 * @param $search
 * @param $array
 * @param $key_array
 * @return array
 */
function search_in_array($search, $array, $key_array)
{
    $search = strtolower($search);
    $result = array();
    if (!empty($array)) {
        foreach ($array as $item) {
            foreach ($key_array as $key) {
                $word = strtolower($item[$key]);
                if (strstr($word, $search)) {
                    $result[] = $item;
                }
            }
        }
        $result = make_array_unique($result, 'id');
    }

    return $result;
}

/**
 * @param $array
 * @return array
 */
function make_array_one_order($array)
{

    if (!is_array($array)) {
        return $array;
    } else {
        $new = array();
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                unset($array[$key]);
                $new = array_merge($array, $value);
            }
        }
        return $new;
    }
}


/**
 * @param $array
 * @return array
 */
function shuffle_assoc($array)
{
    if (!empty($array)) {
        $new = array();
        $keys = array_keys($array);
        shuffle($keys);
        foreach ($keys as $key) {
            $new[$key] = $array[$key];
        }
        $array = $new;
    }

    return $array;
}

/**
 * @param $array
 * @return string
 */
function format_array_to_string($array)
{
    if (!is_array($array)) {
        return $array;
    } else {
        $num = count($array);
        $tot = count($array);
        $new = '';
        foreach ($array as $value) {
            if (is_array($value)) {
                $value = format_array_to_string($value);
            }
            $num--;
            if ($num == 0 && $tot != 1) {
                $new .= "and/or " . $value . ".";

            } elseif ($num == 0 && $tot == 1) {
                $new .= $value . ".";

            } elseif ($num == 1) {
                $new .= $value . " ";

            } else {
                $new .= $value . ", ";
            }

        }
        return $new;
    }
}
