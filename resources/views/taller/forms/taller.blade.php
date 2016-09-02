<div class="row">
	<input type="hidden" name="_token" value="{{csrf_token()}}" id="token">
	<div class="col-md-12" id="section1">
		<div class="box box-primary">
			<div class="box-body">
				<section class="col-lg-6">
					<div class="form-group">
						{!!Form::label('Fecha del taller: ')!!}
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-calendar" style="color:black;"></i></span>
							{!!Form::date('fecha', \Carbon\Carbon::now(), ['id'=>'fecha', 'class'=>'form-control ', 'dataDate'=>\Carbon\Carbon::now()->toDateString()])!!}
						</div>
					</div>
				</section>
				<section class="col-lg-6">
					<div class="bootstrap-timepicker">
						<div class="form-group">
							<label>Duración:</label>
							<div class="input-group">
								<div class="input-group-addon"><i class="fa fa-clock-o" style="color:black;width:15px;"></i></div>
								<input type="text" class="form-control timepicker" id="duracion">
							</div>
						</div>
					</div>
				</section>
				<section class="col-lg-12">
					<div class="form-group">
						<section class="col-lg-12">{!!Form::label('Oficiales a cargo:  ')!!}<span class="help-block" style="display:inline; margin-left:1rem;">(Selecciona al menos uno)</span></section>
						<section class="col-lg-6">
							<div class="input-group">
								<span class="input-group-addon" style="text-align: left;" id="group-oficial-1"></span>
							</div>
							<br>	
						</section>
						<section class="col-lg-6">
							<div class="input-group">
								<span class="input-group-addon" style="text-align: left;" id="group-oficial-2"></span>
							</div>
							<br>
						</section>
					</div>
				</section>
			</div>
			<div class="box-footer" id="footer1">
				<span class="input-group-addon" style="background-color:white;border:none;">
					<button href="#" id="sig1" class="btn btn-primary btn-flat"><i class="fa fa-arrow-down"></i> Siguiente</button>
				</span>
			</div>
		</div>
	</div>
	
	<div class="col-md-12" id="section2" style="display:none;">
		<div class="box box-primary">
			<div class="box-header" id="header1">
				<span class="input-group-addon" style="background-color:white;border:none;">
					<button href="#" id="ant1" class="btn btn-primary btn-flat"><i class="fa fa-arrow-up"></i> Anterior</button>
				</span>
			</div>
			<div class="box-body">
				<section class="col-lg-12">
					<div class="form-group">
					<section class="col-lg-12">{!!Form::label('Zona de atención del taller:  ')!!}<span class="help-block" style="display:inline; margin-left:1rem;">(Selecciona al menos uno)</span><br><br></section>
					<section class="col-lg-12">
						<div class="panel panel-primary">
							<div class="panel-body">
								<section class="col-lg-6">
									<div class="form-group">
										<div class="input-group">
											<span class="input-group-addon" style="color:black;"><i class="fa fa-map"></i></span>
											{!!Form::select('departamento', ['placeholder'=>'Selecciona'], null, ['id'=>'departamento', 'class'=>'form-control select2', 'style'=>'width:100%;'])!!}
										</div>
									</div>
								</section>
								<section class="col-lg-6">
									<div class="form-group">
										<div class="input-group">
											<span class="input-group-addon" style="color:black;"><i class="fa fa-graduation-cap"></i></span>
											{!!Form::select('escuela', ['placeholder'=>'Selecciona un departamento antes..'], null, ['id'=>'escuela', 'class'=>'form-control select2', 'style'=>'width:100%;'])!!}
											<span class="input-group-btn">
						                      <button type="button" class="btn btn-default btn-flat" id="addEscuela"><i class="fa fa-plus"></i></button>
						                    </span>
										</div>
									</div>
								</section>
							</div>
						</div>
					</section>
					<section class="col-lg-6">
						<div class="panel panel-primary">
							<div class="panel-body">
								<div class="form-group">
									<div class="input-group">
										<span class="input-group-addon" style="color:black;"><i class="fa fa-users"></i></span>
										{!!Form::select('zona', ['placeholder'=>'Selecciona'], null, ['id'=>'zona', 'class'=>'form-control select2', 'style'=>'width:100%;'])!!}
										<span class="input-group-btn">
					                      <button type="button" class="btn btn-default btn-flat" id="addZona"><i class="fa fa-plus"></i></button>
					                    </span>
									</div>
								</div>
							</div>
						</div>	
					</section>
					<section class="col-lg-6">
						<div class="panel panel-primary">
							<div class="panel-body">
								<div class="form-group">
									<div class="input-group">
										<span class="input-group-addon" style="color:black;"><i class="fa fa-globe"></i></span>
										{!!Form::select('internacional', ['placeholder'=>'Selecciona'], null, ['id'=>'internacional', 'class'=>'form-control select2', 'style'=>'width:100%;'])!!}
										<span class="input-group-btn">
					                      <button type="button" class="btn btn-default btn-flat" id="addInternacional"><i class="fa fa-plus"></i></button>
					                    </span>
									</div>
								</div>
							</div>
						</div>	
					</section>
					<section class="col-lg-12">
						<div class="panel panel-primary">
							
							<div class="panel-heading">
								<h3 class="panel-title">{!!Form::label('Detalles de zonas agregadas:')!!}
								<div class="pull-right">
									<a href="#" style="color:white;" id="remove-detalles"><i class="fa fa-remove"></i> Remover</a>
								</div>
								</h3>
							</div>
							
							<div class="panel-body" id="detalles">
							</div>
						</div>
					</section>
					</div>
				</section>
			</div>
			<div class="box-footer" id="footer2">
				<span class="input-group-addon" style="background-color:white;border:none;">
					<button href="#" id="sig2" class="btn btn-primary btn-flat"><i class="fa fa-arrow-down"></i> Siguiente</button>
				</span>
			</div>
		</div>
	</div>

	<div class="col-md-12" id="section3" style="display:none;">
		<div class="box box-primary">
			<div class="box-header" id="header2">
				<span class="input-group-addon" style="background-color:white;border:none;">
					<button href="#" id="ant2" class="btn btn-primary btn-flat"><i class="fa fa-arrow-up"></i> Anterior</button>
				</span>
			</div>
			<div class="box-body">
				<section class="col-lg-6">
					<div class="form-group">
						<div class="input-group">
							<span class="input-group-addon" style="color:black;">{!!Form::label('Lugar:', null, ["style"=>"width:60px;"])!!}</span>
							{!!Form::select('lugares', ['placeholder'=>'Selecciona'], null, ['id'=>'lugares', 'class'=>'form-control select2', 'style'=>'width:100%;'])!!}
						</div>
					</div>
				</section>
				<section class="col-lg-6">
					<div class="form-group">
						<div class="input-group">
							<span class="input-group-addon" style="color:black;">{!!Form::label('Actividad:', null, ["style"=>"width:60px;"])!!}</span>
							{!!Form::select('actividades', ['placeholder'=>'Selecciona'], null, ['id'=>'actividades', 'class'=>'form-control select2', 'style'=>'width:100%;'])!!}
					</div>
				</section>
				<section class="col-lg-6">
					<div class="panel panel-primary">
						<div class="form-group">
							<div class="panel-heading">
								<h3 class="panel-title">{!!Form::label('Contenidos:')!!}<span class="help-block" style="display:inline; margin-left:1rem;">(Selecciona al menos uno)</span></h3>
							</div>
							<div class="panel-body" id="group-contenido">
							</div>
						</div>
					</div>
				</section>
				<section class="col-lg-6">
					<div class="panel panel-primary">
						<div class="form-group">
							<div class="panel-heading">
								<h3 class="panel-title">{!!Form::label('Audiencia:')!!}<span class="help-block" style="display:inline; margin-left:1rem;">(Selecciona al menos uno)</span></h3>
							</div>
							<div class="panel-body" id="group-audiencia">
							</div>
						</div>
					</div>
				</section>
			</div>
			<div class="box-footer" id="footer3">
				<span class="input-group-addon" style="background-color:white;border:none;">
					<button href="#" id="sig3" class="btn btn-primary btn-flat"><i class="fa fa-arrow-down"></i> Siguiente</button>
				</span>
			</div>
		</div>
	</div>
				
	<div class="col-md-12" id="section4" style="display:none;">
		<div class="box box-primary">
			<div class="box-header" id="header3">
				<span class="input-group-addon" style="background-color:white;border:none;">
					<button href="#" id="ant3" class="btn btn-primary btn-flat"><i class="fa fa-arrow-up"></i> Anterior</button>
				</span>
			</div>
			<div class="box-body">
				<section class="col-lg-5">
					<div class="form-group">
						{!!Form::label('Cantidad de mujeres participantes: ')!!}
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-female" style="color:black;width:15px;"></i></span>
							{!!Form::number('cant_mujeres', null, ["class"=>"form-control", "id"=>"cant_mujeres", "placeholder"=>"Cantidad de mujeres", "min"=>"0"]);!!}
						</div>
					</div>
				</section>
				<section class="col-lg-5">
					<div class="form-group">
						{!!Form::label('Cantidad de hombres participantes: ')!!}
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-male" style="color:black;width:15px;"></i></span>
							{!!Form::number('cant_hombres', null, ["class"=>"form-control", "id"=>"cant_hombres", "placeholder"=>"Cantidad de hombres", "min"=>"0"]);!!}
						</div>
					</div>
				</section>
				<section class="col-lg-2">
					<div class="form-group">
						{!!Form::label('Total: ')!!}
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-calculator" style="color:black;width:15px;"></i></span>
							{!!Form::text('total', null, ["placeholder"=>"Total", "class"=>"form-control", "id"=>"total", "disabled"]);!!}
						</div>
					</div>
				</section>
				<section class="col-lg-5">
					<div class="form-group">
						{!!Form::label('Viáticos usados: ')!!}
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-usd" style="color:black;width:15px;"></i></span>
							{!!Form::number('viaticos', null, ["class"=>"form-control", "id"=>"viaticos", "placeholder"=>"Viáticos usados en la visita", "min"=>"0"]);!!}
						</div>
					</div>
				</section>
				<section class="col-lg-12">
					<div class="form-group">
						{!!Form::label('Observaciones: ')!!}
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-pencil" style="color:black;width:15px;"></i></span>
							{!!Form::textArea('observaciones', null, ['id'=>'observaciones', 'class'=>'form-control', 'placeholder'=>'Observaciones...', 'style'=>'resize: vertical'])!!}
						</div>
					</div>
				</section>
			</div>
			<div class="box-footer">
				<span class="input-group-addon" style="background-color:#367fa9;border:none;">
					{!!link_to('#', $title='Registrar Taller', $attributes=['id'=>'registrar', 'class'=>'btn btn-primary btn-flat', 'style'=>'background-color:white;color:#337ab7;font-weight:bold;'])!!}
				</span>
			</div>
		</div>
	</div>
			
</div>	

