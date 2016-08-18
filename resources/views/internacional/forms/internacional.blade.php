<div class="form-group">
{!!Form::label('Nombre ')!!}
{!!Form::text('nombre', null, ['id'=>'nombreinternacional', 'class'=>'form-control ', 'placeholder'=>'Ingresa el nombre'])!!}
{!!link_to('#', $title='Registrar', $attributes = ['id'=>'registrarInternacional', 'data'=>'internacional', 'class'=>'btn btn-default btn-flat', 'onclick'=>'registrar(this)' ], $secure = null)!!}
</div>