<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Route;
use App\Jobs\MyTestJob;

Route::get('/check-redis', function () {
    try {
        Redis::set('test-key', 'Hello Redis');
        $value = Redis::get('test-key');
        return response()->json(['success' => true, 'message' => 'Redis is working']);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'error' => $e->getMessage()]);
    }
});

Route::get('/check-mongo', function () {
    try {
        $result = DB::connection('mongodb')->getMongoClient()->listDatabases();
        return response()->json(['success' => true, 'databases' => $result]);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'error' => $e->getMessage()]);
    }
});

Route::get('/check-rabbitmq', function () {
    try {
        dispatch(new MyTestJob());
        return response()->json(['success' => true, 'message' => 'Job dispatched to RabbitMQ']);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'error' => $e->getMessage()]);
    }
});
