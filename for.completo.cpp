#include <stdio.h>
#include <locale.h>

int main(){
	
	setlocale(LC_ALL,"Portuguese");
	
	int idade, mediaidade = 0, qtdmaiornoventa = 0, i;
	float peso;
	
	for(i = 0; i < 7; i++){
		printf("Digite a idade: ");
		scanf("%d", &idade);
		
		printf("Digite o peso: ");
		scanf("%f", &peso);
		
		if(peso > 90){
			qtdmaiornoventa++;
		}
		
		//mediaidade = 0
		// mediaidade = 0 + 10
		// mediaidade = 10 + 20
		mediaidade = mediaidade + idade;
	}
	
	mediaidade = mediaidade / 7;
	
	printf("Pessoas com mais de 90kg: %d\n", qtdmaiornoventa);
	printf("Média de idade: %d\n", mediaidade);
	
	return 0;
}


























