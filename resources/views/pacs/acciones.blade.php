<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <div class="box">
        <div class="box-body">
            <table class="table table-striped" id="acciones">
                <thead>
                    <tr>
                        <th>Estado</th>
                        <th>Fecha</th>
                        <th>Duración</th>
                        <th>Participantes</th>
                        <th>Edición</th>
                        <th>Ultima modificación</th>
                    </tr>
                </thead>
                <tbody>
                    @if(isset($pac))
                    @foreach($pac->acciones as $accion)
                    <tr data-id-curso="{{$accion->id_curso}}">
                      <td>{{$accion->estado->nombre}}</td>
                      <td>{{$accion->fecha}}</td>
                      <td>{{$accion->duracion}}</td>
                      <td>{{$accion->alumnos->count()}}</td>
                      <td>{{$accion->edicion}}</td>
                      <td>{{$accion->updated_at}}</td>
                      <td class="actions">
                      </td>
                    </tr>
                @endforeach
                @endif
              </tbody>
            </table>
        </div>
    </div>
</div>
@if(!isset($disabled))
<script>

   function seeButton(id_curso) {
		return '<a class="btn btn-circle ver" title="Ver"><i class="fa fa-search text-info fa-lg"></i></a>';
	}
    
    function editButton(id_curso) {
		return '<a class="btn btn-circle editar" title="Editar"><i class="fa fa-pencil text-info fa-lg"></i></a>';
	}

$(document).ready(function (){
    $(".actions").append(seeButton() + editButton());

    $(".actions").on("click", ".editar", function () {
        location.href = "{{url("/cursos")}}/" + $(this).closest("tr").data("id-curso"); 
    });

    $(".actions").on("click", ".ver", function () {
        location.href = "{{url("/cursos")}}/" + $(this).closest("tr").data("id-curso") + "/see"; 
    });

});


</script>
@endif
