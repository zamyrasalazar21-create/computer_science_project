<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'judge') {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Computer Science Project</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<form action="submit_grade.php" method="POST" onsubmit="return validateForm()">

<div class="rubric-wrapper">

    <div class="rubric-title">
        Computer Science Project
    </div>

    <table class="rubric-table">

        <tr class="info-row">
            <td colspan="2" class="left-info">
                Group Members:
                <input type="text" name="group_members" class="line-input" required>
            </td>
            <td class="right-info">
                Group Number:
                <input type="text" name="group_number" class="line-input short-input" required>
            </td>
        </tr>

        <tr class="info-row">
            <td colspan="3">
                Project Title:
                <input type="text" name="project_title" class="line-input title-input" required>
            </td>
        </tr>

        <tr class="header-row">
            <th>Criteria</th>
            <th>Developing(0-10)</th>
            <th>Accomplished(11-15)</th>
        </tr>

        <tr class="score-row">
            <td class="criteria-text">Articulate requirements</td>
            <td>
                <input type="number" name="articulate_developing" min="0" max="10" class="score-input dev">
            </td>
            <td>
                <input type="number" name="articulate_accomplished" min="11" max="15" class="score-input acc">
            </td>
        </tr>

        <tr class="score-row tall-row">
            <td class="criteria-text">
                Choose appropriate tools and<br>
                methods for each task
            </td>
            <td>
                <input type="number" name="tools_developing" min="0" max="10" class="score-input dev">
            </td>
            <td>
                <input type="number" name="tools_accomplished" min="11" max="15" class="score-input acc">
            </td>
        </tr>

        <tr class="score-row tall-row">
            <td class="criteria-text">
                Give clear and coherent oral<br>
                presentation
            </td>
            <td>
                <input type="number" name="presentation_developing" min="0" max="10" class="score-input dev">
            </td>
            <td>
                <input type="number" name="presentation_accomplished" min="11" max="15" class="score-input acc">
            </td>
        </tr>

        <tr class="score-row tall-row">
            <td class="criteria-text">Functioned well as a team</td>
            <td>
                <input type="number" name="teamwork_developing" min="0" max="10" class="score-input dev">
            </td>
            <td>
                <input type="number" name="teamwork_accomplished" min="11" max="15" class="score-input acc">
            </td>
        </tr>

        <tr class="total-row">
            <td colspan="2" class="total-label">Total</td>
            <td>
                <span id="totalDisplay"></span>
            </td>
        </tr>

        <tr class="judge-row">
            <td colspan="3">
                Judge's name:
                <?php echo htmlspecialchars($_SESSION['full_name']); ?>
            </td>
        </tr>

        <tr class="comments-row">
            <td colspan="3">
                Comments:<br>
                <textarea name="comments" class="comments-box"></textarea>
            </td>
        </tr>

    </table>

    <button type="submit" class="submit-button">Submit Grade</button>
    <br>
    <a href="logout.php" class="logout-link">Logout</a>

</div>

</form>

<script>
const rows = document.querySelectorAll(".score-row");

rows.forEach(row => {
    const developing = row.querySelector(".dev");
    const accomplished = row.querySelector(".acc");

    developing.addEventListener("input", function () {
        accomplished.disabled = developing.value !== "";
        calculateTotal();
    });

    accomplished.addEventListener("input", function () {
        developing.disabled = accomplished.value !== "";
        calculateTotal();
    });
});

function calculateTotal() {
    let total = 0;
    const inputs = document.querySelectorAll(".score-input");

    inputs.forEach(input => {
        if (input.value !== "" && !input.disabled) {
            total += parseInt(input.value);
        }
    });

    document.getElementById("totalDisplay").textContent = total > 0 ? total : "";
}

function validateForm() {
    for (let row of rows) {
        const developing = row.querySelector(".dev");
        const accomplished = row.querySelector(".acc");

        if (developing.value === "" && accomplished.value === "") {
            alert("Please enter one grade for each criterion.");
            return false;
        }
    }
    return true;
}
</script>

</body>
</html>