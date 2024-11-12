<?php

session_start();

if (!isset($_SESSION['id'])) {

    header('Location: index.php');
    exit();

}

$showModal = false;

?>

<!DOCTYPE html> <!--PAINEL DE AGENDAMENTO USUÁRIO-->
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/main.css">
    <title>Login Notebook - Professor</title>
    <style>
        .tour-modal {
            background-color: rgba(0, 0, 0, 0.6);
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1000;
        }

        .tour-content {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            max-width: 400px;
            margin: 10% auto;
            text-align: center;
        }

        .tour-controls button {
            margin: 5px;
            padding: 8px 12px;
            cursor: pointer;
        }

        .tour-highlight {
            position: relative;
            z-index: 10;
            border-radius: 5px;
            background-color: rgba(255, 255, 200, 0.3); /* Fundo claro ao redor do elemento */
            animation: highlightGlow 1.5s infinite alternate;
        }

        @keyframes highlightGlow {
            0% {
                box-shadow: 0 0 15px rgba(255, 255, 100, 0.6), 0 0 25px rgba(255, 255, 100, 0.4);
            }
            100% {
                box-shadow: 0 0 30px rgba(255, 255, 100, 1), 0 0 45px rgba(255, 255, 100, 0.7);
            }
        }

        .tour-highlight label,
        .tour-highlight input,
        .tour-highlight select,
        .tour-highlight textarea {
            color: #FFD700; /* Muda o texto para um tom de amarelo/dourado */
            font-weight: bold;
        }

    </style>
</head>

