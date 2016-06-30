#Maxters Framework

Sim, essa framework foi uma pequena zoeira. Apenas para testar se as minhas libraries estavam ok.


Para instalar:

`
git clone https://github.com/phplegends/Maxters.git
`

Depois:

```
composer install

```


Logo depois execute o servidor para testar

```
cd Maxters\web

php -S localhost:8000

```
Basta acessar http://localhost:8000


Se deseja utilizar o Propel, para conectar-se a um banco de dados, você deverá executar os seguintes comandos, **após ter configurado devidamente seu banco de dados  no `db/propel.json`**:

```
cd db

php propel config:convert

```
