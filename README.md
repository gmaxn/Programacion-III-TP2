# Programacion-III-TP2

#### Crear una API rest con las siguientes rutas:

1- POST signin: recibe email, clave, nombre, apellido, telefono y tipo (user, admin) y lo guarda en un archivo.

2- POST login: recibe email y clave y chequea que existan, si es así retorna un JWT de lo contrario informa el error (si el email o la clave están equivocados).

#### A PARTIR DE AQUI TODAS LAS RUTAS SON AUTENTICADAS.

3- GET detalle: Muestra todos los datos del usuario actual.

4- GET lista: Si el usuario es admin muestra todos los usuarios, si es user solo los del tipo user.

## Modo de uso - POST signin

```python
Request Url: http://localhost/Programacion-III-TP2/index.php/personas/signin
Request Method: POST
```
<img src="/readme_images/readme_img1.png" style="display:block; margin:auto;"></img>

Response:

```python
{
    "status": "Succeed",
    "data": {
        "id": 1588099439,
        "email": "pparker@gmail.com",
        "password": "***",
        "firstname": "Peter",
        "lastname": "Parker",
        "telephone": "123456",
        "userType": "admin"
    }
}
```

## Modo de uso - POST login

```python
Request Url: http://localhost/Programacion-III-TP2/index.php/personas/login
Request Method: POST
```
<img src="/readme_images/readme_img2.png" style="display:block; margin:auto;"></img>

Response:

```python
{
    "status": "Succeed",
    "data": {
        "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE1ODgxMDIyMjIsImV4cCI6MTU4ODEwMjI4MiwiZW1haWwiOiJwcGFya2VyQGdtYWlsLmNvbSIsImZpcnN0bmFtZSI6IlBldGVyIiwibGFzdG5hbWUiOiJQYXJrZXIiLCJ1c2VyX3R5cGUiOiJ1c2VyIn0.7SGsqmul9TmltFkdyhEkA_p8gRjMK3y4c6t0ZoR1DwY"
    }
}
```
Nota: la duracion del Token sera de 60 segundos antes de que este expire.

## Modo de uso - GET detalle

```python
Request Url: http://localhost/Programacion-III-TP2/index.php/personas/details
Request Method: GET
```
<img src="/readme_images/readme_img3.PNG" style="display:block; margin:auto;"></img>

Response:

```python
{
    "status": "succeed",
    "data": {
        "id": 1588096271,
        "email": "pparker@gmail.com",
        "password": "$2y$10$CA6epv35GfaEvmG.pjfVUe5zMl3O3EuBCgftNcqqIbKpr7ueMuftK",
        "firstname": "Peter",
        "lastname": "Parker",
        "telephone": "1160989712",
        "userType": "user"
    }
}
```

## Modo de uso - GET lista

```python
Request Url: http://localhost/Programacion-III-TP2/index.php/personas/list
Request Method: GET
```
<img src="/readme_images/readme_img4.PNG" style="display:block; margin:auto;"></img>

Response:

```python
{
    "status": "succeed",
    "data": [
        {
            "id": 1588096271,
            "email": "pparker@gmail.com",
            "password": "$2y$10$CA6epv35GfaEvmG.pjfVUe5zMl3O3EuBCgftNcqqIbKpr7ueMuftK",
            "firstname": "Peter",
            "lastname": "Parker",
            "telephone": "1160989712",
            "userType": "user"
        },
        {
            "id": 1588096295,
            "email": "mjwatson@gmail.com",
            "password": "$2y$10$sZF/IFD2GCL.1sOGP66RIuxbKSzqMjN7.FUpPROyLHfF/DMU1O6CG",
            "firstname": "Mary Jane",
            "lastname": "Watson",
            "telephone": "1160989712",
            "userType": "user"
        }
    ]
}
```