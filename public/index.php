<?php 



    require_once '../database.php';

    $basePath = 'http://localhost/PHP_Traversy_Media%20/14_product_crud/better/public/';

    $search = $_GET['search'] ?? '';

    if($search){   
        $statement=$pdo->prepare('SELECT * FROM product WHERE title LIKE :title OR description LIKE :title OR price LIKE :title ORDER BY created_by DESC');
        $statement->bindValue(':title', "%$search%");
    }
    else{
        $statement=$pdo->prepare('SELECT * FROM product ORDER BY created_by DESC');
    }

    $statement->execute();
    $products= $statement->fetchAll(PDO::FETCH_ASSOC);
    

?>

    <?php require_once '../views/partial/header.php'; ?>

    <body>
        <h1>Products CRUD</h1>


        <a href="create.php" button type="button" class="btn btn-link btn btn-lg btn btn-warning btn btn-success">Create Product</button></a>
        
        </br>
        
        <form action="" method="get">
            <div class="input-group mb-3">
                <input type="text" class="form-control" name="search">
                <button type="submit">Search</button>
            </div>
        </form>


            <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Title</th>
                <th scope="col">Image</th>
                <th scope="col">Description</th>
                <th scope="col">Price</th>
                <th scope="col">Created Date</th>
                <th scope="col">Action</th>

            </tr>
        </thead>
        <tbody>
            <?php foreach($products as  $i=>$product): ?>

                <tr>
                    <td scope="row"><?php echo $i+1 ?>  </td>    
                    <td> <?php echo $product['title']; ?> </td>
                    <td>
                        <?php if ($product['image']): ?>


                            <img style="width: 150px; height:120px;" src="../<?php echo 'public/'.$product['image'] ?>" alt="<?php echo $product['image'] ?>" class="product-img">
                        <?php endif; ?>
               
                    </td>
                    <td><?php echo $product['description']; ?></td>
                    <td> <?php echo $product['price']; ?> </td>
                    <td> <?php echo $product['created_by']; ?> </td>
                    <td>
                        <!-- <a href="update.php ? id = <?php echo $product['id'] ?>" class="btn btn-sm btn-outline-primary">Edit</a> -->
                        <a href="update.php?id=<?php echo $product['id'] ?>" class="btn btn-sm btn-outline-primary">Edit</a>
                    <form action="delete.php" method="post" style="display:inline-block" >
                        <input type="hidden" name="id" value="<?php echo $product['id'] ?>" >
                        <button type="submit" class="btn btn-sm btn-outline-primary">Delete</button>


                    </form>

                    
                  
                    </td>
                </tr>
           
            <?php endforeach; ?> 

        </tbody>
        </table>
   
  </body>
</html>