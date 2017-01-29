<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Encrypted CSRF token for Laravel, in order for Ajax requests to work --}}
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>
      {{ isset($title) ? $title.' :: '.config('backpack.base.project_name').' Admin' : config('backpack.base.project_name').' Admin' }}
    </title>

    @yield('before_styles')

    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/') }}/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

    <link rel="stylesheet" href="{{ asset('vendor/adminlte/') }}/dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/') }}/dist/css/skins/_all-skins.min.css">

    <link rel="stylesheet" href="{{ asset('vendor/adminlte/') }}/plugins/pace/pace.min.css">
    <link rel="stylesheet" href="{{ asset('vendor/backpack/pnotify/pnotify.custom.min.css') }}">

    <!-- BackPack Base CSS -->
    <link rel="stylesheet" href="{{ asset('vendor/backpack/backpack.base.css') }}">

    <link rel="stylesheet" href="{{ asset('css/bootstrap-treeview.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-slider.min.css') }}">

    @yield('after_styles')

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="hold-transition {{ config('backpack.base.skin') }} sidebar-mini">
    <!-- Site wrapper -->
    <div class="wrapper">

      <header class="main-header">
        <!-- Logo -->
        <a href="{{ url('') }}" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini">{!! config('backpack.base.logo_mini') !!}</span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg">{!! config('backpack.base.logo_lg') !!}</span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">{{ trans('backpack::base.toggle_navigation') }}</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>

          @include('backpack::inc.menu')
        </nav>
      </header>

      <!-- =============================================== -->

      @include('backpack::inc.sidebar')

      <!-- =============================================== -->

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
         @yield('header')

        <!-- Main content -->
        <section class="content">

          @yield('content')

        </section>
        <!-- /.content -->
      </div>
      <!-- /.content-wrapper -->

      <footer class="main-footer">
        @if (config('backpack.base.show_powered_by'))
            <div class="pull-right hidden-xs">
              {{ trans('backpack::base.powered_by') }} <a target="_blank" href="http://laravelbackpack.com">Laravel BackPack</a>
            </div>
        @endif
        {{ trans('backpack::base.handcrafted_by') }} <a target="_blank" href="{{ config('backpack.base.developer_link') }}">{{ config('backpack.base.developer_name') }}</a>.
      </footer>
    </div>
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
    <script src="{{ asset('vendor/adminlte') }}/dist/js/app.min.js"></script>
    <script src="{{ asset('js/bootstrap-treeview.js') }}"></script>
    <script src="{{ asset('js/bootstrap-slider.js') }}"></script>

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

        // Set active state on menu element
        var current_url = "{{ url(Route::current()->getUri()) }}";
        $("ul.sidebar-menu li a").each(function() {
          if ($(this).attr('href').startsWith(current_url) || current_url.startsWith($(this).attr('href')))
          {
            $(this).parents('li').addClass('active');
          }
        });
    </script>

    @include('backpack::inc.alerts')

    @yield('after_scripts')

    <!-- JavaScripts -->
    {{-- <script src="{{ elixir('js/app.js') }}"></script> --}}

    <script>

    // Starrr plugin (https://github.com/dobtco/starrr)
    var __slice = [].slice;

    (function($, window) {
      var Starrr;

      Starrr = (function() {
        Starrr.prototype.defaults = {
          rating: void 0,
          numStars: 5,
          change: function(e, value) {}
        };

        function Starrr($el, options) {
          var i, _, _ref,
            _this = this;

          this.options = $.extend({}, this.defaults, options);
          this.$el = $el;
          _ref = this.defaults;
          for (i in _ref) {
            _ = _ref[i];
            if (this.$el.data(i) != null) {
              this.options[i] = this.$el.data(i);
            }
          }
          this.createStars();
          this.syncRating();
          this.$el.on('mouseover.starrr', 'span', function(e) {
            return _this.syncRating(_this.$el.find('span').index(e.currentTarget) + 1);
          });
          this.$el.on('mouseout.starrr', function() {
            return _this.syncRating();
          });
          this.$el.on('click.starrr', 'span', function(e) {
            return _this.setRating(_this.$el.find('span').index(e.currentTarget) + 1);
          });
          this.$el.on('starrr:change', this.options.change);
        }

        Starrr.prototype.createStars = function() {
          var _i, _ref, _results;

          _results = [];
          for (_i = 1, _ref = this.options.numStars; 1 <= _ref ? _i <= _ref : _i >= _ref; 1 <= _ref ? _i++ : _i--) {
            _results.push(this.$el.append("<span class='glyphicon .glyphicon-star-empty'></span>"));
          }
          return _results;
        };

        Starrr.prototype.setRating = function(rating) {
          if (this.options.rating === rating) {
            rating = void 0;
          }
          this.options.rating = rating;
          this.syncRating();
          return this.$el.trigger('starrr:change', rating);
        };

        Starrr.prototype.syncRating = function(rating) {
          var i, _i, _j, _ref;

          rating || (rating = this.options.rating);
          if (rating) {
            for (i = _i = 0, _ref = rating - 1; 0 <= _ref ? _i <= _ref : _i >= _ref; i = 0 <= _ref ? ++_i : --_i) {
              this.$el.find('span').eq(i).removeClass('glyphicon-star-empty').addClass('glyphicon-star');
            }
          }
          if (rating && rating < 5) {
            for (i = _j = rating; rating <= 4 ? _j <= 4 : _j >= 4; i = rating <= 4 ? ++_j : --_j) {
              this.$el.find('span').eq(i).removeClass('glyphicon-star').addClass('glyphicon-star-empty');
            }
          }
          if (!rating) {
            return this.$el.find('span').removeClass('glyphicon-star').addClass('glyphicon-star-empty');
          }
        };

        return Starrr;

      })();
      return $.fn.extend({
        starrr: function() {
          var args, option;

          option = arguments[0], args = 2 <= arguments.length ? __slice.call(arguments, 1) : [];
          return this.each(function() {
            var data;

            data = $(this).data('star-rating');
            if (!data) {
              $(this).data('star-rating', (data = new Starrr($(this), option)));
            }
            if (typeof option === 'string') {
              return data[option].apply(data, args);
            }
          });
        }
      });
    })(window.jQuery, window);



    $(function() {
      return $(".starrr").starrr();
    });






    $(document).ready(function(){
      $.ajax({
          type: "POST",
          url: 'test-view/employees',
          data: "",
          success: function(data) {
              //return data;
              drawTree(data);
          }
      });
    // $('#tree').treeview({data: getTree()});

    $('#myTabs a').click(function (e) {
      e.preventDefault()
      $(this).tab('show')
    });

    // With JQuery
    $('.ex1').slider({
    	formatter: function(value) {
    		return 'Current value: ' + value;
    	}
    });

    $('#stars').on('starrr:change', function(e, value){
        $('#count').html(value);
      });

      $('#stars-existing').on('starrr:change', function(e, value){
        $('#count-existing').html(value);
      });




});

  function drawTree(data){
    $('#tree').treeview({
      data: data,
      showIcon: true,
      showCheckbox: true,
      onNodeChecked: function(event, node) {
          $('#checkable-output').prepend('<p>' + node.text + ' was checked</p>');
      },
      onNodeUnchecked: function (event, node) {
          $('#checkable-output').prepend('<p>' + node.text + ' was unchecked</p>');
      }
    });
  }

    function getTree() {
        $.ajax({
            type: "POST",
            url: 'test-view/employees',
            data: "",
            success: function(data) {
                return data;
            }
        })
    };
    </script>
</body>
</html>
