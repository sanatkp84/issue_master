@extends('layout.master')
@section('content')
<main id="main" class="main">

    <div class="col-12 m-3 mb-5">
        <a href="{{ route('create-user') }}" class="btn btn-warning" type="button">Create new user</a>
    </div>

<section class="section dashboard">
  <div class="row">



<div class="input-group mb-3 col-lg-6 col-sm-6" style="max-width:500px">
 
  <input type="text" class="form-control styled-input" id="searchInput" placeholder="Search Employees here..." aria-label="Default" aria-describedby="inputGroup-sizing-default">
   <div class="input-group-prepend">
    <span class="input-group-text" id="inputGroup-sizing-default">  <i class="bi bi-search search-icon"></i> </span>
  </div>
</div>
    



  <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">All Employees</h5>


              @if(isset($users) && count($users) > 0)
                    <table class="table table-borderless" id="reportTable">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Name</th>
                                <td> </td>
                                <td> </td>
                                <th scope="col">Status</th>
                                <th scope="col">Edit</th>
                                <th scope="col">Delete</th>
                         
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <th scope="badge bg-success "><a href="#">{{ $user->id ?? '---' }}</a></th>
                                    <td> <a class="" href="users/user_info/{{$user->id ?? ''}}"> {{ $user->username ?? '---'}}</a></td>
                                    <td> </td>
                                    <td> </td>
                                    <td> <a class="status-user"  data-report-id="{{ $user->id }}" href="#">{{ $user->status ?? '---' }} </a> </td>
                                    <td><a class="" href="users/edit-user/{{$user->id ?? ''}}"><i class="bi bi-pencil-square"></i></a></td>
                                    <td>  <a class="delete-user" data-report-id="{{ $user->id }}" href="#"><i class="bi bi-trash-fill"></i></a></td>
                                </tr>
                            @endforeach
                        </tbody>
                     
                      
                    </table>
                    
                      {{ $users->links('pagination::bootstrap-5') }}
                      
                      
                    @else
                   <hr class="mt-4">
                    <center class="mt-5 mb-5"><h3 class="mt-5 mb-5">No Record's Were Found</h3></center>

                @endif

            </div>


            </div>
        </div>
    </div>
</div>
</section>


     <!-- Modal -->
     <div class="modal fade" id="deleteUser" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="deleteModalLabel">Confirmation</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDelete">Delete</button>
                </div>
            </div>
        </div>
    </div>

</main>

<script>
    $(document).ready(function () {
        function confirmDelete(url, reportId) {
            $('#deleteUser').modal('show');

            // Handle delete button click inside the modal
            $('#confirmDelete').click(function () {
                $.ajax({
                    url: '{{ url("users") }}/' + url + '/' + reportId,
                    type: 'post',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        // Handle success (you can update the UI, e.g., remove the row)
                        console.log(response);
                        $('#deleteUser').modal('hide');
                        location.reload();
                    },
                    error: function (error) {
                        // Handle error
                        console.error(error);
                        $('#deleteUser').modal('hide');
                    }
                });
            });
        }

        // Handle delete link click
        $('.delete-user').click(function (e) {
            e.preventDefault();

            $('#deleteModalLabel').text('Confirm Deletion');
            $('.modal-body').html('<p>Are you sure you want to delete this User?</p>');

            var reportId = $(this).data('report-id');
            var url = 'delete-user';
            confirmDelete(url, reportId);
        });

        // Handle status link click
        $('.status-user').click(function (e) {
            e.preventDefault();

            $('#deleteModalLabel').text('Confirm Status Changing');
            $('#confirmDelete').text('Change');
            $('.modal-body').html('<p>Are you sure you want to change the status of this User?</p>');

            var reportId = $(this).data('report-id');
            var url = 'status-user';
            confirmDelete(url, reportId);
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