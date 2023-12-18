@extends('layout.master')

@section('main-content')

    @php
        $username = session()->get('user')->name ?? '';
        $user = session()->get('user') ?? '';
        $isMaster = $user->roles()->where('title','master')->first();
        $isAdmin = $user->roles()->where('title','admin')->first();

    @endphp

    <div x-data="{ open: false }" @keydown.window.escape="open = false"
         xmlns:x-transition="http://www.w3.org/1999/xhtml" xmlns:x-state="http://www.w3.org/1999/xhtml">
        <div>
            <!-- Off-canvas menu for mobile, show/hide based on off-canvas menu state. -->
            <template x-if="true">
                <div x-show="open" x-ref="dialog" class="relative z-50 lg:hidden" role="dialog" aria-modal="true">
                    <!--
                      Off-canvas menu backdrop, show/hide based on off-canvas menu state.

                      Entering: "transition-opacity ease-linear duration-300"
                        From: "opacity-0"
                        To: "opacity-100"
                      Leaving: "transition-opacity ease-linear duration-300"
                        From: "opacity-100"
                        To: "opacity-0"
                    -->
                    <div x-show="open" x-transition:enter="transition-opacity ease-linear duration-300"
                         x-transition:enter-start="opacity-0"
                         x-transition:enter-end="opacity-100"
                         x-transition:leave="transition-opacity ease-linear duration-300"
                         x-transition:leave-start="opacity-100"
                         x-transition:leave-end="opacity-0"
                         class="fixed inset-0 bg-gray-900/80"></div>

                    <div class="fixed inset-0 flex">
                        <!--
                          Off-canvas menu, show/hide based on off-canvas menu state.

                          Entering: "transition ease-in-out duration-300 transform"
                            From: "-translate-x-full"
                            To: "translate-x-0"
                          Leaving: "transition ease-in-out duration-300 transform"
                            From: "translate-x-0"
                            To: "-translate-x-full"
                        -->
                        <div x-show="open" x-transition:enter="transition ease-in-out duration-300 transform"
                             x-transition:enter-start="-translate-x-full"
                             x-transition:enter-end="translate-x-0"
                             x-transition:leave="transition ease-in-out duration-300 transform"
                             x-transition:leave-start="translate-x-0"
                             x-transition:leave-end="-translate-x-full"
                             class="relative mr-16 flex w-full max-w-xs flex-1">
                            <!--
                              Close button, show/hide based on off-canvas menu state.

                              Entering: "ease-in-out duration-300"
                                From: "opacity-0"
                                To: "opacity-100"
                              Leaving: "ease-in-out duration-300"
                                From: "opacity-100"
                                To: "opacity-0"
                            -->
                            <div x-show="open" x-transition:enter="ease-in-out duration-300"
                                 x-transition:enter-start="opacity-0"
                                 x-transition:enter-end="opacity-100"
                                 x-transition:leave="ease-in-out duration-300"
                                 x-transition:leave-start="opacity-100"
                                 x-transition:leave-end="opacity-0"
                                 class="absolute left-full top-0 flex w-16 justify-center pt-5">
                                <button type="button" class="-m-2.5 p-2.5" @click="open = false">
                                    <span class="sr-only">Close sidebar</span>
                                    <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                         stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>

                            <!-- Sidebar component, swap this element with another sidebar if you like -->
                            <div class="flex grow flex-col gap-y-5 overflow-y-auto bg-zinc-700 px-6 pb-4">
                <div class="flex h-16 shrink-0 items-center">
                <h1 class="mt-10 text-center text-2xl leading-9 tracking-tight text-white">Product Management</h1>
                </div>
                <nav class="flex flex-1 flex-col">
                    <ul role="list" class="flex flex-1 flex-col gap-y-7">
                        <li>
                            <ul role="list" class="-mx-2 space-y-1">
                                <li>
                                    <!-- Current: "bg-zinc-800 text-white", Default: "text-zinc-200 hover:text-white hover:bg-zinc-800" -->
                                    <a href="{{ route('home.index') }}"
                                       class="{{ request()->routeIs('home.index') ? 'bg-zinc-800 text-white' : 'text-zinc-200 hover:text-white hover:bg-zinc-800' }}  group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold">
                                        <svg class="h-6 w-6 shrink-0 text-white" fill="none" viewBox="0 0 24 24"
                                             stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/>
                                        </svg>
                                        Home
                                    </a>
                                </li>

                                @if($isAdmin != null | $isMaster != null)
                                <li>
                                    <!-- Current: "bg-zinc-800 text-white", Default: "text-zinc-200 hover:text-white hover:bg-zinc-800" -->
                                    <a href="{{ route('user.index') }}"
                                       class="{{ request()->routeIs('user.index') ? 'bg-zinc-800 text-white' : 'text-zinc-200 hover:text-white hover:bg-zinc-800' }}  group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold">
                                       <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                    </svg>User Management
                                    </a>
                                </li>
                                @endif
                                
                                <div x-data="{ level: false }">
                                    <li>
                                        <a href="#" class="text-zinc-200 hover:text-white hover:bg-zinc-800 group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold"  @click="level = !level">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" /></svg>
                                            Product Management 
                                                <svg x-show="!level" class="h-6 w-6 flex-shrink-0 text-zinc-200 group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                                                <svg x-show="level" class="h-6 w-6 flex-shrink-0 text-zinc-200 group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/> 
                                                </svg>
                                        </a>
                                    </li>

                                    @if (request()->routeIs('product.index') || request()->routeIs('category.index') || request()->routeIs('product-in.index') || request()->routeIs('product-out.index'))
                                    <div x-show="!level" class="text-left text-sm mt-2 w-4/5 mx-auto text-gray-200 font-bold ml-2" id="submenu1">
                                        @else
                                        <div x-show="level" class="text-left text-sm mt-2 w-4/5 mx-auto text-gray-200 font-bold ml-2" id="submenu1">
                                            @endif
                                    @if($isAdmin != null | $isMaster != null)
                                    <div class="mt-2">
                                        <li>
                                            <a href="{{ route('product.index') }}" 
                                            class="{{ request()->routeIs('product.index') ? 'bg-zinc-800 text-white' : 'text-zinc-200 hover:text-white hover:bg-zinc-800' }}  group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold"> 
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                            </svg>
                                            Products
                                            </a>
                                        </li>
                                    </div>
                                    <div class="mt-2">
                                        <li>
                                            <a href="{{ route('category.index') }}" 
                                            class="{{ request()->routeIs('category.index') ? 'bg-zinc-800 text-white' : 'text-zinc-200 hover:text-white hover:bg-zinc-800' }}  group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold"> 
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z" />
                                        </svg> Product Categories
                                            </a>
                                        </li>
                                    </div>
                                    @endif
                                    @if($isAdmin == null)
                                    <div class="mt-2">
                                        <li>
                                            <a href="{{ route('product-in.index') }}" 
                                            class="{{ request()->routeIs('product-in.index') ? 'bg-zinc-800 text-white' : 'text-zinc-200 hover:text-white hover:bg-zinc-800' }}  group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold"> 
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
                                            </svg>Product Ins
                                            </a>
                                        </li>
                                    </div>
                                    <div class="mt-2">
                                        <li>
                                            <a href="{{ route('product-out.index') }}" 
                                            class="{{ request()->routeIs('product-out.index') ? 'bg-zinc-800 text-white' : 'text-zinc-200 hover:text-white hover:bg-zinc-800' }}  group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold"> 
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                                                </svg>Product Outs
                                            </a>
                                        </li>
                                    </div>
                                    @endif

                                    </div>
                                </div>
                                @if($isAdmin != null | $isMaster != null)
                                <li>
                                    <!-- Current: "bg-zinc-800 text-white", Default: "text-zinc-200 hover:text-white hover:bg-zinc-800" -->
                                    <a href="{{ route('supplier.index') }}"
                                       class="{{ request()->routeIs('supplier.index') ? 'bg-zinc-800 text-white' : 'text-zinc-200 hover:text-white hover:bg-zinc-800' }}  group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold">
                                       <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12" />
                                    </svg>Suppliers
                                    </a>
                                </li>
                                @endif
                                
                            </ul>
                        </li>
                    </ul>
                </nav>
            </div>
                        </div>
                    </div>
                </div>
            </template>
        </div>

        <!-- Static sidebar for desktop -->
        <div class="hidden lg:fixed lg:inset-y-0 lg:z-50 lg:flex lg:w-72 lg:flex-col">
            <!-- Sidebar component, swap this element with another sidebar if you like -->
            <div class="flex grow flex-col gap-y-5 overflow-y-auto bg-zinc-700 px-6 pb-4">
                <div class="flex h-16 shrink-0 items-center">
                <h1 class="mt-10 text-center text-2xl leading-9 tracking-tight text-white">Product Management</h1>
                </div>
                <nav class="flex flex-1 flex-col">
                    <ul role="list" class="flex flex-1 flex-col gap-y-7">
                        <li>
                            <ul role="list" class="-mx-2 space-y-1">
                                <li>
                                    <!-- Current: "bg-zinc-800 text-white", Default: "text-zinc-200 hover:text-white hover:bg-zinc-800" -->
                                    <a href="{{ route('home.index') }}"
                                       class="{{ request()->routeIs('home.index') ? 'bg-zinc-800 text-white' : 'text-zinc-200 hover:text-white hover:bg-zinc-800' }}  group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold">
                                        <svg class="h-6 w-6 shrink-0 text-white" fill="none" viewBox="0 0 24 24"
                                             stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/>
                                        </svg>
                                        Home
                                    </a>
                                </li>

                                @if($isAdmin != null | $isMaster != null)
                                <li>
                                    <!-- Current: "bg-zinc-800 text-white", Default: "text-zinc-200 hover:text-white hover:bg-zinc-800" -->
                                    <a href="{{ route('user.index') }}"
                                       class="{{ request()->routeIs('user.index') ? 'bg-zinc-800 text-white' : 'text-zinc-200 hover:text-white hover:bg-zinc-800' }}  group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold">
                                       <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                    </svg>User Management
                                    </a>
                                </li>
                                @endif
                                
                                <div x-data="{ level: false }">
                                    <li>
                                        <a href="#" class="text-zinc-200 hover:text-white hover:bg-zinc-800 group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold"  @click="level = !level">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" /></svg>
                                            Product Management 
                                                <svg x-show="!level" class="h-6 w-6 flex-shrink-0 text-zinc-200 group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                                                <svg x-show="level" class="h-6 w-6 flex-shrink-0 text-zinc-200 group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/> 
                                                </svg>
                                        </a>
                                    </li>

                                    @if (request()->routeIs('product.index') || request()->routeIs('category.index') || request()->routeIs('product-in.index') || request()->routeIs('product-out.index'))
                                    <div x-show="!level" class="text-left text-sm mt-2 w-4/5 mx-auto text-gray-200 font-bold ml-2" id="submenu1">
                                        @else
                                        <div x-show="level" class="text-left text-sm mt-2 w-4/5 mx-auto text-gray-200 font-bold ml-2" id="submenu1">
                                            @endif
                                    @if($isAdmin != null | $isMaster != null)
                                    <div class="mt-2">
                                        <li>
                                            <a href="{{ route('product.index') }}" 
                                            class="{{ request()->routeIs('product.index') ? 'bg-zinc-800 text-white' : 'text-zinc-200 hover:text-white hover:bg-zinc-800' }}  group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold"> 
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                            </svg>
                                            Products
                                            </a>
                                        </li>
                                    </div>
                                    <div class="mt-2">
                                        <li>
                                            <a href="{{ route('category.index') }}" 
                                            class="{{ request()->routeIs('category.index') ? 'bg-zinc-800 text-white' : 'text-zinc-200 hover:text-white hover:bg-zinc-800' }}  group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold"> 
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z" />
                                        </svg> Product Categories
                                            </a>
                                        </li>
                                    </div>
                                    @endif
                                    @if($isAdmin == null)
                                    <div class="mt-2">
                                        <li>
                                            <a href="{{ route('product-in.index') }}" 
                                            class="{{ request()->routeIs('product-in.index') ? 'bg-zinc-800 text-white' : 'text-zinc-200 hover:text-white hover:bg-zinc-800' }}  group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold"> 
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
                                            </svg>Product Ins
                                            </a>
                                        </li>
                                    </div>
                                    <div class="mt-2">
                                        <li>
                                            <a href="{{ route('product-out.index') }}" 
                                            class="{{ request()->routeIs('product-out.index') ? 'bg-zinc-800 text-white' : 'text-zinc-200 hover:text-white hover:bg-zinc-800' }}  group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold"> 
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                                                </svg>Product Outs
                                            </a>
                                        </li>
                                    </div>
                                    @endif

                                    </div>
                                </div>
                                @if($isAdmin != null | $isMaster != null)
                                <li>
                                    <!-- Current: "bg-zinc-800 text-white", Default: "text-zinc-200 hover:text-white hover:bg-zinc-800" -->
                                    <a href="{{ route('supplier.index') }}"
                                       class="{{ request()->routeIs('supplier.index') ? 'bg-zinc-800 text-white' : 'text-zinc-200 hover:text-white hover:bg-zinc-800' }}  group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold">
                                       <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12" />
                                    </svg>Suppliers
                                    </a>
                                </li>
                                @endif
                                <li>
                                    <!-- Current: "bg-zinc-800 text-white", Default: "text-zinc-200 hover:text-white hover:bg-zinc-800" -->
                                    <a href="{{ route('customer.index') }}"
                                       class="{{ request()->routeIs('customer.index') ? 'bg-zinc-800 text-white' : 'text-zinc-200 hover:text-white hover:bg-zinc-800' }}  group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold">
                                       <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12" />
                                    </svg>Customer
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="mt-auto">
                            
                        </li>
                    </ul>
                </nav>
            </div>
        </div>

        <!-- nav-bar section -->
        <div class="lg:pl-72">
            <div
                class="sticky top-0 z-40 flex h-16 shrink-0 items-center gap-x-4 border-b border-gray-200 bg-white px-4 shadow-sm sm:gap-x-6 sm:px-6 lg:px-8">
                <button type="button" class="-m-2.5 p-2.5 text-gray-800 lg:hidden" @click="open = true">
                    <span class="sr-only">Open sidebar</span>
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                         aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/>
                    </svg>
                </button>

                <!-- Separator -->
                <div class="h-6 w-px bg-gray-900/10 lg:hidden" aria-hidden="true"></div>

                <div class="flex flex-1 gap-x-4 self-stretch lg:gap-x-6">
                    <form class="relative flex flex-1" action="#" method="GET" style="opacity:0;">
                        <label for="search-field" class="sr-only">Search</label>
                        <svg class="pointer-events-none absolute inset-y-0 left-0 h-full w-5 text-gray-400"
                             viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd"
                                  d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z"
                                  clip-rule="evenodd"/>
                        </svg>
                        <input id="search-field"
                               class="block h-full w-full border-0 py-0 pl-8 pr-0 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm"
                               placeholder="Search..." type="search" name="search" disabled>
                    </form>
                    <div class="flex items-center gap-x-4 lg:gap-x-6">
                        <!-- <button type="button" class="-m-2.5 p-2.5 text-gray-400 hover:text-gray-500">
                          <span class="sr-only">View notifications</span>
                          <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                          </svg>
                        </button> -->

                        <!-- Separator -->
                        <!-- <div class="hidden lg:block lg:h-6 lg:w-px lg:bg-gray-900/10" aria-hidden="true"></div> -->

                        <!-- Profile dropdown -->
                        @if ($username != '')
                            <div x-data="{ dropdown: false }" @keydown.window.escape="dropdown = false"
                                 @click.away="dropdown = false" class="relative">
                                <button type="button" class="-m-1.5 flex items-center p-1.5" id="user-menu-button"
                                        aria-expanded="false" aria-haspopup="true" @click="dropdown = !dropdown">
                                    <span class="sr-only">Open user menu</span>
                                    <!-- <img class="h-8 w-8 rounded-full bg-gray-50 lg:hidden sm:hidden"
                                         src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                         alt=""> -->
                                         <svg class="h-8 w-8 rounded-full bg-gray-50 lg:hidden sm:hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" >
                                         <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>

                                    <span class="hidden lg:flex lg:items-center">
                <span class="ml-4 text-sm font-semibold leading-6 text-gray-900"
                      aria-hidden="true">Hi, {{$username}}</span>
                <svg class="ml-2 h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                  <path fill-rule="evenodd"
                        d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                        clip-rule="evenodd"/>
                </svg>
              </span>
                                </button>

                                <!--
                                  Dropdown menu, show/hide based on menu state.

                                  Entering: "transition ease-out duration-100"
                                    From: "transform opacity-0 scale-95"
                                    To: "transform opacity-100 scale-100"
                                  Leaving: "transition ease-in duration-75"
                                    From: "transform opacity-100 scale-100"
                                    To: "transform opacity-0 scale-95"
                                -->
                                <template x-if="true">
                                    <div x-show="dropdown" x-transition:enter="transition ease-out duration-100"
                                         x-transition:enter-start="transform opacity-0 scale-95"
                                         x-transition:enter-end="transform opacity-100 scale-100"
                                         x-transition:leave="transition ease-in duration-75"
                                         x-transition:leave-start="transform opacity-100 scale-100"
                                         x-transition:leave-end="transform opacity-0 scale-95"
                                         class="absolute right-0 z-10 mt-2.5 w-32 origin-top-right rounded-md bg-white py-2 shadow-lg ring-1 ring-gray-900/5 focus:outline-none"
                                         role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button"
                                         tabindex="-1">
                                        <!-- Active: "bg-gray-50", Not Active: "" -->
                                        <!-- <a href="#" class="block px-3 py-1 text-sm leading-6 text-gray-900" role="menuitem" tabindex="-1" id="user-menu-item-0">Your profile</a> -->
                                        <a href="{{ route('user.logout') }}"
                                           class="block px-3 py-1 text-sm leading-6 text-gray-900" role="menuitem"
                                           tabindex="-1" id="user-menu-item-1">Sign out</a>
                                    </div>
                                </template>
                            </div>

                        @else
                            <a href="/login-web"
                               class="p-2 font-bold text-sm leading-6 text-gray-900 hover:text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-800">Login
                                / Register</a>
                        @endif

                    </div>
                </div>
            </div>
            <main class="py-10">
                <div class="px-4 sm:px-6 lg:px-8">
                    @yield('primary-content')
                </div>
            </main>
            <footer class="bg-white">
                <div class="mx-auto max-w-7xl px-6 py-12  flex items-center justify-center text-center lg:px-8">
                    <!-- <div class="flex justify-center space-x-6 md:order-2">
                      <a href="#" class="text-gray-400 hover:text-gray-500">
                        <span class="sr-only">Facebook</span>
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                          <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" />
                        </svg>
                      </a>
                      <a href="#" class="text-gray-400 hover:text-gray-500">
                        <span class="sr-only">Instagram</span>
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                          <path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd" />
                        </svg>
                      </a>
                      <a href="#" class="text-gray-400 hover:text-gray-500">
                        <span class="sr-only">Twitter</span>
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                          <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" />
                        </svg>
                      </a>
                      <a href="#" class="text-gray-400 hover:text-gray-500">
                        <span class="sr-only">GitHub</span>
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                          <path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd" />
                        </svg>
                      </a>
                      <a href="#" class="text-gray-400 hover:text-gray-500">
                        <span class="sr-only">YouTube</span>
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                          <path fill-rule="evenodd" d="M19.812 5.418c.861.23 1.538.907 1.768 1.768C21.998 8.746 22 12 22 12s0 3.255-.418 4.814a2.504 2.504 0 0 1-1.768 1.768c-1.56.419-7.814.419-7.814.419s-6.255 0-7.814-.419a2.505 2.505 0 0 1-1.768-1.768C2 15.255 2 12 2 12s0-3.255.417-4.814a2.507 2.507 0 0 1 1.768-1.768C5.744 5 11.998 5 11.998 5s6.255 0 7.814.418ZM15.194 12 10 15V9l5.194 3Z" clip-rule="evenodd" />
                        </svg>
                      </a>
                    </div> -->
                    <div class="mt-8 md:order-1 md:mt-0">
                        <p class="text-center text-xs leading-5 text-gray-500">&copy; {{ date('Y') }} Product Management, Inc. All rights
                            reserved.</p>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    </div>


@endsection
