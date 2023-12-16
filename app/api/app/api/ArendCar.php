<?php

header('http://localhost:8000/home_page.html');
$mysqli = new mysqli("mysql", "user", "password", "autobase2");

//Getting all clients
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    //if (isset($_GET['id'])) {
        //$result = $mysqli->query("SELECT `id_arend_c`, `marka`, `time_arend`, `price_arend` FROM ArendC where id_arend_c = {$_GET['id']}");
    
        $result = $mysqli->query("SELECT id_arend_c, marka, time_arend, price_arend FROM ArendCar");
    $display_string = "<div class='table3'>";
    $display_string .= "<table>";
    $display_string .= "<tr>";
    $display_string .= "<th>ID Аредной машины</th>";
    $display_string .= "<th>Марка</th>";
    $display_string .= "<th>Время аренды</th>";
    $display_string .= "<th>Стоимость</th>";
    $display_string .= "<th>Обновление</th>";
    $display_string .= "<th>Удаление</th>";
    $display_string .= "</tr>";
    $ArendC = mysqli_fetch_all($result);
    foreach ($ArendC as $ArendCs) {
        $display_string .= "<tr>";
        $display_string .= "<th>" . $ArendCs[0] . "</th>";
        $display_string .= "<th>" . $ArendCs[1] . "</th>";
        $display_string .= "<th>" . $ArendCs[2] . "</th>";
        $display_string .= "<th>" . $ArendCs[3] . "</th>";
        $display_string .= "<th><button id ='iButton_upFAC_" . $ArendCs[0] . "' class='Button_upFAC' onclick='openForm_uppAC(this.id)'>Обновить</button></th>";
        $display_string .= "<th><button id ='iButton_delFAC_" . $ArendCs[0] . "' class='Button_delFAC' onclick='openForm_delAC(this.id)'>Удалить</button></th>";
        $display_string .= "</tr>";
    }
    /*
    $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
    echo json_encode(['ArendC' => $rows], 200);
    */
    $display_string .= "</table>";
    $display_string .= "</div>";
    echo $display_string;
    return 0;
}

//Creating new users
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id_up'])) {
        if(!empty($_POST['id_up'])){
        $id = $_POST['id_up'];
        $result = $mysqli->query("SELECT * FROM ArendCar where id_arend_c = $id");
        $row = mysqli_fetch_array($result);
        $marka = $row[1];
        $time_arend = $row[2];
        $price_arend = $row[3];
        //$paddress = isset($_POST['marka']) ? $_POST['marka'] : $marka;
        if (!empty($_POST['marka'])) {
            $pmarka = $_POST['marka'];
            //echo('ДА');
        } else {
            $pmarka = $marka;
            //echo('НЕ');
        }
        //$pnumber  = isset($_POST['time_arend']) ? $_POST['time_arend'] : $time_arend;
        if (!empty($_POST['time_arend'])) {
            $ptime_arend = $_POST['time_arend'];
        } else {
            $ptime_arend = $time_arend;
        }
        //$pname = isset($_POST['price_arend']) ? $_POST['price_arend'] : $price_arend;
        if (!empty($_POST['price_arend'])) {
            $pprice_arend = $_POST['price_arend'];
        } else {
            $pprice_arend = $price_arend;
        }
       
        $result = $mysqli->query("UPDATE ArendCar SET `marka`='$pmarka',`time_arend`='$ptime_arend',`price_arend`='$pprice_arend' WHERE id_arend_c = $id");
        $result = $mysqli->query("SELECT `id_arend_c`, `marka`, `time_arend`, `price_arend` FROM ArendCar where  id_arend_c = $id");
        $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
        //echo json_encode(['ArendC' => $rows], 200);
    }
    } else if (isset($_POST['marka'], $_POST['time_arend'], $_POST['price_arend'])) {
        $marka = $_POST['marka'];
        $time_arend = $_POST['time_arend'];
        $price_arend = $_POST['price_arend'];
        $result = $mysqli->query("INSERT INTO ArendCar (`marka`, `time_arend`, `price_arend`) VALUES ('$marka', '$time_arend', '$price_arend')");
        //echo json_encode(['message' => 'added client: ' . $mysqli->insert_id], 200);
    } else {
        //echo json_encode(['message' => 'Error: all fields needed'], 400);
    }
    header("Location: http://localhost:8000/home_page.html");
    return 0;
}

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    if (isset($_POST['id_up'])) {
        $id = $_POST['id_up'];
        $result = $mysqli->query("SELECT * FROM ArendCar where id_arend_c = $id");
        $row = mysqli_fetch_array($result);
        $marka = $row[1];
        $time_arend = $row[2];
        $price_arend = $row[3];
        $paddress = isset($_POST['marka']) ? $_POST['marka'] : $marka;
        $pnumber  = isset($_POST['number ']) ? $_POST['number '] : $number ;
        $pname = isset($_POST['name']) ? $_POST['name'] : $name;
        $pdocuments = isset($_POST['documents']) ? $_POST['documents'] : $documents;
        $pcar_rights = isset($_POST['car_rights']) ? $_POST['car_rights'] : $car_rights;
        $result = $mysqli->query("UPDATE clients SET `address`='$paddress',`number`='$pnumber',`name`='$pname', `documents`='$pdocuments', `car_rights`='$pcar_rights' WHERE id_client = $id");
        /*
        echo json_encode(['message' => 'updated client: ' . $id], 200);
    } else {
        echo json_encode(['message' => 'Error: id is needed'], 400);
        */
    }
    //header('Location: ../../index.html');
    return 0;
}

//Deleting users
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    if (isset($_GET['id'])) {
        if($mysqli->query("DELETE FROM ArendCar WHERE id_arend_c = {$_GET['id']}") === TRUE) {
            //echo json_encode(['message' => 'deleted: ' . $_GET['id']], 200); 
        }
        else { 
            //echo "Error deleting record: " . $mysqli->error; 
        }
    } else {
        //echo json_encode(['message' => 'Error: id is needed'], 400);
    }
    header("Location: http://localhost:8000/home_page.html");
    echo('ДА');
    return 0;
}