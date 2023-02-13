@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="my-3">Lists Project</h1>

        <a class="btn btn-primary rounded-5 my-3" href="{{ route('admin.projects.create') }}">Crea un nuovo progetto</a>
        <table class="table">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Image</th>
                    <th>Github_link</th>
                </tr>
            </thead>
            <tbody>
                
                @foreach ($projects as $project)
                    <tr>
                        <td>{{ $project->id }}</td>
                        <td>{{ $project->name }}</td>
                        <td>{{ $project->description }}</td>
                        <td><img src="{{ asset('/storage/' . $project->cover_img) }}" alt="" style="width:90px; object-fit:cover">
                        </td>
                        <td>{{ $project->github_link }}</td>

                        <td>
                            <div class="d-flex gap-2 ">
                                <a href="{{ route('admin.projects.edit', $project->id) }}" class="btn rounded-5 btn-primary">Edit</a>
                                <a href="{{ route('admin.projects.show', $project->id) }}" class="btn rounded-5 btn-info">dettagli</a>
                                <form action="{{ route('admin.projects.destroy', $project->id) }}" method="POST">
                                    @csrf()
                                    @method('delete')
                                    <button class="btn rounded-5 btn-danger">Delete</button>
                                </form>
                            </div>

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>




    </div>
@endsection
