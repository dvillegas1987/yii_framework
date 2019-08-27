$(function(){

	$('#cd').attr('readonly', true);

	var value1 = $("#credito-neto").val();
	var value2 = $("#credito-debitos").val();
	var resultado = value1 - value2;
    var value = ((resultado)*20)/100;
	$('#cd').val(value);


	$('#btn_ap').click(function(){

		$('#btn_ap').attr('disabled', true);

		$('#div_ap').html('Credito aprobado. Redireccionando...');
	});


	/*$("#ajax2").submit(function(e) {

		var clase = $('#button1').attr("class");

		if(clase === 'btn btn-success pull-right'){
			var n1 = $('#credito-neto').val();
			var n2 = $('#credito-debitos').val();
			var n3 = $('#credito-saldo').val();
			var n4 = $('#credito-plan').val();
			var n5 = $('#credito-monto').val();
			var n6 = $('#credito-operatoria').text();

			if(n1 !=="" && n2!=="" && n3!=="" && n4!=="" && n5!=="" && n6!==""){
				var x = $("#credito-file_recibo").val();
			       var y = $("#credito-file_movimientos").val();
			      if (x === "" || y === "") {
			        alert("Debe adjuntar tanto recibo como movimientos.");
			        e.stopImmediatePropagation();
			        return false;
			      } else 
			          return true;
			}
		}	

			

       			
    });*/


	//ocultamiento de tabla planes al crear un nuevo credito / Muestreo de tabla al presionar boton VER PLANES
	/*$('#crear_cred').click(function(){

		setTimeout($('#tabla_planes_disponibles').hidee(), 5000);
	});*/

	/*$('#button2').click(function(){

		 

		setTimeout($('#tabla_planes_disponibles').show(), 3000);
	});*/




	/*var combo_op = $("#credito-codigo option:selected").text();
	combo_op = 'Planes disponibles - Operatoria: '+ combo_op;
	$('#tipo_operatoria').html(combo_op);*/


	/**** EJECUCION DE POPUP's ****/

	$('#modalButton').click(function(){

		$('#modal').modal('show')
		.find('#modalContent')
		.load($(this).attr('value'));

	});

	$('#modalButton2').click(function(){

		$('#modal2').modal('show')
		.find('#modalContent2')
		.load($(this).attr('value'));

	});

	$('#modalButton_operatoria').click(function(){

		$('#modal_operatoria').modal('show')
		.find('#modalContent_operatoria')
		.load($(this).attr('value'));

	});

	$('#modalButton_plan').click(function(){

		$('#modal_plan').modal('show')
		.find('#modalContent_plan')
		.load($(this).attr('value'));

	});


	/**** VISUALIZAR PLANES ****/
	/*$('#button_grilla_planes').click(function(){

		$('#grilla_plan').load($(this).attr('value'));



		//var cd = $('#cd').val();
		//var operatoria = 1;
  		//$.post('index.php?r=credito/tabla_planes',{id:operatoria});

	});*/
	

	/**** MUESTREOS DE ABM's  EN ALTA CLIENTE ****/

	$('#modalButton_localidad,#modalButton_nacionalidad,#modalButton_grupo,#modalButton_barrio, #modalButton_trabajo,#modalButton_banco ,#modalButton_sucursal,#modalButton_sector').click(function(){

		$('#modal_abm').modal('show')
		.find('#modalContent_abm')
		.load($(this).attr('value'));

		document.getElementById('header_abm').innerHTML = 'Agregar nuevo elemento';
	});



	$('#modalButton_cliente').click(function(){

		$('#modal_abm_credito').modal('show')
		.find('#modalContent_abm_credito')
		.load($(this).attr('value'));

		document.getElementById('header_abm_credito').innerHTML = 'Agregar nuevo elemento';

	});

	/**** USO DE KEY UP ****/

	$('#cliente-cuil').keyup(function (){
		if( $(this).val().length == 13){
			var value = $(this).val();
		    formato = value.substring(3,11);
		    $('#cliente-dni').val(formato);
		}
		
	});

	$('#credito-debitos').keyup(function (){	

		var value1 = $("#credito-neto").val();
	    var value2 = $("#credito-debitos").val();
	
	    resultado = value1 - value2;
	    setTimeout($('#credito-saldo').val(resultado), 10000);


		var value = ((resultado)*20)/100;
	    setTimeout($('#cd').val(value), 40000);
	    setTimeout($('#credito-cdisponible').val(value), 40000);
	});

	$('#credito-neto').keyup(function (){	

		var value1 = $("#credito-neto").val();
	    var value2 = $("#credito-debitos").val();
	
	    resultado = value1 - value2;
	    setTimeout($('#credito-saldo').val(resultado), 10000);


		var value = ((resultado)*20)/100;
	    setTimeout($('#cd').val(value), 40000);
	    setTimeout($('#credito-cdisponible').val(value), 40000);
	});


	/*OBTENCION DE VALORES DE INPUT  -- MONTO DISPONIBLES -- Y -- PLAN -- */
	/*function getOperatoria()
    { 
    	var value= $("#credito-codigo").val();
    	alert(value);
   	    return value;
    }

    function getCuotaDisponible()
    { 
    	var value= $("#cd").val();
    	alert(value);
   	    return value;
    }*/


    	/**** LOAD DE COMPONENTES DEL FORMULARIO CLIENTE ****/

	/*$('#btn_trabajo').click(function(){

		 $.pjax.reload({container:'#id_trabajo_ajax'});
		//document.getElementById("lugar_trabajo_id").contentWindow.location.reload(true);
		//parent.document.getElementById("lugar_trabajo_id").reload();
	});*/
		


		/*$('#button_grilla_planes').click(function() {

            var value= 1;

            $.ajax({
                    type: "POST",
                    url: "index.php?r=credito/tabla_planes",
                    data: { 'd' : value},
                    contentType: "application/json; charset=utf-8",
                    dataType: "json",
                    success: function (data) {
                        alert("trabaja");
                    },
                    error: function (errormessage) {
                        alert("no trabaja");
                    }
                });

        });*/

	 /*$('#button_grilla_planes').click(function() {

	    var n1 =1;
	    var n2 =800;
	    $.ajax({
	            type: "POST",
	            url: "index.php?r=credito/tabla_planes",
	            data: "id="+n1,  
            	dataType: "text",
	            success: function (data) {
	               	
	               alert("working");
	               $('#grilla_plan').load('index.php?r=credito/tabla_planes');
	            },
	            error: function (errormessage) {

	                //do something else
	                alert("not working");

		            }
	        });
	 		
	});*/


	  //$('#grilla_plan').load('index.php?r=credito/tabla_planes');



	//REAPRACION DE FORMULARIO AUXILIAR PARA ENVIO DE DATOS DE PLANES DISPONIBLES  

	//$('#credito-operatoria').val($('#credito-codigo').val());

	$( "#credito-operatoria" ).change(function() {
	 	$('#c_operatoria').val($('#credito-operatoria').val());
	});




	



});