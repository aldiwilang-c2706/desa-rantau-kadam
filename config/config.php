<?php
declare(strict_types=1);
define('BASE_URL', '/desa-rantau-kadam');
define('APP_NAME', 'Desa Rantau Kadam');
define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'desa_rantau_kadam');
define('DB_USER', 'root');
define('DB_PASS', '');
define('MAX_IMAGE_SIZE', 2 * 1024 * 1024);
define('MAX_PDF_SIZE', 5 * 1024 * 1024);
date_default_timezone_set('Asia/Jakarta');
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
