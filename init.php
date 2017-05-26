<?php

include("utils/connect.php");

if ($_GET['confirm'] != 'true')
	exit("Illegal call to this page");

mysql_query("DROP VIEW top_cache") or die(mysql_error());
mysql_query("DROP TABLE post") or die(mysql_error());
mysql_query("DROP TABLE post_reply") or die(mysql_error());
mysql_query("DROP TABLE rule") or die(mysql_error());
mysql_query("DROP TABLE board") or die(mysql_error());	
mysql_query("DROP TABLE user") or die(mysql_error());

mysql_query("CREATE TABLE user (
	user_ID INT NOT NULL AUTO_INCREMENT,
	username VARCHAR(20) NOT NULL,
	password VARCHAR(32) NOT NULL,
	default_permission TINYINT NOT NULL,
	registration_time DATETIME NOT NULL,
	
	UNIQUE(username),
	PRIMARY KEY (user_ID),
	UNIQUE INDEX (username, password)
)") or die(mysql_error());

mysql_query("CREATE TABLE board (
	board_ID TINYINT NOT NULL AUTO_INCREMENT,
	board_name VARCHAR(50) NOT NULL,
	
	UNIQUE(board_name),
	PRIMARY KEY (board_ID)
)")
or die(mysql_error());

mysql_query("CREATE TABLE rule (
	user_ID INT NOT NULL,
	board_ID TINYINT NOT NULL,
	permission TINYINT NOT NULL,
	
	PRIMARY KEY (user_ID, board_ID),
	FOREIGN KEY (user_ID) REFERENCES user(user_ID),
	FOREIGN KEY (board_ID) REFERENCES board(board_ID)
)")
or die(mysql_error());

mysql_query("CREATE TABLE post (
	post_ID INT NOT NULL AUTO_INCREMENT,
	user_ID INT NOT NULL,
	board_ID TINYINT NOT NULL,
	post_name VARCHAR(50),
	create_time DATETIME NOT NULL,
	last_update DATETIME NOT NULL,
	content TEXT NOT NULL,
	
	PRIMARY KEY (post_ID),
	FOREIGN KEY (user_ID) REFERENCES user(user_ID),
	FOREIGN KEY (board_ID) REFERENCES board(board_ID)
)")
or die(mysql_error());

mysql_query("CREATE TABLE post_reply (
	reply_ID INT NOT NULL AUTO_INCREMENT,
	user_ID INT NOT NULL,
	post_ID INT NOT NULL,
	create_time DATETIME NOT NULL,
	content TEXT NOT NULL,
	
	PRIMARY KEY (reply_ID),
	FOREIGN KEY (post_ID) REFERENCES post(post_ID)
)")
or die(mysql_error());

mysql_query("CREATE VIEW top_cache (post_ID, reply_count) AS
SELECT post_ID, count(*) FROM post_reply GROUP BY post_ID LIMIT 10")
or die(mysql_error());
?>

<!DOCTYPE html>
<script>
	alert("Database has been reset.");
</script>
