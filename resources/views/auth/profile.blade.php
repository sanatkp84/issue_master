@extends('layout.master')
@section('content')
<main id="main" class="main">


<div class="pagetitle">
      <h1>Profile</h1>
  
    </div><!-- End Page Title -->

    <section class="section profile">
      <div class="row">
        <div class="col-xl-4">

          <div class="card">
            <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

              
              <h2> {{$user->username ?? ''}} </h2>
             @if($user->role == '0' )
              <h3>Primary Admin</h3>
              @elseif($user->role == '1')
               <h3>Administrator</h3>
              @else
               <h3>Partner</h3>
              @endif
              
              
              <div class="social-links mt-2">
                <a href="{{$user->twitter ?? '#'}}" class="twitter"><i class="bi bi-twitter"></i></a>
                <a href="{{$user->facebook ?? '#'}}" class="facebook"><i class="bi bi-facebook"></i></a>
                <a href="{{$user->instagram ?? '#'}}" class="instagram"><i class="bi bi-instagram"></i></a>
                <a href="{{$user->linkedin ?? '#'}}" class="linkedin"><i class="bi bi-linkedin"></i></a>
              </div>
              
            </div>
          </div>

        </div>

        <div class="col-xl-8">

          <div class="card">
            <div class="card-body pt-3">
              <!-- Bordered Tabs -->
              <ul class="nav nav-tabs nav-tabs-bordered">

                <li class="nav-item">
                  <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Overview</button>
                </li>

                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit Profile</button>
                </li>


   @if(Auth::user()->role == '0')
                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-settings">Activities</button>
                </li>
   @endif

                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Change Password</button>
                </li>

              </ul>
              <div class="tab-content pt-2">

                <div class="tab-pane fade show active profile-overview" id="profile-overview">

                  <h5 class="card-title">Profile Details</h5>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label ">Full Name</div>
                    <div class="col-lg-9 col-md-8">{{$user->first_name ?? ' No Name'}}  {{ $user->last_name ?? ''}}</div>
                  </div>


                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Role</div>
               @if($user->role == '0' )
          <div class="col-lg-9 col-md-8">Primary Admin</div>
              @elseif($user->role == '1')
            <div class="col-lg-9 col-md-8">Administrator</div>
              @else
               <div class="col-lg-9 col-md-8">Partner</div>
              @endif
                  </div>
                  
                  
                  
                      <div class="row">
                    <div class="col-lg-3 col-md-4 label">Email</div>
                    <div class="col-lg-9 col-md-8">{{$user->email}}</div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Country</div>
                    <div class="col-lg-9 col-md-8">{{$user->country ?? '----'}}</div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Address</div>
                    <div class="col-lg-9 col-md-8"> {{$user->address ?? '---'}}</div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Phone</div>
                    <div class="col-lg-9 col-md-8">{{$user->number ?? '---'}}</div>
                  </div>

                    <div class="row">
                    <div class="col-lg-3 col-md-4 label">Status</div>
                    <div class="col-lg-9 col-md-8">{{$user->status ?? '---'}}</div>
                  </div>

                </div>

                <div class="tab-pane fade profile-edit pt-3" id="profile-edit">

                  <!-- Profile Edit Form -->
                  <form action="{{ url('update_user_profile')}}"  method="post" enctype="multipart/form-data">
