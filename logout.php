<?php
session_start();

require_once __DIR__ . '/inc/track_exit.php';

session_unset();
session_destroy();

header("Location: index.php");
exit;

