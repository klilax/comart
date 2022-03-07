<?php
require_once ('db.php');

$conn = getConnection();

function intRatingStat($id) {
    global $conn;
    $sql = "INSERT INTO ratingstat (inventoryId) VALUE (:id)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
}

function getRating($inventorId): array {
    global $conn;
    $rating = array();
    for ($i=1; $i<=5; $i++) {

        $sql = "SELECT COUNT(rating) AS rating from review where inventoryId = :id AND rating = :rating";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $inventorId);
        $stmt->bindParam(':rating', $i);
        $stmt->execute();
        $row = $stmt->fetch();
        $rating[$i-1] = $row[0];

    }
    return $rating;
}

function updateRating($id) {
    global $conn;
    $rating = getRating($id);
    $sql = "UPDATE ratingstat 
            SET 
                `5Star` = :rating_5,
                `4Star` = :rating_4,
                `3Star` = :rating_3,
                `2Star` = :rating_2,
                `1Star` = :rating_1
            WHERE inventoryId = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':rating_5', $rating[4]);
    $stmt->bindParam(':rating_4', $rating[3]);
    $stmt->bindParam(':rating_3', $rating[2]);
    $stmt->bindParam(':rating_2', $rating[1]);
    $stmt->bindParam(':rating_1', $rating[0]);
    $stmt->bindParam(':id', $id);

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
//        intRatingStat($row['inventoryId']);
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
    <button id="update" onclick="updateRating()">Update</button>
</body>
<script>
    function updateRating() {
        window.location.href = 'updateRating.php?update=true';
    }
</script>
</html>