@csrf
               
               <input type="hidden" value="{{$user->id}}" name="id" >

                    <div class="row mb-3">
                      <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Full Name</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="name" type="text" class="form-control" id="fullName" value="{{$user->first_name ?? ''}}  {{ $user->last_name ?? ''}}">
                      </div>
                    </div>

                

                    <div class="row mb-3">
                      <label for="Country" class="col-md-4 col-lg-3 col-form-label">Country</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="country" type="text" class="form-control" id="Country"  value="{{$user->country}}">
                      </div>
                    </div>
                    

                    <div class="row mb-3">
                      <label for="Address" class="col-md-4 col-lg-3 col-form-label">Address</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="address" type="text" class="form-control" id="Address" value="{{$user->address}}">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="Phone" class="col-md-4 col-lg-3 col-form-label">Phone</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="number" type="text" class="form-control" id="Phone" value="{{$user->number}}">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="Twitter" class="col-md-4 col-lg-3 col-form-label">Twitter Profile</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="twitter" type="text" class="form-control" id="Twitter" value="{{$user->twitter}}">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="Facebook" class="col-md-4 col-lg-3 col-form-label">Facebook Profile</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="facebook" type="text" class="form-control" id="Facebook" value="{{$user->facebook}}">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="Instagram" class="col-md-4 col-lg-3 col-form-label">Instagram Profile</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="instagram" type="text" class="form-control" id="Instagram" value="{{$user->instagram}}">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="Linkedin" class="col-md-4 col-lg-3 col-form-label">Linkedin Profile</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="linkedin" type="text" class="form-control" id="Linkedin" value="{{$user->linkedin}}">
                      </div>
                    </div>

                    <div class="text-center">
                      <button type="submit" class="btn btn-warning">Save Changes</button>
                    </div>
                  </form><!-- End Profile Edit Form -->

                </div>


                  @if(Auth::user()->role == '0')
                  
                <div class="tab-pane fade pt-3" id="profile-settings">

                  <!-- Settings Form -->
               
                  
                   @if(isset($activities) && count($activities) > 0)
                    <table class="table table-borderless" id="reportTable">
          
                <th>ID</th>
                    <th>Activity</th>
                        <th> Date</th>
                
                        <tbody >
                              
        @foreach($activities as $key => $activity)
        <tr>
            <th>{{ $key + 1 }}</th>
            <td>{{ $activity->activity ?? '---' }}</td>
            <td>{{ $activity->created_at ?? '---' }}</td>
        </tr>
       @endforeach
                         </tbody>
                           
                    </table>
                    @else
                   <hr class="mt-4">
                    <center class="mt-5 mb-5"><h3 class="mt-5 mb-5">No Record's Were Found</h3></center>

                @endif
              
                  
                  <!-- End settings Form -->

                </div>
     @endif
     
     
                <div class="tab-pane fade pt-3" id="profile-change-password">
                  <!-- Change Password Form -->
                  <form method="POST" action="{{ url('user_password_update')}}">
                    @csrf

                  <div class="row mb-3">
                    <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Current Password</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="old_password" type="text" @error('old_password') is-invalid @enderror" required class="form-control" id="currentPassword">
                    </div>
                    @error('old_password')
                    {{-- <span class="invalid-feedback" role="alert"> --}}
                        <strong>{{ $message }}</strong>
                    {{-- </span> --}}
                @enderror
                  </div>
                  {{-- </div> --}}

                  <div class="row mb-3">
                    <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">New Password</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="password" @error('password') is-invalid @enderror" type="text" required class="form-control" id="password">
                    </div>
                    @error('password')
                    {{-- <span class="invalid-feedback" role="alert"> --}}
                        <strong>{{ $message }}</strong>
                    {{-- </span> --}}
                @enderror
                  </div>

                  <div class="row mb-3">
                    <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">Re-enter New Password</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="password_confirmation" type="text" @error('password_confirmation') is-invalid @enderror" required class="form-control" id="confirm_password">
                    </div>
                   
                  </div>

                  <div class="text-center">
                    <button type="submit" class="btn btn-primary">Change Password</button>
                  </div>
                </form><!-- End Change Password Form -->


                </div>

              </div><!-- End Bordered Tabs -->

            </div>
          </div>

        </div>
        
        
        

        
        
      @if(isset($prevoius_data) && Auth::user()->role == '0' )
                   
                   <div class="">
    <table class="table table-bordered" style="width: max-content;" id="reportTable">
        <h5 class="text-primary">Recent Modifications</h5>
        <thead>
            <tr>
                <th scope="col" style="width: 250px;">Creator ID</th>
                   <th scope="col" style="width: 250px;">Name</th>
                <th scope="col" style="width: 250px;">Email</th>
                <th scope="col" style="width: 250px;">Number</th>
                <th scope="col" style="width: 250px;">Status</th>
                <th scope="col" style="width: 250px;">Address</th>
                <th scope="col" style="width: 250px;">Country</th>
                <th scope="col" style="width: 250px;">Role</th>
                <th scope="col" style="width: 250px;">Created At</th>
            </tr>
        </thead>
        <tbody>
            @foreach($prevoius_data as $prevoius)
            @php $decodedData = json_decode($prevoius->detail, true) @endphp
            <tr>
                <td>{{ $prevoius->creator_id ?? '---' }}</td>
                    <td>{{ $decodedData['username'] ?? '---' }}</td>
                <td>{{ $decodedData['email'] ?? '---' }}</td>
                <td>{{ $decodedData['number'] ?? '---' }}</td>
                <td>{{ $decodedData['status'] ?? '---' }}</td>
                 <td>{{ $decodedData['address'] ?? '---' }}</td>
                <td>{{ $decodedData['country'] ?? '---' }}</td>
                <td>{{ $decodedData['role'] ?? '---' }}</td>
                <td>{{ $decodedData['created_at'] ?? '---' }}</td>
          
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

                    
                      @endif
        
        
      </div>
    </section>

  </main><!-- End #main -->
@endsection
