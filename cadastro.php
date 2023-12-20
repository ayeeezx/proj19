<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styleCadastro.css">
    <title>Document</title>
</head>

<body>
    <div class="signup-container">
        <form class="signup-form" method="POST">
            <h2>Cadastro</h2>

            <div class="input-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="input-group">
                <label for="fullname">Confirm Password</label>
                <input type="password" id="fullname" name="rpt" required>
            </div>
            <button type="submit" name="enviar">Sign Up</button>
        </form>
        <div class="login-link">
            <p>Already have an account? <a href="index.php">Login</a></p>
        </div>
    </div>
    <?php
    include_once('./config.php');
    include_once('./crud.php');

    if (isset($_POST["enviar"])) {
        if (
            $_POST["password"] != null && $_POST["username"] != null
            && $_POST["rpt"] != null
        ) {
            $crud = new Crud($db);
            if ($_POST['password'] == $_POST['rpt']) {
                $username = $_POST["username"];
                $password = $_POST["password"];
                $isEqual = false;
                $result = $crud->read();
                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    if ($row['login'] == $username) {
                        $isEqual = true;
                    }
                }
                if ($isEqual == false) {
                    $crud->insert($username, $password);
                    echo '<script type="text/javascript"> window.location.href="index.php"; </script>';
                }
            }
        }
    }
    ?>



</body>

</html>