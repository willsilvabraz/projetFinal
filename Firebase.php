<?php

use Kreait\Firebase\Factory;

class Firebase {
    private static $instance;
    private $factory;

    private function __construct() {
        $this->factory = (new Factory())->withDatabaseUri('https://teste-dfb53-default-rtdb.firebaseio.com/');
    }

    public static function getInstance() {
        if (!isset(self::$instance)) {
            self::$instance = new Firebase();
        }
        return self::$instance;
    }

    public function getDatabase() {
        return $this->factory->createDatabase();
    }
}
