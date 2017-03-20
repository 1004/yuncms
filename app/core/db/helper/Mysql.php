<?php
// +----------------------------------------------------------------------
// | YunCMS
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://www.yunalading.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: jabber <2898117012@qq.com>
// +----------------------------------------------------------------------


namespace app\core\db\helper;

use app\core\db\DbHelper;

/**
 * Class Mysql
 * @package app\core\db\helper
 */
class Mysql extends DbHelper {
    protected $type = 'mysql';
    protected $database = 'information_schema';

    public function __construct($host, $username, $password, $port) {
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
        $this->port = $port;
    }

    public function connectionTest() {
        try {
            $this->connection()->getTables();
            return true;
        } catch (\PDOException $e) {
            return false;
        }
    }

    public function databaseExists($database) {
        try {
            $this->database = $database;
            return $this->connectionTest();
        } catch (\PDOException $e) {
            return false;
        }
    }

    public function createDatabase($database, $charset) {
        $this->connection()->query('CREATE DATABASE ' . $database . ' DEFAULT CHARSET ' . $charset);
        return $this->databaseExists($database);
    }

    public function version() {
        $result = $this->connection()->query('SELECT VERSION() AS version');
        return $result[0]['version'];
    }

    public function exeSQL($sql) {
        return $this->connection()->execute($sql);
    }
}
