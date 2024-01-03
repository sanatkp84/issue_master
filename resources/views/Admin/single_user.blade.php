@extends('layout.master')
@section('content')
<main id="main" class="main">

<div class="pagetitle">
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="/users">Go back to Employees List</a></li>
    </ol>
  </nav>
</div><!-- End Page Title -->

<section class="section dashboard">
  <div class="row">


  <div class="col-lg-12 mb-5">
   

      <div class="card mt-5">
            <div class="card-body">  
     <br>   
       <h3>{{$user->username ?? 'Employee Name'}}</h3>
      <br>
      
      <div class="col-sm-12 row ">
        
        
      <div class="col-sm-6">
         <h6>Email : {{$user->email ?? 'Employee Email'}}</h6>
    </div>
    
     <div class="col-sm-3">
         <h6>Role : {{$user->role ?? 'Employee Role'}}</h6>
    </div>
    
     <div class="col-sm-3">
         <h6>ID : {{$user->id ?? 'Employee Role'}}</h6>
    </div>
        
        
         <br>    <br>
         
    </div>
     </div>
      </div>
  
 

            </div>


            </div>
      
        
        
        
        
        
        
    </div>

</section>



 
</main>

 @endsection