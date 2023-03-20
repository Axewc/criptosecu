#include <stdio.h>
#include <string.h>
#include <unistd.h>

#define MAX_PASSWORD_LENGTH 16

int granted(char *password) {
  printf("Lograste llegar hasta aquí. ¡Felicidades!\n");
  printf("Acceso Autorizado...\n");

  char *cmd[] = {"./a.out", NULL};
  if (fork() == 0) {
    execvp(cmd[0], cmd);
  }

  return 0;
}

int main() {
  char password[MAX_PASSWORD_LENGTH+1];
  printf("¡Bienvenido!\n");
  printf("Anota la contraseña por favor:");

  if (fgets(password, sizeof(password), stdin) == NULL) {
    perror("Error al leer la contraseña");
    return 1;
  }

  // Elimina el salto de línea del final de la contraseña si es que lo hay
  password[strcspn(password, "\n")] = 0;

  if (strcmp(password, "root")) {
    printf("Lo siento la contraseña es incorrecta. \nAcceso Denegado\n");
  } else {
    granted(password);
  }

  return 0;
}
