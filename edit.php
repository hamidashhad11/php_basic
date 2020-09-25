<?php

session_start();
include "connection.php";

if(isset($_SESSION['errors'])){
    $errors = $_SESSION['errors'];
    $_SESSION['errors'] = null;
    unset($_SESSION['errors']);
} else {
    $errors = array(
        'nameErr' => null,
        'publisherErr' => null,
        'isbnErr' => null,
        'imageErr' => null,
        'nameValue' => null,
        'isbnValue' => null,
        'publisherValue' => null,
        'imagePath' => null
    );

    if(isset($_GET['isbn'])){

        $id = $_GET['isbn'];
        $id = trim($id);
        $id = stripslashes($id);
        $id = htmlspecialchars($id);
        $name = $publisher = $image = "";
        if(!is_numeric($id)){
            echo "<script>alert ('Error. Invalid ISBN')
        location.href = 'index.php';
        </script>";
            exit();
        }
        $sql = "SELECT * FROM books WHERE isbn = ?";
        $prepared = $connection->prepare($sql);
        $prepared->bind_param('i',$id);
        if(!$prepared->execute()){
            echo "<script>alert ('Error." .$prepared->error. "')
        location.href = 'index.php';
        </script>";
        } else {
            $result = $prepared->get_result();
            if($result->num_rows < 1) {
                echo "<script>alert ('No Record found')
        location.href = 'index.php';
        </script>";
            }
            else {
                $row = $result->fetch_assoc();
                $errors['nameValue'] = $row['Name'];
                $errors['publisherValue'] = $row['publisher'];
                $image = $row['coverImage'];
            }
        }

    } else {
        header('location: index.php');
    }
}




include_once 'navbar.php';
?>

<div class="container">
    <h2>Update Books</h2>
    <form action="operations.php" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="email">ISBN:</label>
            <input type="text" name="isbn" value="<?= $id?>" hidden>
            <span><?= $id?></span>
        </div>
        <div class="form-group">
            <label for="email">Name:</label>
            <input type="text" class="form-control" id="name" placeholder="Name" name="name" value="<?= $errors['nameValue']?>">
            <span class="errors"><?= $errors['nameErr']?></span>
        </div>
        <div class="form-group">
            <label for="pwd">Publisher:</label>
            <input type="text" class="form-control" id="publisher" placeholder="Publisher" name="publisher" value="<?= $errors['publisherValue']?>">
            <span class="errors"><?= $errors['publisherErr']?></span>
        </div>
        <div class="form-group">
            <label for="pwd">Image:</label>
            <input type="file" class="form-control" id="image" value="<?= $image?>"  name="image-test">
            <span class="errors"><?= $errors['imageErr']?></span>
        </div>
        <input type="text" name="op" value="update" hidden>
        <button type="submit" class="btn btn-primary" name="submit">Update</button>
    </form>
</div>

</body>
</html>


<?php

function parseData($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>
