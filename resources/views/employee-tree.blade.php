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
    <div class="row">
      <div class="col-md-12">
        <div class="box box-default">
          <div class="box-header with-border">
            <div class="box-header with-border">
              <div class="box-title"><a data-toggle="collapse" href="#question">Question</a></div>
            </div>

            <div class="box-body collapse" id="question">
              <div class="row">
                <div class="col-md-12">
                  <p><strong>Q2:</strong>Select all the people you enteract with?</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
        <div class="col-md-12">
            <div class="box box-default">
                <div class="box-header with-border">
                    <div class="box-title"><a data-toggle="collapse" href="#answer">Answer</a></div>
                </div>

                <div class="box-body collapse" id="answer">
                  <div class="row">
                    <div class="col-lg-2" id="tree">

                    </div>
                    <div class="col-md-3">
              <!-- USERS LIST -->
              <div class="box box-danger">
                <div class="box-header with-border">
                  <h3 class="box-title">Members</h3>

                  <!-- <div class="box-tools pull-right">
                    <span class="label label-danger">8 New Members</span>
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
                    </button>
                  </div> -->
                </div>
                <!-- /.box-header -->
                <div class="box-body no-padding">
                  <ul class="users-list clearfix">
                    <li>
                      <img src="/vendor/adminlte/dist/img/boxed-bg.jpg" alt="User Image">
                      <a class="users-list-name" href="#">malanazi</a>
                      <!-- <span class="users-list-date">Today</span> -->
                    </li>
                    <li>
                      <img src="/vendor/adminlte/dist/img/boxed-bg.jpg" alt="User Image">
                      <a class="users-list-name" href="#">oalmujalli</a>
                      <!-- <span class="users-list-date">Yesterday</span> -->
                    </li>
                    <li>
                      <img src="/vendor/adminlte/dist/img/boxed-bg.jpg" alt="User Image">
                      <a class="users-list-name" href="#">kalateeq</a>
                      <!-- <span class="users-list-date">12 Jan</span> -->
                    </li>
                    <li>
                      <img src="/vendor/adminlte/dist/img/boxed-bg.jpg" alt="User Image">
                      <a class="users-list-name" href="#">aalshahrani </a>
                      <!-- <span class="users-list-date">12 Jan</span> -->
                    </li>
                    <li>
                      <img src="/vendor/adminlte/dist/img/boxed-bg.jpg" alt="User Image">
                      <a class="users-list-name" href="#">aralzahrani </a>
                      <!-- <span class="users-list-date">13 Jan</span> -->
                    </li>
                    <li>
                      <img src="/vendor/adminlte/dist/img/boxed-bg.jpg" alt="User Image">
                      <a class="users-list-name" href="#">saljarbo</a>
                      <!-- <span class="users-list-date">14 Jan</span> -->
                    </li>
                    <li>
                      <img src="/vendor/adminlte/dist/img/boxed-bg.jpg" alt="User Image">
                      <a class="users-list-name" href="#">malhabib</a>
                      <!-- <span class="users-list-date">15 Jan</span> -->
                    </li>
                    <li>
                      <img src="/vendor/adminlte/dist/img/boxed-bg.jpg" alt="User Image">
                      <a class="users-list-name" href="#">maalharbi</a>
                      <!-- <span class="users-list-date">15 Jan</span> -->
                    </li>
                    <li>
                      <img src="/vendor/adminlte/dist/img/boxed-bg.jpg" alt="User Image">
                      <a class="users-list-name" href="#">malanazi</a>
                      <!-- <span class="users-list-date">Today</span> -->
                    </li>
                    <li>
                      <img src="/vendor/adminlte/dist/img/boxed-bg.jpg" alt="User Image">
                      <a class="users-list-name" href="#">oalmujalli</a>
                      <!-- <span class="users-list-date">Yesterday</span> -->
                    </li>
                    <li>
                      <img src="/vendor/adminlte/dist/img/boxed-bg.jpg" alt="User Image">
                      <a class="users-list-name" href="#">kalateeq</a>
                      <!-- <span class="users-list-date">12 Jan</span> -->
                    </li>
                    <li>
                      <img src="/vendor/adminlte/dist/img/boxed-bg.jpg" alt="User Image">
                      <a class="users-list-name" href="#">aalshahrani </a>
                      <!-- <span class="users-list-date">12 Jan</span> -->
                    </li>
                    <li>
                      <img src="/vendor/adminlte/dist/img/boxed-bg.jpg" alt="User Image">
                      <a class="users-list-name" href="#">aralzahrani </a>
                      <!-- <span class="users-list-date">13 Jan</span> -->
                    </li>
                    <li>
                      <img src="/vendor/adminlte/dist/img/boxed-bg.jpg" alt="User Image">
                      <a class="users-list-name" href="#">saljarbo</a>
                      <!-- <span class="users-list-date">14 Jan</span> -->
                    </li>
                    <li>
                      <img src="/vendor/adminlte/dist/img/boxed-bg.jpg" alt="User Image">
                      <a class="users-list-name" href="#">malhabib</a>
                      <!-- <span class="users-list-date">15 Jan</span> -->
                    </li>
                    <li>
                      <img src="/vendor/adminlte/dist/img/boxed-bg.jpg" alt="User Image">
                      <a class="users-list-name" href="#">maalharbi</a>
                      <!-- <span class="users-list-date">15 Jan</span> -->
                    </li>
                  </ul>
                  <!-- /.users-list -->
                </div>
                <!-- /.box-body -->
                <div class="box-footer text-center">
                  <a href="javascript:void(0)" class="uppercase">View All Members</a>
                </div>
                <!-- /.box-footer -->
              </div>
              <!--/.box -->
            </div>
                    <div class="col-md-7">
                      <div class="panel box box-primary">
                        <div class="box-header with-border">
                          <h4 class="box-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" class="collapsed">
                              malanazi | eServices | Building Alfa  -completed-
                            </a>
                          </h4>
                          <div class="box-tools pull-right">

                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
                            </button>
                          </div>
                        </div>
                        <div id="collapseOne" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                          <div class="box-body">
                            <ul class="nav nav-tabs" id="myTabs">
                              <li role="presentation" class="active"><a data-toggle="tab" href="#home2">Team work</a></li>
                              <li role="presentation"><a data-toggle="tab" href="#menu2">Communication</a></li>
                            </ul>

                            <div class="tab-content">
                              <div id="home2" class="tab-pane fade in active">
                                <div class="col-md-12">

                                  <form role="form" class="">
                                    <div class="box-body">
                                      <div class="form-group">
                                        <label for="exampleInputEmail1">Affecting Energy:</label>
                                        <p></p>
                                        <input id="ex1" class="form-control ex1" data-slider-id='ex1Slider' type="text" data-slider-min="0" data-slider-max="20" data-slider-step="1" data-slider-value="14"/>
                                      </div>
                                      <div class="form-group">
                                        <label for="exampleInputPassword1">Talk Often</label>
                                        <div class="form-group">
                                          <div class="radio-inline">
                                            <label>
                                              <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked="">
                                              Option one
                                            </label>
                                          </div>
                                          <div class="radio-inline">
                                            <label>
                                              <input type="radio" name="optionsRadios" id="optionsRadios2" value="option2">
                                              Option two
                                            </label>
                                          </div>
                                          <div class="radio-inline">
                                            <label>
                                              <input type="radio" name="optionsRadios" id="optionsRadios3" value="option3" >
                                              Option three
                                            </label>
                                          </div>
                                        </div>
                                      </div>

                                      <div class="form-group">
                                        <label for="exampleInputPassword1">Long You know</label>
                                        <div class="form-group">
                                          <div class="radio-inline">
                                            <label>
                                              <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked="">
                                              Option one
                                            </label>
                                          </div>
                                          <div class="radio-inline">
                                            <label>
                                              <input type="radio" name="optionsRadios" id="optionsRadios2" value="option2">
                                              Option two
                                            </label>
                                          </div>
                                          <div class="radio-inline">
                                            <label>
                                              <input type="radio" name="optionsRadios" id="optionsRadios3" value="option3" >
                                              Option three
                                            </label>
                                          </div>
                                        </div>
                                      </div>


                                      <div class="form-group">
                                        <label for="exampleInputPassword1">Understands ...</label>
                                        <div class="form-group">
                                          <div class="checkbox-inline">
                                            <label>
                                              <input type="checkbox" name="optionsRadios" id="optionsRadios1" value="option1" checked="">
                                              Option one
                                            </label>
                                          </div>
                                          <div class="checkbox-inline">
                                            <label>
                                              <input type="checkbox" name="optionsRadios" id="optionsRadios2" value="option2">
                                              Option two
                                            </label>
                                          </div>
                                          <div class="checkbox-inline">
                                            <label>
                                              <input type="checkbox" name="optionsRadios" id="optionsRadios3" value="option3" >
                                              Option three
                                            </label>
                                          </div>
                                        </div>
                                      </div>

                                      <div class="form-group">
                                        <label for="exampleInputPassword1">Understands ...</label>
                                        <div class="form-group">
                                          <div class="checkbox-inline">
                                            <label>
                                              <input type="checkbox" name="optionsRadios" id="optionsRadios1" value="option1" checked="">
                                              Option one
                                            </label>
                                          </div>
                                          <div class="checkbox-inline">
                                            <label>
                                              <input type="checkbox" name="optionsRadios" id="optionsRadios2" value="option2">
                                              Option two
                                            </label>
                                          </div>
                                          <div class="checkbox-inline">
                                            <label>
                                              <input type="checkbox" name="optionsRadios" id="optionsRadios3" value="option3" >
                                              Option three
                                            </label>
                                          </div>
                                        </div>
                                      </div>


                                    </div>
                                    <!-- /.box-body -->

                                    <div class="box-footer">
                                      <button type="submit" class="btn btn-primary">Save</button>
                                    </div>
                                  </form>
                                </div>
                              </div>
                              <div id="menu2" class="tab-pane fade">
                                <div class="col-md-12">

                                  <form role="form" class="">
                                    <div class="box-body">

                                      <div class="form-group">
                                        <label for="exampleInputPassword1">Turn for input?</label>
                                        <div class="form-group">
                                          <div class="radio-inline">
                                            <label>
                                              <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked="">
                                              Yes
                                            </label>
                                          </div>
                                          <div class="radio-inline">
                                            <label>
                                              <input type="radio" name="optionsRadios" id="optionsRadios2" value="option2">
                                              No
                                            </label>
                                          </div>

                                        </div>
                                      </div>

                                      <div class="form-group">
                                        <label for="exampleInputPassword1">Communication with?</label>
                                        <div class="form-group">
                                          <div class="radio-inline">
                                            <label>
                                              <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked="">
                                              Yes
                                            </label>
                                          </div>
                                          <div class="radio-inline">
                                            <label>
                                              <input type="radio" name="optionsRadios" id="optionsRadios2" value="option2">
                                              No
                                            </label>
                                          </div>

                                        </div>
                                      </div>

                                      <div class="form-group">
                                        <label for="exampleInputEmail1">Influential:</label>
                                        <p></p>
                                        <input id="ex1" class="form-control ex1" data-slider-id='ex1Slider' type="text" data-slider-min="0" data-slider-max="20" data-slider-step="1" data-slider-value="14"/>
                                      </div>

                                      <div class="form-group inline" style="padding-right:40px;">
                                        <label for="exampleInputPassword1">Aspect 1</label>
                                        <div class="form-group inline">

                                        <div id="stars-existing" class="starrr" data-rating='4'></div>
                                      </div>
                                    </div>

                                      <div class="form-group inline">
                                        <label for="exampleInputPassword1">Aspect 2</label>
                                        <div class="form-group inline">

