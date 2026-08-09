<?php
require_once __DIR__ . '/auth.php';
cmk_logout();
header('Location: index.php');
exit;
