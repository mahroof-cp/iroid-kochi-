<!DOCTYPE html>
<html>
<head>
    <title>Employee Details</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css">
</head>
<body>

<div class="container">
    <h1>Employee Details</h1>

    <!-- Error Alert -->
    <div class="alert alert-danger d-none" id="errorAlert">
        <span id="errorMessage"></span>
    </div>

    <div class="row mt-3 mb-3">
        <div class="col">
            <a class="btn btn-success" href="{{ route('employee.createUpdate') }}"> Create Employee </a>
            <a class="btn btn-dark" href="{{ route('company.list') }}"> Company Details </a>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <table id="datatable" class="table table-bordered">
                <thead>
                <tr>
                    <th>SL No.</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Company</th>
                    <th>Mobile Number</th>
                    <th>Image</th>
                    <th>Join Date</th>
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
                Are you sure you want to delete this employee?
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

        // Initialize DataTable
        var table = $('#datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('employee.list') }}",
                type: 'GET',
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                { data: 'name', name: 'name' },
                { data: 'email', name: 'email' },
                { data: 'company', name: 'company' },
                { data: 'mobile_number', name: 'mobile_number' },
                { data: 'image', name: 'image', orderable: false, searchable: false },
                { data: 'join_date', name: 'join_date' },
                { data: 'created_by', name: 'created_by', orderable: false, searchable: true },
                { data: 'updated_by', name: 'updated_by', orderable: false, searchable: true },
                { data: 'created_at', name: 'created_at' },
                { data: 'updated_at', name: 'updated_at' },
                { data: 'action', name: 'action', orderable: false, searchable: false },
            ],
            "order": [[0, "desc"]]
        });

        // Handle delete
        var employeeId; 
        $('body').on('click', '.deleteEmployee', function() {
            employeeId = $(this).data('id'); 
            $('#deleteModal').modal('show'); 
        });

        $('#confirmDelete').click(function() {
            $.ajax({
                type: "DELETE",
                url: "/employee/delete/" + employeeId,  
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