<div id="stars" class="starrr"></div>


                                        </div>
                                      </div>


                                    </div>
                                    <!-- /.box-body -->

                                    <div class="box-footer">
                                      <button type="submit" class="btn btn-primary">Save</button>
                                    </div>
                                  </form>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="panel box box-danger">
                        <div class="box-header with-border">
                          <h4 class="box-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" class="collapsed" aria-expanded="false">
                              nalqubali | GPO | Building Alfa
                            </a>
                          </h4>
                          <div class="box-tools pull-right">

                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
                            </button>
                          </div>
                        </div>
                        <div id="collapseTwo" class="panel-collapse collapse" aria-expanded="false">
                          <div class="box-body">
                            <ul class="nav nav-tabs" id="myTabs">
                              <li role="presentation" class="active"><a data-toggle="tab" href="#home">Team work</a></li>
                              <li role="presentation"><a data-toggle="tab" href="#menu1">Communication</a></li>
                            </ul>

                            <div class="tab-content">
                              <div id="home" class="tab-pane fade in active">
                                <div class="col-md-12">

                                  <form role="form" class="">
                                    <div class="box-body">
                                      <div class="form-group">
                                        <label for="exampleInputEmail1">Affecting Energy:</label>
                                        <p></p>
                                        <input id="ex1" class="form-control ex1" data-slider-id='ex1Slider' type="text" data-slider-min="0" data-slider-max="20" data-slider-step="1" data-slider-value="14"/>
                                      </div>
                                      <div class="form-group">
                                        <label for="exampleInputPassword1">Talk Often</label>
                                        <div class="form-group">
                                          <div class="radio-inline">
                                            <label>
                                              <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked="">
                                              Option one
                                            </label>
                                          </div>
                                          <div class="radio-inline">
                                            <label>
                                              <input type="radio" name="optionsRadios" id="optionsRadios2" value="option2">
                                              Option two
                                            </label>
                                          </div>
                                          <div class="radio-inline">
                                            <label>
                                              <input type="radio" name="optionsRadios" id="optionsRadios3" value="option3" >
                                              Option three
                                            </label>
                                          </div>
                                        </div>
                                      </div>

                                      <div class="form-group">
                                        <label for="exampleInputPassword1">Long You know</label>
                                        <div class="form-group">
                                          <div class="radio-inline">
                                            <label>
                                              <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked="">
                                              Option one
                                            </label>
                                          </div>
                                          <div class="radio-inline">
                                            <label>
                                              <input type="radio" name="optionsRadios" id="optionsRadios2" value="option2">
                                              Option two
                                            </label>
                                          </div>
                                          <div class="radio-inline">
                                            <label>
                                              <input type="radio" name="optionsRadios" id="optionsRadios3" value="option3" >
                                              Option three
                                            </label>
                                          </div>
                                        </div>
                                      </div>


                                      <div class="form-group">
                                        <label for="exampleInputPassword1">Understands ...</label>
                                        <div class="form-group">
                                          <div class="checkbox-inline">
                                            <label>
                                              <input type="checkbox" name="optionsRadios" id="optionsRadios1" value="option1" checked="">
                                              Option one
                                            </label>
                                          </div>
                                          <div class="checkbox-inline">
                                            <label>
                                              <input type="checkbox" name="optionsRadios" id="optionsRadios2" value="option2">
                                              Option two
                                            </label>
                                          </div>
                                          <div class="checkbox-inline">
                                            <label>
                                              <input type="checkbox" name="optionsRadios" id="optionsRadios3" value="option3" >
                                              Option three
                                            </label>
                                          </div>
                                        </div>
                                      </div>

                                      <div class="form-group">
                                        <label for="exampleInputPassword1">Understands ...</label>
                                        <div class="form-group">
                                          <div class="checkbox-inline">
                                            <label>
                                              <input type="checkbox" name="optionsRadios" id="optionsRadios1" value="option1" checked="">
                                              Option one
                                            </label>
                                          </div>
                                          <div class="checkbox-inline">
                                            <label>
                                              <input type="checkbox" name="optionsRadios" id="optionsRadios2" value="option2">
                                              Option two
                                            </label>
                                          </div>
                                          <div class="checkbox-inline">
                                            <label>
                                              <input type="checkbox" name="optionsRadios" id="optionsRadios3" value="option3" >
                                              Option three
                                            </label>
                                          </div>
                                        </div>
                                      </div>


                                    </div>
                                    <!-- /.box-body -->

                                    <div class="box-footer">
                                      <button type="submit" class="btn btn-primary">Save</button>
                                    </div>
                                  </form>
                                </div>
                              </div>
                              <div id="menu1" class="tab-pane fade">
                                <div class="col-md-12">

                                  <form role="form" class="">
                                    <div class="box-body">

                                      <div class="form-group">
                                        <label for="exampleInputPassword1">Turn for input?</label>
                                        <div class="form-group">
                                          <div class="radio-inline">
                                            <label>
                                              <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked="">
                                              Yes
                                            </label>
                                          </div>
                                          <div class="radio-inline">
                                            <label>
                                              <input type="radio" name="optionsRadios" id="optionsRadios2" value="option2">
                                              No
                                            </label>
                                          </div>

                                        </div>
                                      </div>

                                      <div class="form-group">
                                        <label for="exampleInputPassword1">Communication with?</label>
                                        <div class="form-group">
                                          <div class="radio-inline">
                                            <label>
                                              <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked="">
                                              Yes
                                            </label>
                                          </div>
                                          <div class="radio-inline">
                                            <label>
                                              <input type="radio" name="optionsRadios" id="optionsRadios2" value="option2">
                                              No
                                            </label>
                                          </div>

                                        </div>
                                      </div>

                                      <div class="form-group">
                                        <label for="exampleInputEmail1">Influential:</label>
                                        <p></p>
                                        <input id="ex1" class="form-control ex1" data-slider-id='ex1Slider' type="text" data-slider-min="0" data-slider-max="20" data-slider-step="1" data-slider-value="14"/>
                                      </div>

                                      <div class="form-group inline" style="padding-right:40px;">
                                        <label for="exampleInputPassword1">Aspect 1</label>
                                        <div class="form-group inline">

                                        <div id="stars-existing" class="starrr" data-rating='4'></div>
                                      </div>
                                    </div>

                                      <div class="form-group inline">
                                        <label for="exampleInputPassword1">Aspect 2</label>
                                        <div class="form-group inline">

<div id="stars" class="starrr"></div>


                                        </div>
                                      </div>


                                    </div>
                                    <!-- /.box-body -->

                                    <div class="box-footer">
                                      <button type="submit" class="btn btn-primary">Save</button>
                                    </div>
                                  </form>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="panel box box-success" hidden>
                        <div class="box-header with-border">
                          <h4 class="box-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree" class="collapsed" aria-expanded="false">
                              Collapsible Group Success
                            </a>
                          </h4>
                        </div>
                        <div id="collapseThree" class="panel-collapse collapse" aria-expanded="false">
                          <div class="box-body">
                            Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3
                            wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum
                            eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla
                            assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred
                            nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer
                            farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus
                            labore sustainable VHS.
                          </div>
                        </div>
                      </div>
                    </div>

                  </div>
                </div>
            </div>
        </div>
    </div>
@endsection
