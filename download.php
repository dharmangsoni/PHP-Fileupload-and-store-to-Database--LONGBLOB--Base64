<?php
/*
 * 
 * download.php
 *
 * file to download by decoding base64 converted file content
 *
 *
 */

// Storing Database Information
$dbConfig = array("server" => "localhost", "user" => "root", "password" => "");

// Connecting to database server
$connection = mysql_connect($dbConfig["server"], $dbConfig["user"], $dbConfig["password"]);

// selecting database
mysql_select_db("dbfileupload", $connection);

if (!isset($_GET['id'])) {
  header("Location: index.php");
}
$sql = "select * from tbluploadedfiles where id = " . $_GET['id'];

$ref = mysql_query($sql);
if ($ref) {
	$result = mysql_fetch_object($ref);
	if ($result) {
		header("Content-type:$result->filetype");
		header("Content-Length: $result->filesize");
		header("Content-Disposition: attachment; filename=$result->filename");
		header('Pragma: no-cache');
		header('Expires: 0');
		echo base64_decode($result -> filecontent);
		die ;
	}
}
header("Location : index.php");
?>
