<?php 
//Incluímos inicialmente la conexión a la base de datos
error_reporting(0);
require "../config/Conexion.php";

Class Usuario
{
	//Implementamos nuestro constructor
	public function __construct()
	{
		
	}

	//Implementamos un método para insertar registros
	public function insertar($nombre,$tipo_documento,$num_documento,$direccion,$telefono,$email,$cargo,$login,$clave,$imagen,$permisos)
	{
		$sql="INSERT INTO persona (tipo_persona,nombre,tipo_documento,num_documento,direccion,telefono,email)
		VALUES ('Usuario','$nombre','$tipo_documento','$num_documento','$direccion','$telefono','$email')";
		//return ejecutarConsulta($sql);
		$idpersonanew=ejecutarConsulta_retornarID($sql);

		$sqlx="INSERT INTO usuario (cargo,login,clave,idpersona,imagen,condicion)
		VALUES ('$cargo','$login','$clave','$idpersonanew','$imagen','1')";
		
		$idusuarionew=ejecutarConsulta_retornarID($sqlx);

		$num_elementos=0;
		$sw=true;

		while ($num_elementos < count($permisos))
		{
			$sql_detalle = "INSERT INTO usuario_permiso(idusuario, idpermiso) VALUES('$idusuarionew', '$permisos[$num_elementos]')";
			ejecutarConsulta($sql_detalle) or $sw = false;
			$num_elementos=$num_elementos + 1;
		}

		return $sw;
	}

	//Implementamos un método para editar registros
	public function editar($idusuario,$nombre,$tipo_documento,$num_documento,$direccion,$telefono,$email,$cargo,$login,$clave,$imagen,$permisos)
	{
		$idpersona=$this->verificar_persona($idusuario);
		$sql="UPDATE persona SET tipo_persona='Usuario',nombre='$nombre',tipo_documento='$tipo_documento',num_documento='$num_documento',direccion='$direccion',telefono='$telefono',email='$email' WHERE idpersona='$idpersona'";
		ejecutarConsulta($sql);

		$sqlx="UPDATE usuario SET cargo='$cargo',login='$login',clave='$clave',imagen='$imagen' WHERE idusuario='$idusuario'";
		ejecutarConsulta($sqlx);

		//Eliminamos todos los permisos asignados para volverlos a registrar
		$sqldel="DELETE FROM usuario_permiso WHERE idusuario='$idusuario'";
		ejecutarConsulta($sqldel);

		$num_elementos=0;
		$sw=true;

		while ($num_elementos < count($permisos))
		{
			$sql_detalle = "INSERT INTO usuario_permiso(idusuario, idpermiso) VALUES('$idusuario', '$permisos[$num_elementos]')";
			ejecutarConsulta($sql_detalle) or $sw = false;
			$num_elementos=$num_elementos + 1;
		}

		return $sw;

	}

	public function editarcontra($password,$idusuario){
		$sqlcon="UPDATE usuario SET clave='$password' WHERE idusuario='$idusuario' AND condicion='1'";
		ejecutarConsulta($sqlcon);

	}

	//Implementamos un método para desactivar categorías
	public function desactivar($idusuario)
	{
		$sql="UPDATE usuario SET condicion='0' WHERE idusuario='$idusuario'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activar($idusuario)
	{
		$sql="UPDATE usuario SET condicion='1' WHERE idusuario='$idusuario'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idusuario)
	{
		$sql="SELECT * FROM persona p, usuario u WHERE u.idpersona=p.idpersona AND idusuario='$idusuario'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT * FROM persona p, usuario u WHERE(u.idpersona=p.idpersona);";
		return ejecutarConsulta($sql);		
	}
	//Implementar un método para listar los permisos marcados
	public function listarmarcados($idusuario)
	{
		$sql="SELECT * FROM usuario_permiso WHERE idusuario='$idusuario'";
		return ejecutarConsulta($sql);
	}

	//Función para verificar el acceso al sistema
	public function verificar($logina,$clavehash)
    {
    	$sql="SELECT u.idusuario,p.nombre,p.tipo_documento,p.num_documento,p.telefono,p.email,u.cargo,u.imagen,u.login FROM usuario u, persona p WHERE u.idpersona=p.idpersona AND u.login='$logina' AND u.clave='$clavehash' AND u.condicion='1'"; 
    	return ejecutarConsulta($sql);  
	}
	public function verifica($correo)
    {
    	$sql="SELECT u.idusuario,p.nombre,p.tipo_documento,p.num_documento,p.telefono,p.email,u.cargo,u.imagen,u.login FROM usuario u, persona p WHERE u.idpersona=p.idpersona AND p.email='$correo' AND u.condicion='1'"; 
    	return ejecutarConsulta($sql);  
	}
	//Función para verificar el codigo de la persona
	public function verificar_persona($idusuario)
    {
    	$sql="SELECT p.idpersona FROM persona p, usuario u WHERE(u.idpersona=p.idpersona)AND(u.idusuario='$idusuario');"; 
    	return ejecutarConsultaSimpleFila($sql);  
	}
}

?>