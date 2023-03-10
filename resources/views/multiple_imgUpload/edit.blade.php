@extends('multiple_imgUpload.app')
@section('title','Edit From')
@section('content')
@push('style')
<style>
  .imgRemove {}
</style>
@endpush
<div class="container">
  <div class="card mt-4">
    @include('multiple_imgUpload.alert')
    <div class="card-header text-center text-warning">
      <h3>Edit Form</h3>
    </div>
    <div class="card-body">
      <form action="{{route('img.imageUpdate')}}" method="post" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id" value="{{$imageEdit->id}}">
        <div class="form-group">
          <label for="">Name:</label>
          <input type="text" name="img_name" id="" value="{{$imageEdit->img_name}}" class="form-control" placeholder="" aria-describedby="helpId">
        </div>

        <div class="form-group">
          <label for="">Image</label>
          <input type="file" name="images[]" id="image" class="form-control" placeholder="" multiple>
          @php
          $data = json_decode($imageEdit->images);
          @endphp
          @foreach ($data as $key=>$val)
          <div id="img{{$key}}" style="display: inline-flex;">
            <img src="{{asset('Images/')}}/{{$val}}" alt="{{$val}}" width="50" height="50">
            <a href="javascript:void(0)" class="text-danger imgRemove" data-key="{{$key}}" data-id="{{$imageEdit->id}}" data-name="{{$val}}"><i class="fa fa-times"></i></a>
          </div>
          @endforeach

        </div>
        <button type="submit" class="btn btn-primary btn btn-sm">Update</button>
      </form>
    </div>
  </div>
</div>

@endsection

@push('script')
<script>
  $(document).ready(function() {
    $('.imgRemove').on('click', function() {
      let cmr = confirm('Are you sure delete this image.');
      if (cmr) {
        let id = $(this).data('id')
        let imagename = $(this).data('name')
        let key = $(this).data('key')
        $.ajax({
          type: "post",
          url: "{{route('img.updateTimeDeleteImg')}}",
          data: {
            'id': id,
            'imagename': imagename
          },
          success: function(response) {
            if (response.msg === 'success') {
              console.log(`#img${key}`)
              $(`#img${key}`).remove();
            }
          }
        });
      }
    })
  });
</script>
@endpush