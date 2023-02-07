<?php

namespace App\Http\Controllers\Backend;

use App\Models\Module;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use App\Http\Requests\ModuleStoreRequest;

class ModuleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $modules = Module::select(['id','module_name','module_slug','updated_at'])->latest('id')->get();
        return view('admin.pages.module.index',compact('modules'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pages.module.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ModuleStoreRequest $request)
    {
        Module::updateOrCreate([
            'module_name' =>$request->module_name,
            'module_slug' =>Str::slug($request->module_name),
        ]);

        Toastr::success('Module Created Successfully', 'Success',);
        return redirect()->route('admin.module.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($module_slug)
    {
        $module = Module::whereModule_slug($module_slug)->select('module_name','module_slug')->first();
        return view('admin.pages.module.edit',compact('module'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ModuleStoreRequest $request, $module_slug)
    {
        $module = Module::whereModule_slug($module_slug)->first();

        $module->update([
            'module_name' =>$request->module_name,
            'module_slug' =>Str::slug($request->module_name),
        ]);

        Toastr::success('Module Updated Successfully', 'Success',);
        return redirect()->route('admin.module.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($module_slug)
    {
         $module = Module::whereModule_slug($module_slug);
         $module->delete();
         Toastr::success('Module Delete Successfully', 'Success',);
         return redirect()->route('admin.module.index');
    }
}
