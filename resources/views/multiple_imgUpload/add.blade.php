@extends('multiple_imgUpload.app')
@section('title','Add From')
@section('content')
    
<div class="container">
<div class="card mt-4">
    @include('multiple_imgUpload.alert')
    <div class="card-header text-center text-warning">
        <h3>Add Form</h3>
    </div>
    <div class="card-body">
        <form action="{{route('img.imageStore')}}" method="post" enctype="multipart/form-data">
            @csrf
        <div class="form-group">
          <label for="">Name:</label>
          <input type="text" name="img_name" id="" value="{{old('img_name')}}" class="form-control" placeholder="" aria-describedby="helpId">
          <span class="text-danger">
            @error('img_name')
                {{$message}}
            @enderror
          </span>
        </div>

        <div class="form-group">
          <label for="">Image</label>
          <input type="file" name="images[]" id="image" value="{{old('image[]')}}" class="form-control" placeholder="" multiple>
          <span class="text-danger">
            @error('images')
                {{$message}}
            @enderror
          </span>
        </div>
        <button type="submit" class="btn btn-primary btn btn-sm">Upload</button>
        </form>
    </div>
</div>
</div>

@endsection

@push('script')
    
@endpush