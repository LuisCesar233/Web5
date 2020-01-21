<?php
//incluimos inciamente la conexion a la base de datos
require_once "../config/Conexion.php";
class Categoria
{
    //implementamos nuestro constructor
    public function _construct()
    {

    }
    //implementamo un metodo para inserta registros 
    public function insertar($nombre,$descripcion)
    {
        $validacion=$this->comprueba_duplicados($nombre,0);
        if ($validacion==0) 
        {
            $sql="INSERT INTO categoria (nombre,descripcion,condicion) VALUES ('$nombre','$descripcion','1')";
            return ejecutarConsulta($sql);
        }
        else {
            return 0;
        }
    }
    //implemetamos un metodo para editar registros
    public function editar($idcategoria,$nombre,$descripcion)
    {
        $validacion=$this->comprueba_duplicados($nombre,$idcategoria);
        if($validacion==0)
        {
            $sql="UPDATE categoria SET nombre='$nombre', descripcion='$descripcion' WHERE idcategoria='$idcategoria'";     
            return ejecutarConsulta($sql); 
        }
        else {
            return 0;
        }
    }
    //implemetamos un metodo para desactivar categorias
    public function desactivar($idcategoria)
    {
        $sql="UPDATE categoria SET condicion='0' WHERE idcategoria='$idcategoria'";        
        return ejecutarConsulta($sql); 
    }
    //implementamos un metodo para activar categorias
    public function activar($idcategoria)
    {
        $sql="UPDATE categoria SET condicion='1' WHERE idcategoria='$idcategoria'";        
        return ejecutarConsulta($sql); 
    }
    //implementamos un metodo para mostrar los datos de un registro a modificar 
    public function mostrar($idcategoria)
    {
        $sql="SELECT * FROM categoria WHERE idcategoria='$idcategoria'";        
        return ejecutarConsultaSimpleFila($sql); 
    }
    public function listar()
    {
        $sql="SELECT * FROM categoria";        
        return ejecutarConsulta($sql); 
    }
    public function select()
    {
        $sql="SELECT * FROM categoria WHERE (condicion=1)";        
        return ejecutarConsulta($sql); 

    }
    public function comprueba_duplicados($nombre,$id)
    {
        $resultado=0;
        $sql="SELECT COUNT(idcategoria) FROM categoria WHERE (nombre='$nombre') AND (idcategoria<>$id);";
        $resultado = ejecutarConsultaSimpleFila($sql);
        return $resultado["COUNT(idcategoria)"];
    }
}
?>