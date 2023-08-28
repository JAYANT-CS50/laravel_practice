@extends('layouts.app')

@section('title', 'Home')


@section('content')

<div class="mt-5">
  <div>
    @if(isset($filename) || isset($post))
        <img src="{{isset($post) ? asset('storage/uploads/' . $post->image) : asset('storage/uploads/' . $filename)}}" alt="Uploaded Image" style=" max-width: 20%;
        max-height: 20%;">
    @endif
  </div> 
  <form method="POST" action="{{route('upload')}}" enctype="multipart/form-data">
    @csrf
    <input type="file" name="file" required>
    <input type="hidden" name="upload_id" value="{{isset($post) ? $post->id: ""}}">
    <button type="submit" class="btn btn-dark">Upload</button> 

  </form> 

</div>



<form class="row g-3 mt-5" method="POST" action="{{ isset($post) ? route('update', ['id' => $post->id]) : route('store') }}">
  @csrf
  @if(isset($post))
  
    @method('PUT')
  
  @endif
  {{-- {{ isset($post) ?  $filename : old('image') }} --}}
  <div class="col-md-6">
    
    {{ Form::hidden('image', isset($post) ?  $post->image : $filename, ["class"=>"form-control" ] )  }}
    <label for="name" class="form-label">Name</label>

    {{ Form::text('name', isset($post) ?  $post->name : '', ["class"=>"form-control" ] )  }}
  </div>
  <div class="col-md-6">
    <label for="mobile" class="form-label">Mobile No</label>
    {{ Form::text('mobile', isset($post) ?  $post->mobile : '', ["class"=>"form-control"] )  }}
  </div>
  <div class="col-md-6">
    <label for="inputEmail4" class="form-label">Email</label>
    {{ Form::email('email', isset($post) ?  $post->email : '', ["class"=>"form-control"] )}}
  </div>
  <div class="col-md-6">
    <label for="inputPassword4" class="form-label">Password</label>
    {{ Form::text('password', isset($post) ?  $post->password : '', ["class"=>"form-control"] )}}
  </div>
  <div class="col-12">
    <label for="inputAddress" class="form-label">Address</label>
    {{ Form::text('address', isset($post) ?  $post->address : '', ["class"=>"form-control"] )}}
  </div>

  <div class="col-md-4">
    <label for="inputState" class="form-label">State</label><br>
    {{-- <select name="state" class="form-select">
        <option value="">Choose...</option>
        @foreach($states as $state)
            <option value="{{ $state->id }}"
                {{ (isset($post) && $post->state == $state->id) || old('state') == $state->id ? 'selected' : '' }}>
                {{ $state->name }}
            </option>
        @endforeach
    </select> --}}
    {{Form::select('state',[""=> "Select"] + $states, isset($post) ? $post->state : '',  ["class"=>"form-select", "required"=>"true"])}}
</div>


  <div class="col-md-4">
    <label for="inputState" class="form-label">City</label>
    {{Form::select('city',[""=> "Select"] + $cities, isset($post) ? $post->city : '',  ["class"=>"form-select", "required"=>"true"])}}

  </div>
  <div class="col-md-2">
    <label for="inputZip" class="form-label">Zip</label>
    <input type="text" class="form-control" name="zip" value="{{ isset($post) ?  $post->zip : old('zip') }}">
  </div>
  <?php
 
  if(isset($post)){
    $LangArray = explode(", ", $post->language); 
  } else {
    $LangArray = [];
  }
  ?>
  @foreach($languages as $language)
  <div class="col-12">
      <div class="form-check">   
        
          <input class="form-check-input" type="checkbox" name="languages[]" value="{{ $language}}" 
          {{  in_array($language, $LangArray) ? 'checked' : ''}}>
          <label class="form-check-label" for="{{ $language }}">{{ $language }}</label>
      </div>
  </div>
  @endforeach
  
  
  <div class="col-12">
    <button type="submit" class="btn btn-primary">{{ isset($post) ? 'Update':'Sign In'  }}</button>
  </div>  
</form>
<div class="mt-4">
  @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

</div>

    
@endsection
