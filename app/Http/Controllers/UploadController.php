<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UploadController extends Controller
{
    //
    public function images(Request $request)
    {
        // 存储在public磁盘的uploads目录
        $path = $request->file('file')->store('images/'.date('Y/m/d'), 'public');
        // dd($path);
        if ($path) {
            return [
                'success' => true,
                'path' => 'uploads/'.$path
            ];
        }
        return [
            'success' => false,
            'message' => 'error'
        ];
    }
}
