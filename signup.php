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
<h2>Please enter the necessary information to sign up</h2>
    <form action="signup.php" method="post">
        <label for="first_name">First Name:</label><br>
        <input type="text" id="first_name" name="first_name" required><br><br>

        <label for="last_name">Last Name:</label><br>
        <input type="text" id="last_name" name="last_name" required><br><br>

        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br><br>

        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br><br>

        <button type="submit">Submit</button>
    </form>
</body>
</html>

<?php
    if (isset($_POST['first_name'], $_POST['last_name'], $_POST['email'], $_POST['password'])) {
        
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $email = $_POST['email'];
        $password = $_POST['password']; 


        $sql = "INSERT INTO customer (first_name, last_name, password, email)   
                VALUES ('$first_name', '$last_name', '$password', '$email')";


        if (mysqli_query($conn, $sql)) {
            echo "Registration successful!";
            header('Location: login.php');
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
    else {
        echo "Please fill out all required fields.";
    }
?>
<?php
    mysqli_close($conn);
?>