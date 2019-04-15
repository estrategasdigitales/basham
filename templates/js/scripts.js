// ========================================================================
//
// 	FUNCIONES DE AJAX
// 
// ========================================================================
function GetXmlHttpObject(){
    if (window.XMLHttpRequest){
    // code for IE7+, Firefox, Chrome, Opera, Safari
            return new XMLHttpRequest();
    }

    if (window.ActiveXObject){
    // code for IE6, IE5
            return new ActiveXObject("Microsoft.XMLHTTP");
    }
    return null;
}

// ========================================================================
//
// 	FUNCION PARA SELECCIONAR RENGLON EN TABLA
// 
// ========================================================================

function seleccionaLineaSencilla(idArray,numeroElementos,seleccion)
{
	var j;
    for(var i = 1; i <= numeroElementos; i++)
    {
		j = i - 1;
		if(i==seleccion)
		{
			if((j % 2) == 1)
			{
				for(var h = 0; h < idArray.length; h++)
				{
					$j( "#"+idArray[h]+i ).removeClass( "dato_par" ).addClass( "dato_lista_sel" );
				}
			}
			else
			{
				for(var h = 0; h < idArray.length; h++)
				{
					$j( "#"+idArray[h]+i ).removeClass( "dato_non" ).addClass( "dato_lista_sel" );
				}
			}
		}
		else
		{
			if((j % 2) == 1)
			{
				for(var h = 0; h < idArray.length; h++)
				{
					$j( "#"+idArray[h]+i ).removeClass( "dato_lista_sel" ).addClass( "dato_par" );
				}
			}
			else
			{
				for(var h = 0; h < idArray.length; h++)
				{
					$j( "#"+idArray[h]+i ).removeClass( "dato_lista_sel" ).addClass( "dato_non" );
				}
			}
		}
    }
}

// ========================================================================
//
// 	FUNCION PARA DESHABILITAR UN LINK DEL MENU
// 
// ========================================================================

function hrefToSpan(idTag, txt, line)
{
    var n=txt.search("__");
    if (n != -1)
    {
		var txtSplit = txt.split("__");
		var tag = document.getElementById(idTag);
		var span = document.createElement("span");
		//var textNode= document.createTextNode(txt);
		var div = document.createElement('div');
		
		div.innerHTML = txtSplit[1];
		
		tag.parentNode.replaceChild(span, tag);
		span.className = 'dato';
		//span.style.display = 'inline-block';
		span.id = idTag;
		
		var txtSplit2 = txtSplit[0].split('_')
		var i = txtSplit2[1];
		var j = i - 1;
		
		if((j % 2) == 1)
		{
			div.className = 'dato_par';
		}
		else
		{
			div.className = 'dato_non';
		}
		
		div.id = txtSplit[0];
		
		span.appendChild(div);
		
    }
    else
    {
		var tag = document.getElementById(idTag);
		var span = document.createElement("span");
		var textNode= document.createTextNode(txt);
		span.appendChild(textNode);
		tag.parentNode.replaceChild(span, tag);
		span.className = 'hrefDisabled';
		if(line)
		{
			span.style.width = '180px';
			span.style.borderBottom = '1px solid #666666';
		}
		if(txt.length > 15 && !line)
		{
			span.style.width = '180px';
		}
		span.style.display = 'inline-block';
		span.id = idTag;
    }
}

// ========================================================================
//
// 	FUNCION PARA HABILITAR UN LINK DEL MENU
// 
// ========================================================================

function spanToHref(idTag, txt, line)
{
    var tag = document.getElementById(idTag);
    var a = document.createElement("a");
    var textNode= document.createTextNode(txt);
    a.appendChild(textNode);
    tag.parentNode.replaceChild(a, tag);
    a.className = '';
    if(line)
    {
		a.style.width = '180px';
		a.style.borderBottom = '1px solid #666666';
    }
    if(txt.length > 15 && !line)
    {
		a.style.width = '180px';
    }
    a.style.display = 'inline-block';
    a.id = idTag;
}

// ========================================================================
//
// 	FUNCION PARA HABILITAR ABRIR UN REVEAL DESDE UN LINK DEL MENU
// 
// ========================================================================

function addClickReveal(idTag, idReveal)
{
    var tag = document.getElementById(idTag);
    tag.href = "#";
    tag.className = '';
    $j('#'+idTag).click(function(e) {
		e.preventDefault();
		$j('#'+idReveal).reveal({
			animation: 'fadeAndPop',                   //fade, fadeAndPop, none
			animationspeed: 300,                       //how fast animtions are
			closeonbackgroundclick: false,              //if you click background will modal close?
			dismissmodalclass: 'close-reveal-modal'    //the class of a button or element that will close an open modal
		});
    });
}

function changeZIndex(i,id) {
    document.getElementById(id).style.zIndex=i;
}

function cerrarReveal(id)
{
    $j('#'+id).trigger('reveal:close');
    
    changeZIndex(1,id);
    
    if(id == 'generarReporteEvaluacion')
    {
		$j("#nombreAbogadoReporte").html('');
    }
}

function funcionErrors(xhr,status,error){
	alert("Error");
}

function validaFormaLogin(){

	var login;
	var passwd;
	
	// Quitamos los espacios en blanco y los enters del principio y del final 
	login = document.loginForm.usuario.value;
	login = login.replace(/^\s+|\s+$/g, '');
	login = login.replace(/\r?\n/g,"");
	
	passwd = document.loginForm.passwd.value;
	passwd = passwd.replace(/^\s+|\s+$/g, '');
	passwd = passwd.replace(/\r?\n/g,"");
	
	//var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
	
	if(login == "" && passwd == ""){
		alert("Debe teclear un correo electr\u00f3nico y una contrase\u00f1a para ingresar al sistema.");
		return false;
	}
	else if(login == "")
	{
		alert("Debe teclear un correo electr\u00f3nico para ingresar al sistema.");
		return false;
	}
	else if(passwd == "")
	{	
	        alert("Debe teclear una contrase\u00f1a para ingresar al sistema.");
		return false;
	}
	//else if(reg.test(login) == false)
	//{
	//	//Validar formato de correo
	//	alert("El correo electr\u00f3nico no es v\u00e1lido.");
	//	return false;
	//}
	else{
		return true;
	}
}

function salir(token)
{
	this.location.href = "../verifica.php?token="+token;
}

function verAbogados()
{
	var idUsuario = $j("#idUsuario").val();
	var tipoUsuario = $j("#tipoUsuario").val();
    var token = document.getElementById('token').value;
    var name = "Abogados";
    window.open('./abogados.php?token='+token+"&idUsuario="+idUsuario+"&tipoUsuario="+tipoUsuario,name,'height=647,width=900,toolbar=no,directories=no,status=no,continued from previous linemenubar=no,scrollbars=no,resizable=no ,modal=yes');
}

