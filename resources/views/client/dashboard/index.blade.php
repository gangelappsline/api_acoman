@extends('layouts.client', ["title" => "Dashboard"])

@section("main")
<div class="grid grid-cols-5 mb-6 gap-4">
    <!--<div class="p-2 rounded-lg bg-white">
        <a href="{{ url('/admin/usuarios')}}" class="flex flex-col items-center gap-6">
            <img src="{{ asset('/images/gente.svg')}}" class="w-24 block mx-auto my-4 scale-x-[-1]" alt="">
        <span class="font-bold text-lg">{{ __("Usuarios")}}</span>
        </a>
    </div>-->
    <div class="p-2 rounded-lg bg-white">
        <a href="{{ url('/admin/usuarios')}}" class="flex flex-col items-center gap-6">
            <img src="{{ asset('/images/camion.svg')}}" class="w-24 block mx-auto my-4" alt="">
        <span class="font-bold text-lg">{{ __("Maniobras")}}</span>
        </a>
    </div>
    <!--<div class="p-4 rounded-lg bg-white">
        <a href="{{ url('/admin/usuarios')}}" class="flex flex-col items-center gap-6">
            <img src="{{ asset('/images/panel.svg')}}" class="w-24 block mx-auto my-4" alt="">
        <span class="font-bold text-lg">{{ __("Monitoréo")}}</span>
        </a>
    </div>-->
    <div class="p-4 rounded-lg bg-white">
        <a href="{{ url('/admin/usuarios')}}" class="flex flex-col items-center gap-6">
            <img src="{{ asset('/images/reporte.svg')}}" class="w-24 block mx-auto my-4" alt="">
        <span class="font-bold text-lg">{{ __("Reportes")}}</span>
        </a>
    </div>
    <div class="p-2 rounded-lg bg-white">
        <a href="{{ url('/admin/usuarios')}}" class="flex flex-col items-center gap-6">
            <img src="{{ asset('/images/herramienta.svg')}}" class="w-24 block mx-auto my-4" alt="">
        <span class="font-bold text-lg">{{ __("Configuración")}}</span>
        </a>
    </div>
