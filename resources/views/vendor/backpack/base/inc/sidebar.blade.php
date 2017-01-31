@if (Auth::check())
    <!-- Left side column. contains the sidebar -->
    <aside class="main-sidebar">
      <!-- sidebar: style can be found in sidebar.less -->
      <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
          <div class="pull-left image">
            <img src="https://placehold.it/160x160/00a65a/ffffff/&text={{ mb_substr(Auth::user()->name, 0, 1) }}" class="img-circle" alt="User Image">
          </div>
          <div class="pull-left info">
            <p>{{ Auth::user()->name }}</p>
            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
          </div>
        </div>
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
          <li class="header">{{ trans('backpack::base.administration') }}</li>
          <!-- ================================================ -->
          <!-- ==== Recommended place for admin menu items ==== -->
          <!-- ================================================ -->
          <li><a href="{{ url('admin/dashboard') }}"><i class="fa fa-dashboard"></i> <span>{{ trans('backpack::base.dashboard') }}</span></a></li>

          @role(['super_admin', 'admin'])
          <li class="header">Survey Management</li>
          <li><a href="{{ url('admin/survey') }}"><i class="fa fa-dashboard"></i> <span>Manage Surveys</span></a></li>
          <li><a href="{{ url('admin/question_section') }}"><i class="fa fa-dashboard"></i> <span>Manage Sections</span></a></li>
          <li><a href="{{ url('admin/question') }}"><i class="fa fa-dashboard"></i> <span>Manage Questions</span></a></li>
          @endrole

          @role(['super_admin', 'admin', 'sysadmin'])
          <li class="header">User Management</li>
          <li><a href="{{ url('admin/user') }}"><i class="fa fa-dashboard"></i> <span>Manage Users</span></a></li>
          @endrole
          <!-- ======================================= -->
          <li class="header">{{ trans('backpack::base.user') }}</li>
          <li><a href="{{ url('/logout') }}"><i class="fa fa-sign-out"></i> <span>{{ trans('backpack::base.logout') }}</span></a></li>
        </ul>
      </section>
      <!-- /.sidebar -->
    </aside>
@endif
