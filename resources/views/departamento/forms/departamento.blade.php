<div class="form-group">
{!!Form::label('Nombre ')!!}
{!!Form::text('nombre', null, ['id'=>'nombredepartamento', 'class'=>'form-control ', 'placeholder'=>'Ingresa el nombre'])!!}
{!!link_to('#', $title='Registrar', $attributes = ['id'=>'registrarDepartamento', 'data'=>'departamento', 'class'=>'btn btn-default btn-flat', 'onclick'=>'registrar(this)' ], $secure = null)!!}
</div>
