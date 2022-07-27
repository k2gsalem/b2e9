<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Transformers\V1\ProjectTransformer;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    protected $model;

    public function __construct(Project $model)
    {
        $this->model = $model;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $paginator = $this->model->paginate($request->get('limit', config('app.pagination_limit')));
        if ($request->has('limit')) {
            $paginator->appends('limit', $request->get('limit'));
        }
        return fractal($paginator, new ProjectTransformer())->respond();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $request['user_id'] = $request->user()->id;
        //
        $rules = [
            'manufacturing_unit_id' => ['required', 'integer', 'exists:manufacturing_units,id'],
            // 'title'=>['required'],
            // 'part_name'=>['required'],
            // 'drawing_number'=>['required'],
            // 'delivery_date'=>['required'],
            // 'location_preference'=>['required'],
            // 'raw_material_price'=>['required'],
            // 'description'=>['required'],
            // 'publish_at'=>['required'],
            // 'close_at'=>['required'],
            // 'active'=>['required','boolean'],
            // 'instant_publish'=>['required','boolean'],
          
          
        ];
        $this->validate($request, $rules);
        $project = $this->model->create($request->all());
        if ($request->hasFile('attachments') && $request->file('attachments')->isValid()) {
            $file = $request->file('attachments');
            // $project->clearMediaCollection('attachments');
            $project->addMediaFromRequest('attachments')->toMediaCollection('attachments');
            // $project->addMedia($file->getRealPath())->toMediaCollection('attachments');
            // $project->addMedia($file)->toMediaCollection('attachments');
        }
        return fractal($project, new ProjectTransformer())->respond(201);
       
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        //
        return fractal($project, new ProjectTransformer())->respond();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Project $project)
    {
        //
        $rules = [
            'manufacturing_unit_id' => ['required', 'integer', 'exists:manufacturing_units,id'],
            'title'=>['required'],
            // 'part_name'=>['required'],
            // 'drawing_number'=>['required'],
            // 'delivery_date'=>['required'],
            // 'location_preference'=>['required'],
            // 'raw_material_price'=>['required'],
            // 'description'=>['required'],
            // 'publish_at'=>['required'],
            // 'close_at'=>['required'],
            // 'active'=>['required','boolean'],
            // 'instant_publish'=>['required','boolean'],
          
        
        ];
        $this->validate($request, $rules);
        $project->update($request->all());
        if ($request->hasFile('attachments') && $request->file('attachments')->isValid()) {
            // $file = $request->file('avatar');
            $project->clearMediaCollection('attachments');
            $project->addMediaFromRequest('attachments')->toMediaCollection('attachments');
            // $user->addMedia($file)->toMediaCollection('avatar');
        }
        return fractal($project->fresh(), new ProjectTransformer())->respond();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        //
        $project->delete();
        return response()->json(null, 204);
    }
}
