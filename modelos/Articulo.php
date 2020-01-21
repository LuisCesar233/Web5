<?php
require_once "../config/Conexion.php";
class Articulo
{
    public function __construct()
    {

    }

    public function insertar($idcategoria,$codigo,$nombre,$stock,$descripcion,$imagen)
    {
        $sql="INSERT INTO articulo (idcategoria,codigo,nombre,stock,descripcion,imagen,condicion)
            VALUES ('$idcategoria','$codigo','$nombre','$stock','$descripcion','$imagen','1')";
        return ejecutarConsulta($sql);

        /*$validacion=$this->comprueba_duplicados($codigo,$nombre,0);
        if ($validacion==0) 
        {
            $sql="INSERT INTO articulo (idcategoria,codigo,nombre,stock,descripcion,imagen,codigo)
            VALUES ('$idcategoria','$codigo','$nombre','$stock','$descripcion','$imagen','1')";
            return ejecutarConsulta($sql);
        }
        else {
            return 0;
        }*/
    }
    public function editar($idarticulo,$idcategoria,$codigo,$nombre,$stock,$descripcion,$imagen)
    {
        $sql="UPDATE articulo SET idcategoria='$idcategoria', codigo='$codigo', nombre='$nombre',stock='$stock', descripcion='$descripcion', imagen='$imagen' WHERE idarticulo='$idarticulo'";
        return ejecutarConsulta($sql);

        /*$validacion=$this->comprueba_duplicados($codigo, $nombre,$idarticulo);
        if($validacion==0)
        {
            $sql="UPDATE articulo SET idcategoria='$idcategoria', codigo='$codigo', nombre='$nombre',stock='$stock', descripcion='$descripcion', imagen='$imagen' WHERE idarticulo='$idarticulo'";
            return ejecutarConsulta($sql);

        }
        else {
            return 0;
        }*/
    }
    public function desactivar($idarticulo)
    {
        $sql="UPDATE articulo SET condicion='0' WHERE idarticulo='$idarticulo'";        
        return ejecutarConsulta($sql); 
    }
    public function activar($idarticulo)
    {
        $sql="UPDATE articulo SET condicion='1' WHERE idarticulo='$idcategoria'";        
        return ejecutarConsulta($sql); 
    }
    public function mostrar($idarticulo)
    {
        $sql="SELECT * FROM articulo WHERE idarticulo='$idarticulo'";        
        return ejecutarConsultaSimpleFila($sql); 
    }
    public function listar()
    {
        $sql="SELECT a.idarticulo, a.idcategoria, c.nombre as categoria, a.codigo, a.nombre, a.stock, a.descripcion,
        a.imagen, a.condicion FROM articulo a INNER JOIN categoria c on a.idcategoria=c.idcategoria";
                
        return ejecutarConsulta($sql); 
    }
    public function select()
    {
        $sql="SELECT * FROM articulo WHERE (condicion=1)";        
        return ejecutarConsulta($sql); 

    }
    public function comprueba_duplicados($codigo, $nombre, $id)
    {
        $resultado=0;
        $sql="SELECT COUNT(idarticulo) FROM articulo WHERE (nombre='$nombre') AND (codigo='$codigo') AND (idcategoria<>$id);";
        $resultado = ejecutarConsultaSimpleFila($sql);
        return $resultado["COUNT(idarticulo)"];
    }

    public function listarActivosVenta(){
           $sql="SELECT c.idarticulo,a.idcategoria, c.iddetalle_ingreso, c.precio_venta,c.precio_compra, a.codigo, a.nombre, a.stock, a.descripcion,a.imagen, a.condicion, q.nombre as categoria FROM detalle_ingreso c, articulo a, categoria q WHERE c.idarticulo=a.idarticulo AND a.idcategoria=q.idcategoria";
                
        return ejecutarConsulta($sql);
    }
}

?>