function verUsuarios()
{
	var idUsuario = $j("#idUsuario").val();
	var tipoUsuario = $j("#tipoUsuario").val();
    var token = document.getElementById('token').value;
    var name = "Usuarios";
    window.open('./usuarios.php?token='+token+"&idUsuario="+idUsuario+"&tipoUsuario="+tipoUsuario,name,'height=647,width=900,toolbar=no,directories=no,status=no,continued from previous linemenubar=no,scrollbars=no,resizable=no ,modal=yes');
}

function seleccionaUsuario(idUsuario, seleccion)
{
	var numeroUsuarios = document.getElementById('numeroUsuarios').value;
    
	var idsArray = ['nombreUsuarioLista_','nombreUsuarioTd_'];

	seleccionaLineaSencilla(idsArray,numeroUsuarios,seleccion);
	
	$j("#usuarioSeleccionado").val(idUsuario);
	$j("#numeroSeleccionUsuario").val(seleccion);
	
	var url = "./cargarInfoUsuario.php";
			
	var params = "idUsuario="+idUsuario;
	
	$j.ajax({
		url: url,
		dataType: 'html',
		type: 'POST',
		async: true,
		data: params,
		success: function resultSeleccionaUsuario(result,status,xhr){
			
			if(result == "1")
			{
				alert("Error BD");
				return;
			}
			else
			{
				$j("#panelPrincipalUsuarios").html(result);
				
				habilitaMenuUsuarios(1);
			}
			
		},// muestraEditarUsuario,
		//success: actualizaTablaPacientes,
		error: funcionErrors
	});	
}

function habilitaMenuUsuarios(accion)
{
	if (accion == 1)//Seleccionar usuario
	{
		var editarUsuarioVar = document.getElementById('menuEditarUsuario');
		if(editarUsuarioVar.nodeName == 'SPAN')
		{
			spanToHref('menuEditarUsuario', '- Editar', false);
		}
		
		var editarUsuarioVar = document.getElementById('menuEditarUsuario');
		editarUsuarioVar.href = "javascript:;";
		editarUsuarioVar.className = '';
		editarUsuarioVar.onclick=function(){
			editarUsuario();
		};
		
		var borrarUsuarioVar = document.getElementById('menuBorrarUsuario');
		if(borrarUsuarioVar.nodeName == 'SPAN')
		{
			spanToHref('menuBorrarUsuario', '- Borrar', false);
		}
		
		var borrarUsuarioVar = document.getElementById('menuBorrarUsuario');
		borrarUsuarioVar.href = "javascript:;";
		borrarUsuarioVar.className = '';
		borrarUsuarioVar.onclick=function(){
			borrarUsuario();
		};
	}
	else if (accion == 2)//Nuevo/Editar Usuario
	{
		var guardarUsuarioVar = document.getElementById('menuGuardarUsuario');
		if(guardarUsuarioVar.nodeName == 'SPAN')
		{
			spanToHref('menuGuardarUsuario', '- Guardar', false);
		}
		
		var guardarUsuarioVar = document.getElementById('menuGuardarUsuario');
		guardarUsuarioVar.href = "javascript:;";
		guardarUsuarioVar.className = '';
		guardarUsuarioVar.onclick=function(){
			guardarUsuario();
		};
		
		var cancelarEdicionUsuarioVar = document.getElementById('menuCancelarEdicionUsuario');
		if(cancelarEdicionUsuarioVar.nodeName == 'SPAN')
		{
			spanToHref('menuCancelarEdicionUsuario', '- Cancelar Edici\u00f3n', false);
		}
		
		var cancelarEdicionUsuarioVar = document.getElementById('menuCancelarEdicionUsuario');
		cancelarEdicionUsuarioVar.href = "javascript:;";
		cancelarEdicionUsuarioVar.className = '';
		cancelarEdicionUsuarioVar.onclick=function(){
			cancelarEdicionUsuario();
		};
		
		//Deshabilitar menu
		hrefToSpan('menuNuevoUsuario', '- Nuevo', false);
		hrefToSpan('menuEditarUsuario', '- Editar', false);
		hrefToSpan('menuBorrarUsuario', '- Borrar', false);
	}
	else if (accion == 3)
	{
		var nuevoUsuarioVar = document.getElementById('menuNuevoUsuario');
		if(nuevoUsuarioVar.nodeName == 'SPAN')
		{
			spanToHref('menuNuevoUsuario', '- Nuevo', false);
		}
		
		var nuevoUsuarioVar = document.getElementById('menuNuevoUsuario');
		nuevoUsuarioVar.href = "javascript:;";
		nuevoUsuarioVar.className = '';
		nuevoUsuarioVar.onclick=function(){
			nuevoUsuario();
		};
		
		hrefToSpan('menuEditarUsuario', '- Editar', false);
		hrefToSpan('menuBorrarUsuario', '- Borrar', false);
		hrefToSpan('menuGuardarUsuario', '- Guardar', false);
		hrefToSpan('menuCancelarEdicionUsuario', '- Cancelar Edici\u00f3n', false);
	}
}

function nuevoUsuario()
{
	$j("#fieldsetInfoUsuario").attr("disabled", false);
	$j("#botonBuscarUsuarios").attr("disabled", true);
	
	$j('#panelPrincipalUsuarios').children().find('input').each(function(){
		
		$j(this).val('');
	
	});
	$j('#panelPrincipalUsuarios').children().find('select').each(function(){

		$j(this).val(0);
	});
	
	var seleccion = $j("#numeroSeleccionUsuario").val();
	
	//Deshabilitar lista
	var numeroUsuarios = $j('#numeroUsuarios').val();
	var j;
    for(var i = 1; i <= numeroUsuarios; i++)
    {
		j = i - 1;
		var usuario =  $j("#nombreUsuarioLista_"+i).html();
		
		if (seleccion != "")
		{
			if((i % 2) == 0)
			{
				$j( "#nombreUsuarioTd_"+i ).removeClass( "dato_lista_sel" ).addClass( "dato_par" );
			}
			else
			{
				$j( "#nombreUsuarioTd_"+i ).removeClass( "dato_lista_sel" ).addClass( "dato_non" );
			}	
		}
		
		hrefToSpan('nombreUsuarioHref_'+i, 'nombreUsuarioLista_'+i+'__'+usuario, false);
    }
	
	habilitaMenuUsuarios(2);
}

function editarUsuario()
{
	$j("#fieldsetInfoUsuario").attr("disabled", false);
	$j("#botonBuscarUsuarios").attr("disabled", true);
	
	var seleccion = $j("#numeroSeleccionUsuario").val();
	
	var numeroUsuarios = $j('#numeroUsuarios').val();
	var j;
    for(var i = 1; i <= numeroUsuarios; i++)
    {
		j = i - 1;
		var usuario =  $j("#nombreUsuarioLista_"+i).html();
		
		if (seleccion != "")
		{
			if((i % 2) == 0)
			{
				$j( "#nombreUsuarioTd_"+i ).removeClass( "dato_lista_sel" ).addClass( "dato_par" );
			}
			else
			{
				$j( "#nombreUsuarioTd_"+i ).removeClass( "dato_lista_sel" ).addClass( "dato_non" );
			}	
		}
		
		hrefToSpan('nombreUsuarioHref_'+i, 'nombreUsuarioLista_'+i+'__'+usuario, false);
		
		if(i == seleccion)
		{
			document.getElementById("nombreUsuarioLista_"+i).className = 'dato_lista_sel';
			document.getElementById("nombreUsuarioTd_"+i).className = 'dato_lista_sel';
		}
    }
	
	habilitaMenuUsuarios(2);
}

