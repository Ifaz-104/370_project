<?php
    include("db_connect.php");
?>
<?php
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
        echo "<div>";
        echo "<input type='checkbox' id='$item_name' name='items[]' value='$item_name'>";
        echo "<label for='$item_name'>$item_name</label>";
        echo "<br>Quantity for $item_name: <input type='number' name='quantities[$item_name]' min='1' max='100' value='1'>";
        echo "</div><br>";
    }

    echo "<button type='submit'>Submit Order</button>";
    echo "</form>";

?>