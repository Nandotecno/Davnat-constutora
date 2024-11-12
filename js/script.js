var Manha = ["7:30", "8:20", "9:10", "10:15", "11:05", "11:55", "12:45"];
var Tarde = ["13:20", "14:10", "15:25", "16:15", "17:05", "17:50"];
var Noite = ["18:45", "19:25", "20:05", "21:00", "21:40", "22:20"];

var Manha2 = ["8:20", "9:10", "10:00", "11:05", "11:55", "12:45", "13:35"];
var Tarde2 = ["14:10", "15:00", "16:15", "17:05", "17:50", "18:40"];
var Noite2 = ["19:25", "20:05", "20:45", "21:40", "22:20", "23:00"];

// Função para mudar os horários com base no período selecionado
function mudarHorarios() {
    var select = document.getElementById("selectInserir");
    var select2 = document.getElementById("select3");
    var periodoSelecionado = document.getElementById("selectPeriodos").value;

    var horarios = Manha;
    var horarios2 = Manha2;
    
    switch (periodoSelecionado) {
        case "Manhã":
            horarios = Manha;
            horarios2 = Manha2;
            break;
        case "Tarde":
            horarios = Tarde;
            horarios2 = Tarde2;
            break;
        case "Noite":
            horarios = Noite;
            horarios2 = Noite2;
            break;
        default:
            horarios = []; // armazena o horario desejado em um array
    }
    
    // Limpar todas as opções existentes
    select.innerHTML = "";
    select2.innerHTML = "";
    
    // Adicionar as novas opções de horários
    for (var i = 0; i < horarios.length; i++) {
        var option = document.createElement("option");
        option.text = horarios[i];
        option.value = horarios[i];
        select.appendChild(option);
    }

    for (var i = 0; i < horarios2.length; i++) {
      var option = document.createElement("option");
      option.text = horarios2[i];
      option.value = horarios2[i];
      select2.appendChild(option);
    }

    select.addEventListener("change", function() {

        var selectedIndex = select.selectedIndex;
    
        if (selectedIndex < horarios2.length) {

            select2.selectedIndex = selectedIndex;

        }
    });

    select2.addEventListener("change", function () {

        var selectedIndex2 = select2.selectedIndex;

        if (selectedIndex2 < select.selectedIndex) {

            select.selectedIndex = selectedIndex2;

        }

    });

}
mudarHorarios();

function displayAtraso(){
    const radio = document.querySelector('input[name="atraso"]:checked');
    divContainer = document.getElementById("div-atrasoTxt");

    divContainer.innerHTML = '';

    if(radio.value != null || "")
    {
    switch(radio.value){

        case "sim":
            const div = document.createElement('div');
            div.classList.remove('show'); // Remove the show class for reset

            div.className = 'div-atrasoTxt'; 
            div.innerHTML = `
                <label>Tempo de atraso: (em semanas)</label>
                <input type="text" placeholder="1-5" maxlength="1" name="semanas" onkeypress="return event.charCode >= 49 && event.charCode <= 53" >
             `;
            divContainer.appendChild(div)

            setTimeout(() => {
                div.classList.add('show');
            }, 0);
            break;

        case "nao":
            divContainer.innerHTML = '';
            break;

    }
    }
}
document.querySelectorAll('input[name="atraso"]').forEach(radio => {
    radio.addEventListener('change', displayAtraso);
});
displayAtraso();