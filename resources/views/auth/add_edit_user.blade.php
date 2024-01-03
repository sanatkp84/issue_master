@extends('layout.master')
@section('content')
<main id="main" class="main">

<div class="pagetitle">
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href={{ url('users') }}>Go back to Employees List</a></li>
    </ol>
  </nav>
</div><!-- End Page Title -->

<section class="section dashboard">
  <div class="row">


    

  <div class="col-lg-12">
   
     <!-- Vertical Form -->
     <form class="row g-3" method="POST" enctype="multipart/form-data" action="{{ url('users/user_information') }}">
        @csrf
    
    <div>
          @if(!isset($user->id))
       <h3>Create New User</h3>
       @else
       <h3>Edit User</h3>
       @endif
    </div>
    
             
    <div class="row">
            <div class="col-lg-6 order-1 order-lg-0">
            
              <input type="hidden" name="id" value="{{isset($user->id)?$user->id:''}}">
    
              <div class="col-12">
                <label for="inputNanme4" class="form-label">Name</label>
                <input type="text" name="name" class="form-control" value="{{$user->first_name ?? ''}}  {{ $user->last_name ?? ''}}" id="inputNanme4">
              </div>
    
            <div class="col-12">
                    <label for="inputNanme4" class="form-label">Password</label>
                      <input type="Password" class="form-control" name="password" id="inputNanme4">
                    </div>
            </div>
    
            <div class="col-lg-6 order-0 order-lg-1">
             
                  <div class="col-12">
                      <label for="inputNanme4" class="form-label">Email</label>
                      <input type="text" name="email" class="form-control" value="{{isset($user->email)?$user->email:''}}" id="inputNanme4">
             </div>
    
                    <div class="col-12">
                      <label for="inputAddress" class="form-label">Role</label>
                      <select class="form-select" name="role" aria-label="Default select example">
                          <option selected> Select the Role</option>
                          <option value="2" <?php if(isset($user->role) && $user->role == '1' ) echo"selected"?> >Adminstrator</option>
                          <option value="1" <?php if(isset($user->role) && $user->role == '2' ) echo"selected"?>>Employee</option>
             
                        </select>
                    </div>
    
    
            </div>
    
        </div>
             
        <div>
            @if(!isset($user->id))
         <button class="btn btn-warning" type="submit">Create User</button>
         @else
         <button class="btn btn-warning" type="submit">Update User</button>
         @endif
      
      </div>
                  </form><!-- Vertical Form -->


        </div>
    </div>

</section>



</main>

 @endsection