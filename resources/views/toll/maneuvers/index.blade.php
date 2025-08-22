<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Panel Caseta - {{ config('app.name') }}</title>
    <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}" type="image/x-icon">
    <link rel="icon" href="{{ asset('images/favicon.ico') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('css/all.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <style>
    /* Animación para el modal */
    .fade-enter-active, .fade-leave-active {
        transition: opacity 0.3s ease;
    }
    .fade-enter, .fade-leave-to {
        opacity: 0;
    }
    
    /* Estilo para la tabla */
    table tbody tr {
        transition: background-color 0.2s ease;
    }
    table tbody tr:hover {
        background-color: rgba(59, 130, 246, 0.05);
    }
    /* Animaciones para el visor */
        .image-viewer-enter {
            opacity: 0;
            transform: scale(0.95);
        }
        .image-viewer-enter-active {
            opacity: 1;
            transform: scale(1);
            transition: opacity 300ms, transform 300ms;
        }
        .image-viewer-exit {
            opacity: 1;
            transform: scale(1);
        }
        .image-viewer-exit-active {
            opacity: 0;
            transform: scale(0.95);
            transition: opacity 300ms, transform 300ms;
        }
        
        /* Clase para las imágenes clickeables */
        .previewable-image {
            cursor: zoom-in;
            transition: transform 0.2s ease;
        }
        .previewable-image:hover {
            transform: scale(1.02);
        }
</style>
</head>

<body class="min-h-screen w-full flex flex-col">
    <nav class="w-full p-4 bg-app-darkblue shadow flex justify-between items-center">
        <p>
            <span class="text-white">{{date('l, F j, Y')}}</span>
            <br>
            <span id="clock" class="text-white"></span>
        </p>
        <img src="{{ asset("/images/logo.png")}}" alt="Acoman Logo" class="h-12">
        <div>
            <button id="dropdownDefaultButton" data-dropdown-toggle="dropdown" class="text-white focus:ring-4 focus:outline-none  font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center" type="button">{{ auth()->user()->name}} <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                </svg>
            </button>
            <div id="dropdown" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44 dark:bg-gray-700">
    <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDefaultButton">
      <li>
        <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Perfil</a>
      </li>
      <li>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            @method('POST')
            <button type="submit" class="block text-left px-4 py-2 w-full text-red-500">Cerrar sesión</button>
        </form>
      </li>
    </ul>
</div>
        </div>
    </nav>
    <main class="grow bg-white p-8">
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="">
                <livewire:toll.toll-maneuvers-table /> 
            </div>
        </div>
    </main>
    <!-- Visor de imagen a pantalla completa -->
<div id="imageViewer" class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-90 p-4">
    <div class="relative w-full h-full flex items-center justify-center">
        <!-- Botón de cerrar -->
        <button id="closeViewer" class="absolute top-4 right-4 text-white hover:text-gray-300 focus:outline-none">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
        
        <!-- Controles de navegación -->
        <button id="prevImage" class="absolute left-4 text-white hover:text-gray-300 focus:outline-none">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
        </button>
        
        <button id="nextImage" class="absolute right-4 text-white hover:text-gray-300 focus:outline-none">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </button>
        
        <!-- Imagen ampliada -->
        <img id="viewerImage" class="max-w-full max-h-full object-contain" src="" alt="">
        
        <!-- Indicador de imagen (ej. 1/3) -->
        <div id="imageCounter" class="absolute bottom-4 left-1/2 transform -translate-x-1/2 bg-black bg-opacity-50 text-white px-3 py-1 rounded-full text-sm"></div>
    </div>
