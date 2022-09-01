 <?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$mysqli = new mysqli("localhost","root","","login_rest_api");

// Check connection
if ($mysqli -> connect_errno) {
  echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
  exit();
}else{
   // echo "Connection Success";
}




// $email='warsonosigit9@gmail.com';
// $password=md5('rt2rw2ozil');

 $json = file_get_contents('php://input');
 
 // decoding the received JSON and store into $obj variable.
 $obj = json_decode($json,true);

$email=$obj['username'];
$password=md5($obj['password']);

$sql="SELECT * FROM users WHERE email='$email' AND password='$password'"; //echo $sql;
$res=mysqli_query($mysqli, $sql);
$jum=mysqli_fetch_row($res);


$sql1="SELECT * FROM users WHERE email='$email' AND password='$password'"; //echo $sql;
$res1=mysqli_query($mysqli, $sql1);
$row1=mysqli_fetch_array($res1);
//echo $row1['lname'];






 function get_token($panjang){
  $token = array(
   range(1,100),
   range('a','z'),
   range('A','Z')
  );

  $karakter = array();
  foreach($token as $key=>$val){
   foreach($val as $k=>$v){
    $karakter[] = $v;
   }
  }

  $token = null;
  for($i=1; $i<=$panjang; $i++){
   // mengambil array secara acak
   $token .= $karakter[rand($i, count($karakter) - 1)];
  }

  return $token;
 }


if($jum>0){

         $json_response = array(

       'status' => 'ok',
       'message' =>'Logged in',
       'accessToken'=> get_token(100),
    );
    
    $json_response['user'] = array(
                'id' => $row1['id'],
                'fname' => $row1['fname'],
                'lname' => $row1['lname'],
                'username' => $row1['username'],
                'email' => $row1['email'],
                'avatar' => 'https://www.mecallapi.com/users/1.png',
            );

    
}else{

      $json_response = array(

       'status' => 'error',
       'message' =>'Login failed',
    ); 

}


    echo json_encode($json_response, JSON_PRETTY_PRINT);
?>