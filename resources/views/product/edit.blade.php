@extends('layouts.main')

@section('mainLayout')
    <div class='flex flex-col gap-3'>
        <div class='flex gap-2 items-center mb-3'>
            <h1 class='font-bold text-xl text-gray-300'>Daftar Produk</h1>
            <x-ri-arrow-drop-right-line class="w-8 h-8" />
            <h1 class='font-bold text-xl'>Tambah Produk</h1>
        </div>
        <form action="{{ '/product/' . $product->id }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('put')
            <div class='grid gap-6 mb-6 md:grid-cols-3'>
                <div>
                    <label for="category"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Kategori</label>
                    <select id="category" name="categoryId"
                        class="border border-gray-300 text-gray-900 text-sm rounded-md focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value="{{ $product->category->id }}" selected>{{ $product->category->name }}</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class='col-span-2'>
                    <label for='name' class='block mb-2 text-sm font-medium text-gray-900'>
                        Masukkan nama barang
                    </label>
                    <input type='text' id='name' name="name" value="{{ $product->name }}"
                        class='bg-white border border-gray-300 text-gray-900 text-sm rounded-md focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5'
                        placeholder='Masukkan nama barang' />
                    @error('name')
                        {{ $message }}
                    @enderror
                </div>
                <div>
                    <label for='buyPrice' class='block mb-2 text-sm font-medium text-gray-900'>
                        Harga Beli
                    </label>
                    <input type='text' id='buyPrice' name="buyPrice" value="{{ $product->buyPrice }}"
                        class='bg-white border border-gray-300 text-gray-900 text-sm rounded-md focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5'
                        placeholder='Rp' />
                    @error('buyPrice')
                        {{ $message }}
                    @enderror
                </div>
                <div>
                    <label for='sellPrice' class='block mb-2 text-sm font-medium text-gray-900'>
                        Harga Jual
                    </label>
                    <input type='text' id='sellPrice' name="sellPrice" value="{{ $product->sellPrice }}"
                        class='bg-white border border-gray-300 text-gray-900 text-sm rounded-md focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5'
                        placeholder='Rp' readonly />
                </div>
                <div>
                    <label for='stock' class='block mb-2 text-sm font-medium text-gray-900'>
                        Stock Barang
                    </label>
                    <input type='number' id='stock' name="stock" value="{{ $product->stock }}"
                        class='bg-white border border-gray-300 text-gray-900 text-sm rounded-md focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5'
                        placeholder='Masukkan jumlah stok barang' />
                    @error('stock')
                        {{ $message }}
                    @enderror
                </div>

                <div class='col-span-3'>
                    <h1 class='mb-2 text-sm font-medium text-gray-900'>
                        Upload Image
                    </h1>
                    <div class='flex items-center justify-center'>
                        <label for='dropzone-file'
                            class='flex flex-col items-center justify-center w-full h-64 border-2 border-blue-300 border-dashed rounded-md cursor-pointer bg-white'>
                            <div class='flex flex-col items-center justify-center pt-5 pb-6'>
                                <svg class="w-8 h-8 mb-4 text-blue-500" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                                </svg>
                                <p class='mb-2 text-sm text-blue-500'>
                                    <span class='font-semibold'>Upload Gambar Disini
                                </p>
                                <p class='text-xs text-blue-500'>
                                    PNG, JPG (MAX. 800x400px)
                                </p>
                            </div>
                            <input id='dropzone-file' type='file' name="image" accept='.png, .jpeg, .jpg'
                                value="{{ $product->image }}" class='hidden' />
                        </label>
                    </div>
                    @error('image')
                        {{ $message }}
                    @enderror
                </div>
            </div>
            <div class='flex justify-end gap-5'>
                <button type='button'
                    class='text-blue-700 bg-white border border-blue-300 focus:outline-none hover:bg-blue-100 focus:ring-4 focus:ring-blue-200 font-medium rounded-md text-sm px-16 py-2.5'>
                    Batalkan
                </button>
                <button type='submit'
                    class='text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-md text-sm px-16 py-2.5'>
                    Update Data
                </button>
            </div>
        </form>
    </div>

    <script>
        const formatNumberWithCommas = (input) => {
            return input.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        };

        const unformatNumber = (input) => {
            return Number(input.replace(/[^\d]/g, ''));
        };

        const buyPriceInput = document.getElementById('buyPrice');
        const sellPriceInput = document.getElementById('sellPrice');

        buyPriceInput.addEventListener('input', () => {
            const numericValue = unformatNumber(buyPriceInput.value);
            const formattedValue = formatNumberWithCommas(numericValue);

            buyPriceInput.value = formattedValue;

            const sellPrice = numericValue + (0.3 * numericValue);
            sellPriceInput.value = formatNumberWithCommas(Math.round(sellPrice));
        });

        // sellPriceInput.addEventListener('input', () => {
        //     const numericValue = unformatNumber(sellPriceInput.value);
        //     const formattedValue = formatNumberWithCommas(numericValue);

        //     sellPriceInput.value = formattedValue;
        // });
    </script>
@endsection
