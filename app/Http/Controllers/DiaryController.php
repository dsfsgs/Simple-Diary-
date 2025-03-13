<?php
namespace App\Http\Controllers;

use App\Models\Diary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DiaryController extends Controller
{
    public function index()
    {
        return Diary::all();
    }

    public function store(Request $request)
    {
        // Log the incoming request data
        Log::info('Incoming request data:', $request->all());

        try {
            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'image' => 'nullable|string',
            ]);

            $diary = Diary::create($validatedData);

            // Log the created diary data
            Log::info('Diary created successfully:', $diary->toArray());

            return response()->json($diary, 201);
        } catch (\Exception $e) {
            // Log the error message
            Log::error('Error creating diary: ' . $e->getMessage());

            return response()->json(['error' => 'Error creating diary'], 500);
        }
    }

    public function show(Diary $diary)
    {
        return $diary;
    }

    public function update(Request $request, Diary $diary)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|string',
        ]);

        $diary->update($validatedData);
        return response()->json($diary, 200);
    }

    public function destroy(Diary $diary)
    {
        $diary->delete();
        return response()->json(null, 204);
    }
}
