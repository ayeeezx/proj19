<!DOCTYPE html>
<html lang="en">

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
                <textarea id="texto" name="texto" rows="6" cols="50" placeholder="Qual a sua próxima tarefa?"></textarea>
            </div>
            <div id="btn" style="display: inline-block;">
                <input type="submit" value="enviar" name="enviar">
            </div>
        </div>
    </form>
    <?php
    include_once('./config.php');
    include_once('./crud.php');
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }
    $crud = new Crud($db);
    $result = $crud->readTarefa($_SESSION['username']);
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    ?>
        <div id="list">
            <p><?php
                if ($row['texto']) {
                    echo $row['texto'];
                }
                ?>
            </p>
        </div>
    <?php } ?>

    <?php


    if (isset($_POST['enviar'])) {
        if (!empty($_POST['texto'])) {


            $tarefa = $_POST['texto'];
            $dataFormatada = date('d/m/Y');
            $novaTarefa = $tarefa . " (Registrado em: " . $dataFormatada . ")";
            var_dump($novaTarefa);
            $crud->insertTarefa($novaTarefa, $_SESSION['username']);
            header("Refresh:0");
        } else {
            echo '<script>alert("Tarefas Vazias não são suportadas");</script>';
        }
    }
    ?>
</body>

</html>