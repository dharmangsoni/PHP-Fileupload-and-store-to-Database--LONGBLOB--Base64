CREATE TABLE `tbluploadedfiles` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `filename` varchar(50) NOT NULL,
 `filetype` varchar(50) NOT NULL,
 `filesize` int(11) NOT NULL,
 `filecontent` longblob NOT NULL,
 `uploaded_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1
