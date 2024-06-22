<?php

/*** begin the session ***/
include
    session_start();

if (!isset($_SESSION['username'])) {
    $message = header("Location: http://localhost:8888/web-pengajuan-santunan/home.php");
} else {
    try {
        /*** connect to database ***/
        /*** mysql hostname ***/
        $mysql_hostname = 'localhost';

        /*** mysql username ***/
        $mysql_username = 'root';

        /*** mysql password ***/
        $mysql_password = 'root';

        /*** database name ***/
        $mysql_dbname = 'pengajuan_santunan';


        /*** select the users name from the database ***/
        $dbh = new PDO("mysql:host=$mysql_hostname;dbname=$mysql_dbname", $mysql_username, $mysql_password);
        /*** $message = a message saying we have connected ***/

        /*** set the error mode to excptions ***/
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        /*** prepare the insert ***/
        $stmt = $dbh->prepare("SELECT nomor_unik, role FROM users WHERE nomor_unik = :username");

        /*** bind the parameters ***/
        $stmt->bindParam(':username', $_SESSION['username'], PDO::PARAM_INT);

        /*** execute the prepared statement ***/
        $stmt->execute();

        /*** check for a result ***/
        $phpro_username = $stmt->fetchColumn();

        /*** if we have no something is wrong ***/
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if ($row['role'] == 0) {
                $massage = 'Welcome ,' . $row['username'];
            } else {
                $massage = 'Not authorized';
            }
        } else {
            $massage = 'Access Error';
        }
    } catch (Exception $e) {
        /*** if we are here, something is wrong in the database ***/
        $message = 'We are unable to process your request. Please try again later"';
    }
}

?>