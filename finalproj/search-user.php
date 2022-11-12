<?php
include "lib/db.class.php";
include "lib/config.php"; 
include "lib/functions.php";

$return = "";

if(isset($_POST["query"])){
    $query = DB::query("SELECT * FROM student WHERE studentName LIKE %ss", $_POST["query"]);

    echo '
    <div class="table-responsive">
        <table class="table table-bordered">
            <tr>
                <th>Name</th>
            </tr>
    ';
    
    foreach($query as $result){
        echo '
        <tr>
            <td>'.$result["studentName"].'</td>
        </tr>';
    }

    echo '</table>
    </div>
    ';
}

?>