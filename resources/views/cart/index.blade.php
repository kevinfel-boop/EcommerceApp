@extends('layouts.boutique')
@section('content')
<!-- Include this script tag or install `@tailwindplus/elements` via npm: -->
<!-- <script src="https://cdn.jsdelivr.net/npm/@tailwindplus/elements@1" type="module"></script> -->
<div class="flex h-full flex-col overflow-y-auto bg-white shadow-xl">
    <div class="flex-1 overflow-y-auto px-4 py-6 sm:px-6">
      <div class="flex items-start justify-between">
        <h2 id="drawer-title" class="text-lg font-medium text-gray-900">Shopping cart</h2>
        <div class="ml-3 flex h-7 items-center">
          <button type="button" command="close" commandfor="drawer" class="relative -m-2 p-2 text-gray-400 hover:text-gray-500">
            <span class="absolute -inset-0.5"></span>
            <span class="sr-only">Close panel</span>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" data-slot="icon" aria-hidden="true" class="size-6">
              <path d="M6 18 18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
          </button>
        </div>
      </div>

      <div class="mt-8">
        <div class="flow-root">
          <ul role="list" class="-my-6 divide-y divide-gray-200">
           
            
            @foreach ($cart->items as $item  )
           
                
            <li class="flex py-6">
                <div class="size-24 shrink-0 overflow-hidden rounded-md border border-gray-200">
                    <img src="https://tailwindcss.com/plus-assets/img/ecommerce-images/shopping-cart-page-04-product-01.jpg" alt="Salmon orange fabric pouch with match zipper, gray zipper pull, and adjustable hip belt." class="size-full object-cover" />
                </div>
                
                <div class="ml-4 flex flex-1 flex-col">
                    <div>
                        <div class="flex justify-between text-base font-medium text-gray-900">
                            <h3>
                                <a href="#">{{$item->product->name}}</a>
                            </h3>
                            <p class="ml-4">{{$item->FormattedPrice}}</p>
                        </div>
                        <p class="mt-1 text-sm text-gray-500">{{$item->product->category->name}}</p>
                    </div>
                    <div class="flex flex-1 items-end justify-between text-sm">
                        <p class="text-gray-500">{{$item->quantity}}</p>
                        
                        <div class="flex">
                            <form action="{{route('cart.remove', $item)}}" method="POST">
                                @method('delete')
                                @csrf
                                <button type="submit" class="font-medium text-indigo-600 hover:text-indigo-500">Remove</button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </li>
            
          </ul>
        </div>
      </div>
    </div>

    <div class="border-t border-gray-200 px-4 py-6 sm:px-6">
      <div class="flex justify-between text-base font-medium text-gray-900">
        <p>Subtotal</p>
        <p>{{$cart->formatted_subtotal}}</p>
      </div>
      <p class="mt-0.5 text-sm text-gray-500">Shipping and taxes calculated at checkout.</p>
      <div class="mt-6">
        <a href="#" class="flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-6 py-3 text-base font-medium text-white shadow-xs hover:bg-indigo-700">Checkout</a>
      </div>
      <div class="mt-6">
    </div>
    <div class="mt-6flex justify-center text-center">
        <form action="{{route('cart.clear')}}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submite" class="flex items-center justify-center rounded-md border border-transparent bg-amber-600 px-6 py-3 text-base font-medium text-white shadow-xs hover:bg-indigo-700">Vider le panier</button>
            
            
        </form>
        
      </div>
        
          <button type="submit" class="rounded-md bg-gray-950/5 px-2.5 py-1.5 text-sm font-semibold text-gray-900 hover:bg-gray-950/10">vider le panier</button>
      <div class="mt-6 flex justify-center text-center text-sm text-gray-500">
        <p>
          or
         
        </p>
      </div>
    </div>
  </div>
<button command="show-modal" commandfor="drawer" class="rounded-md bg-gray-950/5 px-2.5 py-1.5 text-sm font-semibold text-gray-900 hover:bg-gray-950/10">Open drawer</button>
<el-dialog>
  <dialog id="drawer" aria-labelledby="drawer-title" class="fixed inset-0 size-auto max-h-none max-w-none overflow-hidden bg-transparent not-open:hidden backdrop:bg-transparent">
    <el-dialog-backdrop class="absolute inset-0 bg-gray-500/75 transition-opacity duration-500 ease-in-out data-closed:opacity-0"></el-dialog-backdrop>

    <div tabindex="0" class="absolute inset-0 pl-10 focus:outline-none sm:pl-16">
      <el-dialog-panel class="ml-auto block size-full max-w-md transform transition duration-500 ease-in-out data-closed:translate-x-full sm:duration-700">

      </el-dialog-panel>
    </div>
  </dialog>
</el-dialog>

    
@endsection