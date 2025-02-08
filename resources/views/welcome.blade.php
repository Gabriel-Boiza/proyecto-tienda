<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechAdmin Dashboard</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.29.0/feather.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background-color: #0A0A0A;
        }
        .sidebar {
            background-color: #0A0A0A;
            border-right: 1px solid #1A1A1A;
        }
        .card {
            background-color: #111111;
            border: 1px solid #1A1A1A;
        }
        .product-card {
            background-color: #0A0A0A;
            border: 1px solid #1A1A1A;
        }
        .status-processing { background-color: #8B5CF6; }
        .status-complete { background-color: #10B981; }
        .status-pending { background-color: #F59E0B; }
    </style>
</head>
<body class="text-gray-200">
    <!-- Previous code remains the same until Recent Orders section -->
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="sidebar w-64 p-6">
            <div class="text-xl font-bold text-purple-500 mb-8">Dashboard</div>
            <nav class="space-y-4">
                <a href="#" class="flex items-center space-x-2 text-purple-500">
                    <i data-feather="home"></i>
                    <span>Dashboard</span>
                </a>
                <a href='{{route("productos.index")}}' class="flex items-center space-x-2 text-gray-500 hover:text-gray-300">
                    <i data-feather="box"></i>
                    <span>Productos</span>
                </a>
                <a href='{{route("categorias.create")}}' class="flex items-center space-x-2 text-gray-500 hover:text-gray-300">
                    <i data-feather="box"></i>
                    <span>Categorias</span>
                </a>
                <a href="#" class="flex items-center space-x-2 text-gray-500 hover:text-gray-300">
                    <i data-feather="shopping-cart"></i>
                    <span>Orders</span>
                </a>
                <a href="#" class="flex items-center space-x-2 text-gray-500 hover:text-gray-300">
                    <i data-feather="users"></i>
                    <span>Customers</span>
                </a>
                <a href="#" class="flex items-center space-x-2 text-gray-500 hover:text-gray-300">
                    <i data-feather="bar-chart-2"></i>
                    <span>Analytics</span>
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-6">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h1 class="text-2xl font-semibold">Overview</h1>
                    <p class="text-gray-500">Welcome back, Alex</p>
                </div>
                <button class="bg-purple-600 text-white px-4 py-2 rounded-lg flex items-center space-x-2">
                    <span>+ New Project</span>
                </button>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-4 gap-6 mb-6">
                <div class="card rounded-lg p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-gray-400">Total Revenue</h3>
                        <i data-feather="dollar-sign" class="text-purple-500"></i>
                    </div>
                    <div class="text-2xl font-bold">$84,254</div>
                    <div class="text-green-500 text-sm">+7.2%</div>
                </div>
                <div class="card rounded-lg p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-gray-400">Active Orders</h3>
                        <i data-feather="shopping-cart" class="text-purple-500"></i>
                    </div>
                    <div class="text-2xl font-bold">1,483</div>
                    <div class="text-green-500 text-sm">+10.2%</div>
                </div>
                <div class="card rounded-lg p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-gray-400">Active Users</h3>
                        <i data-feather="users" class="text-purple-500"></i>
                    </div>
                    <div class="text-2xl font-bold">15,073</div>
                    <div class="text-green-500 text-sm">+8.1%</div>
                </div>
                <div class="card rounded-lg p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-gray-400">Conversion Rate</h3>
                        <i data-feather="trending-up" class="text-purple-500"></i>
                    </div>
                    <div class="text-2xl font-bold">4.5%</div>
                    <div class="text-green-500 text-sm">+1.2%</div>
                </div>
            </div>

            <!-- Recent Orders -->
            <div class="card rounded-lg p-6 mb-6">
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
                            <tr class="border-t border-gray-800">
                                <td class="py-4">#ORD-7283</td>
                                <td class="flex items-center space-x-2 py-4">
                                    <img src="/api/placeholder/24/24" class="rounded-full" alt="Sarah">
                                    <span>Sarah Wilson</span>
                                </td>
                                <td>Nike Air Max</td>
                                <td><span class="px-2 py-1 rounded text-xs status-processing">Processing</span></td>
                                <td>$259.00</td>
                            </tr>
                            <tr class="border-t border-gray-800">
                                <td class="py-4">#ORD-7284</td>
                                <td class="flex items-center space-x-2 py-4">
                                    <img src="/api/placeholder/24/24" class="rounded-full" alt="Mike">
                                    <span>Mike Johnson</span>
                                </td>
                                <td>MacBook Pro</td>
                                <td><span class="px-2 py-1 rounded text-xs status-complete">Complete</span></td>
                                <td>$1,999.00</td>
                            </tr>
                            <tr class="border-t border-gray-800">
                                <td class="py-4">#ORD-7285</td>
                                <td class="flex items-center space-x-2 py-4">
                                    <img src="/api/placeholder/24/24" class="rounded-full" alt="Emma">
                                    <span>Emma Davis</span>
                                </td>
                                <td>iPhone 15 Pro</td>
                                <td><span class="px-2 py-1 rounded text-xs status-pending">Pending</span></td>
                                <td>$1,199.00</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Top Products -->
            <div class="card rounded-lg p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-semibold">Top Products</h2>
                    <a href="#" class="text-purple-500 text-sm">View all</a>
                </div>
                <div class="grid grid-cols-3 gap-6">
                    <div class="product-card rounded-lg p-4">
                        <div class="flex items-center space-x-4">
                            <div class="bg-gray-800 p-3 rounded-lg">
                                <i data-feather="box" class="text-purple-500"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold">Gaming Mouse Pro</h3>
                                <p class="text-gray-400">$89.00</p>
                                <p class="text-green-500 text-sm">325 sold</p>
                            </div>
                        </div>
                    </div>
                    <div class="product-card rounded-lg p-4">
                        <div class="flex items-center space-x-4">
                            <div class="bg-gray-800 p-3 rounded-lg">
                                <i data-feather="monitor" class="text-purple-500"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold">Mechanical Keyboard</h3>
                                <p class="text-gray-400">$159.00</p>
                                <p class="text-green-500 text-sm">256 sold</p>
                            </div>
                        </div>
                    </div>
                    <div class="product-card rounded-lg p-4">
                        <div class="flex items-center space-x-4">
                            <div class="bg-gray-800 p-3 rounded-lg">
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
        </main>
    </div>

    <script>
        // Initialize Feather Icons
        document.addEventListener('DOMContentLoaded', function() {
            feather.replace();
        });
    </script>
</body>
</html>