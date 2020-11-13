<?php
    setcookie("is_auth", "yes", time() - 900);
    header("Location: ./index.php");
?>