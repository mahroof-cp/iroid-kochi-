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

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#datatable').DataTable({
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
                { data: 'company', name: 'company'},
                { data: 'mobile_number', name: 'mobile_number'},
                { data: 'image', name: 'image', orderable: false, searchable: false},
                { data: 'join_date', name: 'join_date'},
                { data: 'created_by', name: 'created_by', orderable: false, searchable: true }, 
                { data: 'updated_by', name: 'updated_by', orderable: false, searchable: true }, 
                { data: 'created_at', name: 'created_at'},
                { data: 'updated_at', name: 'updated_at'},
                { data: 'action', name: 'action', orderable: false, searchable: false },
            ],
            "order": [[0, "desc"]]
        });
    });
</script>
</body>
</html>
