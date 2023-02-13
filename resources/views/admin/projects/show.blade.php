@extends('layouts.app')

@section('content')
<div class="container">
  <h1>project id:{{$project->id}}</h1>

  <div class="card margin-auto">
    {{-- Se cover_img esiste, mostra un tag img, altrimenti nulla --}}
    @if ($project->cover_img)

      <img src="{{ asset('/storage/' . $project->cover_img) }}" alt="" class="card-img-top" style="">
    @endif

    <div class="card-body">
      <div class="card-title"><strong>Name:</strong>{{ $project->name }}</div>
      <p class="card-text"><strong>Description:</strong>{{ $project->description }}</p>
      <p class="card-text"><strong>link git:</strong>{{ $project->github_link }}</p>
      <a class="btn btn-info my-3" href="{{ route('admin.projects.index')}}">torna alla pagina dei progetti</a>
    </div>

    
  </div>

</div>

@endsection