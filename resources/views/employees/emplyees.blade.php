@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Add New Employee</h2>
    <form action="{{ route('employees.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <!-- Form fields here -->
        <div class="form-group">
            <label for="first_name">First Name</label>
            <input type="text" name="first_name" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="last_name">Last Name</label>
            <input type="text" name="last_name" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="country_code">Country Code</label>
            <select name="country_code" class="form-control">
                <option value="+1">+1</option>
                <option value="+91">+91</option>
                <!-- More country codes -->
            </select>
        </div>

        <div class="form-group">
            <label for="mobile">Mobile</label>
            <input type="number" name="mobile" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="address">Address</label>
            <textarea name="address" class="form-control" required></textarea>
        </div>

        <div class="form-group">
            <label>Gender</label>
            <div>
                <input type="radio" name="gender" value="Male"> Male
                <input type="radio" name="gender" value="Female"> Female
                <input type="radio" name="gender" value="Other"> Other
            </div>
        </div>

        <div class="form-group">
            <label for="hobby">Hobby</label>
            <input type="checkbox" name="hobby" value="Reading"> Reading
            <input type="checkbox" name="hobby" value="Sports"> Sports
            <!-- Other hobbies -->
        </div>

        <div class="form-group">
            <label for="photo">Photo</label>
            <input type="file" name="photo" class="form-control-file">
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
@endsection
