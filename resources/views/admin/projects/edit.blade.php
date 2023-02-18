@extends('layouts.app')

<h1 class="text-center text-info py-5">Edit</h1>

@section('content')
<div class="container">
  <h2>modifica</h2>
  
  <form action="{{route('admin.projects.update',$project->id)}}" method="POST" enctype="multipart/form-data">
    @csrf()
    @method('PUT')

    @if ($errors->any())
      <div class="alert alert-danger">
        <ul>
          @foreach($errors->all() as $error)
            <li>{{$error}}</li>       
          @endforeach
        </ul>
      </div>
      @endif

    <div class="mb-3">
      <label class="form-label">Name</label>
      <input type="text" class="form-control" name="name" value="{{$project->name}}" >
    </div>

    <div class="mb-3">
      <label class="form-label">Description</label>
      <textarea name="description" cols="30" rows="5" class="form-control">{{$project->description}}</textarea>
    </div>

    <div class="mb-3">
      <label class="form-label">Cover image</label>
      <input type="file" class="form-control" name="cover_img">
    </div>
    

    <div class="mb-3">
      <label class="form-label">Github link</label>
      <input type="text" class="form-control" name="github_link" value="{{$project->github_link}}" >
    </div>

    <select name="type_id" class="form-select mb-4">
      @foreach ($type as $type)
      <option value="{{ $type->id }}">{{ $type->type }}</option>
      @endforeach
    </select>

    <div class="">Technologies</div>
      
       @foreach ($technologies as $technology)
       <div class="form-check form-check-inline @error('technology_id') is-invalid @enderror">
        {{-- Il name dell'input ha come suffisso le quadre [] che indicheranno al server,
              di creare un array con i vari tag che stiamo inviando --}}
        <input class="form-check-input @error('technology_id') is-invalid @enderror" type="checkbox"
          id="technologiesCheckbox_{{ $loop->index }}" value="{{ $technology->id or null}}" name="technology_id[]"
          {{ in_array( $technology->id, old('technology_id', [])) ? 'checked' : '' }}
          >
        <label class="form-check-label" for="technologiesCheckbox_{{ $loop->index }}">{{ $technology->technology }}</label>
      </div>
       @endforeach

    
    

    <a href="{{ route('admin.projects.index') }}" class="btn btn-secondary">Annulla</a>
    <button class="btn btn-primary">Save</button>
  </form>

</div>

@endsection