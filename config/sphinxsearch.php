<?php
return array(
    'host'    => '127.0.0.1',
    'port'    => 9312,
    'timeout' => 30,
    'indexes' => array(
        //'my_index_name' => FALSE,
        'test1' => array('table' => 'documents', 'column' => 'id'),
        'users' => array('table' => 'users', 'column' => 'id'),
    ),
    'mysql_server' => array(
        'host' => '127.0.0.1',
        'port' => 9306
    )
);
