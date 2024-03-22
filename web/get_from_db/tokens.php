<?php
include 'db.php';

$plithos_user = "SELECT COUNT(*) FROM User WHERE adminstrator='user' ";
$result_plithos = mysqli_query($conn, $plithos_user);
$row_plithos = mysqli_fetch_assoc($result_plithos);


$sunolika_tokens = $row_plithos['COUNT(*)'] * 100;
$tokens_80 = 0.8 * $sunolika_tokens;

$users_score = "SELECT PersonID, score FROM User";
$result_user = mysqli_query($conn, $users_score);

$sunoliko_score = 0;
while ($row = mysqli_fetch_assoc($result_user)) {
    $sunoliko_score = $sunoliko_score + $row['score'];
}

$users = [];
mysqli_data_seek($result_user, 0);
while ($row = mysqli_fetch_assoc($result_user)) {
    $user_score_ratio = $row['score'] / $sunoliko_score;
    $month_tokens = round($tokens_80 * $user_score_ratio);
    $users[] = [
        'id' => $row['PersonID'],
        'month_tokens' => $month_tokens
        ];
}

foreach ($users as $user) {
    $user_id = $user['id'];
    $month_tokens = $user['month_tokens'];
    
    $updateQuery = "UPDATE User SET tokens = $month_tokens, total_tokens = total_tokens + $month_tokens WHERE PersonID = $user_id";
    mysqli_query($conn, $updateQuery);
}

echo "Monthly tokens added successfully!";

?>