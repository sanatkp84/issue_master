@extends('layout.master')
@section('content')
<main id="main" class="main">
    <div class="col-12 m-3 mb-5">
        <a href="{{ route('create-report') }}" class="btn btn-warning" type="button">Create new report</a>
    </div>


<div class="input-group mb-3 col-lg-6 col-sm-6" style="max-width:500px">
  <input type="text" class="form-control styled-input" id="searchInput" placeholder="Search Reports here..." aria-label="Default" aria-describedby="inputGroup-sizing-default">
   <div class="input-group-prepend">
    <span class="input-group-text" id="inputGroup-sizing-default">  <i class="bi bi-search search-icon"></i> </span>
  </div>
</div>
    


    @php
    function getBadgeClass($incidentNature) {
        switch ($incidentNature) {
            case 'Low':
                return 'bg-info';
            case 'Medium':
                return 'bg-secondary';
            case 'High':
                return 'bg-warning';
            case 'Urgent':
                return 'bg-danger';
            default:
                return 'bg-primary';
        }
    }
@endphp


    <div class="col-12">
        <div class="card recent-sales overflow-auto">
            
            
            
            <div class="card-body">
                <h5 class="card-title">All Reports <span></span></h5>

                @if(isset($reports) && count($reports) > 0)
                    <table class="table table-borderless" id="reportTable">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                 <th scope="col">Status</th>
                                 
                                <th scope="col"> </th>
                                <th scope="col">Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        
                        
  


                        <tbody>

                            
                            @foreach($reports as $report)
                                <tr>
                                    <th scope="row">{{ $report->id ?? '---' }}</th>
                                    <td><a href="single_report/{{$report->id ?? ''}}">{{ $report->incident_name ?? '---' }}</a> </td>
                                       <td class="badge {{ getBadgeClass($report->incident_nature) }}" >{{ $report->incident_nature ?? '---' }}</td>
                                    <td> </td>
                                 
                                    <td><span >{{ $report->incident_date ?? '---' }}</span></td>
                                    <td>
                                        <div class="dropdown dropend">
                                            <div class="dropdown-toggle-custom btn border-0" role="button"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="bi bi-three-dots-vertical"></i>
                                            </div>
                                            <ul class="dropdown-menu" aria-labelledby="actionsDropdown">
                                                <li>                                              
                                                   
                                                    <a class="dropdown-item" href="{{ url('reports/edit-report/' . $report->id) }}">Edit</a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item delete-report" data-report-id="{{ $report->id }}"
                                                        href="#">Delete</a>
                                                </li>
                                                <!-- Add more actions as needed -->
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            
                            
                            
                        </tbody>
                    </table>
                    
                      {{ $reports->links('pagination::bootstrap-5') }}
                      
                    @else
                    <hr class="mt-4">
                      <center class="mt-5 mb-5"><h3 class="mt-5 mb-5">No Record's Were Found</h3></center>
                      @endif

            </div>

</div>


<br>
<!-- Deleted Records to Show to Admin-->
<br>

  <div class="card recent-sales overflow-auto">





@if(Auth::user()->role == '0')



   <div class="card-body mt-5">
                <h5 class="card-title">Trash Reports <span></span></h5>

                @if(isset($del_reports) && count($del_reports) > 0)
                    <table class="table table-borderless" id="reportTable">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                 <th scope="col"></th>
                                <th scope="col"> </th>
                                <th scope="col">Undo</th>
                                <th scope="col">Delete</th>                               
                            </tr>
                        </thead>

                        <tbody>

                            
                            @foreach($del_reports as $report)
                                <tr>
                                    <th scope="row">{{ $report->id ?? '---' }}</th>
                                    <td><a href="single_report/{{$report->id ?? ''}}">{{ $report->incident_name ?? '---' }}</a> </td>
                                       <td></td>
                                        <td> </td>  
 

                                     <td> <a class="dropdown-item"  href="{{ url('reports/report-undo-delete/' . $report->id) }}"><i class="bi bi-arrow-counterclockwise"></i></a>  </td>
                                       <td> <a class="dropdown-item delete-report-permanent" data-deletereport-id="{{ $report->id }}" href="#"><i class="bi bi-trash-fill"></i></a>  </td>
                                    
                                </tr>
                            @endforeach
                            
                            
                            
                        </tbody>
                    </table>
                    
                      {{ $del_reports->links('pagination::bootstrap-5') }}
                      
                    @else
                    <hr class="mt-4">
                      <center class="mt-5 mb-5"><h3 class="mt-5 mb-5">No Record's Were Found</h3></center>
                      @endif

            </div>





