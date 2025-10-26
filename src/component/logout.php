<?php
session_start();
session_destroy();
?> <script>window.location.href = "/index.php/ap/signin";</script> <?php
exit();
?>