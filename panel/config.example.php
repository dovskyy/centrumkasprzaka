<?php
// Skopiuj ten plik do panel/config.php (config.php jest w .gitignore - nigdy nie trafia do repo).
// Hash wygeneruj poleceniem: php -r "echo password_hash('twoje-haslo', PASSWORD_DEFAULT), PHP_EOL;"

define('CMK_PANEL_LOGIN', 'admin');
define('CMK_PANEL_HASH', '$2y$10$wstaw.tutaj.wygenerowany.hash.hasla');
