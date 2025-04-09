<?php
include 'config/database.php'; // Include your database connection file
// Set headers to force download as Excel
// header("Content-Type: application/vnd.ms-excel");
// header("Content-Disposition: attachment; filename=tasks.xls");

// // Dummy task data (you can fetch from database later)
// $tasks = [
//     ['ID', 'Task Name', 'Important', 'Completed'],
//     [1, 'Learn JavaScript', 'Yes', 'No'],
//     [2, 'Practice DSA', 'No', 'Yes'],
//     [3, 'Build project', 'Yes', 'Yes'],
// ];

// // Output HTML table (Excel will open this as a spreadsheet)
// echo "<table border='1'>";
// foreach ($tasks as $task) {
//     echo "<tr>";
//     foreach ($task as $cell) {
//         echo "<td>{$cell}</td>";
//     }
//     echo "</tr>";
// }
// echo "</table>";


header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=tasks.xls");

$query = "SELECT id, tasks_name, is_imp, is_don FROM tasks";
$result = mysqli_query($conn, $query);

echo "<table border='1'>";
echo "<tr><th>ID</th><th>Task Name</th><th>Important</th><th>Completed</th></tr>";

while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>
        <td>{$row['id']}</td>
        <td>{$row['tasks_name']}</td>
        <td>" . ($row['is_imp'] ? 'Yes' : 'No') . "</td>
        <td>" . ($row['is_don'] ? 'Yes' : 'No') . "</td>
    </tr>";
}
echo "</table>";

?>