<!DOCTYPE html>
<html lang="en">
<?php
include_once('./config.php');
include_once('./crud.php');
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
$crud = new Crud($db);
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styleHome.css">
    <title>Home</title>
</head>

<body>
    <form method="post">
        <div id="insert">
            <div id="ta" style="display: inline-block;">
                <textarea id="texto" name="texto" rows="6" cols="50"><?php echo $_SESSION['edit'] ?></textarea>
            </div>
            <div id="btn" style="display: inline-block;">
                <input type="submit" value="Atualizar" name="enviar">
            </div>
        </div>
    </form>


    <?php

    if (isset($_POST['enviar']) && !empty($_POST['texto'])) {
        $tarefa = $_POST['texto'];
        $crud->update($_SESSION['edit'], $tarefa);
        header("Location: homeADM.php");
    }
    ?>
</body>

</html>