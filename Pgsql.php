<?php
/**
 * Db_Pgsql.php
 *
 * Database adapter for PostgresSQL
 *
 * @author Ashwini Dhekane <ashwini@ashwinidhekane.com>
 * @package xhprofpostgres
 * @copyright Copyright (c) 2012, Ashwini Dhekane
 * @license www.apache.org/licenses/LICENSE-2.0
*/

require_once XHPROF_LIB_ROOT.'/utils/Db/Abstract.php';

class Db_Pgsql extends Db_Abstract {
    public function connect() {
        $conn_string = "host=" . $this->config["dbhost"] .
        " user=" . $this->config["dbuser"] .
        " password=" . $this->config["dbpass"] .
        " dbname=" . $this->config["dbname"] .
        " options='--client_encoding=UTF8'";

        $linkid = pg_connect($conn_string);
        if ($linkid === FALSE) {
            xhprof_error("Could not connect to db");
            throw new Exception("Unable to connect to database");
            return false;
        }
        $this->linkID = $linkid;
    }

    public function query($sql) {
        return pg_query($sql);
    }

    public static function getNextAssoc($resultSet) {
        return pg_fetch_assoc($resultSet);
    }

    public function escape($str) {
        return pg_escape_string($str);
    }

    public function affectedRows() {
        return pg_affected_rows($this->linkID);
    }

    public static function unixTimestamp($field) {
        return 'timestamp('.$field.')';
    }

    public static function dateSub($days) {
        return "current_date - integer '$days'";
    }
}
