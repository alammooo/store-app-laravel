@extends('layouts/main')

@section('mainLayout')
    <div class='flex flex-col gap-3'>
        <div class="relative w-32 h-32 overflow-hidden rounded-full border-gray-300 border">

        </div>
        <h1 class='text-3xl font-semibold mb-3'>Abdullah Alam</h1>
        <div class='grid grid-cols-4'>
            <div class="col-span-3">
                <label for="fullName" class="block mb-2 text-sm font-medium text-gray-900">Nama
                    Kandidat</label>
                <input type="text" id="fullName" name="fullName"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-md focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    placeholder="John" required>
            </div>
            <div>
                <label for="position" class="block mb-2 text-sm font-medium text-gray-900">Posisi
                    Kandidat</label>
                <input type="text" id="position" name="position"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-md focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    placeholder="Doe" required>
            </div>
        </div>
    </div>
@endsection
