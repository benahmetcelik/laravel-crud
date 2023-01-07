<?php
namespace Crud\Traits;


use Crud\Classes\FileUploader;
use Illuminate\Http\Request;

trait BaseCrud
{
    protected $base_dir;
    protected $base_model;
    protected $base_resource;
    protected $tableColumns;
    protected $formInputs;
    protected $formDetails;
    protected $tableActions;

    public function __construct()
    {
        $this->base_dir = 'backend.';
        $this->base_model = '';
        $this->base_resource ='blog.';


    }





    public function index(){
        $model = app($this->base_model)->paginate(12);
        $model_details = [
            'model' => app($this->base_model),
            'base_dir' => $this->base_dir,
            'base_resource' => $this->base_resource,
            'tableColumns' => $this->tableColumns,
            'tableActions' => $this->tableActions,

        ];
        return view($this->base_dir.'index',compact('model','model_details'));
    }
    public function edit($id){
        $model = app($this->base_model)->find($id);
        $this->formDetails['edit']['action'] = route($this->base_resource.'update',$id);
        $model_details = [
            'model' =>$model,
            'base_dir' => $this->base_dir,
            'base_resource' => $this->base_resource,
            'tableColumns' => $this->tableColumns,
            'formInputs' => $this->formInputs,
            'form'=>$this->formDetails['edit'],
        ];
        return view($this->base_dir.'create',compact('model_details'));
    }
    public function store(Request $request){
        $datas = self::fillableRequest($request);
        $model = app($this->base_model)->create($datas);
        return redirect()->route($this->base_resource.'index');
    }
    public function update(Request $request,$id){
        $datas = self::fillableRequest($request);
        $model = app($this->base_model)->find($id);
        $model->update($datas);
        return redirect()->route($this->base_resource.'index');
    }
    public function destroy($id){
        $model = app($this->base_model)->find($id);
        if ($model->image){
           @unlink(public_path($model->image));
        }
        if ($model->images){
           foreach ($model->images as $image){
              @unlink(public_path($image));
           }
        }
        $model->delete();
        return redirect()->route($this->base_resource.'index');
    }
    public function create(){
        $model_details = [
            'model' => app($this->base_model),
            'base_dir' => $this->base_dir,
            'base_resource' => $this->base_resource,
            'tableColumns' => $this->tableColumns,
            'formInputs' => $this->formInputs,
            'form'=>$this->formDetails['create'],
        ];
        return view($this->base_dir.'create',compact('model_details'));
    }

    public function fillableRequest($request){
        $data = array();
        $model = app($this->base_model);
        foreach ($model->getFillable() as $fillable){
           if ($request->has($fillable)){
               $data[$fillable] = $request->get($fillable) != null ? $request->get($fillable) : '';
           }
           if ($request->hasFile($fillable)){
               $file = new FileUploader();
                $data[$fillable] = json_encode($file->uploadMultiple($request->file($fillable),$fillable.'/'));
           }
        }


        return $data;

    }

    public function show($id)
    {
        $model = app($this->base_model)->find($id);
        $model_details = [
            'model' => $model,
            'base_dir' => $this->base_dir,
            'base_resource' => $this->base_resource,
            'tableColumns' => $this->tableColumns,
            'formInputs' => $this->formInputs,
            'form' => $this->formDetails['show'],
        ];
        return view($this->base_dir . 'create', compact('model_details'));
    }



}
