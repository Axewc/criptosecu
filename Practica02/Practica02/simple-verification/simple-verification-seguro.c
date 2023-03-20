#include <stdio.h>
#include <ctype.h>
#include <string.h>

#define MAX_PASSWORD_LENGTH 16

int allLower()
{
	printf("Lo lograste, el secreto es tomar mucha awuita\n");
	printf("Lograste llegar hasta aquí. Felicidades\n");
	return 0;
}

int main() {
    char password[MAX_PASSWORD_LENGTH+1];

    printf("Anota una palabra e intenta descubrir el secreto:\n");
    if (fgets(password, sizeof(password), stdin) == NULL) {
        perror("Error al leer la contraseña");
        return 1;
    }

    password[strcspn(password, "\n")] = 0; // Elimina el salto de línea del final de la contraseña si es que lo hay

    int i = 0;
    int counter = 0;
    char ch = password[0];

    while (ch != '\0') {
    	ch = password[i];
        if (islower(ch))
            counter++;
 
        i++;
    }

    if(counter == 0)
    	allLower();
    else 
    	printf("\nNo lo lograste. ¡Sigue intentando!\n");

    return 0;
}
