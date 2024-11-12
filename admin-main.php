'
<!DOCTYPE html> <!-- PÁGINA ADMINISTRADOR CADASTRO -->
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/adm11.css">
    <title>Document</title>
</head>

<body>

    <?php

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
    <header>
        <div class="user-info"> <!--Logout panel-->
            <?php
            echo 'Bem vindo, ' . $_SESSION['nome'] . '.';
            ?>
            <a href="logout.php">Sair</a>
        </div>
    </header>
    <div class="background">
        <div class="panel">
            <div class="checks">
                <div>
                    <input type="checkbox"  name="manha" id="manha" value="Manhã">
                    <span>Manhã</span>
                </div>
                <div>
                    <input type="checkbox"  name="tarde" id="tarde" value="Tarde">
                    <span>Tarde</span>
                </div>
                <div>
                    <input type="checkbox"  name="noite" id="noite" value="Noite">
                    <span>Noite</span>
                </div>
            </div>

            <div class="data">
                <input type="date" name="dia" id="dia" onchange="atualizarOrdenacao()">
            </div>
            <div class="ordenar">
                <span id="asc" onclick="mudarOrdem('ASC')">Ascendente</span>
                <span id="desc" onclick="mudarOrdem('DESC')">Descendente</span>
            </div>
            <select id="ordenarPor" onchange="atualizarOrdenacao()">
                <option value="horarioRetirada">Horario</option>
                <option value="quant">Quantidade</option>
                <option value="semanas">Atraso</option>
            </select>

        </div>
    </div>
    <hr>
    <div class="display-container" id="display-container">
    </div>
    <div class="botao-flutuante"><a href="index-admin.php">Cadastrar usuario</a></div>
    </div>
    <footer>
    </footer>
    <script>
        
        let ordem = 'ASC';

        function mudarOrdem(novaOrdem) {
            ordem = novaOrdem || 'ASC';
            atualizarOrdenacao();
        }

        function atualizarOrdenacao() {
            const criterio = document.getElementById('ordenarPor').value;
            const periodosSelecionados = [];
            const selectedDate = document.getElementById('dia').value;

            if (document.getElementById('manha').checked) periodosSelecionados.push('Manhã');
            if (document.getElementById('tarde').checked) periodosSelecionados.push('Tarde');
            if (document.getElementById('noite').checked) periodosSelecionados.push('Noite');

            const formData = new FormData();
            formData.append('ordenarPor', criterio);
            formData.append('ordem', ordem);
            formData.append('periodos', JSON.stringify(periodosSelecionados));
            formData.append('dia', selectedDate); 
            fetch('check_requisicoes.php', {
                method: 'POST',
                body: formData,
            })
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        console.error(data.error);
                        document.getElementById('display-container').innerHTML = '<p class="erro">Não há requisições que se encaixam nos filtros selecionados.</p>';
                    } else {
                        document.getElementById('display-container').innerHTML = data.requisicoes.map(req => {
                            return `<div class="comment-container">
                    <div class="comment-header">
                        <h3>${req.nome}</h3>
                        <span class="email">${req.email}</span>
                    </div>
                    <div class="comment-text">
                        <p><strong>Materia:</strong> ${req.materia}</p>
                        <p><strong>Quantidade:</strong> ${req.quant}</p>
                        <p><strong>Observações:</strong> ${req.observacoes}</p>
                        <p><strong>Dia:</strong> ${req.dia}</p>
                        <p>Retirada às ${req.horarioRetirada} e devolução às ${req.horarioDevolucao}</p>
                        <p>${req.semanas == 0 ? 'Não há conteúdo atrasado' : 'Há um atraso no conteúdo de ' + req.semanas + ' semana(s)'}</p>
                    </div>
                </div>`;
                        }).join('');
                    }
                })
                .catch(error => console.error('Erro:', error));
        }

    document.querySelectorAll('.checks input[type="checkbox"]').forEach(checkbox => {
        checkbox.addEventListener('change', atualizarOrdenacao);
    });
    atualizarOrdenacao();

    </script>
</body>

</html>