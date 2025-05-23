@extends('layouts.app')

@section('title', 'Order Confirmed')

@section('header')
    <h1 class="text-3xl font-bold text-gray-900">Order Confirmed</h1>
@endsection

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="text-center">
                        <svg class="mx-auto h-12 w-12 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <h2 class="mt-3 text-lg font-medium text-gray-900">Thank You for Your Order!</h2>
                        <p class="mt-1 text-sm text-gray-500">
                            Your order #{{ $order->order_number }} has been placed successfully.
                        </p>
                    </div>

                    <div class="mt-8">
                        <div class="rounded-md bg-gray-50 px-6 py-5 sm:flex sm:items-start sm:justify-between">
                            <div class="sm:flex sm:items-start">
                                <div>
                                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                                        Order Details
                                    </h3>
                                    <div class="mt-2 max-w-xl text-sm text-gray-500">
                                        <p>
                                            Order Number: #{{ $order->order_number }}
                                        </p>
                                        <p>
                                            Date: {{ $order->created_at->format('F j, Y, g:i a') }}
                                        </p>
                                        <p>
                                            Status: <span class="font-medium text-yellow-500">{{ ucfirst($order->status) }}</span>
                                        </p>
                                        <p>
                                            Payment Method: {{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}
                                        </p>
                                        <p>
                                            Payment Status: <span class="font-medium {{ $order->payment_status == 'paid' ? 'text-green-500' : 'text-yellow-500' }}">{{ ucfirst($order->payment_status) }}</span>
                                        </p>
                                        @if($order->pickup_time)
                                            <p>
                                                Pickup Time: {{ \Carbon\Carbon::parse($order->pickup_time)->format('F j, Y, g:i a') }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4 sm:mt-0 sm:ml-6 sm:flex-shrink-0">
                                <a href="{{ route('orders.print', $order) }}" target="_blank" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <svg class="-ml-1 mr-2 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M5 4v3H4a2 2 0 00-2 2v3a2 2 0 002 2h1v2a2 2 0 002 2h6a2 2 0 002-2v-2h1a2 2 0 002-2V9a2 2 0 00-2-2h-1V4a2 2 0 00-2-2H7a2 2 0 00-2 2zm8 0H7v3h6V4zm0 8H7v4h6v-4z" clip-rule="evenodd" />
                                    </svg>
                                    Print Receipt
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                            Order Summary
                        </h3>
                        <div class="mt-2 border-t border-gray-200">
                            <dl class="divide-y divide-gray-200">
                                @foreach($order->items as $item)
                                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                                        <dt class="text-sm font-medium text-gray-500">
                                            {{ $item->quantity }} x {{ $item->menuItem->name ?? 'Unknown Item' }}
                                        </dt>
                                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                            @if($item->addOns->count() > 0)
                                                <div class="text-xs text-gray-500">
                                                    Add-ons: {{ $item->addOns->pluck('name')->join(', ') }}
                                                </div>
                                            @endif
                                            
                                            @if($item->special_instructions)
                                                <div class="text-xs text-gray-500 mt-1">
                                                    Special Instructions: {{ $item->special_instructions }}
                                                </div>
                                            @endif
                                            
                                            <div class="text-right">
                                                ${{ number_format($item->subtotal, 2) }}
                                            </div>
                                        </dd>
                                    </div>
                                @endforeach
                                
                                <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                                    <dt class="text-sm font-medium text-gray-500">
                                        Subtotal
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2 text-right">
                                        ${{ number_format($order->subtotal, 2) }}
                                    </dd>
                                </div>
                                
                                <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                                    <dt class="text-sm font-medium text-gray-500">
                                        Tax (13%)
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2 text-right">
                                        ${{ number_format($order->tax, 2) }}
                                    </dd>
                                </div>
                                
                                @if($order->delivery_fee > 0)
                                <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                                    <dt class="text-sm font-medium text-gray-500">
                                        Delivery Fee
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2 text-right">
                                        ${{ number_format($order->delivery_fee, 2) }}
                                    </dd>
                                </div>
                                @endif
                                
                                <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                                    <dt class="text-sm font-medium text-gray-900">
                                        Total
                                    </dt>
                                    <dd class="mt-1 text-sm font-bold text-gray-900 sm:mt-0 sm:col-span-2 text-right">
                                        ${{ number_format($order->total, 2) }}
                                    </dd>
                                </div>
                            </dl>
                        </div>
                    </div>

                    <div class="mt-8">
                        <div class="flex justify-center space-x-4">
                            <a href="{{ route('home') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Back to Home
                            </a>
                            <a href="{{ route('menu.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Order Again
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection 