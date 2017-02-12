<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Encrypted CSRF token for Laravel, in order for Ajax requests to work --}}
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>
      Nasj Survey
    </title>

    @yield('before_styles')

    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/') }}/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="//cdn.rawgit.com/morteza/bootstrap-rtl/v3.3.4/dist/css/bootstrap-rtl.min.css">
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/') }}/dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="{{ asset('css/journal-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-slider.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/star-rating.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-treeview.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

    @yield('after_styles')

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="">
  <div class="navbar navbar-default">
    <div class="container-fluid">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="{{ url('') }}">Nasj Survey</a>
      </div>

      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav">
          @role(['super_admin', 'admin', 'cxo', 'manager', 'sys'])
            <li><a href="{{ url('admin') }}">Admin Panel</a></li>
          @endrole

          @role(['super_admin', 'admin', 'cxo', 'manager', 'emp'])
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Start A Survey <span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                @foreach ($surveys AS $survey)
                <li class="{{ $selected_survey->slug === $survey['slug'] ? "active" : "" }}"><a href="{{ url('s/'.$survey['slug']) }}">{{ $survey['name']}}</a></li>
                @endforeach
              </ul>
            </li>
          @endrole
          </ul>
          @role(['super_admin', 'admin', 'cxo', 'manager', 'emp'])
          @if(!empty($selected_survey->name))
          <!-- <span class='nav navbar-text' style="">Survey Progress: {{ $progress }}%</span> -->
          <!-- <span class='nav navbar-text' >Survey Progress: </span> -->
            <div class="nav navbar-text progress progress-striped" style="width: 40%;" id="progress">

                    <div class="progress-bar progress-bar-info" style="width: {{ $progress }}%;"></div>
                    <span class="" style="padding-right: 240px">Progress: {{ $progress }}%</span>

            </div>
          @endif
        @endrole
        <ul class="nav navbar-nav navbar-right">
          @if (Auth::guest())
              <li><a href="{{ url(config('backpack.base.route_prefix', 'admin').'/login') }}">{{ trans('backpack::base.login') }}</a></li>
              @if (config('backpack.base.registration_open'))
              <!-- <li><a href="{{ url(config('backpack.base.route_prefix', 'admin').'/register') }}">{{ trans('backpack::base.register') }}</a></li> -->
              @endif
          @else
              <li><a href="{{ url(config('backpack.base.route_prefix', 'admin').'/logout') }}"><i class="fa fa-btn fa-sign-out"></i> {{ trans('backpack::base.logout') }}</a></li>
          @endif
        </ul>
      </div>
    </div>
  </div>

      <!-- =============================================== -->



      <!-- =============================================== -->

      <div class="container-fluid">
      <!-- Content Wrapper. Contains page content -->
      <div class="bs-docs-section clearfixr">
        <!-- Content Header (Page header) -->
         @yield('header')

        <!-- Main content -->
        <section class="content">

          @yield('content')

        </section>
        <!-- /.content -->
      </div>
      <!-- /.content-wrapper -->
    </div>

      <footer class="main-footer">

      </footer>

    <!-- ./wrapper -->


    @yield('before_scripts')

    <!-- jQuery 2.2.0 -->
    <script src="https://code.jquery.com/jquery-2.2.0.min.js"></script>
    <script>window.jQuery || document.write('<script src="{{ asset('vendor/adminlte') }}/plugins/jQuery/jQuery-2.2.0.min.js"><\/script>')</script>
    <!-- Bootstrap 3.3.5 -->
    <script src="{{ asset('vendor/adminlte') }}/bootstrap/js/bootstrap.min.js"></script>
    <script src="{{ asset('vendor/adminlte') }}/plugins/pace/pace.min.js"></script>
    <script src="{{ asset('vendor/adminlte') }}/plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <script src="{{ asset('vendor/adminlte') }}/plugins/fastclick/fastclick.js"></script>
    <script src="{{ asset('js/bootstrap-slider.js') }}"></script>
    <script src="{{ asset('js/star-rating.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap-treeview.js') }}"></script>


    <!-- page script -->
    <script type="text/javascript">
        // To make Pace works on Ajax calls
        $(document).ajaxStart(function() { Pace.restart(); });

        // Ajax calls should always have the CSRF token attached to them, otherwise they won't work
        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

        // // Set active state on menu element
        // var current_url = "{{ url(Route::current()->getUri()) }}";
        // $("ul.sidebar-menu li a").each(function() {
        //   if ($(this).attr('href').startsWith(current_url) || current_url.startsWith($(this).attr('href')))
        //   {
        //     $(this).parents('li').addClass('active');
        //   }
        // });
    </script>


    @yield('after_scripts')

    <script>

    // Starrr plugin (https://github.com/dobtco/starrr)
    // var __slice = [].slice;
    //
    // (function($, window) {
    //   var Starrr;
    //
    //   Starrr = (function() {
    //     Starrr.prototype.defaults = {
    //       rating: void 0,
    //       numStars: 5,
    //       change: function(e, value) {}
    //     };
    //
    //     function Starrr($el, options) {
    //       var i, _, _ref,
    //         _this = this;
    //
    //       this.options = $.extend({}, this.defaults, options);
    //       this.$el = $el;
    //       _ref = this.defaults;
    //       for (i in _ref) {
    //         _ = _ref[i];
    //         if (this.$el.data(i) != null) {
    //           this.options[i] = this.$el.data(i);
    //         }
    //       }
    //       this.createStars();
    //       this.syncRating();
    //       this.$el.on('mouseover.starrr', 'span', function(e) {
    //         return _this.syncRating(_this.$el.find('span').index(e.currentTarget) + 1);
    //       });
    //       this.$el.on('mouseout.starrr', function() {
    //         return _this.syncRating();
    //       });
    //       this.$el.on('click.starrr', 'span', function(e) {
    //         return _this.setRating(_this.$el.find('span').index(e.currentTarget) + 1);
    //       });
    //       this.$el.on('starrr:change', this.options.change);
    //     }
    //
    //     Starrr.prototype.createStars = function() {
    //       var _i, _ref, _results;
    //
    //       _results = [];
    //       for (_i = 1, _ref = this.options.numStars; 1 <= _ref ? _i <= _ref : _i >= _ref; 1 <= _ref ? _i++ : _i--) {
    //         _results.push(this.$el.append("<span class='glyphicon .glyphicon-star-empty'></span>"));
    //       }
    //       return _results;
    //     };
    //
    //     Starrr.prototype.setRating = function(rating) {
    //       if (this.options.rating === rating) {
    //         rating = void 0;
    //       }
    //       this.options.rating = rating;
    //       this.syncRating();
    //       return this.$el.trigger('starrr:change', rating);
    //     };
    //
    //     Starrr.prototype.syncRating = function(rating) {
    //       var i, _i, _j, _ref;
    //
    //       rating || (rating = this.options.rating);
    //       if (rating) {
    //         for (i = _i = 0, _ref = rating - 1; 0 <= _ref ? _i <= _ref : _i >= _ref; i = 0 <= _ref ? ++_i : --_i) {
    //           this.$el.find('span').eq(i).removeClass('glyphicon-star-empty').addClass('glyphicon-star');
    //         }
    //       }
    //       if (rating && rating < 5) {
    //         for (i = _j = rating; rating <= 4 ? _j <= 4 : _j >= 4; i = rating <= 4 ? ++_j : --_j) {
    //           this.$el.find('span').eq(i).removeClass('glyphicon-star').addClass('glyphicon-star-empty');
    //         }
    //       }
    //       if (!rating) {
    //         return this.$el.find('span').removeClass('glyphicon-star').addClass('glyphicon-star-empty');
    //       }
    //     };
    //
    //     return Starrr;
    //
    //   })();
    //   return $.fn.extend({
    //     starrr: function() {
    //       var args, option;
    //
    //       option = arguments[0], args = 2 <= arguments.length ? __slice.call(arguments, 1) : [];
    //       return this.each(function() {
    //         var data;
    //
    //         data = $(this).data('star-rating');
    //         if (!data) {
    //           $(this).data('star-rating', (data = new Starrr($(this), option)));
    //         }
    //         if (typeof option === 'string') {
    //           return data[option].apply(data, args);
    //         }
    //       });
    //     }
    //   });
    // })(window.jQuery, window);
    //
    //
    //
    // $(function() {
    //   return $(".starrr").starrr();
    // });
    //





    // $(document).ready(function(){
//       $.ajax({
//           type: "POST",
//           url: 'test-view/employees',
//           data: "",
//           success: function(data) {
//               //return data;
//               drawTree(data);
//           }
//       });
//     // $('#tree').treeview({data: getTree()});
//
//     $('#myTabs a').click(function (e) {
//       e.preventDefault()
//       $(this).tab('show')
//     });
//
//     // With JQuery
//     $('.ex1').slider({
//     	formatter: function(value) {
//     		return 'Current value: ' + value;
//     	}
//     });
//
//     $('#stars').on('starrr:change', function(e, value){
//         $('#count').html(value);
//       });
//
//       $('#stars-existing').on('starrr:change', function(e, value){
//         $('#count-existing').html(value);
//       });
//
//
//
//
// });
//
//   function drawTree(data){
//     $('#tree').treeview({
//       data: data,
//       showIcon: true,
//       showCheckbox: true,
//       onNodeChecked: function(event, node) {
//           $('#checkable-output').prepend('<p>' + node.text + ' was checked</p>');
//       },
//       onNodeUnchecked: function (event, node) {
//           $('#checkable-output').prepend('<p>' + node.text + ' was unchecked</p>');
//       }
//     });
//   }
//
//     function getTree() {
//         $.ajax({
//             type: "POST",
//             url: 'test-view/employees',
//             data: "",
//             success: function(data) {
//                 return data;
//             }
//         })
//     };
    </script>
</body>
</html>
