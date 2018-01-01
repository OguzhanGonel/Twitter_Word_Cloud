<?php


$host = "cs.utm.utoronto.ca";
$dbname="gonelogu";
$user="gonelogu";
$password="2621700";


// Connecting, selecting database
$dbconn = pg_connect("host=$host dbname=$dbname user=$user password=$password")
    or die('Could not connect: ' . pg_last_error());



$username1 = $_POST["name"];
$username1 = strtolower($username1);
$password1 = $_POST["password"];
$password2 = $_POST["re-confirm"];





// I check if all fields have been covered
if ($username1&&$password1&&$password2){
		
		// I create a boolean value
		$boolValue = True;
		// I check if the first character is a alphabetical character
		if (!(ctype_alnum($username1[0]))){
			echo "Please start with an alphabetical character";
		}
		else{

			$i = 0;
			while ($boolValue and ($i < strlen($username1))){
				
				// I create uservar variable which is equal to username1 at index value
				$uservar = $username1[$i];
				// if the current value is not _
				if (!(stristr($uservar, '_'))){
					echo $uservar;
					// I check if it is an alphabetical character
					if (ctype_alnum($uservar)){
					$i++;
					}
					// if it is not, I exit
					else{
						$boolValue= False;
						break;
					}
				} 

				// if the current variable is a _
				elseif (stristr($uservar, '_')){
					$i++;
				}

				// they put wrong character, may not need this else actually
				else{
					echo "Please put proper characters";
					$boolValue= False;
					break;
				}
			}

			// I execute the below if only boolValue is True
			if ($boolValue){

				// I check if the two passwords are equal
				if ($password1 != $password2){
						echo "passwords do not match";
					}
			
				else{
						// I check if the password is less than 6 characters
						if (strlen($password1) < 6){
							echo "password too short";
						}
						// So right now everything is good so far
						else{
						

							$array1 = array($username1);


							// I do the query below to see if the username is taken or not
							$result = pg_prepare($dbconn, "my_query1", 'SELECT * FROM userAccounts where userid = $1');

							$result = pg_execute($dbconn, "my_query1", $array1);



							// I check if the username is taken or not
							if ($result){
							$arr = pg_fetch_all($result);
							$rows = pg_num_rows($result);
						
								if ($rows!=0){
									echo "Username already taken";
								}
								// Here I check if the file size is too big
								elseif ($_FILES['userfile']['size'] > 50000) {
    								echo "Sorry, your file is too large.";
	   
								}
								// Username is not taken, and file size is ok, so I can now register it
								else{

									if(!isset($_FILES['userfile']) || $_FILES['userfile']['error'] == UPLOAD_ERR_NO_FILE) {
									//if(!isset($_FILES['userfile']['error']) || is_array($_FILES['userfile']['error'])){
										echo "Heyy";
										$imgName = "default.jpg";
										$hash = openssl_encrypt	 ($password1, "AES-128-ECB", $username1);
										
										

										$array2 = array($username1, $hash, $imgName);




										$sql1 = "INSERT INTO userAccounts VALUES($1, $2, $3)";
										$result23 = pg_prepare($dbconn, "insert_user", $sql1);
										$result1234 = pg_execute($dbconn, "insert_user", $array2); 
										echo "Account created with a default profile picture";
										
									}

									else {
										
										$hash = openssl_encrypt	 ($password1, "AES-128-ECB", $username1);
										$uploaddir = '/student/gonelogu/www/CSC3092/images1/';
										
										$imgName = $username1 . basename($_FILES['userfile']['name']);

										$array2 = array($username1, $hash, $imgName);




										$sql1 = "INSERT INTO userAccounts VALUES($1, $2, $3)";
										$result23 = pg_prepare($dbconn, "insert_user", $sql1);
										$result1234 = pg_execute($dbconn, "insert_user", $array2); 
										echo "DONEEE";
										$uploadfile = $uploaddir . $imgName;
										
										
										echo '<pre>';
										if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
										    echo "File is valid, and was successfully uploaded.\n";
										    echo 
										    chmod("$uploadfile", 0644);
										} else {
										    echo "Possible file upload attack!\n";
										}

										echo 'Here is some more debugging info:';
										print_r($_FILES);




									}

									
							}
						}
							else{
								echo "Query failed";
							}
						}
					}
				}
			else{
				echo "newly put in";
			}
		}
	}
	else{
		echo "Fill in all fields please";
	}






// Free resultset
pg_free_result($result);

// Closing connection
pg_close($dbconn);
?>