function cancelarEdicionUsuario()
{
	var url = "./listaUsuarios.php";
			
	var params = "";
	
	$j.ajax({
		url: url,
		dataType: 'html',
		type: 'POST',
		async: true,
		data: params,
		success: function resultCancelarEdicionUsuario(result,status,xhr){
			
			if(result == "1")
			{
				alert("Error BD");
				return;
			}
			else
			{
				$j("#infoCompletaUsuarios").html(result);
				
				$j("#botonBuscarUsuarios").attr("disabled", false);
				
				habilitaMenuUsuarios(3);
			}
			
		},// muestraEditarUsuario,
		//success: actualizaTablaPacientes,
		error: funcionErrors
	});		
}

function buscarUsuariosLista()
{
	var nombre = $j('#busquedaNombreUsuario').val();
	var apPaterno = $j('#busquedaApellidoPaternoUsuario').val();
    var apMaterno = $j('#busquedaApellidoMaternoUsuario').val();
	if (nombre.length == 0 && apPaterno.length == 0 && apMaterno.length == 0) {
		alert("Escriba en los campos de texto el nombre y/o apellidos del usuario que desea buscar.");
	    return;
	}
	
	var url = "./listaUsuarios.php";
			
	var params = "nombre="+nombre+"&apPaterno="+apPaterno+"&apMaterno="+apMaterno;
	
	$j.ajax({
		url: url,
		dataType: 'html',
		type: 'POST',
		async: true,
		data: params,
		success: function resultCancelarEdicionUsuario(result,status,xhr){
			
			if(result == "1")
			{
				alert("Error BD");
				return;
			}
			else
			{
				$j("#infoCompletaUsuarios").html(result);
				
				$j("#botonBuscarUsuarios").attr("disabled", false);
				
				habilitaMenuUsuarios(3);
			}
			
		},// muestraEditarUsuario,
		//success: actualizaTablaPacientes,
		error: funcionErrors
	});	
}

function guardarUsuario()
{
	var idUsuario = $j("#usuarioSeleccionado").val();
	var nombre = $j('#nombreUsuario').val();
    var aPaterno = $j('#apPaternoUsuario').val();
    var aMaterno = $j('#apMaternoUsuario').val();
    var password = $j('#passwordUsuario').val();
    var login = $j('#loginUsuario').val();
	var email = $j('#emailUsuario').val();
	var tipoUsuario = $j('#tipoUsuarioSel').val();
	
	if (idUsuario == "")
	{
		idUsuario = 0;
	}
    
    var errorNombre = 0;
    if(nombre.length == 0)
    {
		document.getElementById("tdNombreUsuario").style.backgroundColor = "#F1B3B3";
		errorNombre = 1;
    }
    else
    {
		document.getElementById("tdNombreUsuario").style.backgroundColor = "transparent";
		errorNombre = 0;
    }
    
    var errorApPaterno = 0;
    if(aPaterno.length == 0)
    {
		document.getElementById("tdApPaternoUsuario").style.backgroundColor = "#F1B3B3";
		errorApPaterno = 1;
    }
    else
    {
		document.getElementById("tdApPaternoUsuario").style.backgroundColor = "transparent";
		errorApPaterno = 0;
    }
    
    var errorApMaterno = 0;
    if(aMaterno.length == 0)
    {
		document.getElementById("tdApMaternoUsuario").style.backgroundColor = "#F1B3B3";
		errorApMaterno = 1;
    }
    else
    {
		document.getElementById("tdApMaternoUsuario").style.backgroundColor = "transparent";
		errorApMaterno = 0;
    }
    
	var errorLogin = 0;
    if(login.length == 0)
    {
		document.getElementById("tdLoginUsuario").style.backgroundColor = "#F1B3B3";
		errorLogin = 1;
    }
    else
    {
		document.getElementById("tdLoginUsuario").style.backgroundColor = "transparent";
		errorLogin = 0;
    }
	
	var errorEmail = 0;
    if(email.length == 0)
    {
		document.getElementById("tdEmailUsuario").style.backgroundColor = "#F1B3B3";
		errorEmail = 1;
    }
    else
    {
		document.getElementById("tdEmailUsuario").style.backgroundColor = "transparent";
		errorEmail = 0;
    }
	
	var errorTipoUsuario = 0;
    if(tipoUsuario == 0)
    {
		document.getElementById("tdTipoUsuario").style.backgroundColor = "#F1B3B3";
		errorTipoUsuario = 1;
    }
    else
    {
		document.getElementById("tdTipoUsuario").style.backgroundColor = "transparent";
		errorTipoUsuario = 0;
    }

    if(errorNombre || errorApPaterno || errorApMaterno || errorEmail || errorLogin || errorTipoUsuario){
	    alert('Favor de llenar los campos obligatorio correctamente');
	    return;
    }
	
	var url = "./guardarCambiosUsuario.php";
    
    var params = "nombre="+nombre+"&aPaterno="+aPaterno+"&aMaterno="+aMaterno+
		"&password="+password+"&login="+login+"&idUsuario="+idUsuario+"&email="+email+
		"&tipoUsuario="+tipoUsuario;
		
	$j.ajax({
		url: url,
		dataType: 'html',
		type: 'POST',
		async: true,
		data: params,
		success: function resultGuardarUsuario(result,status,xhr){
			
			if(result == 0)
			{
				alert("ERROR. El caracter ' \" ' no esta permitido.");
				return;
			}
			else if(result != "1" && result != "2" && result != "3")
			{
				alert("La informaci\u00f3n ha sido guardada.");
			
				cancelarEdicionUsuario();
			}
			else if(result == "1")
			{
				alert("Error BD.");
				return;
			}
			else if(result == "2")
			{
				alert("Existe otro usuario con los mismos datos.");
				return;
			}
			else if(result == "3")
			{
				alert("Existe otro usuario con el mismo login.");
				return;
			}
			else if(result == "4")
			{
				alert("Existe otro usuario con el mismo correo.");
				return;
			}
			
		},// muestraEditarUsuario,
		//success: actualizaTablaPacientes,
		error: funcionErrors
	});	
}

