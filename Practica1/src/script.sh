#!/bin/bash

if [ -z "$1" ]; then
    echo "Debe proporcionar un dominio como argumento."
    exit 1
fi

# Obtener información de whois
whois $1 > temp.txt

# Extraer campos específicos del archivo temporal
nombre_dominio=$(grep -i 'domain name:' temp.txt | awk '{print $3}')
creado=$(grep -i 'Creation Date:' temp.txt | awk '{print $3}')
actualizado=$(grep -i 'Updated Date:' temp.txt | awk '{print $3}')
expiracion=$(grep -i 'Expiration Date:' temp.txt | awk '{print $3}')
organizacion=$(grep -i 'Registrant Organization:' temp.txt | awk '{print $3}')
pais=$(grep -i 'Registrant Country:' temp.txt | awk '{print $3}')
estado=$(grep -i 'Registrant State/Province:' temp.txt | awk '{print $3}')
ciudad=$(grep -i 'Registrant City:' temp.txt | awk '{print $3}')
calle=$(grep -i 'Registrant Street:' temp.txt | awk '{print $3}')
codigo_postal=$(grep -i 'Registrant Postal Code:' temp.txt | awk '{print $3}')
contacto_nombre=$(grep -i 'Registrant Name:' temp.txt | awk '{print $3}')
contacto_email=$(grep -i 'Registrant Email:' temp.txt | awk '{print $3}')
contacto_telefono=$(grep -i 'Registrant Phone:' temp.txt | awk '{print $3}')
ip=$(dig +short $1 | head -1)


# Imprimir información del dominio
#cat temp.txt
# imprimie los primeros caracteres de temp.txt usando head
head -c 1300 temp.txt

# Comprobar la conectividad de la red
ping -c 4 -w 5 $1 > ping.txt
connectivity=$(cat ping.txt | tail -1)

# Medir la latencia
if [[ $connectivity == "4 received"* ]]
then
    min_latency=$(cat ping.txt | grep "min/avg/max" | awk '{print $4}' | cut -d '/' -f 1)
    avg_latency=$(cat ping.txt | grep "min/avg/max" | awk '{print $4}' | cut -d '/' -f 2)
    max_latency=$(cat ping.txt | grep "min/avg/max" | awk '{print $4}' | cut -d '/' -f 3)
else
    min_latency="No disponible"
    avg_latency="No disponible"
    max_latency="No disponible"
fi

####

# Comprobar la conectividad de la red
echo "Comprobando la conectividad de la red..."
ping -c 5 $nombre_dominio

#Medir la latencia
echo "Midiendo la latencia..."
traceroute $nombre_dominio

# Obtener información de DNS
echo "Obteniendo información de DNS..."
host $nombre_dominio

# Obtener información de puertos
echo "Obteniendo información de puertos..."
nmap $nombre_dominio

# Eliminar archivo temporal
# rm temp.txt

# Eliminar archivo temporal
# rm ping.txt

