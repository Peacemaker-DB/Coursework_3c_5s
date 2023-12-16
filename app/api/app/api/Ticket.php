<?php
header('Content-Type: application/json; charset=utf-8');
$mysqli = new mysqli("mysql", "user", "password", "autobase2");

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    $result = $mysqli->query("SELECT id_ticket, id_client_t, id_car_t, id_parking_t, price FROM Ticket");
    
    $display_string = "<div class='table5'>";
    $display_string .= "<table>";
    $display_string .= "<tr>";
    $display_string .= "<th>ID Талона</th>";
    $display_string .= "<th>ID Клиента</th>";
    $display_string .= "<th>ID Машины</th>";
    $display_string .= "<th>ID Парковочного места</th>";
    $display_string .= "<th>Цена</th>";
    $display_string .= "<th>Обновление</th>";
    $display_string .= "<th>Удаление</th>";
    $display_string .= "</tr>";
    $tickets = mysqli_fetch_all($result);
    foreach ($tickets as $ticket) {
        $display_string .= "<tr>";
        $display_string .= "<th>" . $ticket[0] . "</th>";
        $display_string .= "<th>" . $ticket[1] . "</th>";
        $display_string .= "<th>" . $ticket[2] . "</th>";
        $display_string .= "<th>" . $ticket[3] . "</th>";
        $display_string .= "<th>" . $ticket[4] . "</th>";
        $display_string .= "<th><button id ='iButton_upT_" . $ticket[0] . "' class='Button_upT' onclick='openForm_uppT(this.id)'>Обновить</button></th>";
        $display_string .= "<th><button id ='iButton_delT_" . $ticket[0] . "' class='Button_delT' onclick='openForm_delT(this.id)'>Удалить</button></th>";
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
        $result = $mysqli->query("SELECT * FROM Ticket where id_ticket  = $id");
        $row = mysqli_fetch_array($result);
        $id_client_t = $row[1];
        $id_car_t = $row[2];
        $id_parking_t = $row[3];
        $price = $row[4];
        if (!empty($_POST['id_client_t'])) {
            $pid_client_t = $_POST['id_client_t'];
        } else {
            $pid_client_t = $id_client_t;
        }
        if (!empty($_POST['id_car_t'])) {
            $pid_car_t = $_POST['id_car_t'];
        } else {
            $pid_car_t = $id_car_t;
        }
        if (!empty($_POST['id_parking_t'])) {
            $pid_parking_t = $_POST['id_parking_t'];
        } else {
            $pid_parking_t = $id_parking_t;
        }
        if (!empty($_POST['price'])) {
            $pprice = $_POST['price'];
        } else {
            $pprice = $price;
        }
        $result = $mysqli->query("UPDATE Ticket SET `id_client_t`='$pid_client_t',`id_car_t`='$pid_car_t',`id_parking_t`='$pid_parking_t', `price`='$pprice' WHERE id_ticket = $id");
        $result = $mysqli->query("SELECT `id_ticket`, `id_client_t`, `id_car_t`, `id_parking_t`, `price` FROM Ticket where  id_ticket = $id");
        $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
    } else if (isset($_POST['id_client_t'], $_POST['id_car_t'], $_POST['id_parking_t'], $_POST['price'])) {
        $id_client_t = $_POST['id_client_t'];
        $id_car_t = $_POST['id_car_t'];
        $id_parking_t = $_POST['id_parking_t'];
        $price = $_POST['price'];
        $result = $mysqli->query("INSERT INTO Ticket (`id_client_t`, `id_car_t`, `id_parking_t`, `price`) VALUES ('$id_client_t', '$id_car_t', '$id_parking_t', '$price')");
    } else {
        echo json_encode(['message' => 'Error: all fields needed'], 400);
    }
    header("Location: http://localhost:8000/home_page.html");
    return 0;
}
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    if (isset($_GET['id'])) {
        if($mysqli->query("DELETE FROM Ticket WHERE id_ticket = {$_GET['id']}") === TRUE) {
            echo json_encode(['message' => 'deleted: ' . $_GET['id']], 200); }
        else { 
            echo "Error deleting record: " . $mysqli->error; }
    } else {
        echo json_encode(['message' => 'Error: id is needed'], 400);
    }
    header("refresh: http://localhost:8000/home_page.html");
    
}