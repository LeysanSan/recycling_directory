@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Facilities</h1>

        <div class="flex justify-between items-center mb-4">
            <!-- Search and Filter -->
            <form method="GET" class="flex gap-2">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search..."
                    class="border rounded px-2 py-1">
                <select name="material_id" class="border rounded px-2 py-1">
                    <option value="">All Materials</option>
                    @foreach ($materials as $material)
                        <option value="{{ $material->id }}" {{ request('material_id') == $material->id ? 'selected' : '' }}>
                            {{ $material->name }}
                        </option>
                    @endforeach
                </select>
                <button type="submit" class="px-4 py-2 bg-green-500 text-black rounded hover:bg-green-600">Filter</button>
            </form>

            <!-- Action Buttons -->
            <div class="flex gap-2">
                <a href="{{ route('facilities.create') }}"
                    class="px-4 py-2 bg-blue-500 text-black rounded hover:bg-blue-600">+ Add New Facility</a>
                <a href="{{ route('facilities.export', request()->query()) }}"
                    class="px-4 py-2 bg-purple-500 text-black rounded hover:bg-purple-600">Export CSV</a>
            </div>
        </div>

        <!-- Facilities Table -->
        <table class="w-full border-collapse border">
            <thead>
                <tr class="bg-indigo-200">
                    <th class="border px-2 py-1">Business Name</th>
                    <th class="border px-2 py-1">Last Update</th>
                    <th class="border px-2 py-1">Materials Accepted</th>
                    <th class="border px-2 py-1">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($facilities as $facility)
                    <tr>
                        <td class="border px-2 py-1">{{ $facility->business_name }}</td>
                        <td class="border px-2 py-1">{{ optional($facility->last_update_date)->format('Y-m-d') }}</td>
                        <td class="border px-2 py-1">{{ $facility->materials->pluck('name')->join(', ') }}</td>
                        <td class="border px-2 py-1 flex gap-1">
                            <a href="{{ route('facilities.edit', $facility) }}"
                                class="px-2 py-1 bg-yellow-400 text-black rounded hover:bg-yellow-500">Edit</a>
                            <form action="{{ route('facilities.destroy', $facility) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="px-2 py-1 bg-red-500 text-black rounded hover:bg-red-600">Delete</button>
                            </form>
                            <a href="{{ route('facilities.show', $facility) }}"
                                class="px-2 py-1 bg-teal-500 text-black rounded hover:bg-teal-600">View</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="border px-2 py-1 text-center">No facilities found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $facilities->links() }}
        </div>
    </div>
@endsection
