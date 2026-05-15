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
    <style>
        .admin-wrapper {
            width: 700px;
            margin: 30px auto;
            font-family: Arial, Helvetica, sans-serif;
        }
        .admin-title {
            background-color: #cfcfcf;
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            padding: 12px;
            border-bottom: 3px solid white;
        }
        .admin-topbar {
            background-color: #cfcfcf;
            padding: 10px 14px;
            font-size: 13px;
            font-weight: bold;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 3px solid white;
        }
        .admin-topbar a {
            color: #333;
            font-size: 12px;
            text-decoration: underline;
        }
        .section-title {
            background-color: #cfcfcf;
            font-size: 14px;
            font-weight: bold;
            padding: 8px 14px;
            border-bottom: 2px solid white;
            border-top: 3px solid white;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #cfcfcf;
        }
        th {
            background-color: #b0b0b0;
            font-size: 13px;
            font-weight: bold;
            padding: 8px 10px;
            text-align: left;
            border: 2px solid white;
        }
        td {
            font-size: 13px;
            padding: 8px 10px;
            border: 2px solid white;
            background-color: #cfcfcf;
        }
        tr:hover td {
            background-color: #c0c0c0;
        }
    </style>
</head>
<body>

<div class="admin-wrapper">

    <div class="admin-title">Computer Science Project — Admin Dashboard</div>

    <div class="admin-topbar">
        <span>Logged in as: <?php echo htmlspecialchars($_SESSION['full_name']); ?></span>
        <a href="logout.php">Logout</a>
    </div>

    <div class="section-title">Group Averages</div>
    <table>
        <tr>
            <th>Group Number</th>
            <th>Project Title</th>
            <th>Group Members</th>
            <th>Judges</th>
            <th>Average Grade</th>
        </tr>
        <?php while ($row = $result->fetch()) { ?>
        <tr>
            <td><?php echo htmlspecialchars($row['group_number']); ?></td>
            <td><?php echo htmlspecialchars($row['project_title']); ?></td>
            <td><?php echo htmlspecialchars($row['group_members']); ?></td>
            <td><?php echo $row['number_of_judges']; ?></td>
            <td><?php echo number_format($row['average_grade'], 2); ?></td>
        </tr>
        <?php } ?>
    </table>

    <div class="section-title">All Judge Scores</div>
    <table>
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
            <td><?php echo htmlspecialchars($row['full_name']); ?></td>
            <td><?php echo htmlspecialchars($row['group_number']); ?></td>
            <td><?php echo htmlspecialchars($row['project_title']); ?></td>
            <td><?php echo $row['total']; ?></td>
            <td><?php echo htmlspecialchars($row['comments']); ?></td>
            <td><?php echo $row['submitted_at']; ?></td>
        </tr>
        <?php } ?>
    </table>

</div>

</body>
</html>