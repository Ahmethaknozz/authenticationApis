<?php 


require_once('db_helper.php');

$response = array();

$data = json_decode(file_get_contents('php://input'), true); //Json post edilen veriler listesi

if(isset($data['name'],$data['username'], $data['password']) && !empty($data['name'])  && !empty($data['username']) && !empty($data['password'])){

try {
  $conn = new PDO("mysql:host=".SERVER_NAME.";dbname=".DB_NAME, USERNAME, PASSWORD);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


  $user = $conn->query("SELECT * FROM users WHERE username='".$data['username']."' LIMIT 1")->fetch(); 

 
  if(isset($user['id']) && !empty($user['id'])){
    $response['status'] = '0';
    $response['error'] = 'Bu kullanıcı adı zaten alınmış.';
  }else{
      
    $sql = "INSERT INTO users (name, username, password)
    VALUES ('".$data['name']."', '".$data['username']."', '".$data['password']."')";
    $conn->exec($sql);

    $response['status'] = '1';
    $response['error'] = null;

  }


} catch(PDOException $e) {
  $response['status'] = '0';
  $response['error'] = $e->getMessage();
}
}else{
  $response['status'] = '0';
  $response['error'] = 'Geçersiz veri!';
}

echo json_encode($response);
?>