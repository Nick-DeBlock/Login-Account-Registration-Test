<?php
session_start();
if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'admin') {
    header("Location: ../login.php");
    exit();
}
?>  


<!DOCTYPE html>
<html>
<head>
    <title>Login Test</title>
</head>

<style>
    body {
        font-family: Arial, sans-serif;
        background: linear-gradient(to right, #2563eb, #0891b2);
        display: flex;
        flex-direction: column;
        align-items: center;
        /* justify-content: center; */
        min-height: 100vh;
        margin: 0;
        color: white;
    }

    
</style>

<body>
    <h1>Login Test Suite</h1>
    <form action="run_tests.php" method="post">
        <input type="submit" value="Run Login Tests">
        
    </form>
</body>
</html>