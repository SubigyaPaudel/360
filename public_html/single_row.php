<?php include('header.php');
    require('config.php');
?>
    <h3>Selected row</h3>
    <?php
            $new_email = mysqli_real_escape_string($conn, $_POST['email']);
            $sub = mysqli_real_escape_string($conn, $_POST['subscription']);
            $web = mysqli_real_escape_string($conn, $_POST['web']);

            $sqlquery = "SELECT * from {$sub} X WHERE X.email = '{$new_email}' AND X.website = '{$web}';" ;
            $result = mysqli_query($conn, $sqlquery);
            $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
            if(count($rows)){
                echo "<h5> row exists </h5>";
            }else{
                echo "<h5> row doesn't exists </h5>";
            }
    ?>
    <?php 
    if(count($rows)):
        ?>
        <table class="centre_table">
        <?php
            echo "<tr>";
            while($row = $result->fetch_field()):
                echo "<th>" . $row->name . "</th>";
            endwhile;
            echo "</tr>";
            foreach($rows as $row):
                echo "<tr>";
                foreach($row as $column):
                    echo "<td>" . $column . "</td>";
                endforeach;
                echo "</tr>";
            endforeach;
        endif;
        ?>
        </table>
<?php include('footer.php') ?>