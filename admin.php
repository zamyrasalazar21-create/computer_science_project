<?php
session_start();
include "db.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

$sql = "
SELECT 
    group_number,
    project_title,
    group_members,
    COUNT(*) AS number_of_judges,
    AVG(total) AS average_grade
FROM grades
GROUP BY group_number, project_title, group_members
ORDER BY group_number
";

$result = $pdo->query($sql);

$details = "
SELECT grades.*, users.full_name 
FROM grades 
JOIN users ON grades.judge_id = users.id
ORDER BY grades.submitted_at DESC
";

$detailResult = $pdo->query($details);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h2>Admin Dashboard</h2>
<p><strong>Logged in as:</strong> <?php echo $_SESSION['full_name']; ?></p>
<a href="logout.php">Logout</a>
<hr>

<h3>Group Averages</h3>
<table border="1" cellpadding="10" cellspacing="0">
    <tr>
        <th>Group Number</th>
        <th>Project Title</th>
        <th>Group Members</th>
        <th>Number of Judges</th>
        <th>Average Grade</th>
    </tr>
    <?php while ($row = $result->fetch()) { ?>
        <tr>
            <td><?php echo $row['group_number']; ?></td>
            <td><?php echo $row['project_title']; ?></td>
            <td><?php echo $row['group_members']; ?></td>
            <td><?php echo $row['number_of_judges']; ?></td>
            <td><?php echo number_format($row['average_grade'], 2); ?></td>
        </tr>
    <?php } ?>
</table>

<br>
<h3>All Judge Scores</h3>
<table border="1" cellpadding="10" cellspacing="0">
    <tr>
        <th>Judge</th>
        <th>Group</th>
        <th>Project</th>
        <th>Total</th>
        <th>Comments</th>
        <th>Date</th>
    </tr>
    <?php while ($row = $detailResult->fetch()) { ?>
        <tr>
            <td><?php echo $row['full_name']; ?></td>
            <td><?php echo $row['group_number']; ?></td>
            <td><?php echo $row['project_title']; ?></td>
            <td><?php echo $row['total']; ?></td>
            <td><?php echo $row['comments']; ?></td>
            <td><?php echo $row['submitted_at']; ?></td>
        </tr>
    <?php } ?>
</table>

</body>
</html>