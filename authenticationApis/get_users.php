<?php 

require_once('db_helper.php');

header('Content-Type: application/json; charset=utf-8');

$response = array();

try {
  $conn = new PDO("mysql:host=".SERVER_NAME.";dbname=".DB_NAME, USERNAME, PASSWORD);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $response['users'] = array();

  $users = $conn->query("SELECT * FROM users ORDER BY name,username ASC")->fetchAll(PDO::FETCH_ASSOC); 

    foreach($users as $user){
        array_push($response['users'], $user);
    }

    $response['status'] = '1';
 


} catch(PDOException $e) {
    $response['status'] = '0';
    $response['error'] = $e->getMessage();

}

echo json_encode($response);

?>