@if($errors->any())
    <ul class="mb-4 p-4 border border-red-300 bg-red-100 bg-opacity-80 space-y-4">
        @foreach($errors->all() as $error)
            <li class="text-xs text-red-600">{{ $error }}</li>
        @endforeach
    </ul>
@endif