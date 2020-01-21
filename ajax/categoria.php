<?php 
require_once "../modelos/Categoria.php";
$categoria=new Categoria();
$idcategoria=isset($_POST["idcategoria"])? limpiarCadena($_POST["idcategoria"]):"";
$nombre=isset($_POST["nombre"])? mb_strtoupper(limpiarCadena($_POST["nombre"]),'utf-8'):"";
$descripcion=isset($_POST["descripcion"])? mb_strtoupper(limpiarCadena($_POST["descripcion"]),'utf-8'):"";
switch ($_GET['op']) {
	case 'guardaryeditar':
	if (empty($idcategoria)) {
	$rspta=$categoria->insertar($nombre,$descripcion);
	echo $rspta?"categoria registrada": "categoria no registrada";
	}
	else{
		$rspta=$categoria->editar($idcategoria,$nombre,$descripcion);
	echo $rspta ? "categoria actualizada": "categoria no se pudo actualizar";
	}
		break;
	//}
	case'desactivar':
	$rspta=$categoria->desactivar($idcategoria);
	echo $rspta?"categoria Desactivada": "categoria no se puede Desactivar";
	break;
	break;
	case'activar':
		$rspta=$categoria->activar($idcategoria);
	echo $rspta?"categoria activada": "categoria no se puede activar";
	break;
	break;
	case'mostrar':
		$rspta=$categoria->mostrar($idcategoria);
		//codificar el resultado utilizando json orientado a la web como si fuera un xml
	echo json_encode($rspta);
	break;
	break;
	case 'listar':
	$rspta=$categoria->listar();
	//vamos a declarar un array
	$data=Array();
	while ($reg=$rspta->fetch_object()) {
	$data[]=array(
		"0"=>($reg->condicion)?'<button class="btn btn-warning" onclick="mostrar('.$reg->idcategoria.')"><i class="fa fa-pencil"></i></button>'.
		'<button class="btn btn-danger" onclick="desactivar('.$reg->idcategoria.')"><i class="fa fa-close"></i></button>':
		'<button class="btn btn-warning" onclick="mostrar('.$reg->idcategoria.')"><i class="fa fa-pencil"></i></button>'.
		'<button class="btn btn-primary" onclick="activar('.$reg->idcategoria.')"><i class="fa fa-check"></i></button>',
		"1"=>$reg->nombre,
		"2"=>$reg->descripcion,
		"3"=>($reg->condicion)?'<span claa="label bg-green">Activado</span>':
		'<span class="label bg-red">Desactivado</span>'
		);
	}
	$results=array(
		"sEcho"=>1,//informacion para el datables
		"iTotalRecords"=>Count($data),//enviamos el total registros al dataatble
		"idTotalDisplayRecords(format)"=>count($data),//enviamos el total registros a visualizar
		"aaData"=>$data);
	echo json_encode($results);
	break;

}
 ?>