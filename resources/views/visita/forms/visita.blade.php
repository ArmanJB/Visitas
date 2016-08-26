<div class="row">
	<input type="hidden" name="_token" value="{{csrf_token()}}" id="token">
	<div class="col-md-12" id="section1">
		<div class="box box-primary">
			<div class="box-body">
				<section class="col-lg-6">
					<div class="panel panel-primary">
							<div class="panel-body">
								<div class="form-group">
									{!!Form::label('Área de la visita: ')!!}
									<div class="input-group">
										<span class="input-group-addon" style="color:black;"><i class="fa fa-sitemap"></i></span>
										{!!Form::select('area', ['placeholder'=>'Selecciona un área'], null, ['id'=>'area', 'class'=>'form-control select2', 'style'=>'width:100%;'])!!}
									</div>
								</div>
							</div>
						</div>
				</section>
				<section class="col-lg-6">
					<div class="panel panel-primary">
							<div class="panel-body">
								<div class="form-group">
									{!!Form::label('Fecha de la visita: ')!!}
									<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-calendar" style="color:black;"></i></span>
										{!!Form::date('fecha', \Carbon\Carbon::now(), ['id'=>'fecha', 'class'=>'form-control ', 'dataDate'=>\Carbon\Carbon::now()->toDateString()])!!}
									</div>
								</div>
							</div>
						</div>
				</section>
				<section class="col-lg-12">
					<div class="panel panel-primary">
						<div class="panel-body">
							<div class="form-group">
								<section class="col-lg-12">{!!Form::label('Escuela visitada: ')!!}</section>
								<section class="col-lg-6">
									<div class="input-group">
										<span class="input-group-addon" style="color:black;"><i class="fa fa-map"></i></span>
										{!!Form::select('departamento', ['placeholder'=>'Selecciona un departamento'], null, ['id'=>'departamento', 'class'=>'form-control select2', 'style'=>'width:100%;'])!!}
									</div>
								</section>
								<section class="col-lg-6">
									<div class="input-group">
										<span class="input-group-addon" style="color:black;"><i class="fa fa-graduation-cap"></i></span>
										{!!Form::select('escuela', ['placeholder'=>'Selecciona un departamento antes..'], null, ['id'=>'escuela', 'class'=>'form-control select2', 'style'=>'width:100%;'])!!}
									</div>
								</section>
							</div>
						</div>
					</div>
				</section>
			</div>
			<div class="box-footer" id="footer1" style="display:none;">
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
				<section class="col-lg-3"></section>
				<section class="col-lg-6">
					<div class="panel panel-primary">
						<div class="panel-body">
							<div class="form-group">
								{!!Form::label('Oficial a cargo: ')!!}
								<div class="input-group">
									<span class="input-group-addon" style="color:black;"><i class="fa fa-male"></i> <i class="fa fa-female"></i></span>
									{!!Form::select('oficial', ['placeholder'=>'Selecciona un oficial'], null, ['id'=>'oficial', 'class'=>'form-control select2', 'style'=>'width:100%;'])!!}
								</div>
							</div>
						</div>
					</div>
				</section>
				<section class="col-lg-12">
					<div class="form-group">
						<section class="col-lg-12">{!!Form::label('Voluntarios participantes:  ')!!}</section>
						<section class="col-lg-6">
							<div class="input-group">
								<span class="input-group-addon" style="text-align: left;color:black;" id="group-voluntario-1"></span>
							</div>
							<br>	
						</section>
						<section class="col-lg-6">
							<div class="input-group">
								<span class="input-group-addon" style="text-align: left;color:black;" id="group-voluntario-2"></span>
							</div>
							<br>
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
				<section class="col-lg-12">
					<div class="form-group">
						<section class="col-lg-12">{!!Form::label('Motivos de la visita:  ')!!}</section>
						<section class="col-lg-6">
							<div class="input-group">
								<span class="input-group-addon" style="text-align: left;color:black;" id="group-motivos-1"></span>
							</div>
							<br>	
						</section>
						<section class="col-lg-6">
							<div class="input-group">
								<span class="input-group-addon" style="text-align: left;color:black;" id="group-motivos-2"></span>
							</div>
							<br>
						</section>
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
				<section class="col-lg-6">
					<div class="panel panel-primary">
						<div class="panel-body">
							<div class="form-group">
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-flag" style="color:black;width:15px;"></i></span>
									{!!Form::number('aulas', null, ["class"=>"form-control", "id"=>"aulas", "placeholder"=>"Cantidad de aulas visitadas", "min"=>"0"]);!!}
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
									<span class="input-group-addon"><i class="fa fa-usd" style="color:black;width:15px;"></i></span>
									{!!Form::number('viaticos', null, ["class"=>"form-control", "id"=>"viaticos", "placeholder"=>"Viáticos usados en el taller", "min"=>"0"]);!!}
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
									<span class="input-group-addon"><i class="fa fa-asterisk" style="color:black;width:15px;"></i></span>
									{!!Form::textArea('pendientes', null, ['id'=>'pendientes', 'class'=>'form-control', 'placeholder'=>' Pendientes de la visita', 'style'=>'resize: vertical'])!!}
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
									<span class="input-group-addon"><i class="fa fa-pencil" style="color:black;width:15px;"></i></span>
									{!!Form::textArea('observaciones', null, ['id'=>'observaciones', 'class'=>'form-control', 'placeholder'=>'Observaciones de la visita', 'style'=>'resize: vertical'])!!}
								</div>
							</div>
						</div>
					</div>
				</section>
			</div>
			<div class="box-footer">
				<span class="input-group-addon" style="background-color:#367fa9;border:none;">
					{!!link_to('#', $title='Registrar Visita', $attributes=['id'=>'registrar', 'class'=>'btn btn-primary btn-flat', 'style'=>'background-color:white;color:#337ab7;font-weight:bold;'])!!}
				</span>
			</div>
		</div>
	</div>
</div>
