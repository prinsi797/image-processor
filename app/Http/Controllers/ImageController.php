<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageController extends Controller
{
    public function index(Request $request)
    {
        return view('images.index');
    }
    public function upload(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:10240',
        ]);

        $file = $request->file('image');
        $originalName = $file->getClientOriginalName();
        $path = $file->store('uploads', 'public');

        $image = Image::create([
            'original_name' => $originalName,
            'path' => $path,
        ]);

        return response()->json([
            'success' => true,
            'id' => $image->id,
            'path' => Storage::url($path),
        ]);
    }

    public function process(Request $request, $id)
    {
        $request->validate([
            'filter' => 'nullable|string',
            'format' => 'required|in:jpg,png,webp',
            'width' => 'nullable|integer|min:10',
            'height' => 'nullable|integer|min:10',
            'crop_width' => 'nullable|integer|min:10',
            'crop_height' => 'nullable|integer|min:10',
            'crop_x' => 'nullable|integer|min:0',
            'crop_y' => 'nullable|integer|min:0',
            'rotate' => 'nullable|numeric',
            'scaleX' => 'nullable|numeric',
            'scaleY' => 'nullable|numeric',
        ]);

        $image = Image::findOrFail($id);
        $imagePath = storage_path('app/public/' . $image->path);

        // Create the manager instance
        $manager = new ImageManager(new Driver());

        try {
            $img = $manager->read($imagePath);

            // Apply rotation if requested
            if ($request->filled('rotate')) {
                $img = $img->rotate((float) $request->rotate);
            }

            // Apply horizontal flip if requested
            if ($request->filled('scaleX') && $request->scaleX < 0) {
                $img = $img->flip('h');
            }

            // Apply vertical flip if requested
            if ($request->filled('scaleY') && $request->scaleY < 0) {
                $img = $img->flip('v');
            }

            // Apply filter if requested
            if ($request->filter) {
                $img = $this->applyFilter($img, $request->filter);
            }

            // Apply crop if requested
            if ($request->filled(['crop_width', 'crop_height', 'crop_x', 'crop_y'])) {
                $img = $img->crop(
                    (int) $request->crop_width,
                    (int) $request->crop_height,
                    (int) $request->crop_x,
                    (int) $request->crop_y
                );
            }


            // Resize if requested
            if ($request->filled(['width', 'height'])) {
                $img = $img->resize((int) $request->width, (int) $request->height);
            }

            // Save with requested format
            $format = $request->format;
            $processedFileName = 'processed_' . Str::random(10) . '.' . $format;
            $processedPath = 'processed/' . $processedFileName;
            $fullPath = storage_path('app/public/' . $processedPath);

            // Ensure directory exists
            Storage::makeDirectory('public/processed');

            // Save with appropriate format and quality
            $encodedImage = match ($format) {
                'jpg' => $img->toJpeg(90),
                'png' => $img->toPng(),
                'webp' => $img->toWebp(90),
                default => $img->toJpeg(90),
            };

            // Save the encoded image to disk
            $encodedImage->save($fullPath);

            // Update image record
            $image->processed_path = $processedPath;
            $image->format = $format;
            $image->save();

            return response()->json([
                'success' => true,
                'processed_url' => Storage::url($processedPath),
                'download_url' => route('images.download', $image->id)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    private function applyFilter($img, $filter)
    {
        switch ($filter) {
            case 'ghibli':
                // Ghibli-like effect with v3 API
                $img = $img->brightness(10)
                    ->contrast(15)
                    ->gamma(1.3)
                    ->greyscale()
                    ->colorize(38, 27, 12);
                // Note: colorize might need adjustment for v3
                return $img;

            case 'grayscale':
                return $img->greyscale();

            case 'sepia':
                // Sepia with v3 API
                $img = $img->greyscale();
                // Note: colorize and brightness might need adjustment for v3
                return $img;

            case 'vintage':
                // Vintage with v3 API
                $img = $img->brightness(-10)
                    ->contrast(10)
                    ->gamma(1.3);
                // Note: colorize might need adjustment for v3
                return $img;

            case 'bright':
                return $img->brightness(20)
                    ->contrast(20);

            case 'warm':
                $img->colorize(30, 15, 5); // new custom filter
                return $img;

            case 'cool':
                $img->colorize(0, 10, 30); // new custom filter
                return $img;

            default:
                // No filter
                return $img;
        }
    }
    public function download($id)
    {
        $image = Image::findOrFail($id);

        if (!$image->processed_path) {
            return redirect()->back()->with('error', 'No processed image found');
        }

        $path = storage_path('app/public/' . $image->processed_path);

        return response()->download($path, $image->original_name . '.' . $image->format);
    }
}