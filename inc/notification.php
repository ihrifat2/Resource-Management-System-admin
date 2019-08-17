<?php
if (isset($_SESSION['notification_item'])) {
    echo '<script>swal("'.$_SESSION['notification_item']["title"].'", "'.$_SESSION['notification_item']["text"].'", "'.$_SESSION['notification_item']["type"].'")</script>';
    unset($_SESSION["notification_item"]);
}
?>