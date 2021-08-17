<?php
    require_once "../database.php";

    require_once '../function.php';

    $errors=[];

    $title = '';
    $description = '';
    $price = '';
    
if ($_SERVER['REQUEST_METHOD'] === "POST"){
    
    require_once '../validate_product.php';

    if (empty($errors)) {
        // echo "<pre>";
        // var_dump($_FILES);
        // echo '<pre/>';
    
        $statement = $pdo->prepare("INSERT INTO product(title, description, image, price, created_by) VALUES(:title,:description,:image,:price,:date)");

        $statement->bindValue(':title', $title);
        $statement->bindValue(':description', $description);
        $statement->bindValue(':image', $imagePath);
        $statement->bindValue(':price', $price);
        $statement->bindValue(':date', $date);

        $statement->execute();

        header('Location:index.php');
    }
}   
?>
    <?php require_once '../views/partial/header.php'; ?> 

    <body>

    <a href="index.php" class="btn btn-sm btn-outline-primary" style="float: right;">Back to Index</a>

    <?php require_once '../errors.php'; ?>

    <?php require_once '../views/products/form.php'; ?>

    </body>
</html>

