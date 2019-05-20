<?php

namespace App\Http\Responses;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\Storage;

class ImageResponse implements Responsable
{
    protected $filePath;

    public function __construct($filePath)
    {
        $this->filePath = $filePath;
    }

    public function toResponse($request)
    {
        $fileName = last(explode('/', $this->filePath));
        $extension = last(explode('.', $fileName));

        return response(Storage::get($this->filePath))
            ->header('Content-Type', "image/$extension")
            ->header('Content-Disposition', "inline; filename=\"$fileName\"");
    }
}
