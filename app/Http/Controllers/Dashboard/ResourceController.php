<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
use Schema;

class ResourceController extends Controller
{
    protected string $model;
    protected $tbName;
    protected $with;

    protected $objName;
    protected $tableHeader;
    protected $formFields;
    public function __construct(){
        $this->objName = $this->decamelize(str_replace('Controller','',(new \ReflectionClass($this))->getShortName()));
        $this->tbName = \Illuminate\Support\Pluralizer::plural($this->objName,2);
        $this->model = 'App\\Models\\' . str_replace('_', '', ucwords($this->objName, '_'));
    }

    private function decamelize($string) {
        return strtolower(preg_replace(['/([a-z\d])([A-Z])/', '/([^_])([A-Z][a-z])/'], '$1_$2', $string));
    }

    protected function prepareData(Request $request){
        $data = DB::table($this->tbName);
        if($this->with){
            $data = $this->model::with($this->with);
        }
        return $data;
    }

    protected function getPageProperties(){
        return [
            "title" => "Resources",
            "resource" => $this->objName,
        ];
    }


    final protected function getColumns(){
        return Schema::getColumnListing($this->tbName);
    }

    protected function filterData(Request  $request, $data){
        $columns = $this->getColumns();
        $filter = $request->query('filter');
        $filterValue = $request->query('filterValue');
        $filterOperator = $request->query('filterOperator');
        if($request->query('filter')){
            foreach ($filter as $key => $col) {
                if(in_array($col,$columns)){
                    $q = $filterValue[$key];
                    $operator = $filterOperator[$key];
                    if($operator == 'like'){
                        $q = '%'. $q .'%';
                    }
                    $data = $data->where($col, $operator, $q);
                }elseif(in_array($col,$this->with)){
                    $q = $filterValue[$key];
                    $operator = $filterOperator[$key];
                    if($operator == 'like'){
                        $q = '%'. $q .'%';
                    }
                    $data = $data->whereHas($col, function ($query) use ($operator, $q){
                        $query->where('name', $operator, $q);
                    });
                }
            }
        }
        return $data;
    }

    protected function search($data,$q){
        return $data->where('name', 'like', '%'. $q .'%');
    }

    protected function prepareShowData(Request $request, $id){
        return $this->model::find($id);
    }

    protected function prepareStoreData(Request $request, int $id = null){
        $data = json_decode($request->getContent(), true);
        if(!$id){
            $obj = new $this->model;
        }else{
            $obj = $this->model::findOrFail($id);
        }
        foreach ($data as $key => $value) {
            $obj->$key = $value;
        }
        return $obj;
    }

    protected function afterStoreData(Request $request,$data){

    }

    protected function save(Request $request, int $id = null){
        $data = $this->prepareStoreData($request, (int)$id);
        $data->save();
        $this->afterStoreData($request, $data);
        return $data;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request  $request)
    {
        $perpage = $request->query('perpage')?$request->query('perpage'):15;
        $orderCol = $request->query('sortby')?$request->query('sortby')[0]:'id';
        $orderDirection = 'asc';
        if($request->query('sortDesc')){
            $orderDirection = $request->query('sortDesc')[0] == 'true'?'desc':'asc';
        }
        $data = $this->prepareData($request);
        $data = $data->orderBy($orderCol,$orderDirection)->paginate($perpage);
        return Inertia::render('resources/listing', [
            "tableHeader" => $this->tableHeader,
            "tableData" => $data,
            "pageProperties" => $this->getPageProperties(),
        ]);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {   
        $data = [];
        foreach ($this->getColumns() as $key => $value) {
            $data[$value] = null;
        }
        return Inertia::render('resources/show', [
            "formData" => $data,
            "formFields" => $this->formFields,
            "pageProperties" => $this->getPageProperties(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $this->save($request);
        return to_route("{$this->objName}.show", $data->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id)
    {
        $data = $this->prepareShowData($request, $id);
        return Inertia::render('resources/show', [
            "formData" => $data,
            "formFields" => $this->formFields,
            "pageProperties" => $this->getPageProperties(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        $data = $this->save($request, $id);
        return to_route("{$this->objName}.show", $data->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

}
