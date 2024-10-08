<!DOCTYPE html>
<html>
<head>
    <title>{{ empty($student->id) ? 'Submit Student' : 'Update Student' }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap.min.css">
</head>
<body>

<div class="container">
    <h2>{{ empty($student->id) ? 'Submit Student' : 'Update Student' }}</h2>
    <form action="{{ route('students.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id" value="{{ empty($student->id) ? 0 : $student->id }}">

        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $student->name) }}">
            @error('name')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $student->email) }}">
            @error('email')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="phone">Phone:</label>
            <input type="text" class="form-control" id="phone" name="phone" maxlength="10" value="{{ old('phone', $student->phone) }}">
            @error('phone')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Reusable avatar component -->
        @if(!empty($student->avatar))
        <x-avatar :avatar="$student->avatar" />
        @endif

        <div class="form-group">
            <label for="avatar">New Avatar:</label>
            <input type="file" class="form-control-file" id="avatar" name="avatar">
            @error('avatar')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <a type="button" href="{{ route('students.list') }}" class="btn btn-success">Back</a>
        <button type="submit" class="btn btn-primary">{{ empty($student->id) ? 'Submit' : 'Update' }}</button>
    </form>
</div>
</body>
</html>
