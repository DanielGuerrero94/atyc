var downloadButton = $('<a href="#" class="btn btn-square download" title="Descargar archivo"><i class="fa fa-cloud-download fa-lg" style="color: #2F2D2D;"> Descargar</i></a>');	
        var updateButton = $('<a href="#" class="btn btn-square update pull-right" title="Remplazar archivo"><i class="fa fa-cloud-upload fa-lg text-primary"> Actualizar</i></a>');
        var checkButton = $('<a href="#" class="btn btn-square check-ficha-tecnica" title="Aprobar ficha tecnica"><i class="fa fa-check-circle-o fa-lg text-success"> Aprobar</i></a>');

        function box(id, id_pac, id_ficha_tecnica) {
            return  $('<div class="box" id="' + id + '" data-id-pac="' + id_pac  + '" data-id-ficha-tecnica="' + id_ficha_tecnica  + '"></div>');
        }

        function boxBody(id, nombre, updated_at) {
            return $('<div class="box-body" id="' + id + '"><p><b>Nombre:</b> ' + nombre  + '</p><p><b>Última actualización:</b> ' + updated_at  + '</p></div>');
        }

        function boxBodyAprobar(id) {
             return $('<div class="box-body" id="' + id + '"><textarea id="motivo" name="motivo" class="form-control" placeholder="Acotación a la ficha técnica" type="text" rows="3"></textarea></div>');
        }

        function boxFooter(id) {
            return $('<div class="box-footer" id="' + id + '"></div>');
        }

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
            let id_ficha_tecnica = button.data('id-ficha-tecnica');

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
                @if(auth()->user()->isUEC())
				height : 410,
                @else
				height : 230,
                @endif
				closeOnEscape: true,
				resizable: false,
				dialogClass: "alert",
				open: function () {
					box("box-upload", id_pac, id_ficha_tecnica).appendTo('#dialogFichaTecnica');
					boxBody("box-body-upload", nombre, updated_at).appendTo('#box-upload');
					boxFooter("box-footer-upload").appendTo('#box-upload');
                    downloadButton.appendTo('#box-footer-upload');

                @if(auth()->user()->isUEC())
					box("box-aprobar", id_pac, id_ficha_tecnica).appendTo('#dialogFichaTecnica');
                    boxBodyAprobar("box-body-aprobar", nombre, updated_at).appendTo('#box-aprobar');
					boxFooter("box-footer-aprobar").appendTo('#box-aprobar');
					$("#box-footer-upload").addClass("text-center");
					$("#box-footer-aprobar").addClass("text-center");
                    checkButton.appendTo('#box-footer-aprobar');
                @else
                    updateButton.appendTo('#box-footer-upload');
                    $(".download").addClass("pull-left");
                @endif
                    $(".btn").blur();
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
	
        $(document).on("click", ".check-ficha-tecnica", function(event) {
            event.preventDefault();

            let token = $('meta[name=csrf-token]').attr("content");
            let id_ficha_tecnica = $(this).closest(".box").data('id-ficha-tecnica');

            let ajax_url = "{{url('/fichas-tecnicas')}}" + "/" + id_ficha_tecnica + "/aprobar";
            let ajax_data = {
                "_token": token,
                "_method": "PUT",
                "test": true                
            };

            $.ajax({
                url: ajax_url,
                type: 'put',
		        data: ajax_data
            })
            .done(function (data) {
                console.log("success");
				location.reload();
            })
            .fail(function (data) {
                alert("AJAX error\nContacte a soporte.");
		        location.reload();
            });

		});

