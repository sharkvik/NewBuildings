<?php
include_once 'Database.php';
class DbWrapper
{
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
    
    
    static function SelectBaseQuery($Query)
    {
        $m_db=new mysqli(Database::$Host, Database::$User, Database::$Password, Database::$DbName);
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
    static function ExecuteBaseQuery($Query, $returnId=false)
    {
        $m_db=new mysqli(Database::$Host, Database::$User, Database::$Password, Database::$DbName);
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
}
Logger::Debug( 'DbWrapper loaded...' );