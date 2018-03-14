@extends('layouts.adminlte')

@section('content')
<div class="container-fluid">
	<div class="row">		
		<div id="abm" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			@include('pacs.abm')
		</div>
	</div>
	<div class="row">
		<div id="alta-pac" class="col-xs-12 col-sm-12 col-md-12 col-lg-10 col-lg-offset-1" style="display: none;">
		</div>
	</div>
</div>
@endsection

@section('script')
<script type="text/javascript">

    function informarAccionButton(id_pac) {
		return '<a href="#" data-id="' + id_pac + '" class="btn btn-circle informar-accion" title="Informar avance de repetición"><i class="fa fa-calendar-plus-o text-success fa-lg"></i></a>';
    }

    function fichaTecnicaButton(row) {
		return '<a href="#" data-id-pac="' + row.id_pac + '" data-id-ficha-tecnica="' + row.id_ficha_tecnica  + '" data-nombre="' + row.ficha_tecnica.original  + '" data-updated-at="' + row.ficha_tecnica.updated_at  + '" class="btn btn-circle ficha-tecnica" title="Ficha técnica"><i class="fa fa-file-text-o fa-lg"></i></a>';
    }

    function seeButton(id_pac) {
		return '<a href="{{url("/pacs")}}/' + id_pac + '/see" data-id="' + id_pac + '" class="btn btn-circle ver" title="Ver"><i class="fa fa-search text-info fa-lg"></i></a>';
	}
    
    function editButton(id_pac) {
		return '<a href="{{url("/pacs")}}/' + id_pac + '" data-id="' + id_pac + '" class="btn btn-circle editar" title="Editar"><i class="fa fa-pencil text-info fa-lg"></i></a>';
	}

	function deleteButton(id_pac) {
		return '<a href="#" data-id="' + id_pac + '" class="btn btn-circle eliminar" title="Eliminar"><i class="fa fa-trash text-danger fa-lg"></i></a>';
    }
	
	function format ( d ) {
	    var sum="";
        sum = '<div class="container" style="float: left; border: 1px solid; width: 1100px; border-color: #009900aa">';

        sum += '<div style="float: left; width: 250px;"><strong>TEMATICAS</strong>';
	    d.areas_tematicas.forEach(function(item)  {
	    	console.log(item.nombre);
	  		sum += '<br>'+item.nombre;
		});
	    sum += '</div>'
        sum += '<div style="float: left; width: 250px;"><strong>PAUTAS</strong>';
	    d.pautas.forEach(function(item)  {
	    	console.log(item.nombre);
	  		sum += '<br>'+item.nombre;
		});
	    sum += '</div>'

	    sum += '<div style="float: left; width: 250px;"><strong>DESTINATARIOS</strong>';
	    d.destinatarios.forEach(function(item)  {
	    	console.log(item.nombre);
	  		sum += '<br>'+item.nombre;
		});
	    sum += '</div>'

	    sum += '<div style="float: left; width: 250px;"><strong>COMPONENTES CA</strong>';
	    d.componentes_ca.forEach(function(item)  {
	    	console.log(item.nombre);
	  		sum += '<br>'+item.nombre;
		});
	    sum += '</div></div>'

	    return sum;
    }

    function checkEstadoFichaTecnica(row) {

        if (!row.requiere_ficha_tecnica) return '<small class="label bg-aqua" disabled>No requiere</small>';

        if (row.id_ficha_tecnica === 1) return '<small class="label bg-red">Requiere completar</small>';

        if (!row.aprobada) return '<small class="label bg-yellow">Pendiente de aprobación</small>';
        
        return '<small class="label bg-green">Aprobada</small>';

    }

    function progresoAcciones(row) {
        console.log(row)
        //Hardcodeo para test
        let now = row.completadas_count;
        let max = row.planificadas_count;
        let width = now * 100 / max;
        return '<div class="progress" style="margin-top: 1px;"><div class="progress-bar progress-bar-info progress-bar-striped" role="progressbar" aria-valuenow="'+now+'" aria-valuemin="0" aria-valuemax="'+max+'" style="width: '+width+'%;color: #444;display: grid;">'+now+'/'+max+' Completas</div></div>';
    }

    function trimestre(row) {

        let trimestres = '';

        //Hardcodeo 
        row.t1 = true;

        if (row.t1) trimestres += '<span class="badge">1ro</span>';
        if (row.t2) trimestres += '<span class="badge">2do</span>';
        if (row.t3) trimestres += '<span class="badge">3ro</span>';
        if (row.t4) trimestres += '<span class="badge">4to</span>';

        return trimestres;
    }

	$(document).ready(function(){

		var datatable;

		$('#abm').on('click','.filter',function () {
			$('#filtros .box').show();
		});

		var datatable = $('#abm-table').DataTable({
	        processing: true,
	        serverSide: true,
			destroy: true,
			searching: false,
			ajax : '{{ url("/pacs/tabla") }}',
			columns: [
            { 
                data: null,
                class: 'details-control',
                defaultContent: "",
                orderable: false
            },
            { 
                data: 'tipologia',
                title: 'Tipo de Acción',
                render: function (data, type, row, meta) {
                    return '<span title="' + data  + '">' + data.substr(0,15) + '...</span>';
                }
            }, 
            { 
                data: 'nombre',
                title: 'Nombre',
                render: function (data, type, row, meta) {
                    return '<span title="' + data  + '">' + data.substr(0,15) + '...</span>';
                }                
            }, 
            {
                data: 'null',
                title: 'Ficha Técnica',
                render: function ( data, type, row, meta ) {
					return checkEstadoFichaTecnica(row);
				},
                orderable: false
            },
            {
                data: 'null',
                title: 'Repeticiones',
                render: function ( data, type, row, meta ) {
					return progresoAcciones(row);
				},
                orderable: false
            },
            { 
                data: 'null',
                title: 'Trimestre',
                render: function ( data, type, row, meta ) {
					return trimestre(row);
				},
                orderable: false
            },
            {
                data: 'observado',
                title: 'Obsevado',
                render: function (data, type, row, meta) {
                    return '<span title="' + data  + '">' + data.substr(0,15) + '...</span>';
                },
                orderable: false
            },
            { 
                data: 'acciones',
                render: function ( data, type, row, meta ) {
                    let buttons = "";

                    buttons += informarAccionButton(row.id_pac); 
                    
                    buttons += fichaTecnicaButton(row);
                    
                    buttons += seeButton(row.id_pac) + editButton(row.id_pac) + deleteButton(row.id_pac);

                    return buttons;				
                 },
                orderable: false
            }],
			responsive: false
		});
	 // Array to track the ids of the details displayed rows
	    var detailRows = [];
	 
	    $('#abm-table tbody').on( 'click', 'tr td.details-control', function () {
	        var tr = $(this).closest('tr');
	        var row = datatable.row( tr );
	        var idx = $.inArray( tr.attr('id'), detailRows );
	 
	        if ( row.child.isShown() ) {
	            tr.removeClass( 'details' );
	            row.child.hide();
	 
	            // Remove from the 'open' array
	            detailRows.splice( idx, 1 );
	        }
	        else {
	            tr.addClass( 'details' );
	            row.child( format( row.data() ) ).show();
	 
	            // Add to the 'open' array
	            if ( idx === -1 ) {
	                detailRows.push( tr.attr('id') );
	            }
	        }
	    } );
	 
	    // On each draw, loop over the `detailRows` array and show any child rows
	    datatable.on( 'draw', function () {
	        $.each( detailRows, function ( i, id ) {
	            $('#'+id+' td.details-control').trigger( 'click' );
	        } );
	    } );


		$('#alta_pac').on("click",function(){

			$.ajax({
				url: "{{url('/pacs/alta')}}",
				type: 'get',
                beforeSend: function () {
                    $("#alta-pac").html("Procesando, espere por favor...");
                },				
				success: function(data){
					$('#alta-pac').html(data);
					$('#alta-pac').show();
					$('#abm').hide();
				}
			});

		});

		$("#alta-pac").on("click","#volver",function(){
			console.log('Se vuelve sin crear la pac.');
			$('#alta-pac').html("");
			$('#abm').show();
			$('#filtros').show();
        });

	    var downloadButton = $('<a href="#" class="btn btn-square download pull-right" title="Descargar archivo"><i class="fa fa-cloud-download fa-lg" style="color: #2F2D2D;"> Descargar</i></a>');	
        var updateButton = $('<a href="#" class="btn btn-square update pull-right" title="Remplazar archivo"><i class="fa fa-cloud-upload fa-lg text-primary"> Actualizar</i></a>');
        var checkButton = $('<a href="#" class="btn btn-square check-ficha-tecnica pull-right" title="Aprobar ficha tecnica"><i class="fa fa-check-circle-o fa-lg text-success"> Aprobar</i></a>');

        function box(id_pac) {
            return  $('<div class="box" id="box" data-id-pac="' + id_pac  + '"></div>');
        }

        function boxBody(nombre, updated_at) {
            return $('<div class="box-body" id="box-body"><p><b>Nombre:</b> ' + nombre  + '</p><p><b>Última actualización:</b> ' + updated_at  + '</p></div>');
        }

        var boxFooter = $('<div class="box-footer" id="box-footer"></div>');

        $("#abm").on("change", "#update input", function(event) {
			data = new FormData($(this).closest(".box").find("form")[0]);
			let id = $(this).closest(".box-footer").data("id");			
			$.ajax({
				url: "{{url('/materiales')}}" + "/" + id,
				type: 'post',
				data: data,
				processData: false,
				contentType: false,
				success: function (data) {
					console.log("success");
					location.reload();
				},
				error: function (data) {
					alert("Error al actualizar el archivo.");
					location.reload();
				}
			});
		});

        $("#abm").on("click", ".ficha-tecnica", function(event) {
        
            event.preventDefault();

            let button = $(this);
            let nombre = button.data('nombre');
            let updated_at = button.data('updated-at');
            let id_pac = button.data('id-pac');

			$('<div id="dialogFichaTecnica"></div>').appendTo('.container-fluid');

			$("#dialogFichaTecnica").dialog({
				title: "Actualización de ficha técnica",
				show: {
					effect: "fold"
				},
				hide: {
					effect: "fade"
				},
				modal: true,
				width : 390,
				height : 230,
				closeOnEscape: true,
				resizable: false,
				dialogClass: "alert",
				open: function () {
					box(id_pac).appendTo('#dialogFichaTecnica');
					boxBody(nombre, updated_at).appendTo('#box');
					boxFooter.appendTo('#box');
				    updateButton.appendTo('#box');
				    checkButton.appendTo('#box');
					downloadButton.appendTo('#box');
				},
				close : function () {
					$(this).dialog("destroy").remove();
				}
			});			
        });

        formUpdate = '<form id="update" name="update" style="display: none;">{{ csrf_field() }}<label><input type="file" name="csv" style="display: none;"></label></form>';

        $(document).on("click", ".update", function(event) {
			let buttons = $(this).parent();
			$(formUpdate).appendTo(buttons);
			buttons.find("#update input").eq(1).click();
		});
	    
        $(document).on("change", "#update input", function(event) {
            alert("update");
            console.log($(this));
            data = new FormData($(this).closest(".box").find("form")[0]);
            token = data;

            console.log("POST de archivo");
            
            let id_pac = $(this).closest(".box").data("id-pac");

            var id_ficha_tecnica;

			$.ajax({
				url: "{{url('/fichas-tecnicas')}}",
				type: 'post',
				data: data,
				processData: false,
				contentType: false,
                success: function (data) {
                    id_ficha_tecnica = data;
                    console.log("se guardo la ficha tecnica");

                    $.ajax({
	        			url: "{{url('/pacs')}}" + "/" + id_pac + "/ficha-tecnica/" + id_ficha_tecnica,
	        			type: 'post',
		        		data: token,
		        		processData: false,
		        		contentType: false,
		        		success: function (data) {
			        		console.log("success");
				        	location.reload();
				        },
        				error: function (data) {
	        				alert("Error al actualizar el archivo.");
		        			location.reload();
		        		}
                     });

					location.reload();
				},
				error: function (data) {
					alert("Error al actualizar el archivo.");
					//location.reload();
				}
            });


		});
	
        $(document).on("click", ".download", function(event) {
            event.preventDefault();
            let id_ficha_tecnica = 1;
            let url = "{{url('/fichas-tecnicas')}}" + "/" + id_ficha_tecnica + "/download";
            window.location = url;
		});		
	
        var dialogDeleteInput =  jQuery('<textarea/>', {
            id: 'motivo',
            name: 'motivo',
            class: 'form-control',
            placeholder: 'Ingrese el motivo por el cual quiere cancelar la acción',
            type: 'text',
            rows: '4'
        });

        $("#abm").on("click", ".eliminar", function(event) {
        
			event.preventDefault();

			$('<div id="dialogDelete"></div>').appendTo('.container-fluid');

			$("#dialogDelete").dialog({
				title: "Verificación",
				show: {
					effect: "fold"
				},
				hide: {
					effect: "fade"
				},
				modal: true,
				width : 380,
				height : 220,
				closeOnEscape: true,
				resizable: false,
				dialogClass: "alert",
				open: function () {
					dialogDeleteInput.appendTo('#dialogDelete');
				},
				close : function () {
					$(this).dialog("destroy").remove();
				},
				buttons :
				{
					"Aceptar" : function () {
                        $(this).dialog("destroy");

                        let id = $(this).data('id');
						let _token = $('#abm input').first().val();

						$.ajax({
							url: "{{url('/pacs')}}" + "/" + id,
							type: 'delete',
							data: {'_token': _token},
							success: function (data) {
								location.reload("true");
							},
							error: function (data) {
								alert(data.responseText);
							}
						});
					},
					"Cancelar" : function () {
						$(this).dialog("close");
					}
				}
			});			
		});		
        
        $('#alta-pac').on('click','#modificar',function() {

			let id = $(this).data('id');

			$.ajax({				
				url : '{{url("/pacs")}}/' + id,
				method : 'put',
				data : $('form').serialize(),
				success : function(data){
					console.log("Success.");
					location.reload();	
				},
				error : function(data){
					console.log("Error.");
				}
			});
		});				

	});

</script> 
@endsection
