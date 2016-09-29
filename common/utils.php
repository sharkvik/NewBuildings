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

/**
 * Функция производит запрос на выборку в базу
 *
 * Производит запрос в базу с параметрами определеннми в константах проекта
 *
 * @param String $Query Строка SQL-запроса
 * @return Object Возвращает результат запроса resource
 *                  -1 - результат пуст
 *                  0 - нет соединения с базой
 */
function SelectBaseQuery($Query)
{
    $m_db=new mysqli(HOST_CONNECT, USER_LOGIN_CONNECT, USER_PASSW_CONNECT, DB_CONNECT);
    if(!$m_db->connect_error)
    {
        $selectRes = $m_db->query($Query);
        if($selectRes)
        {
            if($selectRes->num_rows > 0)
            {
                $res = null;
                $i = 0;
                while ($row = $selectRes->fetch_assoc())
                {
                    $res[$i] = $row;
                    $i++;
                }
                $m_db->close();
                unset($Query, $m_db, $selectRes, $row, $i);
                return $res;
            }
        }
        $m_db->close();
        unset($Query, $m_db, $selectRes, $m_db);
        return -1;
    }
    else
    {
        $m_db->close();
        unset($Query, $m_db);
        return 0;
    }
}

/**
 * Функция производит запрос на изменение
 *
 * Производит запрос в базу с параметрами определеннми в константах проекта
 *
 * @param String $Query Строка SQL-запроса
 * @return Object Возвращает результат запроса resource
 *                  -1 - результат пуст
 *                  0 - нет соединения с базой
 */
function ExecuteBaseQuery($Query, $returnId=false)
{
    $m_db=new mysqli(HOST_CONNECT, USER_LOGIN_CONNECT, USER_PASSW_CONNECT, DB_CONNECT);
    if(!$m_db->connect_error)
    {
        $selectRes = $m_db->query($Query);
        if($returnId)
        {
            $id = $m_db->insert_id;
            $m_db->close();
            unset($Query, $returnId, $m_db);
            return $id;
        }
        $m_db->close();
        unset($Query, $m_db, $returnId);
        return $selectRes;
    }
    else
    {
        $m_db->close();
        unset($Query, $m_db, $returnId);
        return 0;
    }
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