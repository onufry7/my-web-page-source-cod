<?php

namespace App\Repositories;

use App\Http\Requests\CorrectSleeveRequest;
use App\Http\Requests\SleeveRequest;
use App\Models\CorrectSleeve;
use App\Models\Sleeve;
use App\Services\SleeveService;
use Illuminate\Pagination\LengthAwarePaginator;

class SleeveRepository
{
    private SleeveService $service;

    public function __construct(SleeveService $sleeveService)
    {
        $this->service = $sleeveService;
    }

    public function getAllOrderedPaginatedSleeves(int $paginated = 40): LengthAwarePaginator
    {
        return Sleeve::orderBy('width')->orderBy('height')->orderBy('mark')->orderBy('name')->paginate($paginated);
    }

    public function store(SleeveRequest $request): false|Sleeve
    {
        $sleeve = new Sleeve($request->validated());
        $image = $request->file('image_file');

        if ($request->hasFile('image_file') && !is_null($image) && !is_array($image)) {
            $sleeve->image_path = $this->service->storeImage($image);
        }

        return ($sleeve->push()) ? $sleeve : false;
    }

    public function update(SleeveRequest $request, Sleeve $sleeve): bool
    {
        $image = $request->file('image_file');

        if ($request->hasAny(['delete_image_file', 'image_file']) && !is_null($sleeve->image_path)) {
            $this->service->deleteImage($sleeve->image_path);
            $sleeve->image_path = null;
        }

        if ($request->hasFile('image_file') && !is_null($image) && !is_array($image)) {
            $sleeve->image_path = $this->service->storeImage($image);
        }

        return $sleeve->update($request->validated());
    }

    public function delete(Sleeve $sleeve): bool
    {
        if (!is_null($sleeve->image_path)) {
            $this->service->deleteImage($sleeve->image_path);
        }

        return ($sleeve->delete()) ? true : false;
    }

    public function stockUpdate(CorrectSleeveRequest $request, Sleeve $sleeve): bool
    {
        $quantity = $request->validated('quantity_available');

        if ($request->has('correct') && $request->input('correct') === 'on') {
            $currentQuantity = (is_null($sleeve->quantity_available)) ? 0 : (int) $sleeve->quantity_available;
            $quantity = (!is_null($quantity) && is_numeric($quantity)) ? (int) $quantity : (int) $sleeve->quantity_available;
            $description = (is_string($request->input('description'))) ? $request->input('description') : null;
            $correctSleeve = new CorrectSleeve();
            $correctSleeve->description = $description;
            $correctSleeve->quantity_before = $currentQuantity;
            $correctSleeve->quantity_after = $quantity;
            $sleeve->correctSleeves()->save($correctSleeve);
            $sleeve->quantity_available = $quantity;
        } else {
            $quantity = (!is_null($quantity) && is_numeric($quantity)) ? (int) $quantity : 0;
            $sleeve->quantity_available += $quantity;
        }

        return $sleeve->update();
    }
}
