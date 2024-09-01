<?php

namespace App\Http\Controllers\Admin;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Admin\SettingRequest;

class SettingController extends Controller
{
   
    public function index(): View
    {
        $setting = Setting::first();

        if(!is_null($setting)){

            return view('admin.settings.edit', compact('setting'));
        }
        
           return view('admin.settings.create');
    }

    public function create(): View
    {
        return view('admin.settings.create');
    }

    public function store(SettingRequest $request): RedirectResponse
    {
        if($request->validated()){
            $logo = $request->file('logo')->store('assets/logo','public');
            Setting::create($request->except('logo') + ['logo' => $logo]);
        }
      

        return redirect()->route('admin.settings.index')->with([
            'message' => 'successfully created !',
            'alert-type' => 'success'
        ]);
    }

    public function show(Setting $setting): View
    {
        return view('admin.settings.show', compact('setting'));
    }

    public function edit(Setting $setting): View
    {
        return view('admin.settings.edit', compact('setting'));
    }

    public function update(SettingRequest $request, Setting $setting): RedirectResponse
    {
        if($request->validated()){
            if($request->logo){
                File::delete('storage/' . $setting->logo);
                $logo = $request->file('logo')->store('assets/logo','public');
                $setting->update($request->except('logo') + ['logo' => $logo]);
    
            }else{
                
                $setting->update($request->validated());
            }
    
        }
        
        return redirect()->route('admin.settings.edit',$setting->id)->with([
            'message' => 'successfully updated !',
            'alert-type' => 'info'
        ]);
    }

    public function destroy(Setting $setting): RedirectResponse
    {
        File::delete('storage/' . $setting->logo);

        $setting->delete();

        return back()->with([
            'message' => 'successfully deleted !',
            'alert-type' => 'danger'
        ]);
    }
}