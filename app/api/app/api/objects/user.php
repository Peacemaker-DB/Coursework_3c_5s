<?php
class User{
    private $conn;
    private $table_name = "users";
    public $id;
    public $firstname;
    public $lastname;
    public $email;
    public $role;
    public $password;
    public $corp_password = "0";
    public function __construct($db){
        $this->conn = $db;
    }
function create(){
    $query = "INSERT INTO " . $this->table_name . "
            SET
                firstname = :firstname,
                lastname = :lastname,
                email = :email,
                role = :role,
                password = :password
                ";
    $stmt = $this->conn->prepare($query);
    $this->firstname=htmlspecialchars(strip_tags($this->firstname));
    $this->lastname=htmlspecialchars(strip_tags($this->lastname));
    $this->email=htmlspecialchars(strip_tags($this->email));
    $this->role = $this->role ? htmlspecialchars(strip_tags($this->role)) : 3;
    $this->password=htmlspecialchars(strip_tags($this->password));
    $this->corp_password =htmlspecialchars(strip_tags($this->corp_password));
    $stmt->bindParam(':firstname', $this->firstname);
    $stmt->bindParam(':lastname', $this->lastname);
    $stmt->bindParam(':email', $this->email);
    $dbh = new PDO("mysql:host=" . "mysql" . ";dbname=" . "corp", "user", "password");
    $adminP = $dbh->prepare("SELECT `password` FROM corp_password WHERE id = 1");
    $workerP = $dbh->prepare("SELECT `password` FROM corp_password WHERE id = 2");
    $adminP->execute();
    $workerP->execute();
    $PassA = $adminP->fetch(PDO::FETCH_ASSOC);
    $PassW = $workerP->fetch(PDO::FETCH_ASSOC);
    if ($PassA['password'] == $this->corp_password) {
        $roleValue = 1;
        $stmt->bindParam(':role', $roleValue);
    } else if($PassW['password'] == $this->corp_password){
        $roleValue = 2;
        $stmt->bindParam(':role', $roleValue);
    } else {
        $roleValue = 3;
        $stmt->bindParam(':role', $roleValue);
    }
    $password_hash = password_hash($this->password, PASSWORD_BCRYPT);
    $stmt->bindParam(':password', $password_hash);
    if($stmt->execute()){
        return true;
    }
    return false;
}
function emailExists(){
    $query = "SELECT id, firstname, lastname, role, password
            FROM " . $this->table_name . "
            WHERE email = ?
            LIMIT 0,1";
    $stmt = $this->conn->prepare( $query );
    $this->email=htmlspecialchars(strip_tags($this->email));
    $stmt->bindParam(1, $this->email);
    $stmt->execute();
    $num = $stmt->rowCount();
    if($num>0){
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->id = $row['id'];
        $this->firstname = $row['firstname'];
        $this->lastname = $row['lastname'];
        $this->role = $row['role'];
        $this->password = $row['password'];
        return true;
    }
    return false;
}
public function update(){
    $password_set=!empty($this->password) ? ", password = :password" : "";
    $query = "UPDATE " . $this->table_name . "
            SET
                firstname = :firstname,
                lastname = :lastname,
                email = :email
                role = :role
                {$password_set}
            WHERE id = :id";
    $stmt = $this->conn->prepare($query);
    $this->firstname=htmlspecialchars(strip_tags($this->firstname));
    $this->lastname=htmlspecialchars(strip_tags($this->lastname));
    $this->email=htmlspecialchars(strip_tags($this->email));
    $this->role=htmlspecialchars(strip_tags($this->role));
    $this->corp_password=htmlspecialchars(strip_tags($this->corp_password));
    $stmt->bindParam(':firstname', $this->firstname);
    $stmt->bindParam(':lastname', $this->lastname);
    $stmt->bindParam(':email', $this->email);
    $dbh = new PDO("mysql:host=" . "mysql" . ";dbname=" . "corp_password", "user", "password");
    $adminP = $dbh->prepare("SELECT `password` FROM cop_password WHERE id = 1");
    $workerP = $dbh->prepare("SELECT `password` FROM cop_password WHERE id = 2");
    $adminP->execute();
    $workerP->execute();
    $PassA = $adminP->fetch(PDO::FETCH_ASSOC);
    $PassW = $workerP->fetch(PDO::FETCH_ASSOC);
    if ($PassA['password'] == $this->corp_password) {
        $roleValue = 1;
        $stmt->bindParam(':role', $roleValue);
    } else if($PassW['password'] == $this->corp_password){
        $roleValue = 2;
        $stmt->bindParam(':role', $roleValue);
    } else {
        $roleValue = 3;
        $stmt->bindParam(':role', $roleValue);
    }
    if(!empty($this->password)){
        $this->password=htmlspecialchars(strip_tags($this->password));
        $password_hash = password_hash($this->password, PASSWORD_BCRYPT);
        $stmt->bindParam(':password', $password_hash);
    }
    $stmt->bindParam(':id', $this->id);
    if($stmt->execute()){
        return true;
    }
    return false;
}
}