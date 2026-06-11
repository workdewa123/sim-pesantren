<?php

return [
    App\Providers\AppServiceProvider::class,
    
    // Tambahkan baris ini untuk mendaftarkan engine excel ke internal Laravel:
    Maatwebsite\Excel\ExcelServiceProvider::class,
];