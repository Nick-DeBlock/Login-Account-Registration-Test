<?php
// checks to make sure the user is an admin
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

    input{
        padding: 10px 20px;
        font-size: 16px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    
</style>

<body>
    <h1>Login Test Suite</h1>
    <!-- button to start the test  -->
    <form action="run_tests.php" method="post">
        <input type="submit" value="Run Login Tests">
        
    </form>
    <p>This page is used to preform automated checks of the login system. This system should only be used by those with administrative acces</p>
</body>
</html>