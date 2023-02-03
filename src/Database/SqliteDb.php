<?php

namespace App\Database;

use SQLite3;

class SqliteDb
{

    static  $dbName = __DIR__ . '/../../public/idesa.db';

    public static function setDB(): void
    {
        $db = self::getConnection();
        $db->exec("DROP TABLE IF EXISTS debts");
        $db->exec("CREATE TABLE debts(id INTEGER PRIMARY KEY, lote TEXT, precio INT, clientID INT, vencimiento DATE)");
        $db->exec("INSERT INTO debts(id, lote, precio, clientID, vencimiento) VALUES (1,'00145',150000,123456, '2022-09-01')");
        $db->exec("INSERT INTO debts(id, lote, precio, clientID, vencimiento) VALUES (2,'00146',110000,135486, NULL)");
        $db->exec("INSERT INTO debts(id, lote, precio, clientID, vencimiento) VALUES (3,'00147',160000,135486, NULL)");
        $db->exec("INSERT INTO debts(id, lote, precio, clientID, vencimiento) VALUES (4,'00148',130000,123456, '2022-10-01')");
        $db->exec("INSERT INTO debts(id, lote, precio, clientID, vencimiento) VALUES (5,'00148',145000,123456, NULL)");
        $db->exec("INSERT INTO debts(id, lote, precio, clientID, vencimiento) VALUES (6,'00148',190000,123456, '2022-12-01')");
        $db->exec("INSERT INTO debts(id, lote, precio, clientID, vencimiento) VALUES (7,'00148',190000,123456, '2023-01-01')");
        $db->exec("INSERT INTO debts(id, lote, precio, clientID, vencimiento) VALUES (8,'00148',190000,123456, '2023-02-01')");
    }

    public static function getConnection()
    {

        return new SQLite3(self::$dbName);
    }

    public static function fetch(string $query)
    {
        self::setDB(); 
        $lotes = [];
        $cnx = self::getConnection();
        $stmt = $cnx->query($query);
        while ($rows = $stmt->fetchArray(SQLITE3_ASSOC)) {
            $lotes[] = (object) $rows;
        }
        return $lotes;
    }
}
