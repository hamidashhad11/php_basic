<!DOCTYPE html>
<?php

    require_once 'connection.php';

    $sql = "SELECT * FROM practice.books";
    $prepared = $connection->prepare($sql);
    /*$result = $connection->query($sql);*/
    ;
    $data = "";
    if(!$prepared->execute()){
        $data = $prepared->error;
    }
    else {
        $result = $prepared->get_result();
        if($result->num_rows == 0){
            $data = "No Books found";
        } else {
            $data .= "<thead><tr><th>ISBN</th><th>Name</th><th>Publisher</th><th>Image</th><th>Action</th></tr></thead><tbody>";
            while ($row = $result->fetch_assoc()){
                $data .= "<tr><td class='align-middle'>".$row['isbn']."</td><td class='align-middle'>".$row['Name']."</td><td class='align-middle'>".$row['publisher']."</td><td class='align-middle'><img src='".$row['coverImage']."' alt='Image'></td><td class='align-middle'><button class='btn btn-warning delete'>Delete</button> <button class='btn btn-info edit'>Edit</button></td></tr>";
            }
            $data .= "</tbody>";
        }
    }
$connection->close();
?>

    <?php
        include_once 'navbar.php';
    ?>
        <div class="container">
            <h1>Books</h1>
            <div class="row">
                <div class="col col-md" id="main-con">
                   <table id="data-table" class="table table-bordered table-info table-striped ">
                       <?= $data?>
                   </table>
                </div>
            </div>
        </div>
    <script type="text/javascript">
        $(document).ready(function (){
            $('.delete').on('click',function (){
                var data = $(this).parent().siblings(":first").text();
                var img_path = $(this).parent().prev().children().attr('src');
                $row = $(this).parent().parent();
                if(confirm("Are you sure you want to delete " + data)){
                    $.ajax({
                        url: 'operations.php',
                        method: 'post',
                        data: {
                            del_id : data,
                            img_path: img_path
                        },
                        success: function (data){
                            alert(data);
                            $row.remove();
                        },
                        error: function (err){
                            alert(err);
                        }
                    });
                }
            });
            $('.edit').on('click', function () {
                var data = $(this).parent().siblings(":first").text();
                window.location.href = "edit.php?isbn=" + data;
            });
            $("#search").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#data-table tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });
    </script>
    </body>
</html>