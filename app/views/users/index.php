<?php require_once APPROOT . '/views/inc/header.php'; ?>

<?php require_once APPROOT . '/views/inc/navbar.php'; ?>
    <?php if (isset($_SESSION['username'])) : ?>
        <h1>Welcome </h1>
        <strong><?=$_SESSION['username'];?></strong>
    <?php endif ?>
<?php require_once APPROOT . '/views/inc/footer.php'; ?>
