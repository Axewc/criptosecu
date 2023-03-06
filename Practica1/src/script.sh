#!/bin/bash

if [ -z "$1" ]; then
    echo "Debe proporcionar un dominio como argumento."
    exit 1
fi

#Recibimos el dominio y vamos a usar whois para obtener la info
whois $1 > temp.txt


#Extraer datos basicos del punto 1-4
echo "Analisis de $1:" >> $1.txt
grep -m 1 "Domain" temp.txt >> $1.txt
grep -m 1 "Created" temp.txt >> $1.txt
grep -m 1 "Last" temp.txt >> $1.txt
grep -m 1 "Expiration" temp.txt >> $1.txt
sed -n '/Registrant:/,/Name Servers:/ {/Name Servers:/d; p}' temp.txt >> $1.txt
echo "" >>$1.txt
#Recibimos ahora conectividad de red
echo "******Conectividad de la red:******" >> $1.txt
ping -c 4 $1 >> ping.txt 
cat ping.txt >> $1.txt
echo "" >>$1.txt

# Medir latencia
echo "******Latencia:*******" >> $1.txt
min=$(grep "min/avg/max" ping.txt | awk '{print $4}' | cut -d '/' -f 1)
avg=$(grep "min/avg/max" ping.txt | awk '{print $4}' | cut -d '/' -f 2) 
max=$(grep "min/avg/max" ping.txt | awk '{print $4}' | cut -d '/' -f 3)
echo "min=$min" >> $1.txt
echo "avg=$avg" >> $1.txt
echo "max=$max" >> $1.txt
echo "" >>$1.txt

rm ping.txt
#La IP publica y sus segmentos 
echo "******IP publica y sus segmentos:******" >> $1.txt
nslookup $1 >> $1.txt
echo "" >>$1.txt

#Registros de disponibilidad 
echo "****** Registros de disponibilidad ******" >> $1.txt 
curl -s -o /dev/null -w "%{http_code}\n" $1 >> $1.txt
echo "" >>$1.txt

#Registro IPv4 e IPv6 
echo "*******Registros IPv4 e IPv6*******" >> $1.txt
echo "-------IPv4-------" >> $1.txt
host -t A $1 >> $1.txt
echo "" >> $1.txt
echo "-------IPv6-------" >> $1.txt
host -t AAAA $1 >> $1.txt
echo " " >> $1.txt

#Registros reversos 
echo "******Registros reversos:******" >> $1.txt
host $1 >> $1.txt
echo " " >> $1.txt

#Ruta y los saltos para llegar al dominio 
echo "****** Ruta y saltos ******" >> $1.txt
traceroute $1 >> $1.txt
echo " " >> $1.txt

#Enumerar lo DNS 
echo "******Enumeración de DNS******" >> $1.txt
echo "-----Usando dig ------" >> $1.txt
dig +nocmd $1  >> $1.txt 
echo " " >> $1.txt
echo "------Usando dnsrecon -------" >> $1.txt
dnsrecon -d $1 -t std >> $1.txt
echo " " >> $1.txt

#Puertos, estados y servicios 
echo "******Puertos, estados y servicios******" >> $1.txt
nmap $1 >> $1.txt


#Ya que no necesitamos más datos de este 
rm temp.txt

cat $1.txt
#Descomentar en caso de no querer almacenar la info completa
#rm $1.txt