function borrarUsuario()
{
	var idUsuario = $j("#usuarioSeleccionado").val();
	
	var answer = confirm("\u00bfEst\u00e1 seguro de querer borrar al usuario seleccionado?\n\nEsta acci\u00f3n no se puede deshacer.");
    if(answer)
    {
		var url = "./eliminarUsuario.php";
    
		var params = "idUsuario="+idUsuario;
			
		$j.ajax({
			url: url,
			dataType: 'html',
			type: 'POST',
			async: true,
			data: params,
			success: function resultBorrarUsuario(result,status,xhr){
				
				if(result == "1")
				{
					alert("Error BD.");
					return;
				}
				else
				{
					alert("El usuario fue eliminado satisfactoriamente.");
					cancelarEdicionUsuario();
				}
				
			},// muestraEditarUsuario,
			//success: actualizaTablaPacientes,
			error: funcionErrors
		});	
    }
    else
    {
		return;
    }
}

function iniciarEvaluacion()
{
	var idPractica = $j("#idPracticaAbogadoSeleccionado").val();
	var idNivel = $j("#idNivelAbogadoSeleccionado").val();
	
	if (idNivel == 5)//Abogado E, preguntas pendientes
	{
		alert("El sistema no encontr\u00f3 las preguntas de evaluaci\u00f3n para el abogado seleccionado.");
		return;
	}
	else
	{
		var url = "./cargarPreguntasEvaluacion.php";
				
		var params = "idPractica="+idPractica+"&idNivel="+idNivel+"&seccion=1";
		
		$j.ajax({
			url: url,
			dataType: 'html',
			type: 'POST',
			async: true,
			data: params,
			success: function resultSeleccionaUsuario(result,status,xhr){
				
				if(result == "1")
				{
					alert("Error BD");
					return;
				}
				else
				{
					
					$j("#divPreguntasSeccion1").html(result);
					
					cargarWizard(idPractica, idNivel);
				}
				
			},// muestraEditarUsuario,
			//success: actualizaTablaPacientes,
			error: funcionErrors
		});	
	}
}

function cargarWizard(idPractica, idNivel)
{
	$j("#wizardReporteEvaluacion").steps({
		headerTag: "h2",
		bodyTag: "section",
		transitionEffect: "slideLeft",
		stepsOrientation: "vertical",
		enableCancelButton: true,
		
		onCanceled: function (event) {
			
			$j( "#wizardReporteEvaluacion" ).steps('destroy');
			$j( "#reporteEvaluacion" ).dialog( "close" );
		},
		
		onStepChanging: function (event, currentIndex, newIndex) {
			if (newIndex > currentIndex) {
				var seccionNueva = newIndex + 1;
				var continuar = cargarPreguntas(seccionNueva, idPractica, idNivel);
				
				if (continuar == 1)
				{
					return true;
				}
				else
				{
					return false;
				}
				//var continuar = validaPacienteNuevo(currentIndex);
			}
			else
			{
				var continuar = 1;
			}
			
			if (continuar == 1) {
				return true;
			}
			else{
				return false;
			}
		},
		
		onFinishing: function (event, currentIndex) {
			
			continuar = guardarEvaluacion();
			//alert(continuar);
			if (continuar == 1) {
				return true;
			}
			else
			{
				return false;	
			}
			
		},
		
		onFinished: function (event, currentIndex) {
			$j( "#wizardReporteEvaluacion" ).steps('destroy');
			$j( "#reporteEvaluacion" ).dialog( "close" );
			
			generarReporteEvaluacion();
			
		},
		
		/* Labels */
		labels: {
			cancel: "Cancelar",
			next: "Siguiente",
			previous: "Anterior",
			finish: "Finalizar"
		}
	});
	
	
	$j( "#reporteEvaluacion" ).dialog( "open" );
	$j("#wizardReporteEvaluacion").width("800px");
	//$j(".overlay").toggle(); // show/hide the overlay
}

function cargarPreguntas(seccion, idPractica, idNivel)
{
	var url = "./cargarPreguntasEvaluacion.php";
			
	var params = "idPractica="+idPractica+"&idNivel="+idNivel+"&seccion="+seccion;
	
	var continuar = 0;
	
	$j.ajax({
		url: url,
		dataType: 'html',
		type: 'POST',
		async: false,
		data: params,
		success: function resultCargarPreguntas(result,status,xhr){
			
			if(result == "1")
			{
				alert("Error BD");
				continuar = 0;
			}
			else
			{
				
				$j("#divPreguntasSeccion"+seccion).html(result);
				continuar = 1;
			}
			
		},// muestraEditarUsuario,
		//success: actualizaTablaPacientes,
		error: funcionErrors
	});
	
	return continuar;
}

function guardarEvaluacion()
{
	var numeroSecciones = 5;
	var contadorArray = 0;
	var idPreguntaArray = new Array();
	var respuestaArray = new Array();
	
	for(var i = 1; i <= numeroSecciones; i++)
	{
		for(var j = 1; j <= 5; j++)
		{
			var idPregunta = $j("#idPregunta"+ j +"Seccion"+i).val();
			var respuesta = $j("#respuestasPregunta"+ j +"Seccion"+i).val();
			
			idPreguntaArray[contadorArray] = idPregunta;
			respuestaArray[contadorArray] = respuesta;
			
			contadorArray++;
		}
	}
	
	var idAbogado = $j("#abogadoSeleccionado").val();
	var idUsuario = $j("#idUsuario").val();
	
	var url = "./guardarEvaluacion.php";
			
	var params = "idAbogado="+idAbogado+"&idUsuario="+idUsuario+"&idPreguntaArray="+idPreguntaArray+"&respuestaArray="+respuestaArray;
	
	var continuar = 0;
	
	$j.ajax({
		url: url,
		dataType: 'html',
		type: 'POST',
		async: false,
		data: params,
		success: function resultGuardarEvaluacion(result,status,xhr){
			//alert(result); return 0;
			if(result == 0)
			{
				alert("ERROR. El caracter ' \" ' no esta permitido.");
				continuar = 0;
			}
			else if(result == "1")
			{
				alert("Error BD");
				continuar = 0;
			}
			else
			{
				continuar = 1;
			}
			
		},// muestraEditarUsuario,
		//success: actualizaTablaPacientes,
		error: funcionErrors
	});
	
	return continuar;
}

