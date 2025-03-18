<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use Illuminate\Http\Request;
use App\Models\Image;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ImageRequest;
use Exception;

class ImageController extends Controller
{
    // Get all images
    public function index()
    {
        try {
            $images = Image::all()->map(function ($image) {
                return [
                    'image_id' => $image->image_id,
                    'img' => $image->img,
                    'image_url' => url("storage/uploads/{$image->img}"),
                    'created_at' => $image->created_at,
                    'updated_at' => $image->updated_at
                ];
            });

            return $this->sendResponse($images);
        } catch (Exception $e) {
            return $this->sendError('Failed to retrieve images', 500, $e->getMessage());
        }
    }

    // Get image by ID
    public function show($id)
    {
        try {
            $image = Image::find($id);
            if (!$image) {
                return $this->sendError('Image not found', 404);
            }

            return $this->sendResponse([
                'image_id' => $image->image_id,
                'img' => $image->img,
                'image_url' => url("storage/uploads/{$image->img}"),
                'created_at' => $image->created_at,
                'updated_at' => $image->updated_at
            ]);
        } catch (Exception $e) {
            return $this->sendError('Failed to retrieve image', 500, $e->getMessage());
        }
    }

    // Upload images
    public function create(ImageRequest $request)
    {
        try {
            if (!$request->hasFile('img')) {
                return $this->sendError('No file uploaded', 400);
            }

            $uploadedImages = [];
            $existingImages = [];

            foreach ($request->file('img') as $file) {
                $fileName = $file->getClientOriginalName();

                // Check if image already exists
                if (Image::where('img', $fileName)->exists()) {
                    $existingImages[] = $fileName;
                    continue;
                }

                // Store the image
                $filePath = $file->storeAs('uploads', $fileName, 'public');

                $image = Image::create([
                    'img' => $fileName,
                ]);

                $uploadedImages[] = [
                    'image_id' => $image->image_id,
                    'img' => $fileName,
                    'image_url' => asset("storage/$filePath"),
                ];
            }

            if (!empty($uploadedImages) && !empty($existingImages)) {
                $message = "Some images were uploaded successfully, but some already exist.";
            } elseif (!empty($uploadedImages)) {
                $message = "Images uploaded successfully.";
            } else {
                $message = "Images already exist.";
            }

            return $this->sendResponse([
                'message' => $message,
                'uploaded_images' => $uploadedImages,
                'existing_images' => $existingImages
            ], 201);
        } catch (Exception $e) {
            return $this->sendError('Failed to upload images', 500, $e->getMessage());
        }
    }

    // Update image by ID
    public function update(ImageRequest $request, $id)
    {
        try {
            $image = Image::find($id);
            if (!$image) {
                return $this->sendError('Image not found', 404);
            }

            // Delete old image from storage
            Storage::delete("public/uploads/{$image->img}");

            // Upload new image
            $file = $request->file('img');
            $fileName = $file->getClientOriginalName();
            $file->storeAs('uploads', $fileName, 'public');

            // Update image record
            $image->update(['img' => $fileName]);

            return $this->sendResponse([
                'image_id' => $image->image_id,
                'img' => $fileName,
                'image_url' => asset("storage/uploads/$fileName")
            ], 200, 'Image updated successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to update image', 500, $e->getMessage());
        }
    }

    // Delete image by ID
    public function delete($id)
    {
        try {
            $image = Image::find($id);
            if (!$image) {
                return $this->sendError('Image not found', 404);
            }

            // Remove image from storage
            $filePath = storage_path("app/public/uploads/{$image->img}");
            if (file_exists($filePath)) {
                unlink($filePath);
            }

            $image->delete();

            return $this->sendResponse([], 200, 'Image deleted successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to delete image', 500, $e->getMessage());
        }
    }
}
