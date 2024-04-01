<?php

use App\Http\Livewire\CategoryComponent;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\ClientComponent;
use App\Http\Livewire\InventoryComponent;
use App\Http\Livewire\MeasureComponent;
use App\Http\Livewire\ProductComponent;
use App\Http\Livewire\StockComponent;
use App\Http\Livewire\UbicationComponent;
use App\Http\Livewire\UnitComponent;
use App\Http\Livewire\WorkComponent;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('/dashboard');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::get('/clientes', ClientComponent::class)->name('Clientes');
    Route::get('/ubicaciones', UbicationComponent::class)->name('Ubicaciones');
    Route::get('/unidades', UnitComponent::class)->name('Unidades');
    Route::get('/categorias', CategoryComponent::class)->name('Categorias');
    Route::get('/productos', ProductComponent::class)->name('Productos');
    Route::get('/inventario', InventoryComponent::class)->name('Inventario');
    Route::get('/stock', StockComponent::class)->name('Stock');
    Route::get('/medidas', MeasureComponent::class)->name('Medidas');
    Route::get('/trabajos', WorkComponent::class)->name('Trabajos');
});
