<?php
    $conn = new mysqli( "localhost", "brights1_adminuser", "agileninjascapstone2025", "brights1_dbprimary");

    if ($conn->connect_error) {
        die("Database connection failed: " . $conn->connect_error);

    
    }

?>