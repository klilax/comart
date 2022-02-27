<?php
require_once ('db.php');

$conn = getConnection();

function averageRating($id) {
    global $conn;
    $sql = "SELECT AVG(rating) FROM review WHERE inventoryId = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    return $stmt->fetchColumn();
}

function updateRating($id) {
    global $conn;
    $rating = averageRating($id);
    $sql = "UPDATE inventory SET rating = :rating WHERE inventoryId = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':rating', $rating);
    $stmt->execute();
}

function updateInventoryRating() {
    global $conn;
    $sql = "SELECT inventoryId FROM inventory";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll();
    foreach ($result as $row) {
        updateRating($row['inventoryId']);
    }
}

if (isset($_GET['update'])) {
    if ($_GET['update'] == 'true') {
        updateInventoryRating();
        $_GET['update'] = 'false';
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Update</title>
</head>
<body>
    <button id="update" onclick="updateRating()"></button>
</body>
<script>
    function updateRating() {
        window.location.href = 'class/updateRating.php?update=true';
    }
</script>
</html>
