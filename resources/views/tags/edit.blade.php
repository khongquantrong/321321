@extends('layout')

@section('content')
    <form action="{{ route('tags.update', $model) }}" method="post" enctype="multipart/form-data">
        @csrf

        <div class="mb-3 mt-3">
            <label for="name" class="form-label">Name:</label>
            <input type="text" value="{{ $model->name }}"
                   class="form-control" name="name" id="name" placeholder="Enter name" >
        </div>

        <div class="mb-3 mt-3">
            <label for="img">Image:</label>
            <input type="file" class="form-control" id="img" name="img">
            <img src="{{ $model->img }}" width="100px" alt="">
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection
