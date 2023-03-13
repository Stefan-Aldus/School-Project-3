<?php
try {
    $db = new PDO('mysql:host=localhost;dbname=brouwerskazen', 'root', '');
}
catch(PDOexception $e) {
    die("Fout bij verbinden met database: " .$e->getMessage());
}

?>