</div>
<div class="w-full mt-6 grid grid-cols-12 gap-6">
    <div class="col-span-7 rounded-lg p-4 bg-white shadow-lg">
        <h2 class="text-2xl font-bold mb-6 text-center text-gray-800">Últimos 10 Movimientos de Maniobras</h2>
    <div class="overflow-x-auto">
      <table class="min-w-full table-auto">
        <thead class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
          <tr>
            <th class="py-3 px-6 text-left">Cliente</th>
            <th class="py-3 px-6 text-left">Movimiento</th>
            <th class="py-3 px-6 text-center">Estatus</th>
            <th class="py-3 px-6 text-center">Fecha</th>
          </tr>
        </thead>
        <tbody class="text-gray-700 text-sm divide-y divide-gray-200">
          <!-- Fila de ejemplo -->
          <tr>
            <td class="py-3 px-6 text-left">Logística del Norte</td>
            <td class="py-3 px-6 text-left">Carga de mercancía</td>
            <td class="py-3 px-6 text-center">
              <span class="bg-yellow-100 text-yellow-800 py-1 px-3 rounded-full text-xs">Pendiente</span>
            </td>
            <td class="py-3 px-6 text-center">2025-04-15</td>
          </tr>
          <tr>
            <td class="py-3 px-6 text-left">Transportes Vega</td>
            <td class="py-3 px-6 text-left">Descarga en patio</td>
            <td class="py-3 px-6 text-center">
              <span class="bg-blue-100 text-blue-800 py-1 px-3 rounded-full text-xs">En Caseta</span>
            </td>
            <td class="py-3 px-6 text-center">2025-04-15</td>
          </tr>
          <tr>
            <td class="py-3 px-6 text-left">Grupo Rápido</td>
            <td class="py-3 px-6 text-left">Revisión de unidad</td>
            <td class="py-3 px-6 text-center">
              <span class="bg-purple-100 text-purple-800 py-1 px-3 rounded-full text-xs">En Patio</span>
            </td>
            <td class="py-3 px-6 text-center">2025-04-14</td>
          </tr>
          <tr>
            <td class="py-3 px-6 text-left">CargaMax</td>
            <td class="py-3 px-6 text-left">Entrega final</td>
            <td class="py-3 px-6 text-center">
              <span class="bg-green-100 text-green-800 py-1 px-3 rounded-full text-xs">Finalizada</span>
            </td>
            <td class="py-3 px-6 text-center">2025-04-14</td>
          </tr>
          <tr>
            <td class="py-3 px-6 text-left">Expresos del Sur</td>
            <td class="py-3 px-6 text-left">Ruta bloqueada</td>
            <td class="py-3 px-6 text-center">
              <span class="bg-red-100 text-red-800 py-1 px-3 rounded-full text-xs">Cancelada</span>
            </td>
            <td class="py-3 px-6 text-center">2025-04-14</td>
          </tr>
          <tr>
            <td class="py-3 px-6 text-left">NorteLog</td>
            <td class="py-3 px-6 text-left">Entrega parcial</td>
            <td class="py-3 px-6 text-center">
              <span class="bg-orange-100 text-orange-800 py-1 px-3 rounded-full text-xs">Por Entregar</span>
            </td>
            <td class="py-3 px-6 text-center">2025-04-13</td>
          </tr>
          <tr>
            <td class="py-3 px-6 text-left">Transcol</td>
            <td class="py-3 px-6 text-left">Ingreso a caseta</td>
            <td class="py-3 px-6 text-center">
              <span class="bg-blue-100 text-blue-800 py-1 px-3 rounded-full text-xs">En Caseta</span>
            </td>
            <td class="py-3 px-6 text-center">2025-04-13</td>
          </tr>
          <tr>
            <td class="py-3 px-6 text-left">Distribuciones MX</td>
            <td class="py-3 px-6 text-left">Esperando carga</td>
            <td class="py-3 px-6 text-center">
              <span class="bg-yellow-100 text-yellow-800 py-1 px-3 rounded-full text-xs">Pendiente</span>
            </td>
            <td class="py-3 px-6 text-center">2025-04-12</td>
          </tr>
          <tr>
            <td class="py-3 px-6 text-left">Rápidos GDL</td>
            <td class="py-3 px-6 text-left">Revisión final</td>
            <td class="py-3 px-6 text-center">
              <span class="bg-green-100 text-green-800 py-1 px-3 rounded-full text-xs">Finalizada</span>
            </td>
            <td class="py-3 px-6 text-center">2025-04-12</td>
          </tr>
          <tr>
            <td class="py-3 px-6 text-left">Carga Norteña</td>
            <td class="py-3 px-6 text-left">Entrega cancelada</td>
            <td class="py-3 px-6 text-center">
              <span class="bg-red-100 text-red-800 py-1 px-3 rounded-full text-xs">Cancelada</span>
            </td>
            <td class="py-3 px-6 text-center">2025-04-11</td>
          </tr>
        </tbody>
      </table>
    </div>
    </div>
    <div class="col-span-5 rounded-lg p-4 bg-white shadow-lg">
        <h2 class="text-center text-2xl font-bold mb-6">Estados de Maniobras</h2>
        <canvas id="graficaManiobras" class="w-full"></canvas>
    </div>
    <div class="col-span-5 rounded-lg p-4 bg-white shadow-lg">
    </div>
    <div class="col-span-7 rounded-lg p-4 bg-white shadow-lg">
        <h2 class="text-xl font-bold mb-4 text-center">Evolución Mensual de Maniobras</h2>
        <canvas id="maniobrasPorMes" class="w-full mt-4"></canvas>
    </div>
</div>
<!-- Stats -->
<!--<div class="grid grid-cols-4 gap-6 mb-6">
    <div class="bg-white p-4 rounded shadow">
        <p class="text-gray-600">Weekly Progress</p>
        <h2 class="text-2xl font-bold">42%</h2>
    </div>
    <div class="bg-white p-4 rounded shadow">
        <p class="text-gray-600">Weekly Running</p>
        <h2 class="text-2xl font-bold">40 Km</h2>
    </div>
    <div class="bg-white p-4 rounded shadow">
        <p class="text-gray-600">Daily Cycling</p>
        <h2 class="text-2xl font-bold">230 Km</h2>
    </div>
    <div class="bg-white p-4 rounded shadow">
        <p class="text-gray-600">Morning Yoga</p>
        <h2 class="text-2xl font-bold">18:34:21</h2>
    </div>
