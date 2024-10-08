<!DOCTYPE html>
<html>
<head>
    <title>{{ empty($company->id) ? 'Submit Company' : 'Update Company' }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap.min.css">
</head>
<body>

<div class="container">
    <h2>{{ empty($company->id) ? 'Submit Company' : 'Update Company' }}</h2>
    <form action="{{ route('company.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id" value="{{ empty($company->id) ? 0 : $company->id }}">

        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" id="name" name="name"  value="{{ old('name', $company->name) }}">
            @error('name')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="description">Description:</label>
            <textarea class="form-control" id="description" name="description">{{ old('description', $company->description) }}</textarea>
            @error('description')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        @if(isset($company->logo))
            <x-logo :logo="$company->logo" />
        @endif

        <div class="form-group">
            <label for="logo">New logo:</label>
            <input type="file" class="form-control-file" id="logo" name="logo">
            @error('logo')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>


        <div class="form-group">
            <label for="contact_number">Contact Number:</label>
            <input type="text" class="form-control" id="contact_number" name="contact_number" maxlength="10" value="{{ old('contact_number', $company->contact_number) }}">
            @error('contact_number')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="annual_turnover">Annual Turnover:</label>
            <input type="number" class="form-control" id="annual_turnover" name="annual_turnover" value="{{ old('annual_turnover', $company->annual_turnover) }}">
            @error('annual_turnover')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <a type="button" href="{{ route('company.list') }}" class="btn btn-success">Back</a>
        <button type="submit" class="btn btn-primary">{{ empty($company->id) ? 'Submit' : 'Update' }}</button>
    </form>
</div>
</body>
</html>
