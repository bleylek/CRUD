<?php
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$database = "crud"; 

// Create a connection to the MySQL database
$connection = new mysqli($servername, $username, $password, $database);

// Initialize variables to hold user input values. Initially set to empty.
$name = "";
$email = "";
$phone = "";
$address = "";

// Initialize variables to hold error and success messages
$errorMessage = "";
$successMessage = "";

// Check if the form was submitted using the POST method
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve user input from the form
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $address = $_POST["address"];

    // Use a do-while loop to attempt form processing and easily break on errors
    do {
        // Check if any form field is empty and set an error message
        if (empty($name) || empty($email) || empty($phone) || empty($address)) {
            $errorMessage = "All fields are required.";
            break; // Exit the loop if any field is empty
        }

        // Check if the email address already exists in the database
        $stmt = $connection->prepare("SELECT * FROM crud_table WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $errorMessage = "The email address is already in use.";
            break; // Exit the loop if email exists
        }

        // Prepare an SQL statement to insert the new user data into the database
        if ($stmt = $connection->prepare("INSERT INTO crud_table (name, email, phone, address) VALUES (?, ?, ?, ?)")) {
            // Bind the user input to the prepared statement
            $stmt->bind_param("ssss", $name, $email, $phone, $address);
            $stmt->execute(); // Execute the prepared statement

            // Check if the user was successfully added to the database
            if ($stmt->affected_rows > 0) {
                $successMessage = "User added successfully.";
                // Clear the input fields to prevent resubmission
                $name = $email = $phone = $address = "";
                // Redirect to a confirmation page or another desired location
                header("Location: /crud/index.php");
                exit; // Ensure no further code is executed after redirection
            } else {
                $errorMessage = "There was a problem adding the user.";
            }

            // Close the prepared statement
            $stmt->close();
        } else {
            $errorMessage = "Could not prepare SQL statement.";
        }
    } while (false); // End of do-while loop
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create User - CRUD</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        .navbar-custom {
            background-color: green; /* Customizes the navbar background color */
        }
        .navbar-custom .navbar-brand {
            color: white; /* Changes the brand text color */
            margin: auto; /* Centers the navbar brand */
            font-weight: bold; /* Makes the brand text bold */
        }
    </style>
</head>
<body>
    <!-- Navbar section -->
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">CRUD Application</a>
        </div>
    </nav>

    <!-- Main content section -->
    <div class="container my-5">
        <h2>Add New User</h2>

        <!-- Display error message if any -->
        <?php if (!empty($errorMessage)) : ?>
            <div class='alert alert-warning alert-dismissible fade show' role='alert'>
                <strong><?php echo $errorMessage; ?></strong>
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>
        <?php endif; ?>

        <!-- User input form -->
        <form method="POST">
            <!-- Input field for name -->
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Name</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="name" value="<?php echo htmlspecialchars($name); ?>">
                </div>
            </div>

            <!-- Input field for email -->
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Email</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="email" value="<?php echo htmlspecialchars($email); ?>">
                </div>
            </div>

            <!-- Input field for phone -->
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Phone</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="phone" value="<?php echo htmlspecialchars($phone); ?>">
                </div>
            </div>

            <!-- Input field for address -->
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Address</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="address" value="<?php echo htmlspecialchars($address); ?>">
                </div>
            </div>

            <!-- Display success message if any -->
            <?php if (!empty($successMessage)) : ?>
                <div class='alert alert-success alert-dismissible fade show' role='alert'>
                    <strong><?php echo $successMessage; ?></strong>
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>
            <?php endif; ?>

            <!-- Form submission buttons -->
            <div class="row mb-3">
                <div class="col-sm-6 offset-sm-3 d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="submit" class="btn btn-outline-primary me-md-2">Submit</button>
                    <a class="btn btn-outline-primary" href="/crud/index.php" role="button">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
