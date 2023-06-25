@extends('layout.master')

@section('main-content')

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

<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 ">
  <!-- We've used 3xl here, but feel free to try other max-widths based on your needs -->
  <div class="mx-auto max-w-3xl ">
    <!-- Content goes here -->

    <div class="my-5">
    <form method="POST" action="{{ route('user.store') }}">
            @csrf
  <div class="space-y-12">
    <div class="border-b border-gray-900/10 pb-12">
        <div class="my-5">
        <a href="{{ route('user.index') }}">
        <button type="button" class="inline-flex items-center gap-x-1.5 rounded-md bg-slate-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-slate-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-600">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
            <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zm-4.28 9.22a.75.75 0 000 1.06l3 3a.75.75 0 101.06-1.06l-1.72-1.72h5.69a.75.75 0 000-1.5h-5.69l1.72-1.72a.75.75 0 00-1.06-1.06l-3 3z" clip-rule="evenodd" />
        </svg>
        Back
        </button>
    </a>
        </div>
      <h2 class="text-base font-semibold leading-7 text-gray-900">Add new user</h2>
      <p class="mt-1 text-sm leading-6 text-gray-600">only admin can add new user</p>

      <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
       <div class="sm:col-span-full">
          <label for="name" class="block text-sm font-medium leading-6 text-gray-900">Name</label>
          <div class="mt-2">
            <input required id="name" name="name" type="text" autocomplete="name_product" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
          </div>
        </div>
       <div class="sm:col-span-full">
          <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email</label>
          <div class="mt-2">
            <input required id="email" name="email" type="email" autocomplete="email" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
          </div>
        </div>

        <div class="sm:col-span-full">
          <label for="password" class="block text-sm font-medium leading-6 text-gray-900">Password</label>
          <div class="mt-2">
            <input required id="password" name="password" type="password" autocomplete="password" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
          </div>
        </div>

        <div class="sm:col-span-full">
          <label for="nik" class="block text-sm font-medium leading-6 text-gray-900">Nik</label>
          <div class="mt-2">
            <input required id="nik" name="nik" type="number" autocomplete="nik" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
          </div>
        </div>

      </div>
    </div>
  </div>

  <div class="mt-6 mb-6 flex items-center justify-end gap-x-6">
    <button type="submit" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Save</button>
  </div>
</form>
    </div>
    
  </div>
</div>

@endsection