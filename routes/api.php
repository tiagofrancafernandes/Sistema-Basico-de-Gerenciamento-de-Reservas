<?php

use Illuminate\Support\Facades\Route;

Route::prefix('guests')->name('guests.')->group(function () {
    Route::post('index', function () {
        $totalRecords = 50;

        return response()->json([
            'records' => cache()->remember('fake_guest_records', 60 * 5, fn () => Arr::map(range(1, 10), fn ($item) => [
                'id' => $item,
                'name' => fake()->name(),
                'country' => [
                    'name' => 'Algeria',
                    'code' => 'dz'
                ],
                'company' => 'Benton, John B Jr',
                'date' => '2015-09-13',
                'status' => 'unqualified',
                'verified' => true,
                'activity' => 17,
                'representative' => [
                    'name' => 'Ioni Bowcher',
                    // 'image' => 'https://primefaces.org/cdn/primevue/images/avatar/ivanmagalhaes.png',
                    'image' => 'ivanmagalhaes.png',
                ],
                'balance' => 70663
            ])),
            'totalRecords' => $totalRecords,
        ]);
    });
});
