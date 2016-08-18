<div class="form-group">
{!!Form::label('Nombre ')!!}
{!!Form::text('nombre', null, ['id'=>'nombreactividad', 'class'=>'form-control ', 'placeholder'=>'Ingresa el nombre'])!!}
{!!link_to('#', $title='Registrar', $attributes = ['id'=>'registrarActividad', 'data'=>'actividad', 'class'=>'btn btn-default btn-flat', 'onclick'=>'registrar(this)' ], $secure = null)!!}
</div>