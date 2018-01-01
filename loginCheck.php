<?php
// Connecting, selecting database
$dbconn = pg_connect("host=127.0.0.1 dbname=gonelogu user=gonelogu password=2621700")
    or die('Could not connect: ' . pg_last_error());


$username1 = $_POST["username"];
$username1 = strtolower($username1);
$password1 = $_POST["password"];




$array1 = array($username1);


// Performing SQL query
$result = pg_prepare($dbconn, "my_query", 'SELECT * FROM userAccounts where userid = $1');

$result = pg_execute($dbconn, "my_query", $array1);




if ($result){
  $hashed_password = crypt($password1);
	$arr = pg_fetch_all($result);
	$rows = pg_num_rows($result);
	$rowForPW = pg_fetch_assoc($result);
  	
  $toDecrypt = $rowForPW[userpw];
  $hash2 = openssl_encrypt  ($password1, "AES-128-ECB", $username1);
  
  $imageRow = $rowForPW[userimage];
  echo $imageRow;
  
  
	
  //if ($rows!=0 and ($decryptedPW == $password1)){
  if ($rows!=0 and ($toDecrypt == $hash2)){
		echo "Successfully logged in";
		echo '<img src="images1/'.$imageRow.'" id="aaa"/>';
		
		//echo '<img src="images1/"'.$imageRow.' id="aaa"/>';
	}
	else{
		die("Wrong user information");
	}
}



// Free resultset
pg_free_result($result);

// Closing connection
pg_close($dbconn);
?>

</body>
</html>