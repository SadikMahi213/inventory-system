<?php

namespace App\Imports;

use App\Models\Category;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Validators\Failure;
use Throwable;

class CategoriesImport implements ToModel, WithHeadingRow, WithValidation, SkipsEmptyRows, WithUpserts, WithBatchInserts, SkipsOnError, SkipsOnFailure
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // Check if category with this name already exists
        $existingCategory = Category::where('name', $row['name'])->first();

        // Prepare category data
        $categoryData = [
            'name' => $row['name'],
            'description' => $row['description'] ?? null,
        ];

        if ($existingCategory) {
            // Update existing category
            $existingCategory->update($categoryData);
            return null; // Return null to skip inserting
        } else {
            // Create new category
            return new Category($categoryData);
        }
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ];
    }

    /**
     * Custom validation messages
     */
    public function customValidationMessages()
    {
        return [
            'name.required' => 'Category name is required',
            'name.max' => 'Category name must not exceed 255 characters',
        ];
    }

    /**
     * @return string|array
     */
    public function uniqueBy()
    {
        return 'name';
    }

    /**
     * @return int
     */
    public function batchSize(): int
    {
        return 1000;
    }

    /**
     * @return int
     */
    public function chunkSize(): int
    {
        return 1000;
    }

    /**
     * Handle skipped errors
     *
     * @param Throwable $e
     */
    public function onError(Throwable $e)
    {
        // Log the error but continue processing
        \Illuminate\Support\Facades\Log::error('Category import error: ' . $e->getMessage());
    }

    /**
     * Handle validation failures
     *
     * @param Failure[] $failures
     */
    public function onFailure(Failure ...$failures)
    {
        // Log the failures but continue processing
        foreach ($failures as $failure) {
            \Illuminate\Support\Facades\Log::error('Category import failure on row ' . $failure->row() . ': ' . json_encode($failure->errors()));
        }
    }
}