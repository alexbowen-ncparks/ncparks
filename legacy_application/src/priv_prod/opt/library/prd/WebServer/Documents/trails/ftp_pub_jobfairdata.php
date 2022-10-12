<?php

//connect and login to FTP server
//$ftp_server = "204.211.255.170";
$sftp_ssh_server = "204.211.255.170";
//$ftp_conn=ftp_connect($ftp_server) or die("Could not connect to $ftp_server");
$sftp_ssh_conn=ssh2_connect($sftp_ssh_server) or die("Could not connect to $sftp_ssh_server!");
//$ftp_username="jgcarter";
$sftp_ssh_username="jgcarter";
//$sftp_ssh_login=ssh2_auth_password($sftp_ssh_conn, 'jgcarter', 'L0g1t3ch!');
//$ftp_userpass="L0g1t3ch!";
$sftp_ssh_userpass="L0g1t3ch!";
//$login=ftp_login($ftp_conn,$ftp_username,$ftp_userpass);
ssh2_auth_password($sftp_ssh_conn,$sftp_ssh_username,$sftp_ssh_userpass);
$sftp=ssh2_sftp($sftp_ssh_conn);

//connection check
//if((!$ftp_conn || !$login))
/*
if ((!$sftp_ssh_conn || !$sftp_ssh_login))
{
	echo "FTP connection has failed!";
	//echo "Attempted to connect to $sftp_server, for user $ftp_username.";
	exit;
}
else
{
	//echo "Connected to $ftp_server, for user $ftp_username.";
	echo "Connected!";
	// to $ftp_server, for user $ftp_username.";
}
*/

//read new files
//$stream=fopen('ssh2.sftp://'.intval($sftp).'/opt/library/WebServer', 'r');
//fclose($stream);

//close ftp connection
//ftp_close($ftp_conn);
ssh2_disconnect($sftp_ssh_conn);



?>