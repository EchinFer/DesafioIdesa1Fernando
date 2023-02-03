<?php

namespace App;

use \PDO;


class Tools
{

    public static function generateJwt(array $headers, array $payload)
    {

        $secret = $_ENV['SECRET_AUTH_KEY'];
        $headers_encoded = self::base64urlEncode(json_encode($headers));

        $payload_encoded = self::base64urlEncode(json_encode($payload));

        $signature = hash_hmac('SHA256', "$headers_encoded.$payload_encoded", $secret, true);
        $signature_encoded = self::base64urlEncode($signature);

        $jwt = "$headers_encoded.$payload_encoded.$signature_encoded";

        return $jwt;
    }
    public static function base64urlEncode(string $str)
    {
        return rtrim(strtr(base64_encode($str), '+/', '-_'), '=');
    }
    public static function vcal()
    {
        $headers = array('alg' => 'HS256', 'typ' => 'JWT');
        // $payload = array('sub' => '1234567890', 'name' => 'John Doe', 'admin' => true, 'exp' => (time() + 60));
        $payload = array('email' => 'echinfer@gmail.com');

        $jwt = self::generateJwt($headers, $payload);

        return $jwt;
    }



    public static function fetchDb(PDO $db, string $query)
    {
        $sth  = $db->prepare($query);
        $sth->execute();
        $result = $sth->fetch(PDO::FETCH_ASSOC);
        return $result;
    }
    public static function fetchAllDb(PDO $db, string $query)
    {
        $sth  = $db->prepare($query);
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public static function insertDb(PDO $db, string $table, array $payload)
    {
        $query = "INSERT INTO {$table}(";
        $columns = array_keys($payload);
        $query .= implode(',', $columns) . ")";


        $valuesPosition = [];
        foreach ($columns as $value) $valuesPosition[] = "?";
        $query .= "VALUE(" . implode(',', $valuesPosition) . ")";

        $stmt  = $db->prepare($query);
        $success = $stmt->execute(array_values($payload));
        $id = $db->lastInsertId();

        return $success ? $id : $success;
    }

    public static function updatetDb(PDO $db, string $table, array $payload, array $idArgs)
    {
        $values = [];
        foreach ($payload as $key => $value) {
            $values[] = sprintf(
                '%s=%s',
                $key,
                '?',
            );
        }
        $values = implode(',', $values);
        $query = "UPDATE {$table} SET {$values} WHERE ";

        foreach ($idArgs as $key => $value) {
            $where = sprintf(
                '%s=%s',
                $key,
                '?',
            );
        }
        $query .= $where;

        $payloadValues = array_values($payload);
        foreach ($idArgs as $key => $value) {
            $payloadValues[] = $value;
        }
        $stmt  = $db->prepare($query);
        $success = $stmt->execute($payloadValues);

        return $success;
    }

    public static function deletetDb(PDO $db, string $table, string $idName, string | int $idValue)
    {
        
        $stmt  = $db->prepare("DELETE FROM {$table} WHERE {$idName} = ?");
        $success = $stmt->execute([$idValue]);

        return $success;
    }

    public static function existForeignIdData(PDO $db, string $table, string $columnName, string $columnValue)
    {
        $result = self::fetchDb($db, "SELECT * FROM {$table} WHERE {$columnName} = {$columnValue}");
        return $result !== false;
    }

    public static function validateRequiredParams(array $requireParams, array $requestParams)
    {
        $keyRequstParams = array_keys($requestParams);

        foreach ($requireParams as $value) {
            if (!array_key_exists($value, $requestParams)) return false;
        }


        return true;
    }
}
