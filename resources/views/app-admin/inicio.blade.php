@extends('app-admin.vista_admin')

@section('title', 'Tienda de Teclados Gaming')

@section('contentAdmin')

<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-2xl font-semibold">Overview</h1>
        <p class="text-gray-500">Welcome back, Alex</p>
    </div>
    <button class="bg-purple-600 text-white px-4 py-2 rounded-md flex items-center space-x-2">
        <span>+ New Project</span>
    </button>
</div>

<!-- Stats Grid -->
<div class="grid grid-cols-4 gap-6 mb-6">
    <div class="bg-zinc-800/50 border border-zinc-700 rounded-md p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-gray-400">Total Revenue</h3>
            <i data-feather="dollar-sign" class="text-purple-500"></i>
        </div>
        <div class="text-2xl font-bold">$84,254</div>
        <div class="text-green-500 text-sm">+7.2%</div>
    </div>
    <div class="bg-zinc-800/50 border border-zinc-700 rounded-md p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-gray-400">Active Orders</h3>
            <i data-feather="shopping-cart" class="text-purple-500"></i>
        </div>
        <div class="text-2xl font-bold">1,483</div>
        <div class="text-green-500 text-sm">+10.2%</div>
    </div>
    <div class="bg-zinc-800/50 border border-zinc-700 rounded-md p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-gray-400">Active Users</h3>
            <i data-feather="users" class="text-purple-500"></i>
        </div>
        <div class="text-2xl font-bold">15,073</div>
        <div class="text-green-500 text-sm">+8.1%</div>
    </div>
    <div class="bg-zinc-800/50 border border-zinc-700 rounded-md p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-gray-400">Conversion Rate</h3>
            <i data-feather="trending-up" class="text-purple-500"></i>
        </div>
        <div class="text-2xl font-bold">4.5%</div>
        <div class="text-green-500 text-sm">+1.2%</div>
    </div>
</div>

<!-- Recent Orders -->
<div class="bg-zinc-800/50 border border-zinc-700 rounded-md p-6 mb-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-semibold">Recent Orders</h2>
        <a href="#" class="text-purple-500 text-sm">View all</a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="text-gray-400 text-left">
                    <th class="pb-4">Order ID</th>
                    <th class="pb-4">Customer</th>
                    <th class="pb-4">Product</th>
                    <th class="pb-4">Status</th>
                    <th class="pb-4">Amount</th>
                </tr>
            </thead>
            <tbody>
                <tr class="border-t border-zinc-700">
                    <td class="py-4">#ORD-7283</td>
                    <td class="flex items-center space-x-2 py-4">
                        <img src="/api/placeholder/24/24" class="rounded-full" alt="Sarah">
                        <span>Sarah Wilson</span>
                    </td>
                    <td>Nike Air Max</td>
                    <td><span class="px-2 py-1 rounded text-xs bg-purple-600">Processing</span></td>
                    <td>$259.00</td>
                </tr>
                <tr class="border-t border-zinc-700">
                    <td class="py-4">#ORD-7284</td>
                    <td class="flex items-center space-x-2 py-4">
                        <img src="/api/placeholder/24/24" class="rounded-full" alt="Mike">
                        <span>Mike Johnson</span>
                    </td>
                    <td>MacBook Pro</td>
                    <td><span class="px-2 py-1 rounded text-xs bg-emerald-600">Complete</span></td>
                    <td>$1,999.00</td>
                </tr>
                <tr class="border-t border-zinc-700">
                    <td class="py-4">#ORD-7285</td>
                    <td class="flex items-center space-x-2 py-4">
                        <img src="/api/placeholder/24/24" class="rounded-full" alt="Emma">
                        <span>Emma Davis</span>
                    </td>
                    <td>iPhone 15 Pro</td>
                    <td><span class="px-2 py-1 rounded text-xs bg-amber-600">Pending</span></td>
                    <td>$1,199.00</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- Top Products -->
<div class="bg-zinc-800/50 border border-zinc-700 rounded-md p-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-semibold">Top Products</h2>
        <a href="#" class="text-purple-500 text-sm">View all</a>
    </div>
    <div class="grid grid-cols-3 gap-6">
        <div class="bg-zinc-800 border border-zinc-700 rounded-md p-4">
            <div class="flex items-center space-x-4">
                <div class="bg-zinc-700 p-3 rounded-md">
                    <i data-feather="box" class="text-purple-500"></i>
                </div>
                <div>
                    <h3 class="font-semibold">Gaming Mouse Pro</h3>
                    <p class="text-gray-400">$89.00</p>
                    <p class="text-green-500 text-sm">325 sold</p>
                </div>
            </div>
        </div>
        <div class="bg-zinc-800 border border-zinc-700 rounded-md p-4">
            <div class="flex items-center space-x-4">
                <div class="bg-zinc-700 p-3 rounded-md">
                    <i data-feather="monitor" class="text-purple-500"></i>
                </div>
                <div>
                    <h3 class="font-semibold">Mechanical Keyboard</h3>
                    <p class="text-gray-400">$159.00</p>
                    <p class="text-green-500 text-sm">256 sold</p>
                </div>
            </div>
        </div>
        <div class="bg-zinc-800 border border-zinc-700 rounded-md p-4">
            <div class="flex items-center space-x-4">
                <div class="bg-zinc-700 p-3 rounded-md">
                    <i data-feather="headphones" class="text-purple-500"></i>
                </div>
                <div>
                    <h3 class="font-semibold">Pro Gaming Headset</h3>
                    <p class="text-gray-400">$129.00</p>
                    <p class="text-green-500 text-sm">198 sold</p>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection