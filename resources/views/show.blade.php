@extends('layouts.app')

@section('title', 'Home')


@section('content')
<div class="mt-4">
<table class="table table-hover">
  <thead>
    <tr>
      <th scope="col">S No.</th>
      <th scope="col">Image</th>
      <th scope="col">Name</th>
      <th scope="col">Mobile</th>
      <th scope="col">City</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
    <?php $x = 0 ?>
      
      @foreach($posts as $post)
      <tr>
        <?php $x++ ?>
        <th scope="row"><?php echo $x ?></th>
        <td style="width: 30px;"><img src="{{asset('storage/uploads/' . $post->image)}}" alt="Uploaded Image" style="width: 80px;"></td>
        <td>{{ $post->name }}</td>
        <td>{{ $post->mobile }}</td>
        <td>{{ $post->city_name }}</td>
        <td>
          <div class="d-flex flex-row mb-3">
          <a  class="btn btn-outline-warning " href="{{ route('edit', ['id' => $post->id]) }}"> Edit</a>
          <form  action="{{ route('delete', ['id' => $post->id]) }}" method="POST">
          @csrf
          @method('DELETE')
          <button type='submit' class="btn btn-outline-danger mx-2">Delete</button>
          </form>
        </div>
        </td>
      </tr>
      @endforeach
  </tbody>
</table>

</div>


@endsection