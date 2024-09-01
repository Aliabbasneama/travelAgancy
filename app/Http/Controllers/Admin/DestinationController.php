<?php

namespace App\Http\Controllers\Admin;

use App\Models\Destination;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Admin\DestinationRequest;

class DestinationController extends Controller
{
   
    public function index(): View
    {
        $destinations = Destination::get();

        return view('admin.destinations.index', compact('destinations'));
    }

    public function create(): View
    {
        return view('admin.destinations.create');
    }

    public function store(DestinationRequest $request): RedirectResponse
    {
        if($request->validated()){
            $image = $request->file('image')->store('assets/destination','public');
            Destination::create($request->except('image') + ['image' => $image]);
        }

        return redirect()->route('admin.destinations.index')->with([
            'message' => 'successfully created !',
            'alert-type' => 'success'
        ]);
    }

    public function edit(Destination $destination): View
    {
        return view('admin.destinations.edit', compact('destination'));
    }

    public function update(DestinationRequest $request, Destination $destination): RedirectResponse
    {
        $validated = $request->validated();
    // إذا كان هناك صورة جديدة تم تحميلها
    if ($request->hasFile('image')) {
        // حذف الصورة القديمة إذا كانت موجودة
        if ($destination->image) {
            Storage::disk('public')->delete($destination->image);
        }

        // تخزين الصورة الجديدة
        $imagePath = $request->file('image')->store('assets/destination', 'public');

        // تحديث النموذج مع الصورة الجديدة
        $destination->update(array_merge(
            $validated, 
            ['image' => $imagePath]
        ));
    } else {
        // تحديث النموذج بدون تعديل الصورة إذا لم يتم تحميل صورة جديدة
        $destination->update($validated);
    }

    return redirect()->route('admin.destinations.index')->with([
        'message' => 'Successfully updated!',
        'alert-type' => 'info'
    ]);
    }

    public function destroy(Destination $destination): RedirectResponse
    {
        File::delete('storage/'. $destination->image);
        $destination->delete();

        return back()->with([
            'message' => 'successfully deleted !',
            'alert-type' => 'danger'
        ]);
    }
}