function habilitaMenuAbogados(accion)
{
	
	if (accion == 1)//Seleccionar abogado
	{
		var editarAbogadoVar = document.getElementById('menuEditarAbogado');
		if(editarAbogadoVar.nodeName == 'SPAN')
		{
			spanToHref('menuEditarAbogado', '- Editar', false);
		}
		
		var editarAbogadoVar = document.getElementById('menuEditarAbogado');
		editarAbogadoVar.href = "javascript:;";
		editarAbogadoVar.className = '';
		editarAbogadoVar.onclick=function(){
			editarAbogado();
		};
		
		var borrarAbogadoVar = document.getElementById('menuBorrarAbogado');
		if(borrarAbogadoVar.nodeName == 'SPAN')
		{
			spanToHref('menuBorrarAbogado', '- Borrar', false);
		}
		
		var borrarAbogadoVar = document.getElementById('menuBorrarAbogado');
		borrarAbogadoVar.href = "javascript:;";
		borrarAbogadoVar.className = '';
		borrarAbogadoVar.onclick=function(){
			borrarAbogado();
		};
	}
	else if (accion == 2)//Nuevo/Editar Abogado
	{
		var guardarAbogadoVar = document.getElementById('menuGuardarAbogado');
		if(guardarAbogadoVar.nodeName == 'SPAN')
		{
			spanToHref('menuGuardarAbogado', '- Guardar', false);
		}
		
		var guardarAbogadoVar = document.getElementById('menuGuardarAbogado');
		guardarAbogadoVar.href = "javascript:;";
		guardarAbogadoVar.className = '';
		guardarAbogadoVar.onclick=function(){
			guardarAbogado();
		};
		
		var cancelarEdicionAbogadoVar = document.getElementById('menuCancelarEdicionAbogado');
		if(cancelarEdicionAbogadoVar.nodeName == 'SPAN')
		{
			spanToHref('menuCancelarEdicionAbogado', '- Cancelar Edici\u00f3n', false);
		}
		
		var cancelarEdicionAbogadoVar = document.getElementById('menuCancelarEdicionAbogado');
		cancelarEdicionAbogadoVar.href = "javascript:;";
		cancelarEdicionAbogadoVar.className = '';
		cancelarEdicionAbogadoVar.onclick=function(){
			cancelarEdicionAbogado();
		};
		
		//Deshabilitar menu
		hrefToSpan('menuNuevoAbogado', '- Nuevo', false);
		hrefToSpan('menuEditarAbogado', '- Editar', false);
		hrefToSpan('menuBorrarAbogado', '- Borrar', false);
	}
	else if (accion == 3)
	{
		var nuevoAbogadoVar = document.getElementById('menuNuevoAbogado');
		if(nuevoAbogadoVar.nodeName == 'SPAN')
		{
			spanToHref('menuNuevoAbogado', '- Nuevo', false);
		}
		
		var nuevoAbogadoVar = document.getElementById('menuNuevoAbogado');
		nuevoAbogadoVar.href = "javascript:;";
		nuevoAbogadoVar.className = '';
		nuevoAbogadoVar.onclick=function(){
			nuevoAbogado();
		};
		
		hrefToSpan('menuEditarAbogado', '- Editar', false);
		hrefToSpan('menuBorrarAbogado', '- Borrar', false);
		hrefToSpan('menuGuardarAbogado', '- Guardar', false);
		hrefToSpan('menuCancelarEdicionAbogado', '- Cancelar Edici\u00f3n', false);
	}	
}

function nuevoAbogado()
{
	$j("#fieldsetInfoAbogado").attr("disabled", false);
	$j("#botonBuscarAbogados").attr("disabled", true);
	
	$j('#panelPrincipalAbogados').children().find('input').each(function(){
		
		$j(this).val('');
	
	});
	$j('#panelPrincipalAbogados').children().find('select').each(function(){

		$j(this).val(0);
	});
	
	var seleccion = $j("#numeroSeleccionAbogado").val();
	
	//Deshabilitar lista
	var numeroAbogados = $j('#numeroAbogados').val();
	var j;
    for(var i = 1; i <= numeroAbogados; i++)
    {
		j = i - 1;
		var usuario =  $j("#nombreAbogadoLista_"+i).html();
		
		if (seleccion != "")
		{
			if((i % 2) == 0)
			{
				$j( "#nombreAbogadoTd_"+i ).removeClass( "dato_lista_sel" ).addClass( "dato_par" );
			}
			else
			{
				$j( "#nombreAbogadoTd_"+i ).removeClass( "dato_lista_sel" ).addClass( "dato_non" );
			}	
		}
		
		hrefToSpan('nombreAbogadoHref_'+i, 'nombreAbogadoLista_'+i+'__'+usuario, false);
    }
	
	habilitaMenuAbogados(2);
}

function editarAbogado()
{
	$j("#fieldsetInfoAbogado").attr("disabled", false);
	$j("#botonBuscarAbogados").attr("disabled", true);
	
	var seleccion = $j("#numeroSeleccionAbogado").val();
	
	var numeroAbogados = $j('#numeroAbogados').val();
	var j;
    for(var i = 1; i <= numeroAbogados; i++)
    {
		j = i - 1;
		var usuario =  $j("#nombreAbogadoLista_"+i).html();
		
		if (seleccion != "")
		{
			if((i % 2) == 0)
			{
				$j( "#nombreAbogadoTd_"+i ).removeClass( "dato_lista_sel" ).addClass( "dato_par" );
			}
			else
			{
				$j( "#nombreAbogadoTd_"+i ).removeClass( "dato_lista_sel" ).addClass( "dato_non" );
			}	
		}
		
		hrefToSpan('nombreAbogadoHref_'+i, 'nombreAbogadoLista_'+i+'__'+usuario, false);
		
		if(i == seleccion)
		{
			document.getElementById("nombreAbogadoLista_"+i).className = 'dato_lista_sel';
			document.getElementById("nombreAbogadoTd_"+i).className = 'dato_lista_sel';
		}
    }
	
	habilitaMenuAbogados(2);
}

function cancelarEdicionAbogado()
{
	var url = "./listaAbogados.php";
			
	var params = "";
	
	$j.ajax({
		url: url,
		dataType: 'html',
		type: 'POST',
		async: true,
		data: params,
		success: function resultCancelarEdicionAbogado(result,status,xhr){
			
			if(result == "1")
			{
				alert("Error BD");
				return;
			}
			else
			{
				$j("#infoCompletaAbogados").html(result);
				
				$j("#botonBuscarAbogados").attr("disabled", false);
				
				habilitaMenuAbogados(3);
			}
			
		},// muestraEditarAbogado,
		//success: actualizaTablaPacientes,
		error: funcionErrors
	});		
}

function buscarAbogadosLista()
{
	var nombre = $j('#busquedaNombreAbogado').val();
	var apPaterno = $j('#busquedaApellidoPaternoAbogado').val();
    var apMaterno = $j('#busquedaApellidoMaternoAbogado').val();
	if (nombre.length == 0 && apPaterno.length == 0 && apMaterno.length == 0) {
		alert("Escriba en los campos de texto el nombre y/o apellidos del usuario que desea buscar.");
	    return;
	}
	
	var url = "./listaAbogados.php";
			
	var params = "nombre="+nombre+"&apPaterno="+apPaterno+"&apMaterno="+apMaterno;
	
	$j.ajax({
		url: url,
		dataType: 'html',
		type: 'POST',
		async: true,
		data: params,
		success: function resultCancelarEdicionAbogado(result,status,xhr){
			
			if(result == "1")
			{
				alert("Error BD");
				return;
			}
			else
			{
				$j("#infoCompletaAbogados").html(result);
				
				$j("#botonBuscarAbogados").attr("disabled", false);
				
				habilitaMenuAbogados(3);
			}
			
		},// muestraEditarAbogado,
		//success: actualizaTablaPacientes,
		error: funcionErrors
	});	
}


