<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">


<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    {{-- <meta name="csrf-token" content="{{ csrf_token() }}"> --}}

    <title>{{ $title ?? 'EDUCO-SMS' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <script>
        tailwind.config = { darkMode: 'class' }
    </script>
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
    <!-- Navbar -->
    <livewire:fragment.nav />

    <!-- Sidebar + Content -->
    <div class="flex pt-16">
        <!-- Sidebar -->
        <livewire:fragment.sidebar />

        <!-- Main content -->
        <main id="mainContent" class="flex-1 p-6 ml-0 lg:ml-64 w-full transition-all duration-300">
            <div class="min-h-[350px]">
                @if (isset($header))
                <h1 class="text-2xl font-bold mb-6 inline">{{ $header }}</h1>
                @endif
                {{ $slot }}
            </div>

            <!-- Footer -->

            <livewire:fragment.footer />
        </main>
    </div>

    <!-- JS -->
    <script>
        const hamburgerBtn = document.getElementById('hamburgerBtn');
    const sidebar = document.getElementById('sidebar');

    hamburgerBtn.addEventListener('click', () => {
      sidebar.classList.toggle('-translate-x-full');
    });

    document.getElementById('darkModeToggle').addEventListener('click', () => {
      document.documentElement.classList.toggle('dark');
    });

    document.getElementById('avatarBtn').addEventListener('click', () => {
      document.getElementById('avatarMenu').classList.toggle('hidden');
    });
    </script>
 <!-- Chart.js -->
   <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('genderChart').getContext('2d');
    new Chart(ctx, {
      type: 'bar',
      data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
          'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        datasets: [
          {
            label: 'Male',
            data: [120, 150, 180, 170, 200, 220, 190, 210, 230, 240, 250, 260],
            backgroundColor: 'rgba(59, 130, 246, 0.7)',
          },
          {
            label: 'Female',
            data: [100, 130, 160, 140, 190, 210, 180, 200, 220, 230, 240, 250],
            backgroundColor: 'rgba(236, 72, 153, 0.7)',
          }
        ]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
          y: {
            beginAtZero: true,
            grid: { color: 'rgba(107,114,128,0.2)' }
          },
          x: { grid: { display: false } }
        },
        plugins: {
          legend: {
            labels: {
              color: document.documentElement.classList.contains('dark') ? '#f9fafb' : '#111827'
            }
          }
        }
      }
    });
    </script>



</body>

</html>
