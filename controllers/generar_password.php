<?php
echo password_hash("12345", PASSWORD_DEFAULT) . "\n";  // Para "Ana Pérez"
echo password_hash("abcde", PASSWORD_DEFAULT) . "\n";  // Para "Luis Gómez"
?>
