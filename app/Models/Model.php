<?php

namespace App\Models;

use PDO;
use PDOException;

class Model
{
    protected $pdo;

    public function __construct()
    {
        try {
            $this->pdo = new PDO(
                'mysql:host='.DATABASE['HOST'].';dbname='.DATABASE['NAME'].';'.DATABASE['CHARSET'].'',
                DATABASE['USER'],
                DATABASE['PASSWORD'],
                DATABASE['OPTIONS']
            );
        } catch (PDOException $e) {
            die('Could not connect to the database');
        }
    }
}