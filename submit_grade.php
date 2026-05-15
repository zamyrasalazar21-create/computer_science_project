<?php
session_start();
include "db.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'judge') {
    header("Location: index.php");
    exit();
}

function getValue($name) {
    if (isset($_POST[$name]) && $_POST[$name] !== "") {
        return intval($_POST[$name]);
    }
    return null;
}

$judge_id = $_SESSION['user_id'];

$group_members = $_POST['group_members'];
$group_number  = $_POST['group_number'];
$project_title = $_POST['project_title'];
$comments      = $_POST['comments'];

$articulate_developing    = getValue('articulate_developing');
$articulate_accomplished  = getValue('articulate_accomplished');
$tools_developing         = getValue('tools_developing');
$tools_accomplished       = getValue('tools_accomplished');
$presentation_developing  = getValue('presentation_developing');
$presentation_accomplished = getValue('presentation_accomplished');
$teamwork_developing      = getValue('teamwork_developing');
$teamwork_accomplished    = getValue('teamwork_accomplished');

$total = 0;
$grades = [
    $articulate_developing, $articulate_accomplished,
    $tools_developing, $tools_accomplished,
    $presentation_developing, $presentation_accomplished,
    $teamwork_developing, $teamwork_accomplished
];
foreach ($grades as $grade) {
    if ($grade !== null) {
        $total += $grade;
    }
}

$sql = "INSERT INTO grades (
    judge_id, group_members, group_number, project_title,
    articulate_developing, articulate_accomplished,
    tools_developing, tools_accomplished,
    presentation_developing, presentation_accomplished,
    teamwork_developing, teamwork_accomplished,
    total, comments
) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $pdo->prepare($sql);
$stmt->execute([
    $judge_id, $group_members, $group_number, $project_title,
    $articulate_developing, $articulate_accomplished,
    $tools_developing, $tools_accomplished,
    $presentation_developing, $presentation_accomplished,
    $teamwork_developing, $teamwork_accomplished,
    $total, $comments
]);

echo "<h2>Grade submitted successfully.</h2>";
echo "<p>Your total score is: <strong>$total</strong></p>";
echo "<a href='judge.php'>Grade another group</a>";
?>