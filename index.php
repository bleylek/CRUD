<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <style>
        .navbar-custom {
            background-color: green; 
        }
        .navbar-custom .navbar-brand {
            color: white; /* Text color for the brand name */
            margin: auto; /* Centers the brand name horizontally */
            font-weight: bold; /* Makes the brand name text bold */
        }
    </style>
</head>
<body>
    <!-- Navigation bar section -->
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container-fluid">
            <!-- Navbar brand name -->
            <a class="navbar-brand" href="#">CRUD</a>
        </div>
    </nav>

    <!-- Main content container -->
    <div class="container my-5">
        <h2>Users</h2>
        <!-- Button to add a new user -->
        <a class="btn btn-primary" href="/crud/create.php" role="button">Add User</a>
        <br> <br>
        <!-- Table to display user data -->
        <table class="table">
            <thead>
                <tr>
                    <!-- Table headers -->
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Created At</th>
                    <th>Operation</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // PHP code to connect to the database
                $servername = "localhost";
                $username = "root";
                $password = "";
                $database = "crud";

                // Create connection
                $connection = new mysqli($servername, $username, $password, $database);

                // Check connection
                if($connection->connect_error) {
                    die("Connection failed: " . $connection->connect_error);
                }

                // Read all rows from database table
                // Prepare a SQL statement as a string to select all records from 'crud_table'
                $sql = "SELECT * FROM crud_table";

                // Execute the SQL query against the database
                $result = $connection->query($sql);

                // Check if the query was successful
                if(!$result) {
                    // If the query failed, terminate the script and display an error message
                    die("Invalid query: " . $connection->error);
                }

                // If the query was successful, fetch each row of the result set as an associative array
                // 'fetch_assoc()' retrieves the next row from the result set and returns it as an associative array
                while($row = $result->fetch_assoc()){
                    // The echo statement below outputs a table row with data from the current row of the result set
                    // Each column value in the row is accessed using the column name as a key in the associative array (e.g., $row['id'], $row['name'])
                    // The curly braces {} around array keys are used for complex variable parsing in strings
                    // This loop will continue until all rows in the result set have been fetched

                    echo "
                    <tr>
                        <!-- Data cells for each user -->
                        <td>{$row['id']}</td>
                        <td>{$row['name']}</td>
                        <td>{$row['email']}</td>
                        <td>{$row['phone']}</td>
                        <td>{$row['address']}</td>
                        <td>{$row['created_at']}</td>
                        <td>
                            <!-- Update and Delete buttons for each user -->
                            <a class='btn btn-primary btn-sm' href='/crud/update.php?id={$row['id']}'>Update</a> 
                            <a class='btn btn-danger btn-sm' href='/crud/delete.php?id={$row['id']}'>Delete</a>
                        </td>
                    </tr>
                    ";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
