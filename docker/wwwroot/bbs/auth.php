<?
// login.php   performs validation
// authenticate using form variables

$result = authenticate($_POST[f_user], $_POST[f_pass]);


// if user/pass combination is correct

if ($result[0]) {

    // initiate a session
    session_start();

    // register some session variables
    session_register("SESSION");

    // including the username

    $_SESSION['UNAME'] = $_POST[f_user];
    $_SESSION['REALNAME'] = $result[1];


    // redirect to protected page
    header("Location: bbs.php");
    exit();
} else
    // user/pass check failed
{
    // redirect to error page
    header("Location: login.php?wrong=yes");
    exit();

}

// authenticate username/password against a password file
// returns:  1 if user does not exist
// 0 if user exists but password is incorrect
// 1 if username and password are correct


function authenticate($user, $pass) {

    $data = file("passwd");

    foreach ($data as $line) {
	$arr = explode(":", $line);

	if ($arr[0] == $user) {

	    if ($arr[1] == md5($pass)) {
		$result[0] = true;
		break;
	    } else {
		$result[0] = false;
		break;
	    }


	}

    }

$result[1] = $arr[2];
return $result;

}


?>