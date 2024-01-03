@extends('layouts.main')

@section('mainLayout')
    <div class="flex flex-col gap-3">
        <h1 class="font-bold mb-3 text-xl">Daftar Produk</h1>
        <div class="flex justify-between">
            <div class="flex items-center gap-5">
                <form action="/product">
                    <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only">Search</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                            </svg>
                        </div>
                        <input type="search" id="default-search" name="search"
                            class="block w-full p-1.5 ps-10 text-sm text-gray-900 border focus:ring-1.5 focus:border-white border-gray-300 rounded-md focus:ring-black placeholder:text-gray-400"
                            placeholder="Cari barang">
                    </div>
                </form>

                <div>
                    <button id="dropdownDefaultButton" data-dropdown-toggle="dropdown"
                        class="flex justify-between text-black focus:ring-1 border border-gray-300 focus:outline-black focus:ring-black rounded-md text-sm px-3 py-1.5 text-center items-center w-40"
                        type="button">
                        <div class="flex gap-1 items-center">
                            <x-feathericon-package class="w-4 h-4" />
                            Semua
                        </div>
                        <svg class="w-2.5 h-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 4 4 4-4" />
                        </svg>
                    </button>
                    <!-- Dropdown menu -->
                    <div id="dropdown" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-md shadow w-44">
                        <ul class="py-2 text-sm text-gray-700" aria-labelledby="dropdownDefaultButton">
                            <li>
                                <a href="#" class="block px-4 py-2 hover:bg-gray-50">Dashboard</a>
                            </li>
                            <li>
                                <a href="#" class="block px-4 py-2 hover:bg-gray-50">Settings</a>
                            </li>
                            <li>
                                <a href="#" class="block px-4 py-2 hover:bg-gray-50">Earnings</a>
                            </li>
                            <li>
                                <a href="#" class="block px-4 py-2 hover:bg-gray-50">Sign
                                    out</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="flex items-center gap-5">
                <button type="button"
                    class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-1 focus:ring-green-300 font-medium rounded-md text-sm px-5 py-1.5 me-2 mb-2">Export
                    Excel</button>
                <a href="/product/create"
                    class="focus:outline-none text-white focus:ring-1 bg-oren hover:bg-orange-600 font-medium rounded-md text-sm px-5 py-1.5 me-2 mb-2">Tambah
                    Produk</a>
            </div>
        </div>

        <div class="relative overflow-x-auto shadow-md sm:rounded-md">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th scope="col" class="px-4 py-3">
                            No
                        </th>
                        <th scope="col" class="px-4 py-3">
                            Image
                        </th>
                        <th scope="col" class="px-4 py-3">
                            Nama Produk
                        </th>
                        <th scope="col" class="px-4 py-3">
                            Kategori Produk
                        </th>
                        <th scope="col" class="px-4 py-3">
                            Harga Beli (Rp)
                        </th>
                        <th scope="col" class="px-4 py-3">
                            Harga Jual (Rp)
                        </th>
                        <th scope="col" class="px-4 py-3">
                            Stok Produk
                        </th>
                        <th scope="col" class="px-4 py-3">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $key => $product)
                        @php
                            $i = 1;
                        @endphp
                        <tr class="odd:bg-white">
                            <td class="px-4 py-2">
                                {{ $key + 1 }}
                            </td>
                            <td class="px-4 py-2">
                                <img src="{{ asset('storage/images/' . $product->image) }}" alt="{{ $product->name }}"
                                    class="w-10 h-10 object-cover">
                            </td>
                            <th scope="row" class="px-4 py-2 font-medium text-gray-900 whitespace-nowrap">
                                {{ $product->name }}
                            </th>
                            <td class="px-4 py-2">
                                {{ $product->category->name }}
                            </td>
                            <td class="px-4 py-2">
                                {{ number_format($product->buyPrice, 0, '.', ',') }}
                            </td>
                            <td class="px-4 py-2">
                                {{ number_format($product->sellPrice, 0, '.', ',') }}
                            </td>
                            <td class="px-4 py-2">
                                {{ $product->stock }}
                            </td>
                            <td class="px-4 py-2 ">
                                <div class="flex items-center gap-5">
                                    <a href={{ '/product/' . $product->id }}
                                        class="font-medium text-blue-600 hover:text-blue-700"><x-zondicon-edit-pencil
                                            class="w-4 h-4" /></a>
                                    <form action="{{ route('product.destroy', ['id' => $product->id]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            onclick="return confirm('Apakah anda ingin menghapus data ini?')"
                                            class="font-medium text-red-600 hover:text-red-700">
                                            <x-heroicon-o-trash class="w-4 h-4" />
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @php
                            $i++;
                        @endphp
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="flex justify-between mt-2">
            <h1 class="text-gray-600 font-medium text-sm">Show 10 from 50</h1>
            <nav aria-label="Page navigation example">
                <ul class="inline-flex -space-x-px text-sm">
                    <li>
                        <a href="#"
                            class="flex items-center justify-center px-3 h-8 ms-0 leading-tight text-gray-500 bg-white border border-e-0 border-gray-300 rounded-s-lg hover:bg-gray-100 hover:text-gray-700">Previous</a>
                    </li>
                    <li>
                        <a href="#"
                            class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700">1</a>
                    </li>
                    <li>
                        <a href="#"
                            class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700">2</a>
                    </li>
                    <li>
                        <a href="#" aria-current="page"
                            class="flex items-center justify-center px-3 h-8 text-white border border-gray-300 bg-oren hover:bg-orange-600 hover:text-white">3</a>
                    </li>
                    <li>
                        <a href="#"
                            class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700">4</a>
                    </li>
                    <li>
                        <a href="#"
                            class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700">5</a>
                    </li>
                    <li>
                        <a href="#"
                            class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-lg hover:bg-gray-100 hover:text-gray-700">Next</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
@endsection
