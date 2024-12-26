<?php
    include("db_connect.php");
    session_start(); 

if (isset($_SESSION['customerid'])) {
    $customerid = $_SESSION['customerid'];

    $sql = "SELECT name, price FROM grocery_item";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            echo "<h3>Menu</h3>";
            echo "<table border='1'>";
            echo "<tr><th>Name</th><th>Price</th></tr>";

            
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                echo "<td>" . htmlspecialchars($row['price']) . "</td>";
                echo "</tr>";
            }

            echo "</table>";
        } }

        mysqli_data_seek($result, 0);

        echo "<h3>Select Item</h3>";
        echo "<form method='post' action='order.php'>";
        
        while ($row = mysqli_fetch_assoc($result)) {
            $item_name = htmlspecialchars($row['name']);
            $item_price= htmlspecialchars($row['price']);
            echo "<div>";
            echo "<input type='checkbox' id='$item_name' name='items[]' value='$item_name'>";
            echo "<label for='$item_name'>$item_name</label>";
            echo "<br>Quantity for $item_name: <input type='number' name='quantities[$item_name]' min='1' max='10' value='1'>";
            echo "</div><br>";
        }

        echo "<button type='submit'>Submit Order</button>";
        echo "</form>";


    if (isset($_POST['items'], $_POST['quantities'])) {
        $selected_items = $_POST['items']; 
        $quantities = $_POST['quantities'];
        

        echo "<h2>Your Cart</h2>";
        echo "<table border='1'>";
        echo "<tr><th>Item</th><th>Quantity</th><th>Price</th><th>";

        $total_bill=0;

        foreach ($selected_items as $item) {
            $quantity = (int)$quantities[$item];
            
            $sql2 = "SELECT  price FROM grocery_item where name='$item'";
            $result2 = mysqli_query($conn, $sql2);
            $price = mysqli_fetch_assoc($result2);
            $new_price= $quantity*$price['price'];

            $total_bill+=$new_price;
            
            $sql3= "UPDATE grocery_item SET quantity = quantity - '$quantity'  WHERE name = '$item'";
            $result3 = mysqli_query($conn, $sql3);

            echo "<tr>";
            echo "<td>" . $item . "</td>";
            echo "<td>" . $quantity . "</td>";
            echo "<td>" . $new_price . "</td>"; 
            echo "</tr>"; 
        }

    
        echo "<tr>";
        echo "<td colspan='2'><strong>Total Bill </strong></td>";
        echo "<td><strong>" . htmlspecialchars($total_bill) . "</strong></td>";
        echo "</tr>";
        echo "</table>";

        $sql4= "INSERT INTO sales_history (total_amount, c_id) VALUES ('$total_bill', '$customerid')";
        $result4 = mysqli_query($conn, $sql4);
    }

}
?>
