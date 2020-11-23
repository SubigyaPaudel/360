<?php
    if(!isset($_COOKIE['is_auth'])):
        header("Location: ./admin_login.php?status=sign_in_required");
    endif;
?>