function guardarAbogado()
{
	var idUsuario = $j("#idUsuario").val();
	var idAbogado = $j("#abogadoSeleccionado").val();
	var clave = $j("#claveIdentificacion").val();
	var nombre = $j('#nombreAbogado').val();
    var aPaterno = $j('#apPaternoAbogado').val();
	var aMaterno = $j('#apMaternoAbogado').val();
	var nivel = $j('#nivelSel').val();
	var practica = $j('#practicaSel').val();
	var horasCargadas = $j('#horasCargadas').val();
    var sueldo = $j('#sueldo').val();
	
	
	if (idAbogado == "")
	{
		idAbogdado = 0;
	}
	
	var errorClave = 0;
    if(clave.length == 0)
    {
		document.getElementById("tdClave").style.backgroundColor = "#F1B3B3";
		errorClave = 1;
    }
    else
    {
		document.getElementById("tdClave").style.backgroundColor = "transparent";
		errorClave = 0;
    }
    
    var errorNombre = 0;
    if(nombre.length == 0)
    {
		document.getElementById("tdNombreAbogado").style.backgroundColor = "#F1B3B3";
		errorNombre = 1;
    }
    else
    {
		document.getElementById("tdNombreAbogado").style.backgroundColor = "transparent";
		errorNombre = 0;
    }
    
    var errorApPaterno = 0;
    if(aPaterno.length == 0)
    {
		document.getElementById("tdApPaternoAbogado").style.backgroundColor = "#F1B3B3";
		errorApPaterno = 1;
    }
    else
    {
		document.getElementById("tdApPaternoAbogado").style.backgroundColor = "transparent";
		errorApPaterno = 0;
    }
    
    var errorApMaterno = 0;
    if(aMaterno.length == 0)
    {
		document.getElementById("tdApMaternoAbogado").style.backgroundColor = "#F1B3B3";
		errorApMaterno = 1;
    }
    else
    {
		document.getElementById("tdApMaternoAbogado").style.backgroundColor = "transparent";
		errorApMaterno = 0;
    }
    
	var errorNivel = 0;
    if(nivel == 0)
    {
		document.getElementById("tdNivel").style.backgroundColor = "#F1B3B3";
		errorNivel = 1;
    }
    else
    {
		document.getElementById("tdNivel").style.backgroundColor = "transparent";
		errorNivel = 0;
    }
	var errorPractica = 0;
	if(practica == 0)
    {
		document.getElementById("tdPractica").style.backgroundColor = "#F1B3B3";
		errorPractica = 1;
    }
    else
    {
		document.getElementById("tdPractica").style.backgroundColor = "transparent";
		errorPractica = 0;
    }
	var errorHorasCargadas = 0;
	if (horasCargadas.length == 0 || !$j.isNumeric(horasCargadas))
	{
        document.getElementById("tdHorasCargadas").style.backgroundColor = "#F1B3B3";
		errorHorasCargadas =1;
    }else
	{
	document.getElementById("tdHorasCargadas").style.backgroundColor = "transparent";
		errorHorasCargadas =0;	
	}
	var errorSueldo = 0;
	if (sueldo.length == 0 || !$j.isNumeric(sueldo))
	{
        document.getElementById("tdSueldo").style.backgroundColor = "#F1B3B3";
		errorSueldo =1;
    }else
	{
	document.getElementById("tdSueldo").style.backgroundColor = "transparent";
		errorSueldo =0;	
	}


    if(errorNombre || errorApPaterno || errorApMaterno || errorNivel || errorPractica || errorHorasCargadas || errorSueldo || errorClave){
	    alert('Favor de llenar los campos obligatorios correctamente');
	    return;
    }
	
	var url = "./guardarCambiosAbogados.php";
    
    var params = "nombre="+nombre+"&aPaterno="+aPaterno+"&aMaterno="+aMaterno+
		"&clave="+clave+"&nivel="+nivel+"&practica="+practica+"&horasCargadas="+horasCargadas+
		"&sueldo="+sueldo+"&idAbogado="+idAbogado+"&idUsuario="+idUsuario;
		
		console.log(params);
	
	$j.ajax({
		url: url,
		dataType: 'html',
		type: 'POST',
		async: true,
		data: params,
		success: function resultGuardarUsuario(result,status,xhr)
		{
			//alert(result);
			if(result == 0)
			{
				alert("ERROR. El caracter ' \" ' no esta permitido.");
				return;
			}
			else if(result != "1" && result != "2" && result != "3")
			{
				alert("La informaci\u00f3n ha sido guardada.");
			
				cancelarEdicionAbogado();
			}
			else if(result == "1")
			{
				alert("Error BD.");
				return;
			}
			else if(result == "2")
			{
				alert("Existe otro usuario con los mismos datos.");
				return;
			}
			else if(result == "3")
			{
				alert("Existe otro usuario con el mismo login.");
				return;
			}
			else if(result == "4")
			{
				alert("Existe otro usuario con el mismo correo.");
				return;
			}
			
		},// muestraEditarUsuario,
		//success: actualizaTablaPacientes,
		error: funcionErrors
	});
	
	
}

function borrarAbogado()
{
	var idAbogado = $j("#abogadoSeleccionado").val();
	
	var answer = confirm("\u00bfEst\u00e1 seguro de querer borrar al abogado seleccionado? Se eliminar\u00e1n todas las evaluaciones asociados al abogado.\n\nEsta acci\u00f3n no se puede deshacer.");
    if(answer)
    {
		var url = "./eliminarAbogado.php";
    
		var params = "idAbogado="+idAbogado;
			
		$j.ajax({
			url: url,
			dataType: 'html',
			type: 'POST',
			async: true,
			data: params,
			success: function resultBorrarAbogado(result,status,xhr){
				
				if(result == "1")
				{
					alert("Error BD.");
					return;
				}
				else
				{
					alert("El usuario fue eliminado satisfactoriamente.");
					cancelarEdicionAbogado();
				}
				
			},// muestraEditarAbogado,
			//success: actualizaTablaPacientes,
			error: funcionErrors
		});	
    }
    else
    {
		return;
    }
}

function seleccionaAbogadoLista(idAbogado, seleccion)
{
	var numeroAbogados = document.getElementById('numeroAbogados').value;
    
	var idsArray = ['nombreAbogadoLista_','nombreAbogadoTd_'];

	seleccionaLineaSencilla(idsArray,numeroAbogados,seleccion);
	
	$j("#abogadoSeleccionado").val(idAbogado);
	$j("#numeroSeleccionAbogado").val(seleccion);
	
	var url = "./cargarInfoAbogado.php";
			
	var params = "idAbogado="+idAbogado;
	
	$j.ajax({
		url: url,
		dataType: 'html',
		type: 'POST',
		async: true,
		data: params,
		success: function resultSeleccionaAbogado(result,status,xhr){
			
			if(result == "1")
			{
				alert("Error BD");
				return;
			}
			else
			{
				$j("#panelPrincipalAbogados").html(result);
				
				habilitaMenuAbogados(1);
			}
			
		},// muestraEditarAbogado,
		//success: actualizaTablaPacientes,
		error: funcionErrors
	});	
}