@endif






        </div>

        <!-- Modal -->
        <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="deleteModalLabel">Delete Confirmation</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to Permanent delete this report?</p>
                         
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-danger" id="confirmDelete">Delete</button>
                    </div>
                </div>
            </div>
        </div>
        
        
        
        
        
              <!-- Permanent Delete Modal -->
        <div class="modal fade" id="confirmPermanentDelet" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="deleteModalLab">Delete Confirmation</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to Permanent delete this report?</p>
                          <small>This action can't be Undo</small>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-danger" id="confirmPermanent">Delete</button>
                    </div>
                </div>
            </div>
        </div>



    </div>
</main>



<script>
    function confirmDelete(reportId) {
        // Update the modal content or show a custom message
        $('#deleteModalLabel').text('Confirm Deletion');
        $('.modal-body').html('<p>Are you sure you want to delete this report?</p>');

        // Show the modal
        $('#deleteModal').modal('show');

        // Handle delete button click inside the modal
        $('#confirmDelete').off('click').on('click', function () {
            $.ajax({
                url: '{{ route("delete-report", ["id" => ":reportId"]) }}'.replace(':reportId', reportId),
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    // Handle success (you can update the UI, e.g., remove the row)
                    console.log(response);
                    $('#deleteModal').modal('hide');
                    location.reload();  // Corrected typo here
                },
                error: function (error) {
                    // Handle error
                    console.error(error);
                    $('#deleteModal').modal('hide');
                }
            });
        });
    }

    $(document).ready(function () {
       
        $('.delete-report').click(function (e) {
            e.preventDefault();
            var reportId = $(this).data('report-id');
            confirmDelete(reportId);
        });
    });
</script>





<script>

$(document).ready(function () {
    function confirmPermanentDelete(reportId) {
       
     
        // Show the modal
        $('#confirmPermanentDelet').modal('show');

        // Handle delete button click inside the modal
        $('#confirmPermanent').click(function () {
            $.ajax({
                url: '{{ route("delete-report-permanent", ["id" => ":reportId"]) }}'.replace(':reportId', reportId),
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    // Handle success (you can update the UI, e.g., remove the row)
                    console.log(response);
                    $('#confirmPermanentDelet').modal('hide');
                    location.reload();  // Corrected typo here
                },
                error: function (error) {
                    // Handle error
                    console.error(error);
                    $('#confirmPermanentDelet').modal('hide');
                }
            });
        });
    }

    // Handle delete link click
    $('.delete-report-permanent').click(function (e) {
        e.preventDefault();
        var reportId = $(this).data('deletereport-id');
        confirmPermanentDelete(reportId);
    });
});

</script>






<script>
    $(document).ready(function () {
        // Reference to the input element
        var $searchInput = $('#searchInput');

        // Reference to the table
        var $reportTable = $('#reportTable');

        // Reference to all rows in the table
        var $rows = $reportTable.find('tr');

        // Event listener for input changes
        $searchInput.on('input', function () {
            var searchTerm = $(this).val().toLowerCase();

            // Filter rows based on the search term
            $rows.show().filter(function () {
                return $(this).text().toLowerCase().indexOf(searchTerm) === -1;
            }).hide();
        });
    });
</script>



@endsection


