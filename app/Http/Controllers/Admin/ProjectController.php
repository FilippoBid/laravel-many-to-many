<?php

namespace App\Http\Controllers\Admin;



use App\Models\Admin\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\Technology;
use App\Models\Admin\Type;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use PhpParser\Node\Stmt\If_;

use function PHPUnit\Framework\isNull;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::all();

        $types = Type::all();
        $technologies = Technology::all();


        return view("admin.projects.index", [
            "projects" => $projects,
            "types" => $types,
            "technologies" => $technologies
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $types = Type::all();
        $technologies = Technology::all();

        return view("admin.projects.create", compact("types", "technologies"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            "name" => "required|string|max:20",
            "description" => "required|string",
            "cover_img" => "file",
            "github_link" => "string",
            "type_id" => "nullable|exists:types,id",
            "technology_id" => "array|nullable|exists:technologies,id"
        ]);


        if (key_exists("cover_img", $data)) {

            $path = Storage::put("projects", $data["cover_img"]);
        }

        $project = Project::create([
            ...$data,
            //a bd vado a salvare solamente il percorso 
            "cover_img" => $path ?? '',
            // recuperiamo l'id dagli user cioé user_id é uguale all'utente loggato
            "user_id" => Auth::id()
        ]);
        /*  dd($data); */
        /* prende i dati e vede se esistono quei valori nella tabella technlologies  */
        /* la funzione technologie è quella del model technology */
        if ($request->has("technology_id")) {
            /* oppure posso usare */
            // if (key_exists("tags", $data)) {
            $project->technologies()->attach($data["technology_id"]);
        }
        /* dd($data); */
        return redirect()->route("admin.projects.show", compact("project"));
    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Admin\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $project = Project::findOrFail($id);

       /*  dd($project); */
        return view("admin.projects.show", ["project" => $project]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Admin\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $type = Type::all();
        $technologies = Technology::all();

        $project = Project::findOrFail($id);
        return view("admin.projects.edit", compact("project", "type", "technologies"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Admin\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $project = Project::findOrFail($id);
        $data = $request->validate([
            "name" => "required|string|max:20",
            "description" => "required|string",
            "cover_img" => "file",
            "github_link" => "string",
            "type_id" => "nullable|exists:types,id",
            "technology_id" => "array|nullable|exists:technologies,id"
        ]);
    



        // carico il file SOLO se ne ricevo uno
        if (key_exists("cover_img", $data)) {
            // carico il nuovo file
            // salvo in una variabile temporanea il percorso del nuovo file
            $path = Storage::put("project", $data["cover_img"]);

            // Dopo aver caricato la nuova immagine, PRIMA di aggiornare il db,
            // cancelliamo dallo storage il vecchio file.
            // $post->cover_img // vecchio file
            Storage::delete($project->cover_img);
        }
        $project->update([
            ...$data,
            "user_id" => Auth::id(),
            "cover_img" => $path ?? $project->cover_img,

        ]);
        if(isNull($data["technology_id"])){
            $project->technologies()->detach(); 
        }else{
            
            $project->technologies()->sync($data["technology_id"]);
        }
        

        return redirect()->route("admin.projects.show", compact("id","project"));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Admin\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $project = Project::findOrFail($id);

        if ($project->cover_img) {
            Storage::delete($project->cover_img);
        }
        $project->technologies()->detach();
        $project->delete();
        return redirect()->route("admin.projects.index");
    }
}
