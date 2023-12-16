<?php
header('Content-Type: application/json; charset=utf-8');
$mysqli = new mysqli("mysql", "user", "password", "autobase2");
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        
    $result = $mysqli->query("SELECT id_parking, numb_parking, status_p FROM Parking");
    
    $display_string = "<div class='table4'>";
    $display_string .= "<table>";
    $display_string .= "<tr>";
    $display_string .= "<th>ID Парковочного места</th>";
    $display_string .= "<th>Номер </th>";
    $display_string .= "<th>Статус</th>";
    $display_string .= "<th>Обновление</th>";
    $display_string .= "<th>Удаление</th>";
    $display_string .= "</tr>";
    $parkings = mysqli_fetch_all($result);
    foreach ($parkings as $parking) {
        $display_string .= "<tr>";
        $display_string .= "<th>" . $parking[0] . "</th>";
        $display_string .= "<th>" . $parking[1] . "</th>";
        $display_string .= "<th>" . $parking[2] . "</th>";
        $display_string .= "<th><button id ='iButton_upP_" . $parking[0] . "' class='Button_upP' onclick='openForm_uppP(this.id)'>Обновить</button></th>";
        $display_string .= "<th><button id ='iButton_delP_" . $parking[0] . "' class='Button_delP' onclick='openForm_delP(this.id)'>Удалить</button></th>";
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
        $result = $mysqli->query("SELECT * FROM Parking where id_parking = $id");
        $row = mysqli_fetch_array($result);
        $numb_parking = $row[1];
        $status_p  = $row[2];
        if (!empty($_POST['numb_parking'])) {
            $pnumb_parking = $_POST['numb_parking'];
        } else {
            $pnumb_parking = $numb_parking;
        }
        if (!empty($_POST['status_p'])) {
            $pstatus_p = $_POST['status_p'];
        } else {
            $pstatus_p = $status_p;
        }
        $result = $mysqli->query("UPDATE Parking SET `numb_parking`='$pnumb_parking',`status_p`='$pstatus_p'WHERE id_parking = $id");
        $result = $mysqli->query("SELECT `id_parking`, `numb_parking`, `status_p` FROM Parking where  id_parking = $id");
        $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
    } else if (isset($_POST['numb_parking'], $_POST['status_p'])) {
        $numb_parking = $_POST['numb_parking'];
        $status_p = $_POST['status_p'];
        $result = $mysqli->query("INSERT INTO Parking (`numb_parking`, `status_p`) VALUES ('$numb_parking', '$status_p')");
    } else {
        echo json_encode(['message' => 'Error: all fields needed'], 400);
    }
    header("Location: http://localhost:8000/home_page.html");
    return 0;
}
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    if (isset($_GET['id'])) {
        if($mysqli->query("DELETE FROM Parking WHERE id_parking = {$_GET['id']}") === TRUE) {
            echo json_encode(['message' => 'deleted: ' . $_GET['id']], 200); }
        else { 
            echo "Error deleting record: " . $mysqli->error; }
    } else {
        echo json_encode(['message' => 'Error: id is needed'], 400);
    }
    header("refresh: http://localhost:8000/home_page.html");
    
}