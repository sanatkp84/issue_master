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
   
     <!-- Vertical Form -->
     <form class="row g-3" method="POST" enctype="multipart/form-data" action="/category_post">
        @csrf
    
    <div>
       
       <h3>Create New Category</h3>
     
      
    </div>
    

    <input type="hidden"  name="id" value="{{$single_category->id ?? ''}}" >
              <div class="col-12">
                <label for="inputNanme4" class="form-label">Name</label>
                <input type="text" name="name" value="{{$single_category->category_name ?? ''}}" class="form-control" placeholder="Category..." id="inputNanme4">
              </div>
   
         <button class="btn btn-warning" type="submit" style="max-width:200px">Submit</button>
      
                  </form><!-- Vertical Form -->


        </div>
        
        
        
        
  
          <div class="card mt-5">
            <div class="card-body">
              <h5 class="card-title">All Categories</h5>


              @if(isset($data) && count($data) > 0)
                    <table class="table table-borderless" id="reportTable">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Name</th>
                                <td> </td>
                                <td>Creator ID</td>
                                <th scope="col">Edit</th>
                                <th scope="col">Delete</th>
                         
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $data)
                                <tr>
                                    <th scope="badge bg-success "><a href="#">{{ $data->id ?? '---' }}</a></th>
                                    <td>{{ $data->category_name ?? '---'}} </td>
                                    <td> </td>
                                    <td>{{ $data->category_creator_id ?? '---' }} </td>
                                    <td>  <a class="" href="/edit_category/{{$data->id ?? ''}}"><i class="bi bi-pencil-square"></i></a></td>
                                    <td>  <a class="delete-user" data-report-id="{{ $data->id }}" href="#"><i class="bi bi-trash-fill"></i></a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                   <hr class="mt-4">
                    <center class="mt-5 mb-5"><h3 class="mt-5 mb-5">No Record's Were Found</h3></center>

                @endif

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



<script>
    $(document).ready(function () {
        function confirmDelete(url, reportId) {
            $('#deleteUser').modal('show');

            // Handle delete button click inside the modal
            $('#confirmDelete').click(function () {
                $.ajax({
                    url: '/category/' + url + '/' + reportId,
                    type: 'post',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        // Handle success (you can update the UI, e.g., remove the row)
                        console.log(response);
                        $('#deleteUser').modal('hide');
                        
                        // Corrected the modal ID
                        location.reload();
                    },
                    error: function (error) {
                        // Handle error
                        console.error(error);
                        $('#deleteUser').modal('hide'); // Corrected the modal ID
                    }
                });
            });
        }

        // Handle delete link click
        $('.delete-user').click(function (e) {
            e.preventDefault();

            $('#deleteModalLabel').text('Confirm Deletion');
            $('.modal-body').html('<p>Are you sure you want to delete this Category?</p>');

            var reportId = $(this).data('report-id');
            var url = 'delete_category';
            confirmDelete(url, reportId);
        });


 

    });
</script>
</main>

 @endsection