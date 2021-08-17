<?php
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
