<?php
    require('dbinit.php');

    $query = 'SELECT * FROM cars;'; 
    $results = @mysqli_query($dbc,$query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Home</title>
</head>
<body>
    <div class="prodcuts-grid">
        <?php
            $sr_no = 0;
            while($row = mysqli_fetch_array($results, MYSQLI_ASSOC)){
                
            }
        ?>
    </div>
</body>
</html>