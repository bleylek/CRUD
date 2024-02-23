<?php

// The $_GET superglobal array in PHP is used to collect data sent in the URL's query string.
// Here, we're checking if the 'id' key is set in the URL query string.
// For example, in the URL 'delete.php?id=123', 'id' is a parameter in the query string.
// The isset() function checks whether the 'id' parameter exists and has a value.
if (isset($_GET['id'])) {
    // If 'id' is set, the script continues here.
    // We then retrieve the value associated with 'id' from the query string and store it in the $id variable.
    // The $_GET['id'] accesses the value of the 'id' parameter from the URL query string.
    // It's important to ensure the 'id' parameter exists because we use it to specify which database record to delete.
    // Not checking for 'id' could lead to unpredictable behavior or errors since the deletion query requires a specific 'id'.
    $id = $_GET["id"];

    
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "crud";

    // Attempt to establish a new connection to the MySQL database using the mysqli class.
    $connection = new mysqli($servername, $username, $password, $database);

    // Prepare the SQL statement to delete the record with the specified ID.
    // The DELETE statement removes a record from the 'crud_table' where the column 'id' matches the $id variable.
    $sql = "DELETE FROM crud_table WHERE id=$id";
    // Execute the SQL query against the database.
    $connection->query($sql);

    // After executing the query, we check if there was an error with the connection object.
    // If there was an error during the query execution, the connection's error property will be set.
    if($connection->error) {
        // If an error is present, we terminate the script and return an error message.
        // It's essential to stop the script if there's a database error to prevent further incorrect operations.
        die("Error deleting user: " . $connection->error);
    }
}

// Redirect the client to the main index page after the delete operation or if 'id' was not set in the query string.
// The header() function sends a raw HTTP header to the client.
// We use the 'Location' header to redirect the browser to a different page.
header("location: /crud/index.php");
// The exit statement terminates the execution of the script.
// It's used here to ensure that the redirection occurs immediately and no further code is executed.
exit;

?>
