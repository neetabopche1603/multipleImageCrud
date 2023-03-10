@extends('multiple_imgUpload.app')
@section('title','Show Images')
@section('content')

<div class="container">
  <div class="card mt-4">
    @include('multiple_imgUpload.alert')
    <div class="card-header text-center text-warning">
      <h3>Show Images</h3>
      <a href="{{route('img.addFormView')}}" class="btn btn-primary float-lg-right"><i class="fa fa-plus-circle"></i> Add</a>
    </div>
    <div class="card-body table-responsive">

      <table class="table">
        <thead>
          <tr>
            <th>Id</th>
            <th>Image</th>
            <th>Image Name</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($images as $key=>$img)
          <tr>
            <td scope="row">{{$key+1}}</td>
            <td>
              @php
              $data = json_decode($img->images);
              @endphp
              @foreach ($data as $val)
              <img src="{{asset('Images/')}}/{{$val}}" class="img-fluid" alt="Images" width="50" height="50">
              @endforeach

            </td>
            <td>{{$img->img_name}}</td>
            <td>
              <a href="{{route('img.imageEdit',$img->id)}}" class="btn btn-primary">Edit</a>
              <a href="#" class="btn btn-success">View</a>
              <a href="{{route('img.imageDelete',$img->id)}}" onclick="return confirm('Are sure delete this data')" class="btn btn-danger">Delete</a>
            </td>
          </tr>
          @endforeach

        </tbody>
      </table>
    </div>
  </div>
</div>

@endsection

@push('script')

@endpush