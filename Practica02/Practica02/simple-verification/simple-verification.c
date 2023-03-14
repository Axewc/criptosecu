#include <stdio.h>
#include <ctype.h>

int allLower()
{
	printf("Lo lograste, el secreto es tomar mucha awuita\n");
	printf("Lograste llegar hasta aquí. Felicidades");
	return 0;
}

int main() {

    char pass[16];

    printf("Anota una palabra e intenta descubrir el secreto: \n");
    gets(pass);

    int i = 0;
    int counter = 0;
    char ch;
    ch = pass[0];

    while (ch != '\0') {
    	ch = pass[i];
        if (islower(ch))
            counter++;
 
        i++;
    }

    if(counter == 0)
    	allLower();
    else 
    	printf("\nNo lo lograste, tuviste todos estos errores: %d", counter);
    return 0;
}