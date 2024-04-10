<?php
require_once './model/query.php';
$dbQueries = new Queries();

$data = $dbQueries->loadPost(0, 5);
