<?php
/**
 * KumbiaPHP Web Framework
 * Parámetros de conexión a la base de datos
 */
return [
    'development' => [
        /**
         * host: ip o nombre del host de la base de datos
         */
        'host'     => 'db-mysql-sfo3-58066-do-user-18079590-0.m.db.ondigitalocean.com',
        /**
         * username: usuario con permisos en la base de datos
         */
        'username' => 'doadmin', //no es recomendable usar el usuario root
        /**
         * password: clave del usuario de la base de datos
         */
        'password' => 'AVNS_6-KQujFcvyFYZv3VV7X',
        /**
         * test: nombre de la base de datos
         */
        'name'     => 'Plantas',
        /**
         * type: tipo de motor de base de datos (mysql, pgsql, oracle o sqlite)
         */
        'type'     => 'mysql',

        'port' => '25060',
        /**
         * charset: Conjunto de caracteres de conexión, por ejemplo 'utf8'
         */
        'charset'  => 'utf8',
        /**
         * dsn: Cadena de conexión a la base de datos
         */
        //'dsn' => '',
        /**
         * pdo: activar conexiones PDO (On/Off); descomentar para usar
         */
        //'pdo' => 'On',
        ],

    'production' => [
        /**
         * host: ip o nombre del host de la base de datos
         */
        'host'     => 'db-mysql-sfo3-58066-do-user-18079590-0.m.db.ondigitalocean.com',
        /**
         * username: usuario con permisos en la base de datos
         */
        'username' => 'doadmin',//no es recomendable usar el usuario root
        /**
         * password: clave del usuario de la base de datos
         */
        'password' => 'AVNS_6-KQujFcvyFYZv3VV7X',
        /**
         * test: nombre de la base de datos
         */
        'name'     => 'Plantas',
        /**
         * type: tipo de motor de base de datos (mysql, pgsql o sqlite)
         */
        'type'     => 'mysql',

        'port' => '25060',
        /**
         * charset: Conjunto de caracteres de conexión, por ejemplo 'utf8'
         */
        'charset'  => 'utf8',
        /**
         * dsn: cadena de conexión a la base de datos
         */
        //'dsn' => '',
        /**
         * pdo: activar conexiones PDO (OnOff); descomentar para usar
         */
        //'pdo' => 'On',
        ],
];

/**
 * Ejemplo de SQLite
 */
/*'development' => [
    'type' => 'sqlite',
    'dsn' => 'temp/data.sq3',
    'pdo' => 'On',
] */
