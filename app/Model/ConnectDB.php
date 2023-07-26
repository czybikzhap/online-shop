<?php

namespace Model;

use PDO;

class ConnectDB
{
    public function connectDB(): PDO
    {
        return new PDO('pgsql:host=db; dbname=dbname', 'dbuser', 'dbpwd');
    }
}