/**Principal Abogados**/


function buscarAbogados(tipo)
{
	
    var params = "tipo="+tipo;
    if(tipo == 'uno')
    {
		var nombre = document.getElementById('nombreBusquedaAbogados').value;
		var aPaterno = document.getElementById('apellidoPaternoBusquedaAbogados').value;
		var aMaterno = document.getElementById('apellidoMaternoBusquedaAbogados').value;
		var practica = document.getElementById('practicaBusquedaAbogados').value;
		var nivel = document.getElementById('nivelBusquedaAbogados').value;
	
		if(nombre.length == 0 && aPaterno.length == 0 && aMaterno.length == 0 && practica == 0 && nivel == 0)
		{
			alert("Escriba en los campos de texto el nombre, apellido paterno, materno y/o eliga una práctica o nivel");
			return;
		}
	
		params = params+"&nombre="+nombre+"&aPaterno="+aPaterno+"&aMaterno="+aMaterno+"&practica"+practica+"&nivel="+nivel;
	
    }
	
    var url = "buscarAbogados.php";
	
	$j.ajax({
		url: url,
		dataType: 'html',
		type: 'POST',
		async: true,
		data: params,
		success: function resultCancelarEdicionAbogado(result,status,xhr){
			
			if(result == "1")
			{
				alert("Error BD");
				return;
			}
			else
			{
				despliegaAbogadosEncontrados(result);
			}
			
		},// muestraEditarAbogado,
		//success: actualizaTablaPacientes,
		error: funcionErrors
	});	
	
    
}

function despliegaAbogadosEncontrados(result)
{
	var respuesta = result;
	//alert(respuesta);return;
	if(respuesta == 0 || respuesta.lenght == 0)
	{
		alert("No se encontraron abogados registrados en el sistema.");
		return;
	}
	else
	{
		document.getElementById("despliegueAbogados").innerHTML = respuesta;
		
		var tipoUsuario = $j("#tipoUsuario").val();
		if (tipoUsuario == 1)
		{
			//Deshabilitar menu para cargar horas
			hrefToSpan('menuCargarHorasAbogado', '- Cargar Horas a Abogado...', false);
			
			document.getElementById('menuCargarHorasAbogado').style.width = '230px';
		}
		//else if (tipoUsuario == 2)
		//{
		//Deshabilitar menu para generar evaluaciones
		hrefToSpan('menuIniciarEvaluacion', '- Iniciar Evaluaci\u00f3n...', false);
		//Deshabilitar menu para obtener reporte de evaluacion
		hrefToSpan('menuReporteEvaluacion', '- Generar Reporte de Evaluaci\u00f3n...', false);
		
		document.getElementById('menuIniciarEvaluacion').style.width = '230px';
		document.getElementById('menuReporteEvaluacion').style.width = '230px';
		//}
	}
}//despliega

function seleccionaAbogado(idAbogado, seleccion, idPractica, idNivel)
{
	var numeroAbogados = document.getElementById('numeroAbogados').value;
    
	var idsArray = ['nombreAbogadoLista_','nombreAbogadoTd_','apPaternoAbogadoLista_','apPaternoAbogadoTd_',
					'apMaternoAbogadoLista_','apMaternoAbogadoTd_','nivelAbogadoLista_','nivelAbogadoTd_',
					'practicaAbogadoLista_','practicaAbogadoTd_'];

	seleccionaLineaSencilla(idsArray,numeroAbogados,seleccion);
	
	$j("#abogadoSeleccionado").val(idAbogado);
	$j("#numeroSeleccionAbogado").val(seleccion);
	$j("#idPracticaAbogadoSeleccionado").val(idPractica);
	$j("#idNivelAbogadoSeleccionado").val(idNivel);
	
	var tipoUsuario = $j("#tipoUsuario").val();
	if (tipoUsuario == 1)
	{
		//Habilitar menu para cargar horas
		var cargarHorasAbogadoVar = document.getElementById('menuCargarHorasAbogado');
		if(cargarHorasAbogadoVar.nodeName == 'SPAN')
		{
			spanToHref('menuCargarHorasAbogado', '- Cargar Horas a Abogado...', false);
		}
		
		var cargarHorasAbogadoVar = document.getElementById('menuCargarHorasAbogado');
		cargarHorasAbogadoVar.href = "javascript:;";
		cargarHorasAbogadoVar.className = '';
		cargarHorasAbogadoVar.onclick=function(){
			abrirCargarHorasAbogado();
		};
		
		document.getElementById('menuCargarHorasAbogado').style.width = '230px';
	}
	//else if (tipoUsuario == 2)
	//{
	//Habilitar menu para iniciar evaluaciones
	var iniciarEvaluacionVar = document.getElementById('menuIniciarEvaluacion');
	if(iniciarEvaluacionVar.nodeName == 'SPAN')
	{
		spanToHref('menuIniciarEvaluacion', '- Iniciar Evaluaci\u00f3n...', false);
	}
	
	var iniciarEvaluacionVar = document.getElementById('menuIniciarEvaluacion');
	iniciarEvaluacionVar.href = "javascript:;";
	iniciarEvaluacionVar.className = '';
	iniciarEvaluacionVar.onclick=function(){
		iniciarEvaluacion();
	};
	
	//Habilitar menu para obtener reporte de evaluacion
	var generarReporteEvaluacionVar = document.getElementById('menuReporteEvaluacion');
	if(generarReporteEvaluacionVar.nodeName == 'SPAN')
	{
		spanToHref('menuReporteEvaluacion', '- Generar Reporte de Evaluaci\u00f3n...', false);
	}
	
	var generarReporteEvaluacionVar = document.getElementById('menuReporteEvaluacion');
	generarReporteEvaluacionVar.href = "javascript:;";
	generarReporteEvaluacionVar.className = '';
	generarReporteEvaluacionVar.onclick=function(){
		generarReporteEvaluacion();
	};
	
	document.getElementById('menuIniciarEvaluacion').style.width = '230px';
	document.getElementById('menuReporteEvaluacion').style.width = '230px';
	//}
}

