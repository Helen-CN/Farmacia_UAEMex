<?php
session_start();
session_destroy();
require_once __DIR__ . '/../config/rutas.php'; // para tener URL_BASE

header("Location: " . URL_BASE . "/views/login.php");
exit();

