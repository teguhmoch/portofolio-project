@extends('layout.side-menu')

@section('primary-content')

@if (session('error'))
        @if(is_array(session('error')))
            @foreach(session('error') as $error)
                <div class="bg-red-600 p-4 my-5 mx-5 rounded-lg text-white">
                    {{ $error }}
                </div>
            @endforeach
        @else
            <div class="bg-red-600 p-4 my-5 mx-5 rounded-lg text-white">
                {{ session('error') }}
            </div>
        @endif
    @elseif(session('success'))
        <div class="bg-green-600 p-4 my-5 mx-5 rounded-lg text-white">
            {{ session('success') }}
        </div>
    @endif

    <!--Container-->
    <div class="w-full px-2">

        <!--Card-->
        <div class="p-6 mt-6 lg:mt-0 rounded-lg shadow-lg bg-white">
            <div class="border-b border-gray-900/10 mb-4 pb-4">
                <nav class="w-full rounded-md">
                    <ol class="list-reset flex">
                        <li>
                            <a href="{{ route('home.index') }}" class="text-sm transition duration-150 ease-in-out hover:text-primary-600 focus:text-primary-600 active:text-primary-700">Home</a>
                        </li>
                        <li>
                            <span class="mx-2 text-sm text-neutral-500">&#x2022;</span>
                        </li>
                        <li>
                            <span class="text-sm text-neutral-500">Product Management</span>
                        </li>
                        <li>
                            <span class="mx-2 text-sm text-neutral-500">&#x2022;</span>
                        </li>
                        <li>
                            <span class="text-sm text-neutral-500">Products</span>
                        </li>
                    </ol>
                </nav>
                <div class="mt-2">
                <a href="{{ route('product.create') }}">
                    <button type="button" class="inline-flex items-center gap-x-1.5 rounded-md bg-green-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-green-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                      <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zM12.75 9a.75.75 0 00-1.5 0v2.25H9a.75.75 0 000 1.5h2.25V15a.75.75 0 001.5 0v-2.25H15a.75.75 0 000-1.5h-2.25V9z" clip-rule="evenodd" />
                    </svg>
                        Add New
                    </button>
                </a>
            </div>

            </div>
            <table id="example" class="stripe hover" style="width:100%; padding-top: 1em; padding-bottom: 1em;">
                <thead>
                <tr class="text-black text-center">
                    <th data-priority="1">No</th>
                    <th data-priority="2">Name</th>
                    <th data-priority="3">Stock</th>
                    <th data-priority="4">Total Product In</th>
                    <th data-priority="5">Total Product Out</th>
                    <th data-priority="6">Added By</th>
                    <th data-priority="7">Created At</th>
                    <th data-priority="8">Status</th>
                    <th data-priority="9">Action</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($products as $i => $product)
                    <tr class="text-black">
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $product->name ?? '' }}</td>
                        <td class="text-center">{{ $product->stock ?? 0 }}</td>
                        <td class="text-center">{{ $product->total_product_in ?? 0 }}</td>
                        <td class="text-center">{{ $product->total_product_out ?? 0 }}</td>
                        <td>{{ $product->addedBy->name ?? '' }}</td>
                        <td>{{ $product->create ?? '' }}</td>
                        <td><label class="{{ $product->status == 'inactive' ? 'bg-red-500' : 'bg-green-500' }} text-white rounded px-2 py-1">{{ App\Models\Product::STATUS_SELECT[$product->status] ?? '' }}</label></td>
                        <td class="text-center">
                            <button onClick="showUrl({{ $product->id }})" class="mb-1 bg-cyan-500 hover:bg-cyan-600 text-grey-darkest font-bold py-2 px-4 rounded inline-flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4"> <path d="M12 15a3 3 0 100-6 3 3 0 000 6z" /><path fill-rule="evenodd" d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 010-1.113zM17.25 12a5.25 5.25 0 11-10.5 0 5.25 5.25 0 0110.5 0z" clip-rule="evenodd" /></svg>
                            </button>

                            <button onClick="editUrl({{ $product->id }})" class="mb-1 bg-yellow-500 hover:bg-yellow-600 text-grey-darkest font-bold py-2 px-4 rounded inline-flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4"> <path d="M21.731 2.269a2.625 2.625 0 00-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 000-3.712zM19.513 8.199l-3.712-3.712-12.15 12.15a5.25 5.25 0 00-1.32 2.214l-.8 2.685a.75.75 0 00.933.933l2.685-.8a5.25 5.25 0 002.214-1.32L19.513 8.2z" /></svg>
                            </button>

                            @if ($isMaster != null)
                            <button onClick="deleteUrl({{ $product->id }})" class="bg-red-500 hover:bg-red-600 text-grey-darkest font-bold py-2 px-4 rounded inline-flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4"><path fill-rule="evenodd" d="M16.5 4.478v.227a48.816 48.816 0 013.878.512.75.75 0 11-.256 1.478l-.209-.035-1.005 13.07a3 3 0 01-2.991 2.77H8.084a3 3 0 01-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 01-.256-1.478A48.567 48.567 0 017.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 013.369 0c1.603.051 2.815 1.387 2.815 2.951zm-6.136-1.452a51.196 51.196 0 013.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 00-6 0v-.113c0-.794.609-1.428 1.364-1.452zm-.355 5.945a.75.75 0 10-1.5.058l.347 9a.75.75 0 101.499-.058l-.346-9zm5.48.058a.75.75 0 10-1.498-.058l-.347 9a.75.75 0 001.5.058l.345-9z" clip-rule="evenodd" /></svg>
                            </button>
                            @endif
                            

                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!--/Card-->
    </div>
    <!--/container-->

    <script>
        function showUrl(id) {
            var productId = id;
            var url = "products/show/" + productId;
            window.location.href = url;            
        }
        function editUrl(id) {
            var productId = id;
            var url = "products/edit/" + productId;
            window.location.href = url;            
        }
        function deleteUrl(id) {
            var productId = id;
            var url = "products/destroy/" + productId;
            window.location.href = url;            
        }
    </script>

@endsection