function generarReporteEvaluacion()
{
	var seleccion = $j("#numeroSeleccionAbogado").val();
	
	var nombre = $j("#nombreAbogadoLista_"+seleccion).html();
	var apPaterno = $j("#apPaternoAbogadoLista_"+seleccion).html();
	var apMaterno = $j("#apMaternoAbogadoLista_"+seleccion).html();
	
	nombre = nombre.replace(/^\s*|\s*$/g,'');
	apPaterno = apPaterno.replace(/^\s*|\s*$/g,'');
	apMaterno = apMaterno.replace(/^\s*|\s*$/g,'');
	
	var nombreCompleto = nombre + " " + apPaterno + " " + apMaterno;
	
	$j("#nombreAbogadoReporte").html(nombreCompleto);
	
	$j('#generarReporteEvaluacion').reveal({
		animation: 'fadeAndPop',                   //fade, fadeAndPop, none
		animationspeed: 300,                       //how fast animtions are
		closeonbackgroundclick: false,              //if you click background will modal close?
		dismissmodalclass: 'close-reveal-modal'    //the class of a button or element that will close an open modal
	});
	
	changeZIndex(101,'generarReporteEvaluacion');
}

function validaHabilitarBtnReporte(idTxt, idBtn)
{
	var txt = $j('#'+idTxt).val();
	
	if (txt.length > 0)
	{	
		$j("#" + idBtn).attr("disabled", false);
	}
	else
	{
		$j("#" + idBtn).attr("disabled", true);
	}
}

function validaReportes(form, tipoReporte)
{
	var url = "";
	var params = "";
	
	var idAbogado = "";
	
	var errorTipoReporte = 0;
	var errorNombreArchivo = 0;
	
	tipoReporteGlobal = tipoReporte;
	
	// Reporte de Evaluacion
	//if (tipoReporte == "Evaluacion") {
	//	
	//	var nombreArchivo = form.nombreArchivoReporte.value;
	//	
	//}

	reporteExcel = 1;
	reporteExcelGlobal = 1;
	
	if (reporteExcel)
	{
		var token = $j("#token").val();	
		exportaReporteExcelConf(form, token, tipoReporte);
	}
}

function exportaReporteExcelConf(form, token, tipoReporte){
	var url = "";
	var params = "";
	
	// Reporte General
	if (tipoReporte == "Evaluacion") {
		
		//var input = form.nombreArchivoReporte.value;
		
		var idTds = "ReporteGeneral";
		url = "./exportaReporteExcel.php";
		
		var idAbogado = $j("#abogadoSeleccionado").val();
	}
	
	urlGlobal = url;
	
//	var extension = input.substr( (input.lastIndexOf('.') +1) );
//    var nombreArchivo;
//    if(input.indexOf('.') === -1)
//    {
//      	nombreArchivo = input + ".xlsx";
//    }
//    else
//    {
//		if(extension != "xlsx")
//		{
//			input = input.replace(".","_");
//			nombreArchivo = input + ".xlsx";
//		}
//		else
//		{
//			nombreArchivo = input;
//		}
//    }
	
	url = "./exportaReporteExcelVerificar.php";	
	
	params = "idAbogado="+idAbogado;
	//params += "&tipoReporte="+tipoReporte;
	//params += "&nombreArchivo="+nombreArchivo;
	//alert(params);return;
	url = url + "?token="+token +'&'+ params;
	urlGlobal = urlGlobal + "?token="+token +'&'+ params;
	
	xmlhttp = GetXmlHttpObject();
	if (xmlhttp == null){
		alert ("Your browser does not support HTTP Request");
		return;
	}
	
	xmlhttp.onreadystatechange = showExportarReporteExcel;
	xmlhttp.open("GET",url,true);
		
	xmlhttp.send(params);
}// exportaReporteExcelConf

function showExportarReporteExcel(){
    if (xmlhttp.readyState == 4){
        if(xmlhttp.status == 200){
			var respuesta = xmlhttp.responseText;
			//alert(respuesta);return;
			
			if(respuesta == 0)
			{
				alert("ERROR. El caracter ' \" ' no esta permitido.");
				return;
			}
			else if (respuesta == 1) {
				alert('No se ha podido generar el reporte de Excel porque\nno se encontraron evaluaciones para el abogado seleccionado.');
			}
			else{
				alert('El reporte de Excel se gener\u00f3 correctamente. Su descarga puede tardar unos momentos.');
				//alert(urlGlobal);return;
				var excelFrame = document.getElementById("myExcelframe");
				excelFrame.src = urlGlobal;
			}
        }// if status
    }// if readyState
}// showExportarReporteExcel

function abrirCargarHorasAbogado()
{
	var idAbogado = $j("#abogadoSeleccionado").val();
	
	var url = "./obtenerHorasAbogado.php";
			
	var params = "idAbogado="+idAbogado;
	
	$j.ajax({
		url: url,
		dataType: 'html',
		type: 'POST',
		async: true,
		data: params,
		success: function resultSeleccionaUsuario(result,status,xhr){
			
			if(result == "1")
			{
				alert("Error BD");
				return;
			}
			else
			{
				var resultArray = result.split("_");
				var horasCargadas = resultArray[0];
				var horasFacturadas = resultArray[1];
				
				$j("#horasCargadasAbogado").val(horasCargadas);
				$j("#horasFacturadasAbogado").val(horasFacturadas);
				
				$j('#capturarHorasAbogado').reveal({
					animation: 'fadeAndPop',                   //fade, fadeAndPop, none
					animationspeed: 300,                       //how fast animtions are
					closeonbackgroundclick: false,              //if you click background will modal close?
					dismissmodalclass: 'close-reveal-modal'    //the class of a button or element that will close an open modal
				});
				
				changeZIndex(101,'capturarHorasAbogado');
				
				$j( "#horasFacturadasAbogado" ).focus();
			}
			
		},// muestraEditarUsuario,
		//success: actualizaTablaPacientes,
		error: funcionErrors
	});	
}

function cargarHoras()
{
	var idAbogado = $j("#abogadoSeleccionado").val();
	var horasFacturadas = $j("#horasFacturadasAbogado").val();
	
	if ($j.isNumeric( horasFacturadas ))
	{
		var url = "./guardarHorasAbogado.php";
			
		var params = "idAbogado="+idAbogado+"&horasFacturadas="+horasFacturadas;
		
		$j.ajax({
			url: url,
			dataType: 'html',
			type: 'POST',
			async: true,
			data: params,
			success: function resultSeleccionaUsuario(result,status,xhr){
				
				if(result == "1")
				{
					alert("Error BD");
					return;
				}
				else
				{
					alert("Las horas fueron cargadas satisfactoriamente.");
					
					$j("#btnOkCapturarHorasAbogado").attr("disabled",true);
					
					cerrarReveal('capturarHorasAbogado');
				}
				
			},// muestraEditarUsuario,
			//success: actualizaTablaPacientes,
			error: funcionErrors
		});	
	}
	else
	{
		alert("Introduzca un valor num\u00e9rico.");
		$j( "#horasFacturadasAbogado" ).focus();
	}
}

function habilitaBtnCargarHoras(valor)
{
	if (valor.length > 0)
	{
		$j("#btnOkCapturarHorasAbogado").attr("disabled",false);
	}
	else
	{
		$j("#btnOkCapturarHorasAbogado").attr("disabled",true);
	}
}