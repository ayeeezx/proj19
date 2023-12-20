<?php
include_once('./config.php');
include_once('./crud.php');
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
$crud = new Crud($db);
$result = $crud->readAllTarefa();
if (isset($_GET['edit'])) {
    $_SESSION['edit'] = $_GET['edit'];
    header("Location: edit.php");
    exit();
}
if (isset($_GET['delete'])) {
    $deleteId = $_GET['delete'];
    $crud->delete($deleteId);
    header("Location: homeADM.php");
    exit();
}

if (isset($_POST['enviar']) && !empty($_POST['texto'])) {


    $tarefa = $_POST['texto'];
    $usuario = $_POST['usuario'];
    var_dump($tarefa);
    var_dump($usuario);
    $dataFormatada = date('d/m/Y');
    $novaTarefa = $tarefa . " (Registrado em: " . $dataFormatada . ")";

    if (isset($_POST['usuario']) && $_POST['usuario'] != "nada") {

        $crud->insertTarefaADM($novaTarefa, $usuario);
        header("Location: homeADM.php");
        exit();
    } else {
        echo '<script>alert("Por favor, selecione a quem deseja atribuir a tarefa");</script>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styleHomeADM.css">
    <title>Home</title>
</head>

<body>
    <form method="post">
        <div id="insert">
            <div id="ta" style="display: inline-block;">
                <textarea id="texto" name="texto" rows="6" cols="50" placeholder="Qual a sua próxima tarefa?"></textarea>
            </div>
            <div id="user" style="display: inline-block;">
                <select name="usuario">
                    <option value="nada">--------</option>
                    <?php
                    $usuarios = $crud->read();
                    foreach ($usuarios as $usuarioss) {
                        echo "<option value='" . $usuarioss['id'] . "'>" . $usuarioss['login'] . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div id="btn" style="display: inline-block;">
                <input type="submit" value="Enviar" name="enviar">
            </div>
        </div>
    </form>
    <?php
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    ?>
        <div id="list">
            <p>
                <?php echo $row['texto']; ?>
                <a href="?delete=<?php echo $row['idtarefa']; ?>">Apagar</a>
                <a href="?edit=<?php echo $row['idtarefa']; ?>">Editar</a>
            </p>
        </div>
    <?php
    }

    // Código PHP para deletar a tarefa
    if (isset($_GET['delete'])) {
        $deleteId = $_GET['delete'];
        $crud->delete($deleteId);
        header("Location: HOMEADM.php");
        exit();
    }

    // Código PHP para edição da tarefa
    if (isset($_GET['edit'])) {
        $crud->readTar($_GET['edit']);
        exit;
        $_SESSION['edit'] = $_GET['edit'];
        header('Location: edit.php');
    }
    ?>
</body>

</html>