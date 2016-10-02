<?php
class RequestStorage{
    protected static $ItemsDictionary = array();

    public static function Add( $key, $value )
    {
        self::$ItemsDictionary[$key] = $value;
    }

    public static function GetItem( $key )
    {
        return self::$ItemsDictionary[$key];
    }

    public static function Remove( $key )
    {
        unset(self::$ItemsDictionary[$key]);
    }
}

class Namespaces
{
    protected static function GetKey()
    {
        return DOMAIN.".Namespaces";
    }

    static function Add( $namespace, $path )
    {
        $collection = RequestStorage::GetItem(self::GetKey());
        if( !isset($collection) )
        {
            $collection = array();
        }
        $collection[$namespace] = $path;
        RequestStorage::Add(self::GetKey(),$collection);
    }

    static function Get( $namespace )
    {
        $collection = RequestStorage::GetItem(self::GetKey());
        if( !isset($collection) )
            return '';

        return $collection[$namespace];
    }
}