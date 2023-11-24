<?php

use App\Http\Controllers\administrationController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ViewsController;
use App\Http\Middleware\Admin;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});



Route::get('/conception', [ViewsController::class, 'conception'])->name('conception');
Route::get('/optimisation', [ViewsController::class, 'optimisation'])->name('optimisation');
Route::get('/referencement', [ViewsController::class, 'referencement'])->name('referencement');


Route::get('/contactez nous', [ViewsController::class, 'nousContacter'])->name('nousContacter');
Route::post('/contact', 'ContactController@sendEmail')->name('contact');

Route::get('/nos formations', [ViewsController::class, 'nosFormations'])->name('nosFormations');
Route::get('/demander un devis gratuitement', [ViewsController::class, 'devisGratuis'])->name('devisGratuis');


Route::get('/faqs', [ViewsController::class, 'faqs'])->name('faqs');
Route::get('/qui sommes-nous', [ViewsController::class, 'quiSommesNous'])->name('quiSommesNous');
Route::get('/supports', [ViewsController::class, 'supports'])->name('supports');
Route::get('/polique de confidentialité', [ViewsController::class, 'politiqueConfidentialite'])->name('politiqueConfidentialite');
Route::get('/temoignages', [ViewsController::class, 'temoignages'])->name('temoignages');
Route::get('/modèles de site web', [ViewsController::class, 'modeles'])->name('modeles');


Route::get('/administration', [AdminController::class, 'create'])->name('adminDashboard');
Route::post('/administration', [AdminController::class, 'store']);

Route::get('/dashboard client', [ViewsController::class, 'client'])->name('clientDashboard');
Route::get('/dashboard etudiant', [ViewsController::class, 'etudiant'])->name('etudiantDashboard');
Route::get('/dashboard redacteur', [ViewsController::class, 'redacteur'])->name('redacteurDashboard');












Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/client/dashboard', [ClientController::class, 'dashboard'])->name('client.dashboard');

    // Routes pour l'étudiant
    Route::get('/etudiant/dashboard', [EtudiantController::class, 'dashboard'])->name('etudiant.dashboard');

    // Routes pour le rédacteur
    Route::get('/redacteur/dashboard', [RedacteurController::class, 'dashboard'])->name('redacteur.dashboard');
});

require __DIR__.'/auth.php';
