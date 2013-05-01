<?php
/*
 * 
 * index.php
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

ini_set('mysql.connect_timeout', 300);
ini_set('default_socket_timeout', 300);

// checking file upload (post) request
if (isset($_POST['btnUploadFile'])) {

  $fileName = $_FILES['uploadfile']['name'];
	$uploadDir = "uploadedFiles" . DIRECTORY_SEPARATOR . $fileName;
	$fileType = $_FILES['uploadfile']['type'];
	$tmpName = $_FILES['uploadfile']['tmp_name'];
	$size = $_FILES['uploadfile']['size'];

	if ($size > 0) {
		$file = fopen($tmpName, "r");
		$fileContent = fread($file, $size);
		$contentToStore = base64_encode($fileContent);
		$values = array("filename" => mysql_real_escape_string($fileName), "filetype" => mysql_real_escape_string($fileType), "filesize" => mysql_real_escape_string($size), "filecontent" => mysql_real_escape_string($contentToStore));
		$sql = "INSERT INTO tbluploadedfiles (filename, filetype, filesize, filecontent) VALUES ('" . implode("','", array_values($values)) . "')";
		if (!@mysql_query($sql)) {
			echo mysql_error();
			die("<br>Unable to store information : " . mysql_errno());
		} else {
			echo "File Uploaded to database successfully";
		}

	}
}
?>
<!DOCTYPE  HTML PUBLIC "-//IETF//DTD HTML//EN">
<html>
	<head>
		<title>Upload File to Database with base64 using PHP</title>
		<style type="text/css">
			html {
				background: #ccc;
			}
			body {
				background: #fff;
				moz-border-radius: 10px;
				-webkit-border-radius: 10px;
				border-radius: 10px;
				box-shadow: 2px 2px 9px #414141;
				font-family: Verdana;
				width: 900px;
				padding: 30px;
				text-align: center;
				margin: 50px auto;
			}

		</style>
	</head>
	<body>
		<h2>Upload Any File with PHP and store it to Database after convert to Base64</h2>
		<br/>
		<form action="index.php" method="post" enctype="multipart/form-data">

			<label>Select File :</label>
			<input type="file" name="uploadfile"/>
			<input type="submit" value="Upload File" name="btnUploadFile"/>
		</form>
		<br/>
		<table border="1" width="100%" cellpadding="8" cellspacing="0">
			<tr>
				<th>File Name</th>
				<th>Content Type</th>
				<th>File Size</th>
				<th>Donwload</th>
			</tr>
			<?php
					$sql = "select id, filename, filetype, filesize from tbluploadedfiles order by id desc";
					$ref = mysql_query(($sql));
					while($result = mysql_fetch_object($ref)):
						?>
						<tr>
							<td><?php echo $result -> filename; ?></td>
							<td><?php echo $result -> filetype; ?></td>
							<td width="100px"><?php 
							$size = floor(($result->filesize/1024));
							if($size>1024){
								echo floor(($size/1024)), " MB";
							}else{
								echo $size , " KB";
							}
							?> 
							</td>
							<td><a href="download.php?id=<?php echo $result -> id; ?>">Download</a></td>
						</tr>
						<?php
						endwhile;
			?>
		</table>

	</body>
</html>
