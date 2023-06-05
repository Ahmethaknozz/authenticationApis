<?php 

require_once('db_helper.php');

$data = json_decode(file_get_contents('php://input'), true); //Json post edilen veriler listesi

if(isset($data['user_id'],$data['name'],$data['username'], $data['password']) && !empty($data['user_id']) && !empty($data['name'])  && !empty($data['username']) && !empty($data['password'])){


try {
  $conn = new PDO("mysql:host=".SERVER_NAME.";dbname=".DB_NAME, USERNAME, PASSWORD);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


  $sql = "UPDATE users SET name='".$data['name']."', username='".$data['username']."', password='".$data['password']."' WHERE id='".$data['user_id']."'";
  $conn->exec($sql);

  $response['status'] = '1';
  $response['error'] = null;


}  catch(PDOException $e) {
  $response['status'] = '0';
  $response['error'] = $e->getMessage();
}
}else{
  $response['status'] = '0';
  $response['error'] = 'Geçersiz veri!';
}

echo json_encode($response);

?>