</div>
@livewireScripts
    <!-- Elfsight WhatsApp Chat | Untitled WhatsApp Chat -->
    <script src="{{ asset('/js/flowbite.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('showToast', message => {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: message,
                    showConfirmButton: false,
                    timer: 3000
                });
            });

            Livewire.on('alert', (event) => {
                Swal.fire({
                    title: event[0].title,
                    text: event[0].text,
                    icon: event[0].type,
                    confirmButtonText: 'Aceptar',
                    confirmButtonColor: 'rgb(11, 85, 139)',
                });
            });
        });
        document.addEventListener('DOMContentLoaded', function() {

            var loader ='<span class="loading loading-spinner loading-lg"></span>';
            var file_icon = "<i class='fa-regular fa-file'></i>";

            

            const previewableImages = document.querySelectorAll('.previewable-image');
            const viewer = document.getElementById('imageViewer');
            const viewerImage = document.getElementById('viewerImage');
            const closeViewer = document.getElementById('closeViewer');
            const prevButton = document.getElementById('prevImage');
            const nextButton = document.getElementById('nextImage');
            const imageCounter = document.getElementById('imageCounter');
            
            let currentImageIndex = 0;
            let imagesArray = [];
            
            // Crear array solo con las imágenes clickeables
            previewableImages.forEach((img, index) => {
                imagesArray.push({
                    src: img.src,
                    alt: img.alt
                });
                
                // Agregar evento click a cada imagen
                img.addEventListener('click', () => {
                    currentImageIndex = index;
                    openViewer();
                });
            });
            
            // Función para abrir el visor
            function openViewer() {
                console.table(imagesArray);
                if (imagesArray.length === 0) return;
                
                viewerImage.src = imagesArray[currentImageIndex].src;
                viewerImage.alt = imagesArray[currentImageIndex].alt;
                updateCounter();
                viewer.classList.remove('hidden');
                document.body.style.overflow = 'hidden'; // Evitar scroll del body
                
                // Agregar transición
                viewer.style.opacity = '0';
                setTimeout(() => {
                    viewer.style.opacity = '1';
                    viewer.style.transition = 'opacity 300ms ease';
                }, 10);
            }
            
            // Función para cerrar el visor
            function closeViewerFunc() {
                viewer.style.opacity = '0';
                setTimeout(() => {
                    viewer.classList.add('hidden');
                    document.body.style.overflow = '';
                }, 300);
            }
            
            // Función para actualizar el contador
            function updateCounter() {
                imageCounter.textContent = `${currentImageIndex + 1}/${imagesArray.length}`;
            }
            
            // Función para navegar entre imágenes
            function navigate(direction) {
                if (direction === 'prev') {
                    currentImageIndex = (currentImageIndex - 1 + imagesArray.length) % imagesArray.length;
                } else {
                    currentImageIndex = (currentImageIndex + 1) % imagesArray.length;
                }
                
                viewerImage.src = imagesArray[currentImageIndex].src;
                viewerImage.alt = imagesArray[currentImageIndex].alt;
                updateCounter();
            }
            
            // Event listeners
            closeViewer.addEventListener('click', closeViewerFunc);
            prevButton.addEventListener('click', () => navigate('prev'));
            nextButton.addEventListener('click', () => navigate('next'));
            
            // Cerrar con ESC
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') {
                    closeViewerFunc();
                } else if (e.key === 'ArrowLeft') {
                    navigate('prev');
                } else if (e.key === 'ArrowRight') {
                    navigate('next');
                }
            });
            
            // Cerrar haciendo clic fuera de la imagen
            viewer.addEventListener('click', (e) => {
                if (e.target === viewer) {
                    closeViewerFunc();
                }
            });

            function updateClock() {
                var currentTime = new Date();
                var currentHours = currentTime.getHours();
                var currentMinutes = currentTime.getMinutes();
                var currentSeconds = currentTime.getSeconds();

                currentMinutes = (currentMinutes < 10 ? "0" : "") + currentMinutes;
                currentSeconds = (currentSeconds < 10 ? "0" : "") + currentSeconds;

                var timeOfDay = (currentHours < 12) ? "AM" : "PM";
                currentHours = (currentHours > 12) ? currentHours - 12 : currentHours;
                currentHours = (currentHours == 0) ? 12 : currentHours;

                var currentTimeString = currentHours + ":" + currentMinutes + ":" + currentSeconds + " " + timeOfDay;
                document.getElementById("clock").innerHTML = currentTimeString;
            }

            setInterval(updateClock, 1000);
        });
    </script>
</body>

</html>