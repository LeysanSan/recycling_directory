@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">{{ $facility->business_name }}</h1>

        <p><strong>Last Update:</strong> {{ optional($facility->last_update_date)->format('Y-m-d') }}</p>
        <p><strong>Address:</strong> {{ $facility->street_address }}</p>
        <p><strong>Materials Accepted:</strong> {{ $facility->materials->pluck('name')->join(', ') }}</p>

        <div class="my-4">
            <iframe width="100%" height="350" frameborder="0" style="border:0"
                src="https://www.google.com/maps?q={{ urlencode($facility->street_address) }}&output=embed" allowfullscreen>
            </iframe>
        </div>

        <a href="{{ route('facilities.index') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
            ← Back to Facilities
        </a>
    </div>
@endsection
