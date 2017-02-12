@extends('backpack::layout')

@section('header')
    <section class="content-header">
      <h1>
        Test View<small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url(config('backpack.base.route_prefix', 'admin')) }}">{{ config('backpack.base.project_name') }}</a></li>
        <li class="active">{{ trans('backpack::base.dashboard') }}</li>
      </ol>
    </section>
@endsection


@section('content')




<div>
	<div>
		<h4>
			<a href="#collapseOne" data-toggle="collapse" data-parent="#accordion">
				 malanazi | eServices | Building Alfa -completed-
			</a>
		</h4>
	</div>
	<div>
		<div>
			<ul>
				<li>
					<a href="#home2" data-toggle="tab">
						Team work
					</a>
				</li>
				<li>
					<a href="#menu2" data-toggle="tab">
						Communication
					</a>
				</li>
			</ul>
			<div>
				<div>
					<div>
						<form>
							<div>
								<div>
									<label for="exampleInputEmail1">
										Affecting Energy:
									</label>
									<input type="text" data-slider-id="ex1Slider" data-slider-min="0" data-slider-max="20" data-slider-step="1" data-slider-value="14" />
								</div>
								<div>
									<label for="exampleInputPassword1">
										Talk Often
									</label>
									<div>
										<div>
											<label>
												<input checked="checked" name="optionsRadios" type="radio" value="option1" />
												 Option one
											</label>
										</div>
										<div>
											<label>
												<input name="optionsRadios" type="radio" value="option2" />
												 Option two
											</label>
										</div>
										<div>
											<label>
												<input name="optionsRadios" type="radio" value="option3" />
												 Option three
											</label>
										</div>
									</div>
								</div>
								<div>
									<label for="exampleInputPassword1">
										Long You know
									</label>
									<div>
										<div>
											<label>
												<input checked="checked" name="optionsRadios" type="radio" value="option1" />
												 Option one
											</label>
										</div>
										<div>
											<label>
												<input name="optionsRadios" type="radio" value="option2" />
												 Option two
											</label>
										</div>
										<div>
											<label>
												<input name="optionsRadios" type="radio" value="option3" />
												 Option three
											</label>
										</div>
									</div>
								</div>
								<div>
									<label for="exampleInputPassword1">
										Understands ...
									</label>
									<div>
										<div>
											<label>
												<input checked="checked" name="optionsRadios" type="checkbox" value="option1" />
												 Option one
											</label>
										</div>
										<div>
											<label>
												<input name="optionsRadios" type="checkbox" value="option2" />
												 Option two
											</label>
										</div>
										<div>
											<label>
												<input name="optionsRadios" type="checkbox" value="option3" />
												 Option three
											</label>
										</div>
									</div>
								</div>
								<div>
									<label for="exampleInputPassword1">
										Understands ...
									</label>
									<div>
										<div>
											<label>
												<input checked="checked" name="optionsRadios" type="checkbox" value="option1" />
												 Option one
											</label>
										</div>
										<div>
											<label>
												<input name="optionsRadios" type="checkbox" value="option2" />
												 Option two
											</label>
										</div>
										<div>
											<label>
												<input name="optionsRadios" type="checkbox" value="option3" />
												 Option three
											</label>
										</div>
									</div>
								</div>
							</div>
							<!-- /.box-body -->
							<div>
								<button type="submit">
									Save
								</button>
							</div>
						</form>
					</div>
				</div>
				<div>
					<div>
						<form>
							<div>
								<div>
									<label for="exampleInputPassword1">
										Turn for input?
									</label>
									<div>
										<div>
											<label>
												<input checked="checked" name="optionsRadios" type="radio" value="option1" />
												 Yes
											</label>
										</div>
										<div>
											<label>
												<input name="optionsRadios" type="radio" value="option2" />
												 No
											</label>
										</div>
									</div>
								</div>
								<div>
									<label for="exampleInputPassword1">
										Communication with?
									</label>
									<div>
										<div>
											<label>
												<input checked="checked" name="optionsRadios" type="radio" value="option1" />
												 Yes
											</label>
										</div>
										<div>
											<label>
												<input name="optionsRadios" type="radio" value="option2" />
												 No
											</label>
										</div>
									</div>
								</div>
								<div>
									<label for="exampleInputEmail1">
										Influential:
									</label>
									<input type="text" data-slider-id="ex1Slider" data-slider-min="0" data-slider-max="20" data-slider-step="1" data-slider-value="14" />
								</div>
								<div>
									<label for="exampleInputPassword1">
										Aspect 1
									</label>
								</div>
								<div>
									<label for="exampleInputPassword1">
										Aspect 2
									</label>
								</div>
							</div>
							<!-- /.box-body -->
							<div>
								<button type="submit">
									Save
								</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div>
	<div>
		<h4>
			<a href="#collapseTwo" data-toggle="collapse" data-parent="#accordion">
				 nalqubali | GPO | Building Alfa
			</a>
		</h4>
	</div>
	<div>
		<div>
			<ul>
				<li>
					<a href="#home" data-toggle="tab">
						Team work
					</a>
				</li>
				<li>
					<a href="#menu1" data-toggle="tab">
						Communication
					</a>
				</li>
			</ul>
			<div>
				<div>
					<div>
						<form>
							<div>
								<div>
									<label for="exampleInputEmail1">
										Affecting Energy:
									</label>
									<input type="text" data-slider-id="ex1Slider" data-slider-min="0" data-slider-max="20" data-slider-step="1" data-slider-value="14" />
								</div>
								<div>
									<label for="exampleInputPassword1">
										Talk Often
									</label>
									<div>
										<div>
											<label>
												<input checked="checked" name="optionsRadios" type="radio" value="option1" />
												 Option one
											</label>
										</div>
										<div>
											<label>
												<input name="optionsRadios" type="radio" value="option2" />
												 Option two
											</label>
										</div>
										<div>
											<label>
												<input name="optionsRadios" type="radio" value="option3" />
												 Option three
											</label>
										</div>
									</div>
								</div>
								<div>
									<label for="exampleInputPassword1">
										Long You know
									</label>
									<div>
										<div>
											<label>
												<input checked="checked" name="optionsRadios" type="radio" value="option1" />
												 Option one
											</label>
										</div>
										<div>
											<label>
												<input name="optionsRadios" type="radio" value="option2" />
												 Option two
											</label>
										</div>
										<div>
											<label>
												<input name="optionsRadios" type="radio" value="option3" />
												 Option three
											</label>
										</div>
									</div>
								</div>
								<div>
									<label for="exampleInputPassword1">
										Understands ...
									</label>
									<div>
										<div>
											<label>
												<input checked="checked" name="optionsRadios" type="checkbox" value="option1" />
												 Option one
											</label>
										</div>
										<div>
											<label>
												<input name="optionsRadios" type="checkbox" value="option2" />
												 Option two
											</label>
										</div>
										<div>
											<label>
												<input name="optionsRadios" type="checkbox" value="option3" />
												 Option three
											</label>
										</div>
									</div>
								</div>
								<div>
									<label for="exampleInputPassword1">
										Understands ...
									</label>
									<div>
										<div>
											<label>
												<input checked="checked" name="optionsRadios" type="checkbox" value="option1" />
												 Option one
											</label>
										</div>
										<div>
											<label>
												<input name="optionsRadios" type="checkbox" value="option2" />
												 Option two
											</label>
										</div>
										<div>
											<label>
												<input name="optionsRadios" type="checkbox" value="option3" />
												 Option three
											</label>
										</div>
									</div>
								</div>
							</div>
							<!-- /.box-body -->
							<div>
								<button type="submit">
									Save
								</button>
							</div>
						</form>
					</div>
				</div>
				<div>
					<div>
						<form>
							<div>
								<div>
									<label for="exampleInputPassword1">
										Turn for input?
									</label>
									<div>
										<div>
											<label>
												<input checked="checked" name="optionsRadios" type="radio" value="option1" />
												 Yes
											</label>
										</div>
										<div>
											<label>
												<input name="optionsRadios" type="radio" value="option2" />
												 No
											</label>
										</div>
									</div>
								</div>
								<div>
									<label for="exampleInputPassword1">
										Communication with?
									</label>
									<div>
										<div>
											<label>
												<input checked="checked" name="optionsRadios" type="radio" value="option1" />
												 Yes
											</label>
										</div>
										<div>
											<label>
												<input name="optionsRadios" type="radio" value="option2" />
												 No
											</label>
										</div>
									</div>
								</div>
								<div>
									<label for="exampleInputEmail1">
										Influential:
									</label>
									<input type="text" data-slider-id="ex1Slider" data-slider-min="0" data-slider-max="20" data-slider-step="1" data-slider-value="14" />
								</div>
								<div>
									<label for="exampleInputPassword1">
										Aspect 1
									</label>
								</div>
								<div>
									<label for="exampleInputPassword1">
										Aspect 2
									</label>
								</div>
							</div>
							<!-- /.box-body -->
							<div>
								<button type="submit">
									Save
								</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div hidden="">
	<div>
		<h4>
			<a href="#collapseThree" data-toggle="collapse" data-parent="#accordion">
				 Collapsible Group Success
			</a>
		</h4>
	</div>
	<div>
		<div>
			Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
		</div>
	</div>
</div>
@endsection
