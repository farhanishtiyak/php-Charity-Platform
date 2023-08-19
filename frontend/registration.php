<?php 

    include "inc/header.php"; 
    ob_start();
    if(!empty($_SESSION['loginEmail'])){
        header('Location: index.php');
    }

?>


<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Define database connection constants
    define('DB_HOST', 'localhost');
    define('DB_USERNAME', 'root');
    define('DB_PASSWORD', '');
    define('DB_NAME', 'charity');

    // Initialize variables
    $name = $email = $phone = $password = '';

    // Function to sanitize and validate input data
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    // Validate and sanitize input data
    $name = test_input($_POST['name']);
    $email = test_input($_POST['email']);
    $phone = test_input($_POST['phone']);
    $password = test_input($_POST['password']);
    $cpassword = test_input($_POST['cpassword']);

    // Create a new database connection
    $conn = mysqli_connect('localhost', 'root', '', 'charity');

    // Check if the connection was successful
    if (!$conn) {
        die('Database connection failed: ' . mysqli_connect_error());
    }

    if($password==$cpassword){
        // Prepare the SQL statement to insert data into the table
        $hashPassword = sha1($password);
        $sql = "INSERT INTO users (name, email, phone, password) 
        VALUES ('$name', '$email', '$phone', '$hashPassword')";

        // Execute the SQL statement
        if (mysqli_query($conn, $sql)) {
            echo 'Sign Up successful!';
            header('location: login.php');
        } else {
            echo 'Error: ' . $sql . '<br>' . mysqli_error($conn);
        }
    }

    // Close the database connection
    mysqli_close($conn);
}
?>

<head>
    <!-- volunteer css -->

    <link rel="stylesheet" type="text/css" href="css/volunteer.css">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

</head>


<body>
    <div class="container mt-5 card p-5" style="-webkit-box-shadow: 1px 0px 20px 1px rgba(0,0,0,0.81);
-moz-box-shadow: 1px 0px 20px 1px rgba(0,0,0,0.81);
box-shadow: 1px 0px 20px 1px rgba(0,0,0,0.81);">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <h2 class="text-center mb-4">Sign Up</h2>
                <form method="POST">

                    <div class="form-group">
                        <label for="name">Full Name:</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>


                    <div class="form-group">
                        <label for="email">Email Address:</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>


                    <div class="form-group">
                        <label for="phone">Phone Number:</label>
                        <input type="tel" class="form-control" id="phone" name="phone" required>
                    </div>

                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>

                    <div class="form-group">
                        <label for="cpassword">Confirm Password:</label>
                        <input type="password" class="form-control" id="cpassword" name="cpassword" required>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block mt-4">Submit</button>
                </form>
                <p class="login-wrapper-footer-text mt-3">Already have an account? <a href="login.php"
                        class="text-reset"><strong style="font-weight:700">Login here</strong></a></p>
            </div>
        </div>
    </div>

    <?php ob_end_flush(); ?>
</body>

<?php include "inc/footer.php"; ?>