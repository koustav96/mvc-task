<?php

require_once './model/query.php';
$dbQueries = new Queries();
// Show 5 posts in the homepage by default.
$data = $dbQueries->loadPost(0, 5);
