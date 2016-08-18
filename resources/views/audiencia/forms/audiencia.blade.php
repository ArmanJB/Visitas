<div class="form-group">
{!!Form::label('Nombre ')!!}
{!!Form::text('nombre', null, ['id'=>'nombreaudiencia', 'class'=>'form-control ', 'placeholder'=>'Ingresa el nombre'])!!}
{!!link_to('#', $title='Registrar', $attributes = ['id'=>'registrarAudiencia', 'data'=>'audiencia', 'class'=>'btn btn-default btn-flat', 'onclick'=>'registrar(this)' ], $secure = null)!!}
</div>