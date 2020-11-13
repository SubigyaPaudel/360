<?php
    include("./header.php");
    $usrname = $_GET['username'] ?? " ";
    $passwrd = $_GET['password'] ?? " ";
    $usrname = htmlspecialchars($usrname);
    $passwrd = htmlspecialchars($passwrd);
    if(isset($_POST['login'])):
        include("./config.php");
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);
        $query = "SELECT * FROM admin_users A WHERE A.username = '{$username}' and A.password = '{$password}';";
        $result = mysqli_query($conn, $query);
        $clean_data = mysqli_fetch_all($result, MYSQLI_ASSOC);
        $letthemin = count($clean_data);
        if($letthemin == 1):
            mysqli_free_result($result);
            mysqli_close($conn);
            setcookie("is_auth", 'yes', time() + 900);
            header("Location: ./maintenance.php");
        elseif($letthemin == 0):
            mysqli_free_result($result);
            mysqli_close($conn);
            header("Location:".$_SERVER['PHP_SELF']."?status=auth_failed&username={$username}&password={$password}");
        else:
            mysqli_free_result($result);
            header("Location: ./failure.php?status=Cannot authenticate user");
        endif;
    elseif(isset($_GET['status'])):
        if($_GET['status'] === "auth_failed"):
            echo "<h2 style = 'color:red;'>Wrong username or password</h2>";
        elseif($_GET['status'] === 'sign_in_required'):
            echo "<h2 style = 'color:red;'> Sign in with an admin account before you proceed </h2>";
        endif;
    else:
        echo "<h3> Enter your admin account credentials </h3>";
    endif;
    ?>
    <form action="<?php $_SERVER['PHP_SELF']?>" method = "POST">
        <input type="text" name = 'username' placeholder = "Admin Username">
        <br>
        <input type="password" name = 'password' placeholder = "Admin Password">
        <br>
        <input type="submit" name = "login" value = "login" class = buttons>
    </form>
<?php
    include("./footer.php");
?>