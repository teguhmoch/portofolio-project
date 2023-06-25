@extends('layout.side-menu')

@section('primary-content')

    <!--Container-->
    <div class="w-full px-2">

    <div class="p-10 grid grid-cols-2 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-4 xl:grid-cols-4 gap-5">
    <!--Card 1-->
    <div class="rounded overflow-hidden shadow-lg bg-green-600">
        <div class="text-center px-6 py-4">
        <div class="font-bold text-xl mb-2">Total Product Out (Qty)</div>
        </div>      
        <div class="text-center px-6 py-4">
        <div class="font-bold text-4xl mb-2">{{ $totalProductIn }}</div>
      </div>
    </div>
    <!--Card 2-->
    <div class="rounded overflow-hidden shadow-lg bg-blue-600">
        <div class="text-center px-6 py-4">
        <div class="font-bold text-xl mb-2">Total Product In (Qty)</div>
        </div>      
        <div class="text-center px-6 py-4">
        <div class="font-bold text-4xl mb-2">{{ $totalProductOut }}</div>
      </div>
    </div>

    <!--Card 3-->
    <div class="rounded overflow-hidden shadow-lg bg-red-600">
        <div class="text-center px-6 py-4">
        <div class="font-bold text-xl mb-2">Total Stock Product (Qty)</div>
        </div>      
        <div class="text-center px-6 py-4">
        <div class="font-bold text-4xl mb-2">{{ $totalStock }}</div>
      </div>
    </div>

    <!--Card 4-->
    <div class="rounded overflow-hidden shadow-lg bg-yellow-600">
        <div class="text-center px-6 py-4">
        <div class="font-bold text-xl mb-2">Total Product Active</div>
        </div>      
        <div class="text-center px-6 py-4">
        <div class="font-bold text-4xl mb-2">{{ $productActive }}</div>
      </div>
    </div>
  </div>
</div>        <!--/Card-->
    </div>
    <!--/container-->

@endsection
