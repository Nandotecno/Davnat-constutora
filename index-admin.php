<?php
$showModal = true;
$showModal_Confirm = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $showModal = false;

}

if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION['id'])) {

    header('Location: index.php');

}

if ($_SESSION['tipo'] != "adm") {

    header('Location: painel69.php');

}

?>
<!DOCTYPE html> <!--PÁGINA VISUALIZAÇÃO DE CADASTRO DE USUARIOS (ADMINISTRADOR) -->
<html lang="pt-br">

<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/index.css">

    <title>Cadastro</title>

</head>

<body>
    <header>
    <div class="user-info"> <!--Painel de Logout-->
        <?php
        echo 'Bem vindo, ' . $_SESSION['nome'] . '.';
        ?>
        <a href="logout.php">Sair</a>
    </div>
    </header>
    <main>
    <div class="botao-flutuante"><a href="admin-main.php">Painel de Registros</a></div>

    <form id="main-content" action="" method="POST">

        <h2>Cadastro</h2>

        <div class="div-input">
            <label>Nome</label>
            <input type="text" name="nome">
        </div>

        <div class="div-input">
            <label>E-mail</label>
            <input type="email" name="email">
        </div>

        <div class="div-input">
            <label>Senha</label>
            <input type="password" name="senha">
        </div>
        <input type="hidden" name="userType" id="userTypeInput" value="<?= isset($_SESSION['userType']) ? $_SESSION['userType'] : '' ?>">

        <input class="button" type="submit" value="Entrar">

        <?php
        include("conexaodb.php");
        if (isset($_POST['email']) || isset($_POST['senha']) || isset($_POST['nome'])) {

            if (strlen($_POST['nome']) == 0) {
                echo '<h5 class="titulo">Preencha o nome</h5>';
            } else if (strlen($_POST['email']) == 0) {
                echo '<h5 class="titulo">Preencha o e-mail</h5>';
            } else if (strlen($_POST['senha']) == 0) {
                echo '<h5 class="titulo">Preencha a senha</h5>';
            } else {

                $nome = mysqli_real_escape_string($mysqli, trim($_POST['nome']));
                $email = $mysqli->real_escape_string($_POST['email']);
                $senha = $mysqli->real_escape_string($_POST['senha']);
                $table = $_POST['userType'];

                $sql_code = "SELECT * FROM $table WHERE email = '$email'";
                $sql_query = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->error);

                $quantidade = $sql_query->num_rows;

                if ($quantidade == 1) {

                    echo '<h5 class="titulo">Email existente</h5>';
                    $_SESSION['userType'] = $table;

                } else {
                    unset($_SESSION['userType']);
                    $sql = "INSERT INTO $table (nome, email, senha) VALUES ('$nome', '$email', '$senha')";

                    if ($table == "adms") {

                        $showModal_Confirm = true;

                    } elseif ($table == "usuarios") {

                        $showModal_Confirm = true;

                    } else {

                        echo '<h5 class="titulo">Erro ao puxar tipo do usuario</h5>';
                    }
                    if ($mysqli->query($sql) === TRUE) {
                        $_SESSION['status_cadastro'] = true;
                    }
                }

            }

        }

        ?>
    </form>

    <div id="modalCont" class="modalContent <?= $showModal ? ' mostrar' : '' ?>">
        <!--modal de confirmacao de envio-->
        <div class="content">
            <center>
                <h1 class="title">Selecione o tipo de usuario que deseja cadastrar</h1>
                <button id="btn-tipo" class="adm">Administrador</button>
                <button id="btn-tipo" class="com">Comum</button>
            </center>
        </div>
    </div>

    <div id="modalConfirmacao" class="modalContent <?= $showModal_Confirm ? ' mostrar' : '' ;?>">
        <div class="content">
            <center>
                <?php
                    if($table == "adms")
                    {
                        echo '<h1 class="title">Cadastro de administrador realizado com sucesso!</h1>';
                    }
                    elseif($table == "usuarios")
                    {
                        echo '<h1 class="title">Cadastro de usuario realizado com sucesso!</h1>';
                    }
                ?>
                <p>Deseja cadastrar um novo usuário?</p>
                <button id="btn-sim">Sim</button>
                <button id="btn-nao">Não</button>
            </center>
        </div>
    </div>
    <script>
        const modalConfirmacao = document.getElementById('modalConfirmacao');
        const modalUserType = document.getElementById('modalCont');

        document.getElementById('btn-sim').addEventListener('click', () => {
        modalConfirmacao.classList.remove('mostrar');
        modalUserType.classList.add('mostrar'); 
        });

        document.getElementById('btn-nao').addEventListener('click', () => {
        modalConfirmacao.classList.remove('mostrar');
        window.location.href = "admin-main.php";
        });

        const modalID = 'modalCont';
        const modal = document.getElementById(modalID);
        modal.addEventListener('click', (e) => {
            if (e.target.id === modalID) {

                <?php
                $showModal = false;
                ?>
            }

        });

        document.querySelector('.adm').addEventListener('click', () => {
            modal.classList.remove('mostrar');
            document.getElementById('userTypeInput').value = "adms";
            <?php
            $showModal = false;
            $_SESSION['userType'] = "adms"; 
            ?>
        });

        document.querySelector('.com').addEventListener('click', () => {
            modal.classList.remove('mostrar');
            document.getElementById('userTypeInput').value = "usuarios";
            <?php
            $showModal = false;
            $_SESSION['userType'] = "usuarios";
            ?>
        });

    </script>
    </main>
</body>

</html>