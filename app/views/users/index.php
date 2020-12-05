<?php
    if (isset($data['username'])) {
        $_SESSION['username'] = $data['username'];
    }
?>

<?php require_once APPROOT . '/views/inc/header.php'; ?>
<?php require_once APPROOT . '/views/inc/navbar.php'; ?>
    <h1>Welcome </h1>
    <strong><?=$data['username'];?></strong>
<?php require_once APPROOT . '/views/inc/footer.php'; ?>
