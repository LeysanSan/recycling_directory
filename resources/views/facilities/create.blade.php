@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Add New Facility</h1>

        <a href="{{ route('facilities.index') }}"
            class="px-4 py-2 bg-blue-600 text-black rounded hover:bg-blue-700 mb-4 inline-block">
            ← Back to Facilities
        </a>

        @if ($errors->any())
            <div class="mb-4 p-2 bg-red-200 border border-red-400 rounded">
                <ul class="list-disc pl-5 text-black">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('facilities.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label for="business_name" class="block mb-1 font-semibold text-black">Business Name</label>
                <input type="text" name="business_name" id="business_name" value="{{ old('business_name') }}"
                    class="border rounded px-2 py-1 w-full" required>
            </div>

            <div>
                <label for="last_update_date" class="block mb-1 font-semibold text-black">Last Update Date</label>
                <input type="date" name="last_update_date" id="last_update_date" value="{{ old('last_update_date') }}"
                    class="border rounded px-2 py-1 w-full" required>
            </div>

            <div>
                <label for="street_address" class="block mb-1 font-semibold text-black">Street Address</label>
                <input type="text" name="street_address" id="street_address" value="{{ old('street_address') }}"
                    class="border rounded px-2 py-1 w-full" required>
            </div>

            <div>
                <label for="materials" class="block mb-1 font-semibold text-black">Materials Accepted</label>
                <select name="materials[]" id="materials" multiple class="border rounded px-2 py-1 w-full">
                    @foreach ($materials as $material)
                        <option value="{{ $material->id }}"
                            {{ in_array($material->id, old('materials', [])) ? 'selected' : '' }}>
                            {{ $material->name }}
                        </option>
                    @endforeach
                </select>
                <small class="text-sm text-black">Hold Ctrl (Windows) or Command (Mac) to select multiple materials.</small>
            </div>

            <button type="submit" class="px-4 py-2 bg-green-600 text-black rounded hover:bg-green-700">
                Add Facility
            </button>
        </form>
    </div>
@endsection
