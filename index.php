<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styleIndex.css">
    <title>Document</title>
</head>

<body>
    <div class="login-container">
        <form class="login-form" method="POST">
            <h2>Login</h2>
            <div class="input-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username">
            </div>
            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password">
            </div>
            <button type="submit" name="enviar">Login</button>
            <button type="submit" name="clima" style="margin-top: 10px;">Saber Clima</button>
        </form>
        <div class="signup-link">
            <p>Don't have an account? <a href="cadastro.php">Sign Up</a></p>
        </div>
    </div>

    <?php
    if(isset($_POST["clima"])){
        echo '<script type="text/javascript"> window.location.href="clima.html"; </script>';
    }
    include_once('./config.php');
    include_once('./crud.php');
    if (isset($_POST['enviar']) && isset($_POST['username'])) {
        $crud = new crud($db);
        $result = $crud->read();
        $user = $_POST['username'];
        $pass = $_POST['password'];

        // Verifica se a consulta retornou resultados
        if ($result) {
            $found = false;
            // Use um loop para iterar sobre os resultados obtidos com o PDO
            if ($user == "admin" && $pass == "admin") {
                echo '<script type="text/javascript"> window.location.href="homeADM.php"; </script>';
            } else {
                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    $login = $row['login'];
                    $senha = $row['senha'];
                    if ($login == $user && $senha == $pass) {
                        if (session_status() !== PHP_SESSION_ACTIVE) {
                            session_start();
                        }
                        $_SESSION['username'] = $login;
                        $found = true;
                        echo '<script type="text/javascript"> window.location.href="home.php"; </script>';
                        break;
                    }
                }
                if (!$found) {
                    echo '<script>alert("Verifique suas credenciais e tente novamente");</script>';
                } else {
                    // Trate o caso em que a consulta não retornou resultados
                    echo "Nenhum resultado encontrado.";
                }
            }
        }
    }
    ?>
</body>

</html>