<body onload="dataMin(); dataMax();">
    <div class="user-info"> <!--Logout panel-->
        <?php
        echo 'Bem vindo, ' . $_SESSION['nome'] . '.';
        ?>
        <a href="logout.php">Sair</a>
    </div>
    <img class="ajuda"
        src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAyCAYAAAAeP4ixAAAACXBIWXMAAAsTAAALEwEAmpwYAAADVUlEQVR4nO2ZWU9TQRTHr34Al7h8AtcvQNQQOtOyBXjQF7f4YODNR2OiiVETjOiDJsgia4UoIFsJoASVB4wgIkskgtDOlFRAfXCJJGpo5z4ccy5yaW25vbfeLg/3n5xk0mnvnN+dOTNnTiXJkiVLlixZshQ/AUvfJTg9IntsmWiCOw6D27ZTSnUBSJtkZs8SnNwXnC4JTiGiMbooOHEiHP5GSiXJ+MYZmdzQ+Y2hpmUPyU+2/xIspG8XnPQaBggH6gafbVtSIFa4bY/gdPa/IdZhuN+TcTChEP45uj/Ayfdozq14HPB16ih8mTqmtKN9P8DJN/+8Y19CIIDlbhGcvNdy6MdMATzvvA7VFS1QfrdDsaqKRzDgKobl6YIoQMSdkGUWLSY+Tx6HuqqHKsC/Vl/1AD5NnIiyzEhXXCFkbqdaDvyaywFnTeOGEGvWUNsAP2dzNWFkL3HEBQL3fMHohNbgo/0XQhx2NZUCGyoCPnIWeltuh/SNPTsfLWbeAlzbbDrI6mGnHaytjZWqo80N1bDiyVwPZGYP6cd2tOfJ8ZiVvye25sC4/tccHem7GNaPnwXHio5tud58ECW10B64u+WO4mRFWQd8HD8Z1j/QVayCNNY6dZwt5IOpEODN2q3j7cFvdza8GzwHS+Onwvp8o2fgXnmrCtLfUaJnRgBmHTtMAxHMdkjPoJEM4+RFzxVlloKDffHNaX3P8NjTTAOROcmJFeRp542w7Xew56ru38uMZicdBJdYMEBlWRu86rsEAUaTAyJiXFovH18OSVEibQAJXVqwetsz7MSTtlsqSFdTaUxLE8wMdpRgZMGoE33tN1UQbMcA4jMVQgHhxGnUEdxyayqbFcO2YRBG60wHWS0gGF8aeA/RcxeJGOheao9L0hjg9LVRZ5Zn8mF5Js8wRICRsbgVJwQjNiPOsKFCZctFwyw46bMRLCwU6HWmv73EcEoiFCMuKSFXXUZm9M1IkTojfLhQL4Q7YRUVLBBgoUBfjOTpjpEAFh+8GXulxJeDtIsQhoxR5nfbDkjJEMxnbsVCwf+DEBc+S0q2sFgdYHQ4li0WCxpSyhWxvcSB11O82WkA+PDERoCUK2JHEiZ7mLmqfyt47GmmJ4CWLFmyZMmSJSlEfwD65jxB590LHQAAAABJRU5ErkJggg==">

    <form action=" " method="POST" id="main-content">
        <h2>Agendamento de Notebook</h2>
        <div class="div-input">
            <label for="nome" id="txtNome">Nome:</label>
            <input required id="nome" type="text" name="nome">
        </div>

        <div class="div-input">
            <label for="materia" id="txtMateria">Matéria:</label>
            <input required id="materia" type="text" name="materia">
        </div>

        <div class="div-input-radio">
            <label for="materia" id="txtAtraso">Conteúdo atrasado?</label>
            <input required id="atraso" type="radio" name="atraso" value="sim">Sim
            <input required id="atraso" type="radio" name="atraso" value="nao">Não
        </div>
        <div id="div-atrasoTxt"></div>
        <div class="div-input">
            <label for="observacoes" id="txtObservacoes">Observações:</label>
            <textarea placeholder="Ex.: Será usado na sala 42 para passar powerpoint, incluir HDMI e cabo de rede."
                required id="observacoes" type="textarea" name="observacoes"></textarea>
        </div>

        <div class="div-input">
            <label for="calendario" id="txtDiaAgendamento">Dia que usará o notebook:</label>
            <input type="date" value="<?php echo date('Y-m-d') ?>" id="diaAgendamento" min="" max="" name="date">
        </div>

        <div class="div-input">
            <label for="calendario" id="txtPeriodos">Periodo:</label> <!--Select que gera horarios dinamicamente-->
            <select id="selectPeriodos" name="periodo" onchange="mudarHorarios()">
                <option value="Manhã">Manhã</option>
                <option value="Tarde">Tarde</option>
                <option value="Noite">Noite</option>
            </select>
        </div>

        <div class="div-input">
            <label for="calendario" id="txtHorarioRetirada">Horario de retirada:</label>
            <select id="selectInserir" name="horarioRetirada">

            </select>
        </div>

        <div class="div-input">
            <label for="calendario" id="txtHorarioDevolucao">Horario de devolução:</label>
            <select id="select3" name="horarioDevolucao">
            </select>
        </div>

        <div class="div-input">
            <label for="materia" id="txtQuant">Quantidade: </label>
            <input required id="quant" type="text" name="quant">
        </div>

        <input type="hidden" id="quantDisponivel" name="quantDisponivel">

        <?php

        echo '<h4> A Quantidade de Notebooks disponíveis são: <span id="quantDisp"> 8 </span></h4>';//total de notes disponivel que altera dinamicamente com base no preenchimento do formulario
        
        ?>

        <input class="btn-envia" type="submit" name="enviar">

        <?php

        if (isset($_POST['materia']) || isset($_POST['observacoes']) || isset($_POST['date'])) {
            include('conexaodb.php');
            if (strlen($_POST['nome']) == 0) {
                echo '<h5 class="titulo">Preencha o nome.</h5>';
            } else if (strlen($_POST['materia']) == 0) {
                echo '<h5 class="titulo">Preencha a matéria.</h5>';
            } else if (strlen($_POST['quant']) == 0) {
                echo '<h5 class="titulo">Preencha a quantidade.</h5>';
            } else {

                $materia = $mysqli->real_escape_string($_POST['materia']);
                $observ = $mysqli->real_escape_string($_POST['observacoes']);
                $dia = $mysqli->real_escape_string($_POST['date']);
                $periodo = $mysqli->real_escape_string($_POST['periodo']);
                $horarioDevolucao = str_pad($_POST['horarioDevolucao'], 5, "0", STR_PAD_LEFT);
                $horarioRetirada = str_pad($_POST['horarioRetirada'], 5, "0", STR_PAD_LEFT);
                $quant = $mysqli->real_escape_string($_POST['quant']);
                $nome = $mysqli->real_escape_string($_POST['nome']);
                $usuario = $_SESSION['id'];
                $dispQuant = $_POST['quantDisponivel'];

                switch ($_POST["atraso"]) {

                    case "sim":
                        $atraso = $_POST['semanas'];
                        break;
                    case "nao":
                        $atraso = "0";
                        break;

                }

                $sql = "SELECT * FROM requisicao WHERE materia = '$materia' AND dia ='$dia' AND horarioDevolucao = '$horarioDevolucao' AND horarioRetirada='$horarioRetirada'";
                $sql_query = $mysqli->query($sql) or die("Falha na execução do código SQL: " . $mysqli->error);

                $quantidade = $sql_query->num_rows;

                if ($quantidade >= 1) {

                    echo '<h5 class="titulo">Já existe uma requisição igual a essa.</h5>';

                } else {

                    if ($quant > $dispQuant) {
                        print_r($dispQuant);
                        print_r($quant);
                        echo '<h5 class="titulo">Você está solicitando uma quantidade de notebooks maior do que a disponível!</h5>';
                    } else if ($quant <= $dispQuant) {

                        $showModal = true; //exibe modal de confirmação de envio de formulario
        
                        $sql = "INSERT INTO requisicao (materia, dia, periodo,horarioRetirada, horarioDevolucao, observacoes, quant, semanas, id_usuario) 
                            VALUES ('$materia', '$dia' , '$periodo', '$horarioRetirada', '$horarioDevolucao', '$observ' , $quant, $atraso, $usuario)";
                        mysqli_query($mysqli, $sql) or die("Falha na execução do código SQL: " . $mysqli->error);

                    }
                }

            }
        }

        ?>
        <div id="modalCont" class="modalContent <?= $showModal ? ' mostrar' : '' ?>">
            <!--modal de confirmacao de envio-->
            <div class="content">
                <button class="fechar">x</button>
                <center>
                    <h1 class="title">Agendamento feito com sucesso!</h1>
                </center>
                <center>
                    <p class="text" id="text">Seu agendamento de
                        <?php echo $quant . " notebook(s) está marcado para a data " . date("d/m/Y", strtotime($dia)) . "<br> Retirada as " . $horarioRetirada . " e devolução as " . $horarioDevolucao; ?>
                    </p>
                </center>
            </div>
        </div>
        <div id="tourModal" class="tour-modal">
            <div class="tour-content">
                <p id="tourText"></p>
                <div class="tour-controls">
                    <button onclick="prevStep()">Voltar</button>
                    <button onclick="nextStep()">Avançar</button>
                    <button onclick="endTour()">Sair</button>
                </div>
            </div>

        </div>

    </form>
    <div id="requisicoesContainer"></div>
    <script src="js/script.js"></script>
    <script>
        const modalID = 'modalCont'
        const modal = document.getElementById(modalID);
        modal.addEventListener('click', (e) => {
            if (e.target.id == modalID || e.target.className == 'fechar') {
                modal.classList.remove('mostrar');
                <?php
                $showModal = false;
                ?>
            }

        });


        function dataMin() {

            let today = new Date();
            let dia = today.getDate().toString().padStart(2, '0');
            let mes = (today.getMonth() + 1).toString().padStart(2, '0');  // Adiciona zero à esquerda se necessário
            let ano = today.getFullYear();
            let data = ano + "-" + mes + "-" + dia;

            document.getElementById("diaAgendamento").setAttribute("min", data);

        }

        function dataMax() {

            let today = new Date();
            let dia = (today.getDate() + 7).toString().padStart(2, '0');
            let mes = (today.getMonth() + 1).toString().padStart(2, '0');  // Adiciona zero à esquerda se necessário
            let ano = today.getFullYear();
            let data = ano + "-" + mes + "-" + dia;

            document.getElementById("diaAgendamento").setAttribute("max", data);

        }

        document.addEventListener('DOMContentLoaded', function () {
            let input = document.getElementById('diaAgendamento');

            function isWeekend(date) {
                let day = date.getDay();
                return (day === 6 || day === 5);
            }

            input.addEventListener('input', function () {
                let selectedDate = new Date(input.value);
                if (isWeekend(selectedDate)) {
                    alert('Sábados e domingos não são dias letivos.');
                    input.value = "<?php echo date('Y-m-d') ?>";
                }
            });
        });

        const tourSteps = [
    { elementId: 'nome', labelId: 'txtNome', text: 'Digite o nome do responsável pelo agendamento.' },
    { elementId: 'materia', labelId: 'txtMateria', text: 'Preencha a matéria ou disciplina.' },
    { elementId: 'atraso', labelId: 'txtAtraso', text: 'Marque se é um conteúdo atrasado.' },
    { elementId: 'observacoes', labelId: 'txtObservacoes', text: 'Descreva detalhes do uso do notebook.' },
    { elementId: 'diaAgendamento', labelId: 'txtDiaAgendamento', text: 'Escolha a data do uso.' },
    { elementId: 'selectPeriodos', labelId: 'txtPeriodos', text: 'Selecione o período (manhã, tarde ou noite).' },
    { elementId: 'selectInserir', labelId: 'txtHorarioRetirada', text: 'Defina o horário de retirada.' },
    { elementId: 'select3', labelId: 'txtHorarioDevolucao', text: 'Defina o horário de devolução.' },
    { elementId: 'quant', labelId: 'txtQuant', text: 'Informe a quantidade de notebooks.' }
];


