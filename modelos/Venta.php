<?php
require_once 'Conexion.php';

class Venta extends Conexion
{
    public $venta_id;
    public $venta_cliente;
    public $venta_fecha;
    public $venta_situacion;


    public function __construct($args = [])
    {
        $this->venta_id = $args['venta_id'] ?? null;
        $this->venta_cliente = $args['venta_cliente'] ?? '';
        $this->venta_fecha = $args['venta_fecha'] ?? '';
        $this->venta_situacion = $args['venta_situacion'] ?? '';
    }

    public function guardar()
    {    /* PARA INGRESAR DATOS A LA TABLA VENTAS */
        $sql = "INSERT INTO ventas(venta_cliente, venta_fecha) values('$this->venta_cliente','$this->venta_fecha')";
        $resultado = self::ejecutar($sql);
        return $resultado;
    }

    public function buscar()
    {       /* Con este Querys Se selecciona los detalles de ventas en la tabla "ventas" que tengan una situación igual a 1, y muestra información adicional de los clientes, productos y  cantidades vendidas. */
        $sql = "SELECT detalle_id, cliente_nombre, venta_fecha, producto_nombre, producto_precio, detalle_cantidad, (producto_precio * detalle_cantidad) as total from ventas inner join clientes on venta_cliente = cliente_id  
             INNER JOIN detalle_ventas ON venta_id = detalle_venta
             INNER JOIN productos ON detalle_producto = producto_id
            where venta_situacion= 1 ";

        if ($this->venta_cliente != '') {
            $sql .= " and venta_cliente = $this->venta_cliente ";
        }

        if ($this->venta_fecha != '') {
            $sql .= " and extend(venta_fecha, year to day) = '$this->venta_fecha' ";
        }
        if ($this->venta_id != null) {
            $sql .= " and venta_id = $this->venta_id ";
        }

        $resultado = self::servir($sql);
        return $resultado;
    }
            //AQUI QUERYS DE FACTURA  
    public function factura($id)
    {
        $sql = "SELECT detalle_id, cliente_nombre, venta_fecha, cliente_nit, producto_nombre, producto_precio, detalle_cantidad, (producto_precio * detalle_cantidad) as total from ventas inner join clientes on venta_cliente = cliente_id  
         INNER JOIN detalle_ventas ON venta_id = detalle_venta
         INNER JOIN productos ON detalle_producto = producto_id
        where venta_situacion= 1 and detalle_id= $id ";
        /* Este Querys realiza una consulta a la base de datos para obtener los detalles de una venta específica, identificada por el valor de la variable pero agrega una cláusula adicional al final del código: and detalle_id= $id. Esta cláusula especifica que solo se deben seleccionar los detalles de venta que tengan un valor de "detalle_id" igual al valor de $id. En otras palabras, se está filtrando la consulta para obtener información detallada de una venta en particular. */
        $resultado = self::servir($sql);
        return $resultado;
    }
}
