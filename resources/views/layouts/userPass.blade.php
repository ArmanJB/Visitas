<div class="modal fade" id="modalUserPass" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Actualizar Contraseña</h4>
            </div>
            <div class="modal-body" id="parentUserPass">
                <div id="msjuserU" class="alert alert-success alert-dismissible" role="alert" style="display:none">
                    <strong id="msjuserU-text"></strong>
                </div>
                <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
                <input type="hidden" id="idn">
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-user" style="color:black;width:15px;"></i></span>
                        {!!Form::text('nombre', null, ['id'=>'nombreU', 'class'=>'form-control', 'placeholder'=>'Nombre del usuario', "disabled"])!!}
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-envelope" style="color:black;width:15px;"></i></span>
                        {!!Form::email('email', null, ['id'=>'emailU', 'class'=>'form-control', 'placeholder'=>'Correo del usuario', "disabled"])!!}
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-lock" style="color:black;width:15px;"></i></span>
                        {!!Form::password('password', ['id'=>'passwordU', 'class'=>'form-control', 'placeholder'=>'Nueva contraseña'])!!}
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-lock" style="color:black;width:15px;"></i></span>
                        {!!Form::password('confirm', ['id'=>'confirmU', 'class'=>'form-control', 'placeholder'=>'Confirmar contraseña'])!!}
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                {!!link_to('#', $title='Actualizar', $attributes=['id'=>'actualizarU', 'class'=>'btn btn-primary'], $secure=null)!!}
            </div>
        </div>
    </div>
</div>