
<!DOCTYPE html> <!--página de login usuário comum-->
<html lang="pt-br">
<head>
	
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="css/index.css">

    <title>Login</title>

</head>

<body>

    <form id="main-content"action="" method="POST">

	<h2>Acesse sua conta</h2>

    <div class="div-input">
    <label>E-mail</label>
    <input type="email" name="email">
    </div>

    <div class="div-input">
    <label>Senha</label>
    <input type="password" name="senha">
    </div>

    <input class="button" type="submit" value="Entrar">

	<?php
include('conexaodb.php');

if(isset($_POST['email']) || isset($_POST['senha'])) {

    if(strlen($_POST['email']) == 0) {
        echo '<h5 class="titulo">Preencha seu e-mail</h5>';
    } else if(strlen($_POST['senha']) == 0) {
        echo '<h5 class="titulo">Preencha sua senha</h5>';
    } else {

        $email = $mysqli->real_escape_string($_POST['email']);
        $senha = $mysqli->real_escape_string($_POST['senha']);

        $sql_code = "SELECT * FROM usuarios WHERE email = '$email' AND senha = '$senha'";
        $sql_query = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->error);

        $quantidade = $sql_query->num_rows;

        if($quantidade == 1) {
            
            $usuario = $sql_query->fetch_assoc();

			if(!isset($_SESSION[1])) {
				session_start();
			}
			
			$_SESSION['id'] = $usuario['id'];
			$_SESSION['nome'] = $usuario['nome'];
            $_SESSION['email'] = $usuario['email'];
            $_SESSION['tipo'] = "comum";
        
            header("Location: painel69.php");

        } 

        $sql_code = "SELECT * FROM adms WHERE email = '$email' AND senha = '$senha'";
        $sql_query = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->error);
        $quantidade = $sql_query->num_rows;

        if($quantidade == 1) {

            $usuario = $sql_query->fetch_assoc();

			if(!isset($_SESSION[1])) {
				session_start();
			}
			
			$_SESSION['id'] = $usuario['id'];
			$_SESSION['nome'] = $usuario['nome'];
			$_SESSION['email'] = $usuario['email'];
            $_SESSION['tipo'] = "adm";

            header("Location: admin-main.php");

        }
        else{

            echo '<h5 class="titulo">Falha ao logar! E-mail ou senha incorretos</h5>';

        }
    }

}
?>

    </form>

</body>

</html>