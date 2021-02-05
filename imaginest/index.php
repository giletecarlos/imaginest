<?php
    require_once('./db/controlUsuari.php');
    
    session_start();

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(isset($_POST['user']) && isset($_POST['pass'])){

            //Protección ante XSS
            $userPOST = filter_input(INPUT_POST, 'user');
            $passPOST = filter_input(INPUT_POST, 'pass');
            $passHash = getHashPass($userPOST);

            $usuari = verificaUsuari($userPOST);
            if($usuari == 1 && password_verify($passPOST,$passHash[0])){
                session_start();
                if (!empty($userPOST)) $_SESSION['usuari'] = $userPOST;
                header("Location: home.php");
                exit;
            }else{
                $err = TRUE;
                $user = $userPOST;
            }
            $err = TRUE;
        }
    }
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <title>IMAGINEST - TU RED SOCIAL</title>
    <link rel="stylesheet" type="text/css" href="./css/main.css" />
    <link rel="icon" href="./img/logoImaginest.png"/>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>

<body>
    <div id="pagewrapper">
        <div class="cont">
            <div class="form">
                <form method="POST" class="login-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <img src="./img/logoImaginest.png" id="logo">
                    <h1>IMAGINEST</h1>
                    <h3>Iniciar sesión</h3>
                    <input id="user" name="user" class="user" type="text" placeholder="Usuario / Correo electrónico" value="<?php if(isset($user)) echo $user;?>"
                        autocomplete="off" autofocus required>
                    <input id="pass" name="pass" class="pass" type="password" placeholder="Contraseña" autocomplete="off" required>
                    <button class="login" type="submit"><span>INICIAR SESIÓN</span></button>
                    <a class="remember" href="https://cursos.fpdeinformatica.es/">¿Has olvidado la contraseña?</a>
                    <?php 
                        if(isset($err) && $err == TRUE){
                        echo '<p class="error">Revisa el correo electrónico y/o la contraseña</p>';
                    }
                    ?>
                </form>
            </div>
        </div>

        <div class="cont2">
            <h3>¿No tienes cuenta?</h3>
            <button class="register"><a href="register.php" class="aRegister">REGISTRARSE</a></button>
        </div>
    </div>
</body>

</html>