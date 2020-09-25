<html lang="en">
<head>
    <title>Basic Project</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        img {
            width: 500px;
            height: 350px;
        }
        .errors {
            color: red;

        }

    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark" >
<a class="navbar-brand" href="index.php">Home</a>
<button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navb">
    <span class="navbar-toggler-icon"></span>
</button>

<div class="collapse navbar-collapse" id="navb">
    <ul class="navbar-nav mr-auto">
        <li class="nav-item">
            <a class="nav-link active" href="addnew.php">Add New</a>
        </li>
    </ul>
    <form class="form-inline my-2 my-lg-0">
        <input class="form-control mr-sm-2" type="text" placeholder="Search" id="search">
        <button class="btn btn-success my-2 my-sm-0" type="button">Search</button>
    </form>
</div>
</nav>