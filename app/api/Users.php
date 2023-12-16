<?php
header('http://localhost:8000/home_page.html');
$mysqli = new mysqli("mysql", "user", "password", "api_db");
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $result = $mysqli->query("SELECT id, firstname, lastname, email, role FROM users");
    $display_string = "<div class='table1'>";
    $display_string .= "<table>";
    $display_string .= "<tr>";
    $display_string .= "<th>ID Пользователя</th>";
    $display_string .= "<th>Имя</th>";
    $display_string .= "<th>Фамилия</th>";
    $display_string .= "<th>Почта</th>";
    $display_string .= "<th>Роль</th>";
    $display_string .= "<th>Обновление</th>";
    $display_string .= "<th>Удаление</th>";
    $display_string .= "</tr>";
    $users = mysqli_fetch_all($result);
    foreach ($users as $user) {
        $display_string .= "<tr>";
        $display_string .= "<th>" . $user[0] . "</th>";
        $display_string .= "<th>" . $user[1] . "</th>";
        $display_string .= "<th>" . $user[2] . "</th>";
        $display_string .= "<th>" . $user[3] . "</th>";
        $display_string .= "<th>" . $user[4] . "</th>";
        $display_string .= "<th><button id ='iButton_upU_" . $user[0] . "' class='Button_upU' onclick='openForm_uppU(this.id)'>Обновить</button></th>";
        $display_string .= "<th><button id ='iButton_delU_" . $user[0] . "' class='Button_delU' onclick='openForm_delU(this.id)'>Удалить</button></th>";
        $display_string .= "</tr>";
    }
    $display_string .= "</table>";
    $display_string .= "</div>";
    echo $display_string;
    return 0;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id_up'])) {
        if(!empty($_POST['id_up'])){
        $id = $_POST['id_up'];
        $result = $mysqli->query("SELECT * FROM users where id = $id");
        $row = mysqli_fetch_array($result);
        $role = $row[4];
        if (!empty($_POST['role'])) {
            $prole = $_POST['role'];
        } else {
            $prole = $role;
        }
        $result = $mysqli->query("UPDATE users SET `role`='$prole ' WHERE id = $id");
        $result = $mysqli->query("SELECT `id`, `firstname`, `lastname`, `email`, `role` FROM users where  id = $id");
        $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
    } else {
        echo json_encode(['message' => 'Error: all fields needed'], 400);
    }
    header("Location: http://localhost:8000/home_page.html");
    return 0;
}
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    if (isset($_GET['id'])) {
        if($mysqli->query("DELETE FROM users WHERE id = {$_GET['id']}") === TRUE) {
            echo json_encode(['message' => 'deleted: ' . $_GET['id']], 200); }
        else { 
            echo "Error deleting record: " . $mysqli->error; }
    } else {
        echo json_encode(['message' => 'Error: id is needed'], 400);
    }
    header("refresh: http://localhost:8000/home_page.html");
}