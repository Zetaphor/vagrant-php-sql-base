<?php
require '../vendor/autoload.php';
require 'config.php';

use Aura\SqlQuery\QueryFactory;
use Aura\Sql\ExtendedPdo;

$query_factory = new QueryFactory('mysql');

$insert = $query_factory->newInsert();
$update = $query_factory->newUpdate();
$delete = $query_factory->newDelete();

$pdo = new ExtendedPdo(
    'mysql:host='.$mysql_host.';dbname='.$mysql_db,
    $mysql_user,
    $mysql_pass,
    array(),
    array()
);

function pdoSelect($select) {
    global $pdo;
    $sth = $pdo->prepare($select->getStatement());
    $sth->execute($select->getBindValues());
    return $sth->fetchAll(PDO::FETCH_ASSOC);
}

function pdoInsert($table, $data) {
    global $pdo, $insert;
    $insert
        ->into($table)
        ->cols(array_keys($data))
        ->bindValues($data);
    $sth = $pdo->prepare($insert->getStatement());
    $sth->execute($insert->getBindValues());
    return $pdo->lastInsertId();
}

function pdoUpdate($table, $id, $data) {
    global $pdo, $update;
    $update
        ->table($table)
        ->where('id = ?', $id)
        ->cols(array_keys($data))
        ->bindValues($data);
    $sth = $pdo->prepare($update->getStatement());
    return $sth->execute($update->getBindValues());
}

function pdoDelete($table, $id) {
    global $pdo, $delete;
    $delete
        ->from($table)
        ->where('id = :id')
        ->bindValue('id', $id);
    $sth = $pdo->prepare($delete->getStatement());
    return $sth->execute($delete->getBindValues());
}

//d(pdoDelete('songs', 2));

//$update_data = array(
//  'filename' => "testtesttest.mp3"
//);
//d(pdoUpdate('songs', 19, $update_data));

//$insert_data = array(
//    'name' => 'dsadsafoo',
//    'artist' => 'dsadsazim',
//    'length' => 55,
//    'filename' => 'dsadsam'
//);
//d(pdoInsert('songs', $insert_data));

//$select->cols(array('*'))->from('songs');
//d(pdoSelect());