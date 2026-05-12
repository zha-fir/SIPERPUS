<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

// Menjalankan perintah artisan langsung dari PHP HTTP
try {
    \Illuminate\Support\Facades\Artisan::call('view:clear');
    $view = \Illuminate\Support\Facades\Artisan::output();
    
    \Illuminate\Support\Facades\Artisan::call('config:clear');
    $config = \Illuminate\Support\Facades\Artisan::output();
    
    \Illuminate\Support\Facades\Artisan::call('route:clear');
    $route = \Illuminate\Support\Facades\Artisan::output();
    
    \Illuminate\Support\Facades\Artisan::call('cache:clear');
    $cache = \Illuminate\Support\Facades\Artisan::output();

    echo "<h1>Sukses Membersihkan Cache Server!</h1>";
    echo "<pre>View: $view</pre>";
    echo "<pre>Config: $config</pre>";
    echo "<pre>Route: $route</pre>";
    echo "<pre>Cache: $cache</pre>";
    echo "<br><br><a href='/login' style='padding:10px 20px; background:#22c55e; color:white; text-decoration:none; border-radius:5px; font-weight:bold;'>Cek Halaman Login</a>";
} catch (\Exception $e) {
    echo "<h1>Gagal:</h1>";
    echo $e->getMessage();
}
