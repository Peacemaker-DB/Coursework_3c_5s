<?php
header('http://localhost:8000/home_page.html');
$mysqli = new mysqli("mysql", "user", "password", "autobase2");
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $result = $mysqli->query("SELECT id_client, address, number, name, documents, car_rights FROM clients");
    $display_string = "<div class='table2'>";
    $display_string .= "<table>";
    $display_string .= "<tr>";
    $display_string .= "<th>ID Клиента</th>";
    $display_string .= "<th>Адрес</th>";
    $display_string .= "<th>Номер телефона</th>";
    $display_string .= "<th>ФИО</th>";
    $display_string .= "<th>Паспортные данныес</th>";
    $display_string .= "<th>Номер водительского удостоверения</th>";
    $display_string .= "<th>Обновление</th>";
    $display_string .= "<th>Удаление</th>";
    $display_string .= "</tr>";
    $clients = mysqli_fetch_all($result);
    foreach ($clients as $client) {
        $display_string .= "<tr>";
        $display_string .= "<th>" . $client[0] . "</th>";
        $display_string .= "<th>" . $client[1] . "</th>";
        $display_string .= "<th>" . $client[2] . "</th>";
        $display_string .= "<th>" . $client[3] . "</th>";
        $display_string .= "<th>" . $client[4] . "</th>";
        $display_string .= "<th>" . $client[5] . "</th>";
        $display_string .= "<th><button id ='iButton_upF_" . $client[0] . "' class='Button_upF' onclick='openForm_upp(this.id)'>Обновить</button></th>";
        $display_string .= "<th><button id ='iButton_delF_" . $client[0] . "' class='Button_delF' onclick='openForm_del(this.id)'>Удалить</button></th>";
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
        $result = $mysqli->query("SELECT * FROM clients where id_client = $id");
        $row = mysqli_fetch_array($result);
        $address = $row[1];
        $number = $row[2];
        $name = $row[3];
        $documents = $row[4];
        $car_rights = $row[5];
        if (!empty($_POST['address'])) {
            $paddress = $_POST['address'];
        } else {
            $paddress = $address;
        }
        if (!empty($_POST['number'])) {
            $pnumber = $_POST['number'];
        } else {
            $pnumber = $number;
        }
        if (!empty($_POST['name'])) {
            $pname = $_POST['name'];
        } else {
            $pname = $name;
        }
        if (!empty($_POST['documents'])) {
            $pdocuments = $_POST['documents'];
        } else {
            $pdocuments = $documents;
        }
        if (!empty($_POST['car_rights'])) {
            $pcar_rights = $_POST['car_rights'];
        } else {
            $pcar_rights = $car_rights;
        }
        $result = $mysqli->query("UPDATE clients SET `address`='$paddress',`number`='$pnumber',`name`='$pname', `documents`='$pdocuments', `car_rights`='$pcar_rights' WHERE id_client = $id");
        $result = $mysqli->query("SELECT `id_client`, `address`, `number`, `name`, `documents`, `car_rights` FROM clients where  id_client = $id");
        $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
    } else if (isset($_POST['address'], $_POST['number'], $_POST['name'], $_POST['documents'], $_POST['car_rights'])) {
        $address = $_POST['address'];
        $number = $_POST['number'];
        $name = $_POST['name'];
        $documents = $_POST['documents'];
        $car_rights = $_POST['car_rights'];
        $result = $mysqli->query("INSERT INTO clients (`address`, `number`, `name`, `documents`, `car_rights`) VALUES ('$address', '$number', '$name', '$documents', '$car_rights')");
    } else {
        echo json_encode(['message' => 'Error: all fields needed'], 400);
    }
    header("Location: http://localhost:8000/home_page.html");
    return 0;
}
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    if (isset($_GET['id'])) {
        if($mysqli->query("DELETE FROM clients WHERE id_client = {$_GET['id']}") === TRUE) {
            echo json_encode(['message' => 'deleted: ' . $_GET['id']], 200); }
        else { 
            echo "Error deleting record: " . $mysqli->error; }
    } else {
        echo json_encode(['message' => 'Error: id is needed'], 400);
    }
    header("refresh: http://localhost:8000/home_page.html");
    
}