let currentStep = 0;

function startTour() {
    document.getElementById('tourModal').style.display = 'block';
    showStep();
}

function showStep() {
    const step = tourSteps[currentStep];
    const element = document.getElementById(step.elementId);
    const label = document.getElementById(step.labelId);

    // Atualizar o texto do tour
    document.getElementById('tourText').innerText = step.text;

    // Remover destaque de qualquer etapa anterior
    removeHighlight();

    // Verificar se o elemento e o label existem antes de destacar
    if (element) {
        element.classList.add('tour-highlight');
        element.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }
    if (label) {
        label.classList.add('tour-highlight');
    }
}



function nextStep() {
    if (currentStep < tourSteps.length - 1) {
        currentStep++;
        showStep();
    } else {
        endTour();
    }
}

function prevStep() {
    if (currentStep > 0) {
        currentStep--;
        showStep();
    }
}

function endTour() {
    document.getElementById('tourModal').style.display = 'none';
    removeHighlight();
    currentStep = 0;
}

function removeHighlight() {
    document.querySelectorAll('.tour-highlight').forEach((el) => {
        el.classList.remove('tour-highlight');
    });
}

// Vincula o tour ao clique da imagem de ajuda
document.querySelector('.ajuda').addEventListener('click', startTour);

    </script>
    <script src="js/contadorDinamico.js"></script>

</body>


</html>

