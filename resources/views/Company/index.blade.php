<!DOCTYPE html>
<html>
<head>
    <title>Companies Details</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css">
</head>
<body>

<div class="container">
<h1>Company Details</h1>

    <!-- Error Alert -->
    <div class="alert alert-danger d-none" id="errorAlert">
        <span id="errorMessage"></span>
    </div>

    <div class="row mt-3 mb-3">
        <div class="col">
            <a class="btn btn-danger " href="{{ route('logout') }}"> Logout </a>
            <a class="btn btn-success" href="{{ route('company.createUpdate') }}"> Create Company </a>
            <a class="btn btn-dark" href="{{ route('employee.list') }}"> Employee Details </a>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <table id="datatable" class="table table-bordered">
                <thead>
                <tr>
                    <th>SL No.</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>logo</th>
                    <th>Contact Number</th>
                    <th>Annual Turnover</th>
                    <th>Created By</th>
                    <th>Updated By</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this company?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDelete">Delete</button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script type="text/javascript">
 $(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var table = $('#datatable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('company.list') }}",
            type: 'GET',
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'name', name: 'name' },
            { data: 'description', name: 'description' },
            { data: 'logo', name: 'logo', orderable: false, searchable: false },
            { data: 'contact_number', name: 'contact_number' },
            { data: 'annual_turnover', name: 'annual_turnover' },
            { data: 'created_by', name: 'created_by', orderable: false, searchable: true },
            { data: 'updated_by', name: 'updated_by', orderable: false, searchable: true },
            { data: 'created_at', name: 'created_at' },
            { data: 'updated_at', name: 'updated_at' },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ],
        "order": [[0, "desc"]]
    });

    // Handle delete 
    var companyId; 
    $('body').on('click', '.deleteCompany', function() {
        companyId = $(this).data('id'); 
        $('#deleteModal').modal('show');
    });

    $('#confirmDelete').click(function() {
        $.ajax({
            type: "DELETE",
            url: "/company/delete/" + companyId, 
            success: function(response) {
                $('#deleteModal').modal('hide');
                table.ajax.reload();
            },
            error: function(response) {
                $('#deleteModal').modal('hide');
                $('#errorMessage').text(response.responseJSON.error);  
                $('#errorAlert').removeClass('d-none'); 
            }
        });
    });
});

</script>
