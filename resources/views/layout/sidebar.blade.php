 <!-- ======= Sidebar ======= -->
 <aside id="sidebar" class="sidebar">

<ul class="sidebar-nav" id="sidebar-nav">


  <li class="nav-item">
    <a class="nav-link " href="{{ url('dashboard') }}">
      <i class="bi bi-grid"></i>
      <span>Dashboard</span>
    </a>
  </li><!-- End Dashboard Nav -->


  <li class="nav-item">
    <a class="nav-link collapsed" href=  "{{ url('reports') }}">
<i class="bi bi-journal-text"></i>
      <span>Reports</span>
    </a>
  </li><!-- End Profile Page Nav -->



    @if(auth::user()->role == '0' || auth::user()->role == '1'  )
  <li class="nav-item">
    <a class="nav-link collapsed" href=  "{{ url('users') }}">
    <i class="bi bi-people-fill"></i>
      <span>Employees</span>
    </a>
  </li>
  <!-- End F.A.Q Page Nav -->
@endif



    @if($user->role == '0' || $user->role == '1'  )
    
<li class="nav-item">
    <a class="nav-link collapsed" href="{{ url('category') }}">
   <i class="bi bi-bookmark-star"></i>
      <span>Categories</span>
    </a>
  </li> 
  <!-- End Contact Page Nav -->
@endif


  <li class="nav-item">
    <a class="nav-link collapsed" href="{{ url('calender') }}">
   <i class="bi bi-calendar2-plus"></i>
      <span>Calender</span>
    </a>
  </li><!-- End Register Page Nav -->
  <hr>

  <li class="nav-item">
    <a class="nav-link collapsed" href="{{ url('user-profile') }}">
   <i class="bi bi-person-circle"></i>
      <span>Profile</span>
    </a>
  </li><!-- End Login Page Nav -->

  <li class="nav-item">
    <a class="nav-link collapsed" href=  "{{ url('logout') }}">
      <i class="bi bi-box-arrow-right"></i>
      <span>Signout</span>
    </a>
  </li>

</ul>

</aside><!-- End Sidebar-->