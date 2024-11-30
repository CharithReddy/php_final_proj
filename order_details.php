<?php
    require('dbinit.php');

    $query = 'select concat(cs.first_name, " ", cs.last_name) as `Customer`, 
                    cr.carName as `Car`, od.sale_date as `Sale Date`, 
                    od.total_price as `Total Price`, od.discount as `Discount`, 
                    od.price_paid as `Price Paid`, cr.fuelType as `Fuel Type`, 
                    cr.driveType as `Drive Type`, cr.carID as `Car ID`, 
                    cs.username as `Customer Username`
                from orders as od inner join customer as cs
                on od.username = cs.username 
                inner join cars as cr
                on cr.carID = od.carID;'; 

    $results = @mysqli_query($dbc,$query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" 
        rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" 
        crossorigin="anonymous">
    <link rel="stylesheet" 
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="table-container">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th scope="col">Customer</th>
                    <th scope="col">Car Name</th>
                    <th scope="col">Sale Date</th>
                    <th scope="col">Total Price</th>
                    <th scope="col">Discount</th>
                    <th scope="col">Price Paid</th>
                    <th scope="col">Fuel Type</th>
                    <th scope="col">Drive Type</th>
                    <th scope="col" class="hidden">Car ID</th>
                    <th scope="col" class="hidden">User Name</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $sr_no = 0;
                    while($row = mysqli_fetch_array($results, MYSQLI_ASSOC)){
                        $sr_no++;
                        $str_to_print = "";
                        $str_to_print = "<tr>";
                        $str_to_print .= "<td>{$row['Customer']}</td>";
                        $str_to_print .= "<td>{$row['Car']}</td>";
                        $str_to_print .= "<td>{$row['Sale Date']}</td>";
                        $str_to_print .= "<td>{$row['Total Price']}</td>";
                        $str_to_print .= "<td>{$row['Discount']}</td>";
                        $str_to_print .= "<td>{$row['Price Paid']}</td>";
                        $str_to_print .= "<td>{$row['Fuel Type']}</td>";
                        $str_to_print .= "<td>{$row['Drive Type']}</td>";
                        $str_to_print .= "<td class=\"hidden\">{$row['Car ID']}</td>";
                        $str_to_print .= "<td class=\"hidden\">{$row['Customer Username']}</td>";
                        $str_to_print .= "</tr>";

                        echo $str_to_print;
                    }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>

