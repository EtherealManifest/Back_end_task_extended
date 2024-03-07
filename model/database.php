<!--Connect to the Database and create the variable to sustain the connection-->
<?php
#Data Source Name
$dsn = 'mysql:host=localhost;dbname=todolist';
$username = 'root';
#$password = 'X9df4L9pS';

try{
    $db = new PDO($dsn, $username);
} catch(PDOException $e) {
    $error = "Database Error: ";
    $error .= $e->getMessage();
    #add the code from view/error, and pass in the value above, to show an error screen
    include('view/error.php');
    exit();
}

?>