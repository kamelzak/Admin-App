<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AdminLTE 3 | Starter</title>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper" id="app">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
      </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
      <li class="nav-item">
        <div class="navbar-search-block">
            <div class="input-group input-group-sm">
              <input class="form-control form-control-navbar" @keyup="searchit" v-model="search" type="search" placeholder="Search" aria-label="Search">
              <div class="input-group-append">
                <button class="btn btn-navbar" @click="searchit">
                  <i class="fas fa-search"></i>
                </button>
                <button class="btn btn-navbar" @click="search=''" type="button" data-widget="navbar-search">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
        </div>
      </li>

    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="{{ asset('img/logo.png') }}" alt="AdminAppLogo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Admin App</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ asset('img/avatar.png') }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{auth()->user()->name}}<p>{{auth()->user()->type}}</p></a>
        </div>
      </div>

      <!-- SidebarSearch Form 
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div> -->

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
            <router-link tag="li" class="nav-item" to="/dashboard" exact>
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-tachometer-alt blue"></i>
                <p>
                Dashboard
                </p>
            </a>
            </router-link>

            @can('isUser')
            <router-link tag="li" class="nav-item" to="/tasks" exact>
              <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-tasks teal"></i>
                  <p>
                  Tasks
                  </p>
              </a>
              </router-link>
            @endcan

            @can('isAdminOrAuthor')
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-cog green"></i>
                    <p>
                    Management
                    <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                @can('isAuthor')
                <ul class="nav nav-treeview">
                  <router-link tag="li" class="nav-item" to="/tasks-management" exact>
                  <a href="#" class="nav-link">
                      <i class="fas fa-tasks nav-icon teal"></i>
                      <p>Tasks</p>
                  </a>
                  </router-link>
                </ul>
                <ul class="nav nav-treeview">
                  <router-link tag="li" class="nav-item" to="/ended-tasks" exact>
                  <a href="#" class="nav-link">
                      <i class="fas fa-clipboard-check nav-icon cyan"></i>
                      <p>Ended Tasks</p>
                  </a>
                  </router-link>
                </ul>
                @endcan
                <ul class="nav nav-treeview">
                    <router-link tag="li" class="nav-item" to="/users" exact>
                    <a href="#" class="nav-link">
                        <i class="fas fa-users nav-icon indigo"></i>
                        <p>Users</p>
                    </a>
                    </router-link>
                </ul>
            </li>
            @endcan

            <router-link tag="li" class="nav-item" to="/profile" exact>
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-user orange"></i>
                    <p>
                    Profile
                    </p>
                </a>
            </router-link>

            @can('isAdmin')
            <router-link tag="li" class="nav-item" to="/developper" exact>
              <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-cogs"></i>
                  <p>
                  Developper
                  </p>
              </a>
            </router-link>
            @endcan

            <li class="nav-item">

                <a class="nav-link" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                        <i class="nav-icon fas fa-power-off red"></i>
                        <p>Logout</p>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </li>
          
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">

            <router-view></router-view> 

            <vue-progress-bar></vue-progress-bar>

      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
      Anything you want
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
  </footer>
</div>
<!-- ./wrapper -->

@auth
  <script>
    window.user = @json(auth()->user())
  </script>
@endauth

<!-- REQUIRED SCRIPTS -->
<script src="{{ asset('js/app.js') }}" defer></script>

</body>
</html>
