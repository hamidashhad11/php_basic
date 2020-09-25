<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if($_SERVER['REQUEST_METHOD'] == "POST") {
    include_once 'connection.php';
    if (isset($_POST['del_id'])) {
        $id = $_POST['del_id'];
        $id = trim($id);
        $id = stripslashes($id);
        $id = htmlspecialchars($id);

        $img_path = $_POST['img_path'];
        $img_path = trim($img_path);
        $img_path = stripslashes($img_path);
        $img_path = htmlspecialchars($img_path);

        $sql = 'DELETE FROM books WHERE isbn = ?';
        $prepared = $connection->prepare($sql);
        $prepared->bind_param('i', $id);
        if ($prepared->execute()) {
            if (unlink($img_path)) {
                echo $id . ' deleted successfully';
            } else {
                echo 'Image remove error';
            }
        } else {
            echo 'unable to delete. ' . $prepared->error;
        }
    }

    if(isset($_POST['submit'])){
        $flag = true;
        $op = $_POST['op'];
        $nameErr = $isbnError = $publisherErr = $imgErr = "";
        $name = $isbn = $publisher = $image = "";

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
        if(empty($_POST['name'])){
            $errors['nameErr'] = "Name required";
            $flag = false;
        } else {
            $name = parseData($_POST['name']);
            $errors['nameValue'] = $name;
        }

        if(empty($_POST['isbn'])){
            $errors['isbnErr'] = "ISBN required";
            $flag = false;
        } else {
            $isbn = parseData($_POST['isbn']);
            $errors['isbnValue'] = $isbn;
            if(!is_numeric($isbn)){
                $errors['isbnErr'] = "ISBN should be a number";
                $flag = false;
            }
        }

        if(empty($_POST['publisher'])){
            $errors['publisherErr'] = "Publisher Required";
            $flag = false;
        } else {
            $publisher = parseData($_POST['publisher']);
            $errors['publisherValue'] = $publisher;
        }
        if($flag){
            $target_file = "";
            if($_FILES['image-test']['error'] != 4){
                $target_file = saveImage($_FILES['image-test']);
            }
            if($op == 'save'){
                $sql = "INSERT INTO books (isbn, Name, publisher, coverImage) VALUES(?,?,?,?)";
                $prepared = $connection->prepare($sql);
                $prepared->bind_param('isss', $isbn, $name, $publisher, $target_file);
                if($prepared->execute()){
                    $prepared->close();
                    header("Location: index.php");
                    exit();
                }
                else {
                    echo $prepared->error;
                    echo "<script>alert ('Error. ". $connection->error."')</script>";
                    die();
                }
            }
            else {
                $sql = "UPDATE books SET Name = ?, publisher = ?, coverImage = ? WHERE isbn = ?";
                $prepared = $connection->prepare($sql);
                $prepared->bind_param('sssi', $name, $publisher, $target_file, $isbn);
                if($prepared->execute()){
                    $prepared->close();
                    header('Location: edit.php?isbn='.$isbn);
                    exit();
                }
                else {
                    echo $prepared->error;
                    echo "<script>alert ('Error. ". $connection->error."')</script>";
                    die();
                }
            }
            $connection->close();
        }
        $_SESSION['errors'] = $errors;
        if($op == 'save'){
            header('Location: addnew.php?error');
        } else {
            header('Location: edit.php?isbn='.$isbn . '&error=true');
        }
    }
}

function parseData($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function saveImage($fileGlobal){

    $temp = explode(".", $fileGlobal["name"]);
    $newfilename = round(microtime(true)) . '.' . end($temp);
    $imgType = strtolower(end($temp));

    if($imgType != "jpg" && $imgType != "png" && $imgType != "jpeg" && $imgType != "gif" ) {
        $errors['imageErr'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        return false;
    }
    $target_file = 'uploads/' . $newfilename;

    #copy($_FILES['image-test']['tmp_name'], $target_file) or die($_FILES['image-test']['error']);
    if(move_uploaded_file($fileGlobal['tmp_name'], $target_file)){
        chmod($target_file,0755);
    } else {
        echo $fileGlobal['error'];

        $errors['imageErr'] = "Cannot upload image" . $fileGlobal['error'];
        return false;
    }
    return $target_file;
}