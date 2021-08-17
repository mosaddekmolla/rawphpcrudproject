<?php

require_once "../database.php";

require_once '../function.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: index.php');
    exit;
}


$statement = $pdo->prepare('SELECT * FROM product WHERE id = :id');
$statement->bindValue(':id', $id);
$statement->execute();
$product = $statement->fetch(PDO::FETCH_ASSOC);


$title = $product['title'];
$description = $product['description'];
$price = $product['price'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    require_once '../validate_product.php';

    if (empty($errors)) {
        $statement = $pdo->prepare("UPDATE product SET title = :title, 
                                        image = :image, 
                                        description = :description, 
                                        price = :price WHERE id = :id");
        $statement->bindValue(':title', $title);
        $statement->bindValue(':image', $imagePath);
        $statement->bindValue(':description', $description);
        $statement->bindValue(':price', $price);
        $statement->bindValue(':id', $id);

        $statement->execute();
        header('Location: index.php');
    }
}   

?>
<?php require_once '../views/partial/header.php'; ?>

<body>
    <p>
        <a href="index.php" class="btn btn-primary">Back to products</a>
    </p>
    <h1>Update Product: <b><?php echo $product['title'] ?></b></h1>

    <?php require_once '../errors.php'; ?>

    <?php require_once '../views/products/form.php'; ?>


</body>
</html>