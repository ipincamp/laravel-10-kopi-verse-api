<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\File\UpdateFileRequest;
use App\Http\Requests\File\UploadFileRequest;
use App\Models\File;
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
            $pathUrl = config('app.url') . '/assets/' . str_replace('public/', '', $path);

            $file = File::create([
                'name' => $request->file('file')->getClientOriginalName(),
                'path' => str_replace('public/', '', $path),
                'type' => $request->file('file')->getClientMimeType(),
            ]);

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
            $request->validate([
                'file' => 'required|file|mimes:jpg,jpeg,png|max:2048',
            ]);

            if (file_exists(public_path('/assets/' . $file->path))) {
                Storage::disk('public')->delete($file->path);
            }

            $path = $request->file('file')->store('public');
            $pathUrl = config('app.url') . '/assets/' . str_replace('public/', '', $path);

            $file->update([
                'name' => $request->file('file')->getClientOriginalName(),
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
