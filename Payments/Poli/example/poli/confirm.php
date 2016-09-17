<?php
$action = $_GET['redirect_url'];
header('Location: ' . $action);
?>