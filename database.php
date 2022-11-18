<html>
    <head>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    </head>
    <body>
        
<style>
    #sql {
        height: 200px;
        width: 400px;
        background-color: black;
        color: lightblue;
        font-size: 16px;
        font-weight: 400;
    }
</style>
<?php

require_once 'dbconfig.php';

$conn;

try {    
    //$conn = new PDO("mysql:host=$host", $username, $password);
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully";
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e;
}
?>

<form method="post">
    <textarea id="sql" name="sql" placeholder="WRITE SQL CODE HERE!" autofocus><?=$_POST['sql'] ?? '' ?></textarea>
    <br>
    <input type="submit">
</form>

<?php
if(isset($_POST['sql'])) :
    $stmt = $conn->prepare($_POST['sql']);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);


    if(isset($results[0])) : ?>

    <pre>
        <?php
        //print_r($results);
        ?>
    </pre>

    <table class="table table-striped">
        <thead class="thead-dark">
            <tr>
            <?php foreach($results[0] as $header => $value) : ?>
            
                <th><?=$header?></th>
            
            <?php endforeach; ?>
            </tr>
        </thead>
        
        <?php foreach ($results as $result) : ?>
        
            <tr>
                <?php foreach ($result as $value) : ?>
                    <td><?=$value?></td>
                <?php endforeach; ?>
            </tr>
        
        <?php endforeach; ?>
    </table>



    <?php
    else: 
        echo 'Database returned no results';
    endif;
    $conn = null;
endif;
?>
    </body>
</html>