</div>

<div class="grid grid-cols-3 gap-6">
    <div class="col-span-2 bg-white p-6 rounded shadow">
        <h3 class="text-lg font-semibold mb-4">Workout Statistic</h3>
        <div class="w-full h-48 bg-gray-100 rounded">Chart Placeholder</div>
    </div>

    <div class="bg-white p-6 rounded shadow">
        <h3 class="text-lg font-semibold mb-4">Featured Diet Menu</h3>
        <ul class="space-y-4">
            <li class="flex items-center gap-4">
                <img src="/path/to/dish.jpg" alt="Dish" class="w-12 h-12 rounded">
                <div>
                    <p class="font-semibold">Chinese Orange Fruit Salad</p>
                    <p class="text-sm text-gray-600">4 mins</p>
                </div>
            </li>
        </ul>
    </div>
</div>

<div class="bg-white p-6 rounded shadow mt-6">
    <h3 class="text-lg font-semibold mb-4">Recommended Trainer for You</h3>
    <div class="flex gap-6">
        <div class="w-1/4 bg-gray-100 p-4 rounded">
            <img src="/path/to/trainer.jpg" alt="Trainer" class="w-full h-24 object-cover rounded mb-2">
            <h4 class="font-semibold">Roberto Carlos</h4>
            <p class="text-sm text-gray-600">Body Building Trainer</p>
            <button class="mt-2 w-full bg-blue-500 text-white py-2 px-4 rounded">Send Request</button>
        </div>
    </div>
</div>-->
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('graficaManiobras').getContext('2d');

    const estados = ['Pendiente', 'En Caseta', 'En Patio', 'Por Entregar', 'Cancelada', 'Finalizada'];
    const colores = [
      '#f1c40f', // Pendiente
      '#3498db', // En Caseta
      '#9b59b6', // En Patio
      '#e67e22', // Por Entregar
      '#e74c3c', // Cancelada (rojo)
      '#2ecc71'  // Finalizada (verde)
    ];

    // Generar valores aleatorios
    const cantidades = estados.map(() => Math.floor(Math.random() * 20) + 1);

    new Chart(ctx, {
      type: 'doughnut',
      data: {
        labels: estados,
        datasets: [{
          data: cantidades,
          backgroundColor: colores,
          borderWidth: 1
        }]
      },
      options: {
        responsive: true,
        plugins: {
          legend: {
            position: 'bottom'
          },
          title: {
            display: true,
            text: 'Distribución de Maniobras'
          }
        }
      }
    });

    var ctx2 = document.getElementById('maniobrasPorMes').getContext('2d');

    const meses = ['Noviembre', 'Diciembre', 'Enero', 'Febrero', 'Marzo', 'Abril'];

    // Datos ficticios por cliente
    var data = {
      labels: meses,
      datasets: [
        {
          label: 'Logística del Norte',
          data: [15, 18, 20, 22, 25, 24],
          borderColor: '#3498db',
          backgroundColor: '#3498db',
          tension: 0.3
        },
        {
          label: 'Transportes Vega',
          data: [10, 11, 12, 13, 15, 14],
          borderColor: '#9b59b6',
          backgroundColor: '#9b59b6',
          tension: 0.3
        },
        {
          label: 'CargaMax',
          data: [8, 9, 10, 11, 12, 13],
          borderColor: '#e67e22',
          backgroundColor: '#e67e22',
          tension: 0.3
        },
        {
          label: 'Rápidos GDL',
          data: [12, 14, 15, 17, 18, 20],
          borderColor: '#2ecc71',
          backgroundColor: '#2ecc71',
          tension: 0.3
        }
      ]
    };

    new Chart(ctx2, {
      type: 'line',
      data: data,
      options: {
        responsive: true,
        plugins: {
          title: {
            display: true,
            text: 'Cantidad de Maniobras por Cliente (por Mes)'
          },
          legend: {
            position: 'bottom'
          }
        },
        interaction: {
          mode: 'index',
          intersect: false
        },
        scales: {
          y: {
            beginAtZero: true,
            title: {
              display: true,
              text: 'Cantidad de maniobras'
            }
          },
          x: {
            title: {
              display: true,
              text: 'Mes'
            }
          }
        }
      }
    });
  </script>
@endsection