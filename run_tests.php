<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);


session_start();
if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'admin') {
    header("Location: ../login.php");
    exit();
}

include("db_connect.php");

$tests = json_decode(file_get_contents("tests.json"), true);
$base_url = "https://brightstart.space/";
?>

<!DOCTYPE html>
<html>
<head>
    <title>Test Results</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, #2563eb, #0891b2);
            margin: 0;
            padding: 40px;
        }
        .card {
            background: white;
            padding: 30px;
            border-radius: 8px;
            max-width: 700px;
            margin: auto;
        }
        .result {
            border-bottom: 1px solid #eee;
            padding: 12px 0;
        }
        .result:last-child { border-bottom: none; }
        .name { font-weight: bold; margin-bottom: 4px; }
        .pass { color: green; }
        .fail { color: red; }
        pre {
            background: #f4f4f4;
            padding: 10px;
            border-radius: 4px;
            overflow-x: auto;
            font-size: 12px;
        }
    </style>
</head>
<body>
<div class="card">
    <h2>Test Results</h2>

    <?php foreach ($tests as $test):
        $url = $base_url . $test["endpoint"];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, true);
        if ($test["method"] == "POST") {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $test["data"]);
        }
        $response = curl_exec($ch);
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        unset($ch);

        $status_ok = ($status == $test["expect_status"]);
        $content_ok = true;
        if ($test["expect_contains"] != "") {
            $content_ok = strpos($response, $test["expect_contains"]) !== false;
        }
        $passed = $status_ok && $content_ok;

    ?>
        <div class="result">
            <div class="name"><?= htmlspecialchars($test["name"]) ?></div>
            <?php if ($passed): ?>
                <div class="pass">PASS</div>
            <?php else: ?>
                <div class="fail">FAIL — Got status: <?= $status ?></div>
                <pre><?= htmlspecialchars($response) ?></pre>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>

    //This deletes the test account after running the tests so it dosent throw an account already exists error
    <?php 
        $test_email = "accountcreation@email.com";
        $stmt = $conn->prepare("DELETE FROM StudentAccount WHERE email = ?");
        $stmt->bind_param("s", $test_email);
        $stmt->execute();
        $stmt->close();
    ?>

</div>
</body>
</html>


