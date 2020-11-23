<?php
    require("config.php");

    // function get_mail($conn, $term) {
    //     $sqlquery = "SELECT * FROM general_account G WHERE G.email_s LIKE '%".$term."%' ORDER BY G.email_s ASC;";
    //     $result = mysqli_query($conn, $sqlquery);
    //     $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
    //     return $rows;
    // }
    // echo ("trial");
    // if(isset($_GET["term"])) {
    //     $sqlquery = "SELECT G.email FROM general_account G WHERE 1 GROUP BY G.email;";
    //     $result = mysqli_query($conn, $sqlquery);
    //     $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
    //     $mail_list = array();
    //     foreach($rows as $mail) {
    //         $mail_list[] = $mail['email_g'];
    //     }
    //     echo json_encode('$mail_list');
    // }
    $term=$_GET["term"];
                $query=mysqli_query($conn, "SELECT * FROM general_account G WHERE G.email LIKE '%".$term."%' ORDER BY G.email ");
                $results=array();

                while($row = mysqli_fetch_array($query)){
                    $results[] = array('label' => $row['tag_value']);
                }
                echo json_encode($results);
?>
