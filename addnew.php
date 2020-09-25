<?php
session_start();
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
}

include_once 'navbar.php';
?>

<div class="container">
    <h2>Add new Books</h2>
    <form action="operations.php" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="email">ISBN:</label>
            <input type="text" class="form-control" id="name" placeholder="ISBN" name="isbn" value="<?= $errors['isbnValue']?>">
            <span class="errors"><?= $errors['isbnErr'] ?></span>
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
            <input type="file" class="form-control" id="image"  name="image-test">
            <span class="errors"><?= $errors['imageErr']?></span>
        </div>
        <input type="text" name="op" value="save" hidden>
        <button type="submit" class="btn btn-primary" name="submit">Save</button>
    </form>
</div>

</body>
</html>

