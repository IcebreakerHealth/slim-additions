<?php
/**
 * Global functions.
 *
 * If you're putting something in here you better have a damn good reason
 * and the approval of all other PHP developers on the team.
 */

/**
 * h
 *
 * For outputting strings. Add all sorts of clean methods in here as desired.
 * either takes one arg of text to escape
 * or printf style args where ALL args apart from the formatter are escaped
 * eg. h('<h1>%s</h1><p>%s</p>', $v1, $v2)
 */
function h($text /*args*/)
{
    $args = func_get_args();
    if (count($args) == 1) {
        return htmlspecialchars($text);
    } else {
        $args = array_map(function ($str) { return htmlspecialchars($str);

        }, $args);
        $args[0] = $text;
        return call_user_func_array('sprintf', $args);
    }
}

/**
 * hx
 *
 * Outputs stings using h() above unless all the arguments are empty
 * Note pass in args using @ if the variable may be unset (eg hx('<p>%s</p>', @$obj->missing))
 */
function hx($text /*args*/)
{
    $args = func_get_args();
    array_shift($args);
    if (join($args) === '') {
        return '';
    }
    array_unshift($args, $text);
    return call_user_func_array('h', $args);
}

/**
 * d
 *
 * Takes a timestamp and optional format, outputting in the correct TZ.
 */
function d($timestamp, $format_override = false)
{
    $dt = is_numeric($timestamp) ? new DateTime(date("c", $timestamp)) : new DateTime($timestamp);
    $dt->setTimezone(new DateTimeZone(\Config::DATE_OUTPUT_TZ));
    return ($format_override === false) ? $dt->format(\Config::DATE_OUTPUT_FORMAT) : $dt->format($format_override);
}
