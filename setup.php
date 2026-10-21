<?php
// One-time setup: creates the database, the donuts table, and the starter data.
// Safe to run more than once. Delete this file from the server after use.

$config = require __DIR__ . '/config.php';

// 1. Connect to the RDS server (no database selected yet)
$db = new mysqli($config['db_host'], $config['db_user'], $config['db_pass']);

// 2. Create the database if it doesn't exist, then use it
$db->query("CREATE DATABASE IF NOT EXISTS `{$config['db_name']}`");
$db->select_db($config['db_name']);

// 3. Run every statement in sql/donuts.sql
$sql = file_get_contents(__DIR__ . '/sql/donuts.sql');
$db->multi_query($sql);
while ($db->more_results()) {
    $db->next_result();
}

// 4. Report how many donuts are in the table
$count = $db->query("SELECT COUNT(*) AS n FROM donuts")->fetch_assoc()['n'];
echo "Setup complete. The donuts table has $count donuts.";
