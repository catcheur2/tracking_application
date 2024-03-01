<?php

if(!isset($conn)){ include 'db_connect.php'; } 
if(isset($_POST['search']))
{
    $valueToSearch = $_POST['valueToSearch'];
    // search in all table columns
    // using concat mysql function
    
    /*$sql = "SELECT * FROM conteneur WHERE nom_c = '$valueToSearch'";
    $resultat = mysqli_query($conn,$sql);
    $rows = mysqli_fetch_array($resultat);
    $id = $rows['id'];*/

    $query = "SELECT * FROM conteneur_track WHERE invoice_id = '$valueToSearch' ";
    //$query_run = mysqli_query($conn, $query);



    //$query = "SELECT * FROM `users` WHERE CONCAT(`id`, `fname`, `lname`, `age`) LIKE '%".$valueToSearch."%'";
    $search_result = filterTable($query);
    
}
 else {
    $query = "SELECT * FROM `conteneur_track` where id='0'";
    $search_result = filterTable($query);
}

// function to connect and execute the query
function filterTable($query)
{
    if(!isset($conn)){ include 'db_connect.php'; } 
    $filter_Result = mysqli_query($conn, $query);
    return $filter_Result;
}

?>

<!DOCTYPE html>
<html>
    <head>
        <title>PHP HTML TABLE DATA SEARCH</title>
        <style>
            table,tr,th,td
            {
                border: 1px solid black;
            }
        </style>
    </head>
    <body>
        <div class="col-md-12 ">
            <div class="card mt-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-7 ">
                            <form action="" method="post">
                                <input type="text" name="valueToSearch" class="form-control" placeholder="Valeur à rechercher">
                                <!--<button type="submit" class="btn btn-primary">Rechercher</button>-->
                                <input type="submit" class="btn btn-primary" name="search" value="Filtrer"><br><br>
                                
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>statut</th>
                                            <th>date</th>
                                        </tr>
                                    </thead>
                                    <?php
                                    $num_conteneur = $conn->query("SELECT * FROM status_conteneur ");
                                    $design_arr[0]= "Unset";
                                    while($row=$num_conteneur->fetch_assoc()){
                                        $design_arr[$row['id']] =$row['nom'];
                                    }
                                    ?>
                                    <?php while($row = mysqli_fetch_array($search_result)):?>
                                    <tbody>
                                        <tr>
                                            <td><?php echo $design_arr[$row['status']];?></td>
                                            <td><?php echo $row['date_created'];?></td>
                                        </tr>
                                    </tbody>
                                    <?php endwhile;?>
                                </table>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>





