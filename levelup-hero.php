<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

$path = __DIR__ . "/../../..";

include_once $path . '/wp-config.php';
include_once $path . '/wp-load.php';
include_once $path . '/wp-includes/wp-db.php';
include_once $path . '/wp-includes/pluggable.php';

require_once('inc/rp-character-functions.php');

header("Content-Type: application/json");
$properties = json_decode(stripslashes(file_get_contents("php://input")));

echo(rp_character_levelup_hero($_REQUEST["id"], $properties));

?>