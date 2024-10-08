<!DOCTYPE html>
<html>
<head>
    <title>{{ empty($employee->id) ? 'Submit Employee' : 'Update Employee' }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap.min.css">
</head>
<body>

<div class="container">
    <h2>{{ empty($employee->id) ? 'Submit Employee' : 'Update Employee' }}</h2>
    <form action="{{ route('employee.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id" value="{{ empty($employee->id) ? 0 : $employee->id }}">

        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" id="name" name="name"  value="{{ old('name', $employee->name) }}">
            @error('name')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $employee->email) }}">
            @error('email')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="company_id">Select Company:</label>
            <select class="form-control" id="company_id" name="company_id">
                <option value="">-- Select Company --</option>
                @foreach($companies as $company)
                    <option value="{{ $company->id }}" {{ old('company_id', $employee->company_id) == $company->id ? 'selected' : '' }}>
                        {{ $company->name }}
                    </option>
                @endforeach
            </select>
            @error('company_id')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="mobile_number">Contact Number:</label>
            <input type="text" class="form-control" id="mobile_number" name="mobile_number" maxlength="10" value="{{ old('mobile_number', $employee->mobile_number) }}">
            @error('mobile_number')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        @if(isset($employee->image))
            <x-image :image="$employee->image" />
        @endif

        <div class="form-group">
            <label for="image">New image:</label>
            <input type="file" class="form-control-file" id="image" name="image">
            @error('image')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="join_date">Join Date:</label>
            <input type="date" class="form-control" id="join_date" name="join_date" value="{{ old('join_date', $employee->join_date) }}">
            @error('join_date')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <a type="button" href="{{ route('employee.list') }}" class="btn btn-success">Back</a>
        <button type="submit" class="btn btn-primary">{{ empty($employee->id) ? 'Submit' : 'Update' }}</button>
    </form>
</div>
</body>
</html>
