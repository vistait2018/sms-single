<x-app-layout>


    <div class="max-w-md w-1/2 m-auto bg-white text-gray-400 dark:bg-gray-900 rounded-2xl shadow-lg p-8 text-center">
        <!-- Icon -->
        <div class="text-6xl text-red-500 mb-4">📡</div>

        <!-- Heading -->
        <h1 class="text-2xl font-bold mb-2">Service Not Available</h1>

        <!-- Error Message -->
        <p class="text-gray-600 mb-6">
            The service is temporarily unavailable because there is<br>
            <strong>no internet connection</strong>. Please check your network and try again.
        </p>

        <!-- Retry Button -->
        <div class="flex justify-center space-x-3">
            <a href="{{ url()->previous() }}"
               class="px-5 py-2 rounded-lg flex gap-2 bg-blue-600 text-white hover:bg-purple-700 transition">
               <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M14.25 9.75 16.5 12l-2.25 2.25m-4.5 0L7.5 12l2.25-2.25M6 20.25h12A2.25 2.25 0 0 0 20.25 18V6A2.25 2.25 0 0 0 18 3.75H6A2.25 2.25 0 0 0 3.75 6v12A2.25 2.25 0 0 0 6 20.25Z" />
</svg>
 Retry
            </a>
            <a href="{{ url('/') }}"
               class="px-5 flex gap-3 py-2 rounded-lg bg-gray-300 text-gray-800 hover:bg-gray-400 transition">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 21v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21m0 0h4.5V3.545M12.75 21h7.5V10.75M2.25 21h1.5m18 0h-18M2.25 9l4.5-1.636M18.75 3l-1.5.545m0 6.205 3 1m1.5.5-1.5-.5M6.75 7.364V3h-3v18m3-13.636 10.5-3.819" />
</svg> Home

            </a>
        </div>
  
</x-app-layout>