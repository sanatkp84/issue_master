@extends('layout.master')
@section('content')


<main id="main" class="main">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />


<div class="col-12">

     <!-- Vertical Form -->
     <form class="row g-3" method="POST" enctype="multipart/form-data" action="{{url('reports/report_submit')}}">
    @csrf

    <div>
      @if(!isset($report->id))
   <span class="card-title">  Create new report </span>
   <button class="btn btn-warning" type="submit">Create report</button>
   @else
   <span class="card-title">  Update report </span>
   <button class="btn btn-warning" type="submit">Update report</button>
   @endif

</div>

         
<div class="row">
        <div class="col-lg-6 order-1 order-lg-0">
        
          <input type="hidden" name="id" value="{{isset($report->id)?$report->id:''}}">
             <div class="row mb-3">
                  <label for="inputPassword" class="col-form-label">Textarea</label>
                  <div class="col-12">
                    <textarea class="form-control" required name="description" style="height: 295px">{{isset($report->description)?$report->description:''}}</textarea>
                  </div>
                </div>

<div class="col-12 mb-3 mt-3">
    @php
      $users = App\Models\User::where('role', '!=', 1)->get();

        if (isset($report)) {
            $members = $report->members_involved;
            $involved_member = json_decode($members);
        }
    @endphp

    <label for="inputNanme4" class="form-label">Involved Parties</label>
    <select class="form-select selecttwo" required name="involved_parties[]" aria-label="Default select example" multiple="multiple">
        @foreach($users as $user)
            <option value="{{ $user->first_name }}" 
                @if(isset($involved_member) && in_array($user->first_name, $involved_member))
                    selected="selected"
                @endif
            >
                {{ isset($user->first_name) ? $user->first_name : '' }}
            </option>
        @endforeach
    </select>
</div>


                <div class="col-12 mb-3">
                <label for="inputNanme4" class="form-label">Status</label>
                 
                  <select class="form-select " name="incident_nature" aria-label="Default select example" required>
                      <option selected disabled >Select the Status</option>
                      <option value="Low" <?php if(isset($report->incident_nature) && $report->incident_nature == 'Low' ) echo"selected"?> >Low</option>
                      <option value="Medium" <?php if(isset($report->incident_nature) && $report->incident_nature == 'Medium' ) echo"selected"?> >Medium</option>
                      <option value="High" <?php if(isset($report->incident_nature) && $report->incident_nature == 'High' ) echo"selected"?>>High</option>
                      <option value="Urgent" <?php if(isset($report->incident_nature) && $report->incident_nature == 'Urgent' ) echo"selected"?>>Urgent</option>
                    </select>
                  
                  
                  
                </div>
        </div>

        <div class="col-lg-6 order-0 order-lg-1">
         
              <div class="col-12 mb-3">
                  <label for="inputNanme4" class="form-label">Name</label>
                  <input type="text" required name="name" class="form-control" value="{{isset($report->incident_name)?$report->incident_name:''}}" id="inputNanme4">
                </div>

                  <div class="col-12 mb-3">
                  <label for="inputNanme4" class="form-label">Date</label>
                  <input type="date" name="date" class="form-control" required id="inputNanme4" value="{{isset($report->incident_date)?$report->incident_date:''}}">
                </div>

                <div class="col-12 mb-3">
                  <label for="inputEmail4" class="form-label">Time</label>
                  <input type="time" class="form-control" name="time" id="inputEmail4" required value="{{isset($report->incident_time)?$report->incident_time:''}}">
                </div>
                <div class="col-12 mb-3">
                  <label for="inputPassword4" class="form-label">Location</label>
                  <input type="text" name="location" class="form-control" id="inputPassword4" required value="{{isset($report->incident_location)?$report->incident_location:''}}">
                </div>

                <div class="col-12 mb-3">
                  <label for="inputAddress" class="form-label">Category</label>
              <select class="form-select" required aria-label="Default select example" name="incident_category">
    <option selected disabled>---- Select the Category ----</option>
    @foreach($categories as $category)
        <option value="{{ $category->id }}" {{ isset($report->incident_category) && $report->incident_category == $category->id ? 'selected' : '' }}>
            {{ $category->category_name }} 
        </option>
    @endforeach
</select>
                </div>

                <div class="col-12 mb-3">
                  <label for="inputAddress" class="form-label">Attachments</label>
                  <input type="file" class="form-control" name="attachment" id="inputAddress">
                </div>


        </div>

    </div>
         
             
    
              </form><!-- Vertical Form -->

    


              </div>
 
 


            </main><!-- End #main -->
            
            
            
            <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
            <script>
                 $(document).ready(function() {
    $('.selecttwo').select2();
});  
            </script>
         
           
@endsection










