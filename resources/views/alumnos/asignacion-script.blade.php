<script type="text/javascript">
    $(document).ready(function () {
        //Inicial
        refreshCounter();

        $.typeahead({
            input: '.alumnos_typeahead',
            maxItem: 10,
            minLength: 3,
            order: "desc",
            dynamic: true,
            delay: 400,
            backdrop: {
                "background-color": "#fff"
            },
            template: function (query, item) {
                return '<tr><td><b>Nombre: </b>' + item.nombres + ' ' + item.apellidos + ' -- <b>Documento: </b>' + item.documentos + '</td></tr>';
            },
            emptyTemplate: function () {
                return '<tr><td><button type="button" class="btn btn-outline" id="alta_participante_dialog"><i class="fa fa-plus text-green"></i><b>  Crear participante </b></button></td></tr>';
            },
            source: {
                Nombres: {
                    display: 'nombres',
                    ajax: {
                        url: "{{url('alumnos/typeahead/apellidos')}}",
                        path: "data.info",
                        data: {
                            q: "@{{query}}"
                        },
                        success: function (data) {
                            console.log(data);
                        },
                        error: function (data) {
                            console.log("ajax error");
                            console.log(data);
                        }
                    }
                },
                Apellidos: {
                    display: 'apellidos',
                    ajax: {
                        url: "{{url('alumnos/typeahead/apellidos')}}",
                        path: "data.info",
                        data: {
                            q: "@{{query}}"
                        },
                        success: function (data) {
                            console.log(data);
                        },
                        error: function (data) {
                            console.log("ajax error");
                            console.log(data);
                        }
                    }
                },
                Documentos: {
                    display: 'documentos',
                    ajax: {
                        url: "{{url('alumnos/typeahead/apellidos')}}",
                        path: "data.info",
                        data: {
                            q: "@{{query}}"
                        },
                        success: function (data) {
                            console.log(data);
                        },
                        error: function (data) {
                            console.log("ajax error");
                            console.log(data);
                        }
                    }
                }
            },
            callback: {
                onInit: function (node) {
                    console.log('Typeahead Initiated on ' + node.selector);
                },
                onClick: function (node, a, item, event) {
                    agregarParticipante(item.nombres, item.apellidos, item.documentos, item.id);
                    $('#alumnos .alumnos_typeahead').val('');
                }
            },
            debug: true
        });

        function agregarParticipante(nombres, apellidos, documentos, id) {
            if (existsInTable(id)) {
                return;
            }

            alumno = '<tr>' +
                '<td>' + nombres + '</td>' +
                '<td>' + apellidos + '</td>' +
                '<td>' + documentos + '</td>' +
                '<td>' +
                '<div class="btn btn-xs btn-info "><a href="{{url('/alumnos')}}/' + id + '"><i class="fa fa-search" data-id="' + id + '"></i></a></div>' +
                '<div class="btn btn-xs btn-danger quitar" data-id="' + id + '"><i class="fa fa-minus"></i></div>' +
                '</td>' +
                '</tr>';
            $('#alumnos-del-curso tbody').append(alumno);
            $('#alumnos-del-curso').closest('div').show();

            const cursoId = {{$curso->id_curso}};
            const form = $.merge($('#form-modificacion').serializeArray(), [{name: 'alumno_id', value: id}]);
            $.ajax({
                url: `{{url('cursos/')}}/${cursoId}/addAlumno`,
                method: 'put',
                data: form,
                success: function (data) {
                    console.log(data)
                    console.log("success")
                    alert(`Alumno ${nombres} ${apellidos} agregado correctamente`)
                },
                error: function (error) {
                    console.log(error)
                    console.log("error")
                    alert("Ocurrio un error al agregar alumno")
                }
            })

            refreshCounter();
        }

        function existsInTable(id) {
            existe = false;
            $.each($('#alumnos-del-curso tbody tr .fa-search'), function (k, v) {
                if ($(v).data('id') == id) {
                    existe = true;
                }
            });
            return existe;
        }

        $('.container-fluid').on('click', '#alta_participante_dialog', function (event) {
            event.preventDefault();

            $.ajax({
                url: "{{url('/alumnos/alta')}}",
                success: function (response) {
                    console.log('success');

                    $('.container-fluid #alta-accion').closest('.row').slideUp(450);
                    //Quick fix
                    $('.container-fluid #modificacion-accion').closest('.row').slideUp(450);

                    //Creo animacion de creando
                    jQuery('<div/>', {
                        id: 'creando-participante',
                        class: 'row',
                        css: 'z-index: 1000;',
                        html: '<h3 style="text-align: center;">(Alta de acción en progreso) <i class="fa fa-cog fa-spin fa-2x fa-fw margin-bottom"></i> Creando Participante</h3>'
                    }).appendTo('.container-fluid');

                    //Creo div para el form de alta de participante
                    jQuery('<div/>', {
                        id: 'alta',
                        text: '',
                        css: 'z-index: 1000;'
                    }).appendTo('.container-fluid');
                    $('#alta').html(response);

                },
                error: function (response) {
                    console.log('error');
                }
            });

        });

        $('#alumnos-del-curso').on('click', '.quitar', function (event) {
            const alumnoId = $(this).data('id')
            const cursoId = {{$curso->id_curso}};
            const form = $.merge($('#form-modificacion').serializeArray(), [{name: 'alumno_id', value: alumnoId}]);
            $.ajax({
                url: `{{url('cursos/')}}/${cursoId}/removeAlumno`,
                method: 'put',
                data: form,
                success: function (data) {
                    console.log(data)
                    console.log("success")
                    alert(`Alumno removido correctamente`)
                },
                error: function (error) {
                    console.log(error)
                    console.log("error")
                    alert("Ocurrio un error al agregar alumno")
                }
            })

            this.closest('tr').remove();
            refreshCounter();
        });

        function refreshCounter() {
            let count = $('#alumnos-del-curso tbody').children().length;
            $('#contador-participantes').html(count);
        }

    });
</script>