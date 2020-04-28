# Programacion-III-TP2

Crear una API rest con las siguientes rutas:

1- POST signin: recibe email, clave, nombre, apellido, telefono y tipo (user, admin) y lo guarda en un archivo.

2- POST login: recibe email y clave y chequea que existan, si es así retorna un JWT de lo contrario informa el error (si el email o la clave están equivocados).

#### A PARTIR DE AQUI TODAS LAS RUTAS SON AUTENTICADAS.

3- GET detalle: Muestra todos los datos del usuario actual.

4- GET lista: Si el usuario es admin muestra todos los usuarios, si es user solo los del tipo user.

## Usage

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
