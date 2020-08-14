Simulación de pasarela de pago
==============================

Este es un script simple para completar un ejercicio de programación.

## Instrucciones:

1) Clona este repo en tu servidor de desarrollo. No necesita BD. 
2) Añade la información de un comercio al fichero `config.php`
3) En tu tienda, para simular el pago, envía al cliente al index de la pasarela, con éstos parámetros, por get o post:
   * `cod_comercio`: El código del comercio
   * `cod_pedido`: El código del pedido que se va a pagar. La pasarela lo enviará de vuelta cuando se realice una acción de pago
   * `importe`: el importe en unidades monetarias
   * `concepto`: El concepto que se mostrará al usuario

El usuario podrá *pagar*, *cancelar el pago*, o hacer un intento de pago *sin éxito*.

La pasarela informa mediante una petición get a la dirección de pingback especificada, con los siguientes parámetros:

* `cod_pedido`
* `importe`
* `estado` El estado de la transacción, que será una de estas tres cadenas:
  * `ok`
  * `nook` El pago no se completó con éxito
  * `cancelado` El usuario canceló voluntariamente el pago
  * `cod_operacion` Un codigo (simulado en este caso), que representa al código de la operación realizada en la pasarela, para referencia tanto de la empresa de la tienda como del usuario.

Se debe programar un servicio que recoja esta petición y actualice la información en la BD pertinentemente, y que al recibir al cliente ya tenga el estado de la transacción.

Haz que el servicio devuelva un json con un mensaje de depuración (que no se utiliza este caso, pero se visualizará en la simulación)

Ej:
```json
{
    "msg": "Servidor de la tienda informado"
}
```

Finalmente, el usuario volverá a la tienda con un get reentrando por GET a la url indicada, pasando "cod_pedido" como parámetro.
