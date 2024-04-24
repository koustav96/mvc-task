<?php

// Starts the session.
session_start();
// Unset the session.
session_unset();
// Destroy the session.
session_destroy();
// Redirect to login page.
header("location: /login");
exit();
