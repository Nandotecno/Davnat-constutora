	#include <stdio.h>
	
	int main(){
		
		int numero, i;
		
		printf("Digite um número: ");
		scanf("%d", &numero);
		
		printf("CRESCENTE\n");
		for(i= 0; i <= numero; i++){
			printf("- %d\n", i);
		}
		
		printf("\n\nDECRESCENTE\n");
		for(i = numero; i >= 0; i--){
			printf("- %d\n, i");
		}
		
		return 0;
		
		}
		
		
		
		
		
		
		
		
		
		
		
		
		
