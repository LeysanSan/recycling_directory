<?php

namespace App\Http\Controllers;

use App\Models\Facility;
use App\Models\Material;
use Illuminate\Http\Request;
use App\Http\Requests\FacilityRequest;

class FacilityController extends Controller
{
    public function index(Request $request)
    {
        $materials = Material::orderBy('name')->get();

        $facilities = Facility::with('materials')
            ->when($request->filled('search'), function ($query) use ($request) {
                $query->where('business_name', 'like', '%' . $request->search . '%');
            })
            ->when($request->filled('material_id'), function ($query) use ($request) {
                $query->whereHas('materials', function ($q) use ($request) {
                    $q->where('materials.id', $request->material_id);
                });
            })
            ->orderBy('updated_at', $request->input('sort', 'desc'))
            ->paginate(10)
            ->withQueryString();

        return view('facilities.index', compact('facilities', 'materials'));
    }

    public function create()
    {
        $materials = Material::orderBy('name')->get();
        return view('facilities.create', compact('materials'));
    }

    public function store(FacilityRequest $request)
    {
        $facility = Facility::create($request->validated());

        // Attach materials if provided
        $facility->materials()->sync($request->input('materials', []));

        return redirect()->route('facilities.index')
            ->with('success', 'Facility created successfully.');
    }

    public function show(Facility $facility)
    {
        $facility->load('materials');
        return view('facilities.show', compact('facility'));
    }

    public function edit(Facility $facility)
    {
        $materials = Material::orderBy('name')->get();
        $facility->load('materials');
        return view('facilities.edit', compact('facility', 'materials'));
    }

    public function update(FacilityRequest $request, Facility $facility)
    {
        $facility->update($request->validated());

        // Sync materials without double-click problem
        $facility->materials()->sync($request->input('materials', []));

        return redirect()->route('facilities.index')
            ->with('success', 'Facility updated successfully.');
    }

    public function destroy(Facility $facility)
    {
        $facility->materials()->detach();
        $facility->delete();

        return back()->with('success', 'Facility deleted successfully.');
    }

    public function export(Request $request)
    {
        $facilities = Facility::with('materials')
            ->when($request->filled('search'), function ($query) use ($request) {
                $query->where('business_name', 'like', '%' . $request->search . '%');
            })
            ->when($request->filled('material_id'), function ($query) use ($request) {
                $query->whereHas('materials', function ($q) use ($request) {
                    $q->where('materials.id', $request->material_id);
                });
            })
            ->orderBy('updated_at', $request->input('sort', 'desc'))
            ->get();

        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename="facilities.csv"',
        ];

        $callback = function () use ($facilities) {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['Business Name', 'Last Updated', 'Address', 'Materials Accepted']);
            foreach ($facilities as $f) {
                fputcsv($out, [
                    $f->business_name,
                    optional($f->last_update_date)->format('Y-m-d'),
                    $f->street_address,
                    $f->materials->pluck('name')->join(', '),
                ]);
            }
            fclose($out);
        };

        return response()->stream($callback, 200, $headers);
    }
}
