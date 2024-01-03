@extends('layout.master')
@section('content')
<main id="main" class="main">
    
    <h3> Report Info </h3>
    
    <div class="col-lg-12">
        
        <div class="row">
            
            
        <div class="col-lg-4 order-1 order-lg-0 p-2" style="height:100% ">
        <div class="card-body " style="background-color:white">
            
         
              <br>
                <br>
            
            <h4 class="text-primary"> {{$report->incident_name ?? 'Report Name'}}</h4>
            
            <br>
              <br>

        
<div class="mb-2"><i class="bi bi-calendar2-week"></i> {{$report->incident_date}} </div>
<div class="mb-2"><i class="bi bi-clock"></i> {{$report->incident_time}} </div>
<div class="mb-2"><i class="bi bi-geo-alt-fill"></i> {{$report->incident_location}} </div>

            
                <br>
                <br>
                
    <h5 class="text-primary">Report Created By</h5>
    
    
       

              

@php
    $creatorUser = App\Models\User::find($report->incident_creartoid);
       $membersInvolved = json_decode($report->members_involved, true);
    $involvedMembers = is_array($membersInvolved) ? implode(', ', $membersInvolved) : $membersInvolved;
@endphp

<div class="mb-2">
    # {{ optional($creatorUser)->id ?? 'Not Exist' }}
</div>

<div class="mb-2">
    Name: {{ optional($creatorUser)->username ?? 'Not Exist' }}
</div>

@if(optional($creatorUser)->role == '0')
    <div class="mb-2"> Role: Primary Admin</div>
@elseif(optional($creatorUser)->role == '1')
    <div class="mb-2"> Role: Secondary Admin</div>
@else
    <div class="mb-2"> Role: Partner</div>
@endif



<div class="mb-2">Report Created On : {{$report->created_at}} </div>
<div class="mb-2">Last Modified On : {{$report->updated_at}} </div>

                <br>
        
            <center>
            <p class="btn btn-primary btn-lg" >{{ $report->incident_nature ?? 'No Status' }}</p>
            
               </center>
               
               
             
                <br>
            
        </div>
       </div>
        
        
        
        
        
         <div class="col-lg-8 order-0 order-lg-1 p-2" style="height:100% ">
             
         <div class="card-body col-12">
            <div class="row">
           <div class="col-sm-6" style=" background-color:white">
               
               <h5 class="text-primary"> Report Details</h5>
               
       <p>{{$report->description ?? ' Lorem ipsum is a pseudo-Latin text used in web design, typography, layout, and printing in place of English to emphasise design....' }}</p>

         </div>   
          <div class="col-sm-6">
              
              <div class="card-body m-1  col-12 w-100" style="background-color:white">
                   <h5 class="text-primary">Involved Parties</h5>
                   

{{ $involvedMembers ??  '---'}}
                  
               </div>    
               
                 <div class="card-body m-1 col-12 w-100" style=" background-color:white">
                      <h5 class="text-primary"> Category</h5>
                      <p>{{$report->incident_category ?? '---' }}</p>
                 </div>    
        
        
         </div> 
       </div>
       
        </div>
             
             <div class="card-body " style=" background-color:white" > 
             <br>
             
              <h5 class="text-primary">Attachments</h5>
        
              <div style="max-width: 100%; max-height: 400px; overflow: hidden;">
               @if($report->attachment)
    @php
        $extension = pathinfo($report->attachment, PATHINFO_EXTENSION);
    @endphp

    @if(in_array($extension, ['jpg', 'jpeg', 'png', 'gif']))
        <!-- Display image -->
       <img src="{{ asset('/public/uploads/' . ($report->attachment ?? '')) }}" alt="No Image" style="width: 100%; height: auto;">
    @else
        <!-- Provide a download link for non-image files -->
        <a href="{{ asset('/public/uploads/' . ($report->attachment ?? '')) }}"download>Download {{$report->attachment ?? ''}}</a>
    @endif
@endif
                
   
</div>


       </div>  
     </div>  
    
    
    
    </div> 
    </div>


    
    
      @if(isset($prevoius_data) && Auth::user()->role == '0' )
                   
                   
                   <div class="">
    <table class="table table-bordered" style="width: max-content;" id="reportTable">
        <h5 class="text-primary">Recent Modifications</h5>
        <thead>
            <tr>
                <th scope="col" style="width: 150px;">Creator ID</th>
                  <th scope="col" style="width: 250px;">Name</th>
                <th scope="col" style="width: 250px;">Category</th>
                <th scope="col" style="width: 250px;">Location</th>
                <th scope="col" style="width: 250px;">Status</th>
                <th scope="col" style="width: 250px;">Time</th>
                <th scope="col" style="width: 250px;">Date</th>
                <th scope="col" style="width: 250px;">Members</th>
                <th scope="col" style="width: 700px;">Description</th>
                <th scope="col" style="width: 250px;">Created At</th>
            </tr>
        </thead>
        <tbody>
            @foreach($prevoius_data as $prevoius)
            @php $decodedData = json_decode($prevoius->detail, true) @endphp
            <tr>
                <th>{{ $prevoius->user_id ?? '---' }}</th>
                  <th>{{ $decodedData['incident_name'] ?? '---' }}</th>
                <td>{{ $decodedData['incident_category'] ?? '---' }}</td>
                <td>{{ $decodedData['incident_location'] ?? '---' }}</td>
                <td>{{ $decodedData['incident_nature'] ?? '---' }}</td>
                <td>{{ $decodedData['incident_time'] ?? '---' }}</td>
                <td>{{ $decodedData['incident_date'] ?? '---' }}</td>
                <td>
                    @php
                        $membersInvolved = json_decode($decodedData['members_involved'] ?? '[]', true);

                        if (is_array($membersInvolved)) {
                            $formattedMembers = implode(', ', $membersInvolved);
                        } else {
                            $formattedMembers = $decodedData['members_involved'] ?? '---';
                        }
                    @endphp
                    {{ $formattedMembers }}
                </td>
           <td>{{ $decodedData['description'] ?? '---' }}</td>
                <td>{{ $decodedData['created_at'] ?? '---' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

                    
                      @endif
    
    
    
    

    
<br><br><br>
</main>

    
<br><br><br>
@endsection
