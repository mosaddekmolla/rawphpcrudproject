<?php
    include_once 'database.php';

    $id = $_GET['id'] ?? null;
    if (!$id) {
        header('Location: index.php');
    }

    $statement = $pdo->prepare('SELECT * FROM product WHERE id = :id');
    $statement->bindValue(':id', $id);
    $statement->execute();
    $product = $statement->fetch(PDO::FETCH_ASSOC);

    $errors=[];

    // $title = '';
    // $description = '';
    // $price = '';

    $title = $product['title'];
    $description = $product['description'];
    $price = $product['price'];
    
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $date = date('Y-m-d H:i:s');


    if (!$title) {
        $errors[]="Title must required";
    }

    if (!$description) {
        $errors[]="Description must required";
    }


    if (!$price) {
        $errors[]="Price must required";
    }

    $image = $_FILES['image'] ?? null;
    $imagePath = '';

    if (!is_dir('images')) {
        mkdir('images');
    }

    if ($image && $image['tmp_name']) {
        $imagePath = 'images/' . randomString(8) . '/' . $image['name'];
        mkdir(dirname($imagePath));
        move_uploaded_file($image['tmp_name'], $imagePath);
    }


    if (empty($errors)) {
        // echo "<pre>";
        // var_dump($_FILES);
        // echo '<pre/>';
    
        //$statement = $pdo->prepare("UPDATE product SET title=:title, description=:description, image=:image, price=:price WHERE id = :id");

        $statement = $pdo->prepare("UPDATE products SET title = :title, 
        image = :image, 
        description = :description, 
        price = :price WHERE id = :id");

        $statement->bindValue(':title', $title);
        $statement->bindValue(':description', $description);
        $statement->bindValue(':image', $imagePath);
        $statement->bindValue(':price', $price);
        $statement->bindValue(':date', $date);
        $statement->bindValue(':id', $id);


        $statement->execute();

        header('Location:index.php');
    }
}

    function randomString($n)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $str = '';
        for ($i = 0; $i < $n; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $str .= $characters[$index];
        }

        return $str;
    }
    
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">

    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
    <link rel="stylesheet" href="app.css">


    <title>Update Products</title>
  </head>
    <body>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <?php foreach ($errors as $error) { ?>
                <p><?php echo $error; ?></p>
            <?php } ?>
        </div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data">
           <div>
               <img src="<?php echo $product['image'] ?>" alt="">
               <div >
                    <label> Product Image</label><br/>
                    <input type="file" name="image" >
                </div>

           </div>

            <br/>

            <div>
                <label>Product Title</label>
                <input type="text" class="form-control"  name="title" value="<?php echo $title ?>">
            </div>

            <br/>

            <div>
                <label>Product Description</label> <br>
                <textarea class="form-control" name="description"><?php echo $description ?></textarea>
            </div>

            <br/>

            <div>
                <label>Product Price</label>
                <input type="number" step=".01" class="form-control" name="price" value="<?php echo $price ?>">
            </div>
            <br/>

            <button type="submit" class="btn btn-primary" name="save">Submit</button>
        </form>

    </body>
</html>

