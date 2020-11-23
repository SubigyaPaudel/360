<?php
    include('./config.php');
    $table_name = mysqli_real_escape_string($conn, $_GET['table']);
    $attribute = mysqli_real_escape_string($conn, $_GET['column']);
    $like = mysqli_real_escape_string($conn, $_GET['like']);
    $query = "SELECT {$attribute} FROM {$table_name} WHERE {$attribute} LIKE '{$like}%'";
    $result = mysqli_query($conn,$query);
    $filtered_data = mysqli_fetch_all($result, MYSQLI_ASSOC);
    echo '[';
    mysqli_free_result($result);
    $num = count($filtered_data);
    for($i = 0; $i < $num; $i++):
        echo "{\"expected\": \"{$filtered_data[$i][$attribute]}\""; 
        if($i != $num - 1){
            echo "},";
        }else{
            echo "}";
        }
    endfor;
    echo ']';
    mysqli_close($conn);
?>
