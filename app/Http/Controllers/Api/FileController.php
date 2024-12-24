<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\File\UpdateFileRequest;
use App\Http\Requests\File\UploadFileRequest;
use App\Models\File;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(UploadFileRequest $request)
    {
        try {
            $path = $request->file('file')->store('public');
            $newPath = str_replace('public/', '', $path);
            $pathUrl = config('app.url') . '/assets/' . $newPath;

            $file = File::create([
                'name' => $request['name'],
                'path' => $newPath,
                'type' => $request->file('file')->getClientMimeType(),
            ]);

            $product = Product::where('id', $request['name'])->first();
            if ($product) {
                $product->update([
                    'image' => $newPath,
                ]);
                $product->save();
            }

            return ApiResponse::send(201, 'File uploaded successfully', [$file, $pathUrl]);
        } catch (\Exception $e) {
            abort(500, $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFileRequest $request, File $file)
    {
        try {
            if (file_exists(public_path('/assets/' . $file->path))) {
                Storage::disk('public')->delete($file->path);
            }

            $path = $request->file('file')->store('public');
            $pathUrl = config('app.url') . '/assets/' . str_replace('public/', '', $path);

            $file->update([
                'name' => $request['name'],
                'path' => str_replace('public/', '', $path),
                'type' => $request->file('file')->getClientMimeType(),
            ]);

            return ApiResponse::send(200, 'File updated successfully', [$file, $pathUrl]);
        } catch (\Exception $e) {
            abort(500, $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(File $file)
    {
        try {
            if (file_exists(public_path('/assets/' . $file->path))) {
                Storage::disk('public')->delete($file->path);
            }

            $file->delete();

            return response()->json([
                'message' => 'File deleted successfully',
            ]);
        } catch (\Exception $e) {
            abort(500, $e->getMessage());
        }
    }
}
