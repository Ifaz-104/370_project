<?php
    include("db_connect.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<h2>Please enter the necessary information to log in</h2>
    <form action="login.php" method="post">
        
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br><br>

        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br><br>

        <button type="submit">Submit</button>
    </form>
</body>
</html>
<?php

    if (isset($_POST['email'], $_POST['password'])) {
        // Retrieve form inputs
        $email = $_POST['email'];
        $password = $_POST['password'];

        $sql = "SELECT * FROM customer WHERE email = '$email' AND password = '$password'";
        $result = mysqli_query($conn, $sql);

        if ($result && mysqli_num_rows($result) > 0) {

            session_start();
            $row = mysqli_fetch_assoc($result);
            $customerid = $row['id'];
            $_SESSION['customerid'] = $customerid;
            
            echo "Login successful! Welcome, " . $email;
            header('Location: order.php');
        } else {
            echo "Invalid email or password. Please try again.";
        }
    } 
    else {
        echo "Please provide both email and password.";
    }
?>