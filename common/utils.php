<?php
function selfURL()
{
    if( !isset( $_SERVER['REQUEST_URI'] ) )
        $suri = $_SERVER['PHP_SELF'];
    else
        $suri = $_SERVER['REQUEST_URI'];

    $s = empty( $_SERVER["HTTPS"] )
        ? ''
        : ( $_SERVER["HTTPS"] == "on" )
            ? "s"
            : "";

    $sp = strtolower( $_SERVER["SERVER_PROTOCOL"] );
    $pr = substr( $sp, 0, strpos( $sp, "/" ) ) . $s;
    $pt = ( $_SERVER["SERVER_PORT"] == "80" )
        ? ""
        : ( ":" . $_SERVER["SERVER_PORT"] );

    return $pr . "://" . $_SERVER['SERVER_NAME'] . $pt . $suri;
}



function Start_With($source_Str, $templ)
{
    if(strncasecmp($source_Str, $templ, strlen($templ)) == 0)
    {
        unset($source_Str, $templ);
        return true;
    }
    unset($source_Str, $templ);
    return false;
}

function End_With($source_Str, $templ)
{
    $tlen=strrev($templ);
    $slen=strrev($source_Str);
    $res=Start_With($slen, $tlen);
    unset($source_Str, $templ, $tlen, $slen);
    return $res;
}

function LoadScript( $path, $object = null )
{
    $path = str_replace( SITE_URL, '', $path );
    $path = str_replace( '.js', '', $path );
    $path = str_replace( '/', '.', $path );
    $path = DOMAIN.$path;
    if( $object != null )
    {
        $data = json_encode ( $object );
    }
    else
    {
        $data = "{}";
    }
    echo '<script type="text/javascript">$(function(){ new $.'.$path.'('.$data.'); });</script>';
}