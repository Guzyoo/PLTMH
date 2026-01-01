<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\Sensor;
use Illuminate\Http\Request;

class SensorController extends Controller
{
    public function store(Request $request, $deviceId)
    {
        // 1. Validasi Format Data Masuk
        $request->validate([
            'data' => 'required|array'
        ]);

        // 2. CEK VALIDITAS DEVICE (Disini kendalinya)
        $device = Device::find($deviceId);

        // Jika device tidak ditemukan di database
        if (!$device) {
            return response()->json([
                'status' => 'error',
                'message' => 'Device tidak dikenali! ID ini tidak terdaftar.'
            ], 404); // 404 Not Found
        }

        // 3. (Opsional tapi Bagus) Cek Token/Identifier
        // Kalau kamu mau lebih aman, ESP32 harus kirim identifier juga buat dicocokkan.
        // if ($request->identifier !== $device->device_identifier) { ... error ... }

        // 4. Simpan Data
        $sensor = Sensor::create([
            'device_id' => $deviceId, // Pakai ID yang sudah divalidasi
            'data' => $request->data
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Data sensor tersimpan!',
            // Tidak perlu balikin seluruh object sensor biar response enteng
        ], 201);
    }
}
