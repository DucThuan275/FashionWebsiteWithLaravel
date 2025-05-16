<x-layout-admin>
    <x-slot:title>
        Dashboard
    </x-slot:title>

    <div class="p-6">
        <!-- Welcome Section -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Welcome to Admin Dashboard</h1>
            <p class="mt-2 text-gray-600">Raising tomorrow's leaders.</p>
        </div>

        <!-- Quick Stats -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition duration-300">
                <div class="text-gray-500">Total Users</div>
                <div class="text-2xl font-bold text-gray-800">1,234</div>
                <div class="text-sm text-green-500">+5.2% from last month</div>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition duration-300">
                <div class="text-gray-500">Total Revenue</div>
                <div class="text-2xl font-bold text-gray-800">$12,345</div>
                <div class="text-sm text-red-500">-2.3% from last month</div>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition duration-300">
                <div class="text-gray-500">Active Projects</div>
                <div class="text-2xl font-bold text-gray-800">45</div>
                <div class="text-sm text-green-500">+10.1% from last month</div>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition duration-300">
                <div class="text-gray-500">Pending Tasks</div>
                <div class="text-2xl font-bold text-gray-800">12</div>
                <div class="text-sm text-red-500">-3.4% from last month</div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Revenue Overview</h2>
                <canvas id="revenueChart"></canvas>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-xl font-bold text-gray-800 mb-4">User Activity</h2>
                <canvas id="userActivityChart"></canvas>
            </div>
        </div>

        <!-- Recent Activities -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Recent Activities</h2>
            <div class="space-y-4">
                <div class="flex items-center space-x-4">
                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-gray-800">New user registered: <span class="font-bold">John Doe</span></p>
                        <p class="text-sm text-gray-500">2 hours ago</p>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-gray-800">Project <span class="font-bold">Website Redesign</span> completed</p>
                        <p class="text-sm text-gray-500">5 hours ago</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-layout-admin>

<!-- Chart.js for Charts -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Revenue Chart
    const revenueCtx = document.getElementById('revenueChart').getContext('2d');
    new Chart(revenueCtx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            datasets: [{
                label: 'Revenue',
                data: [5000, 7000, 9000, 12000, 15000, 18000],
                borderColor: '#3b82f6',
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });

    // User Activity Chart
    const userActivityCtx = document.getElementById('userActivityChart').getContext('2d');
    new Chart(userActivityCtx, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            datasets: [{
                label: 'Active Users',
                data: [200, 400, 600, 800, 1000, 1200],
                backgroundColor: '#10b981',
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
</script>
