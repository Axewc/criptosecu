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

# Eliminar archivo temporal
# rm temp.txt
