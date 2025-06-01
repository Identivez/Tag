{{-- resources/views/test-flowbite.blade.php --}}
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Test Flowbite</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="p-8">

  <h1 class="text-2xl font-bold mb-4">Prueba Flowbite</h1>

  {{-- Dropdown de Flowbite --}}
  <div class="relative inline-block text-left">
    <button id="dropdownButton"
            data-dropdown-toggle="dropdownMenu"
            class="inline-flex justify-center w-full px-4 py-2 bg-blue-600 text-white font-medium rounded-md hover:bg-blue-700">
      Abrir menú
      <svg class="w-5 h-5 ml-2" fill="currentColor" viewBox="0 0 20 20">
        <path d="M5.23 7.21a.75.75 0 011.06-.02L10 10.586l3.71-3.38a.75.75 0 111.04 1.08l-4.25 3.88a.75.75 0 01-1.04 0l-4.25-3.88a.75.75 0 01-.02-1.06z"/>
      </svg>
    </button>

    <div id="dropdownMenu"
         class="hidden z-10 w-44 bg-white rounded shadow mt-2">
      <ul class="py-1 text-sm text-gray-700">
        <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Opción 1</a></li>
        <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Opción 2</a></li>
        <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Opción 3</a></li>
      </ul>
    </div>
  </div>

</body>
</html>
