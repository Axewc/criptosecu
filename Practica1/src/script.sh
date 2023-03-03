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

# Comprobar la conectividad de la red
ping -c 4 $1 > ping.txt
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

# Obtener información de la IP
ip_info=$(whois $ip)

# Extraer campos específicos del archivo temporal
segmentos_ip=$(grep -i 'inetnum:' <<< "$ip_info" | awk '{print $2}')
disponibilidad=$(grep -i 'status:' <<< "$ip_info" | awk '{print $2}')

# Buscar registros IPv4 e IPv6
ipv4=$(dig $1 A +short)
ipv6=$(dig $1 AAAA +short)

# Registros reversos
reverse_ipv4=$(dig -x $ipv4 +short)
reverse_ipv6=$(dig -x $ipv6 +short)

# La ruta y los saltos para llegar al dominio
tracert=$(traceroute -w 1000 $1)

# Enumerar las DNS
dns=$(host -t ns $1)

# Puertos, estados y servicios
nmap_output=$(nmap $1)
open_ports=$(grep -i 'open' <<< "$nmap_output")

# Imprimir información del dominio
echo "Nombre del dominio: $nombre_dominio"
echo "Fecha de creación: $creado"
echo "Fecha de actualización: $actualizado"
echo "Fecha de expiración: $expiracion"
echo "Organización: $organizacion"
echo "País: $pais"
echo "Estado: $estado"
echo "Ciudad: $ciudad"
echo "Calle: $calle"
echo "Código postal: $codigo_postal"
echo "Nombre de contacto: $contacto_nombre"
echo "Email de contacto: $contacto_email"
echo "Teléfono de contacto: $contacto_telefono"

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

echo "que pasaaa"
# Eliminar archivo temporal
rm temp.txt
