<?phpextract($_REQUEST); session_start();$db="eeid";$_SESSION[$db]['loginS'] = '';$_SESSION[$db]['tempID'] = '';$_SESSION[$db]['select'] = '';$_SESSION['loginS'] = '';$_SESSION['parkS'] = '';echo "You have successfully logged out of the EEID.";exit;?>