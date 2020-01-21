
$("#frmReset").on('submit',function(e)
{
	e.preventDefault();
    correo1=$("#correo1").val();
    newpass=$("#newpass").val();
    $.post("../ajax/usuario.php?op=reset",
        {"correo1":correo1,"newpass":newpass},
        function(data)
    {
        if (data!="null")
        {
           $(location).attr("href","/sistema/index.php"); 
            bootbox.alert("su nuevo pass es...'"+ newpass+"'");
            tabla.ajax.reload();
            
        }
        else
        {
            bootbox.alert("El correo escrito no existe...");
        }
    });
})
