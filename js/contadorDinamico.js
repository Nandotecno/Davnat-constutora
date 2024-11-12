document.addEventListener('DOMContentLoaded', function() {
    const diaAgendamento = document.getElementById('diaAgendamento');
    const selectPeriodos = document.getElementById('selectPeriodos');
    const selectInserir = document.getElementById('selectInserir');
    const selectDevolucao = document.getElementById('select3');
    const quantDisplay = document.getElementById('quantDisp');
    const requisicoesContainer = document.getElementById('requisicoesContainer');
    function checkAvailability() {
        if (diaAgendamento && selectPeriodos && selectInserir && selectDevolucao && quantDisplay) {
            const dia = diaAgendamento.value;
            const periodo = selectPeriodos.value;
            const horarioRetirada = selectInserir.value;
            const horarioDevolucao = selectDevolucao.value;
            if (dia && periodo && horarioRetirada && horarioDevolucao) {
                const xhr = new XMLHttpRequest();
                xhr.open('POST', 'check_availabillity.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        console.log(xhr.responseText); // Verifique a resposta aqui
                        try {
                            const response = JSON.parse(xhr.responseText);
                            document.getElementById('quantDisponivel').value = response.quantidadeDisponivel;
                            quantDisplay.innerText = response.quantidadeDisponivel;
                            
                                // Verifica se há requisições
                                if (response.requisicoes != "" || null) {
                                    requisicoesContainer.innerHTML = ''; // Limpa a lista anterior
                                    response.requisicoes.forEach(req => {
                            
                                        const div = document.createElement('div');
                                        div.className = 'comment-container';
                            
                                        if(req.semanas == 0 || req.semanas =="0" ){
                                        div.innerHTML = `
                                            <div class="divAgend">
                                            <div class="comment-header">
                                                <h3>${req.nome}</h3> <p class="email">${req.email}</p>
                                            </div>
                                            <div class="comment-text">
                                                <p>${req.quant} notebook(s) agendado(s) para ${req.dia}</p>
                                                <p>Usará das ${req.horarioRetirada} até ${req.horarioDevolucao}</p>
                                                <p>Não há atraso no conteúdo</p>
                                            </div>
                                            </div>
                                        `;
                                            
                                        requisicoesContainer.appendChild(div); // Adiciona o elemento ao contêiner
                                        }
                                        else{

                                            div.innerHTML = `
                                            <div class="divAgend">
                                            <div class="comment-header">
                                                <h3>${req.nome}</h3> <p class="email">${req.email}</p>
                                            </div>
                                            <div class="comment-text">
                                                <p>${req.quant} notebook(s) agendado(s) para ${req.dia}</p>
                                                <p>Usará das ${req.horarioRetirada} até ${req.horarioDevolucao}</p>
                                                <p>Há um atraso de ${req.semanas} semana(s).</p>
                                            </div>
                                            </div>
                                        `;
                                            
                                        requisicoesContainer.appendChild(div); // Adiciona o elemento ao contêiner

                                        }
                                    });
                                } else {
                                    requisicoesContainer.innerHTML = ''; // Limpa a lista anterior
                                    const div = document.createElement('div');
                                        div.className = 'comment-container';
                                            div.innerHTML = `
                                            <div class="divAgend">
                                            <div class="comment-header">
                                                <h3>Não há registros pra esse dia</h3>
                                            </div>
                                            </div>`
                                    requisicoesContainer.appendChild(div); // Adiciona o elemento ao contêiner
                                    console.error('Elemento requisicoesContainer não encontrado');
                                }
                            }
                        catch (e) {
                            console.error('Erro ao analisar a resposta JSON:', e);
                        }
                    }
                };
                xhr.send(`dia=${encodeURIComponent(dia)}&periodo=${encodeURIComponent(periodo)}&horarioRetirada=${encodeURIComponent(horarioRetirada)}&horarioDevolucao=${encodeURIComponent(horarioDevolucao)}`);
            }
        } else {
            console.error('Um ou mais elementos não foram encontrados no DOM.');
        }
    }

    if (diaAgendamento) {
        diaAgendamento.addEventListener('change', checkAvailability);
    }
    if (selectPeriodos) {
        selectPeriodos.addEventListener('change', checkAvailability);
    }
    if (selectInserir) {
        selectInserir.addEventListener('change', checkAvailability);
    }
    if (selectDevolucao) {
        selectDevolucao.addEventListener('change', checkAvailability);
    }

    checkAvailability();
});
