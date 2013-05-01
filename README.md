PHP Fileupload and store to MySQL Database using LONGBLOB data type and converted to Base64
===========================================================================================

Required Settings for Upload Big size files:

PHP php.ini file Configuration
------------------------------

1. Open php.ini file and search for upload_max_filesize and change its value as per your requiment
2. change max_execution_time to 180
3. change post_max_size 


MySQL my.ini file Configuration
-------------------------------
1. In mysql > my.ini file search for max_allowed_packet and change its value 1M to your requirement
