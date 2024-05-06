<?php

namespace App\Http\Controllers;
use Illuminate\Database\QueryException;

use Illuminate\Support\Facades\Validator;
use App\Models\Flower;
use App\Models\Category;
use App\Http\Requests\StoreFlowerRequest;
use App\Http\Requests\UpdateFlowerRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class FlowerController extends Controller
{
   
    public function index(){

    $flowers = Flower::all();

    // Pass the flower data to the view
    return view('administrator.flowers_list', compact('flowers'));
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all(); // Fetch all categories
        return view('administrator.add_flower', compact('categories')); // Pass categories data to the view
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Validate the request data
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'description' => 'nullable|string|max:255',
                'picture' => 'nullable|image|max:2048',
                'price' => 'required|numeric|min:1',
                'category_id' => 'required|exists:categories,id',
            ]);
    
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
    
            $validatedData = $validator->validated();
    
            // Check if a picture is uploaded
            if ($request->hasFile('picture')) {
                // Store the uploaded file
                $imagePath = $request->file('picture')->store('public/flower');
                // Get the filename from the stored path
                $imageName = basename($imagePath);
            } else {
                // Use a default image if no file was uploaded
                $imageName = 'images/rose.jpeg';
            }
    
            // Add the image name to the validated data
            $validatedData['picture'] = $imageName;
    
            // Create the flower record
            $flower = Flower::create($validatedData);
    
            // Redirect with success message
            return redirect()->route('flowers.index')->with('success', 'Flower created successfully.');
        } catch (\Exception $e) {
            // Handle other exceptions
            return redirect()->back()->with('error', 'Failed to create flower. Please try again.');
        }
    }
    
    /**
     * Display the specified resource.
     */
    public function show(Flower $flower)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Flower $flower)
    {
        $categories = Category::all();
        return view('administrator.edit_flower', compact('flower', 'categories'));
    }

    public function update(Request $request, Flower $flower)
    {
      
            // Validate the request data
            $validatedData = $request->validate([
                'name' => 'required|string|max:100',
                'category_id' => 'required|integer',
                'description' => 'required|string|max:255',
                'price' => 'required|numeric|min:1',
                'picture' => 'image|mimes:jpeg,png,jpg,gif', // Assuming max file size is 2MB
            ], [
                'name.required' => 'The flower name is required.',
                'name.string' => 'The flower name must be a string.',
                'name.max' => 'The flower name cannot be longer than :max characters.',
                'category_id.required' => 'The category is required.',
                'category_id.integer' => 'The category must be an integer.',
                'description.required' => 'The description is required.',
                'description.string' => 'The description must be a string.',
                'description.max' => 'The description cannot be longer than :max characters.',
                'price.required' => 'The price is required.',
                'price.numeric' => 'The price must be a number.',
                'price.min' => 'The price must be at least :min.',
                'picture.image' => 'The picture must be an image.',
                'picture.mimes' => 'The picture must be a file of type: :values.',
            ]);
            
            // Update the flower object with the new data
            $flower->update([
                'name' => $validatedData['name'],
                'category_id' => $validatedData['category_id'],
                'description' => $validatedData['description'],
                'price' => $validatedData['price'],
            ]);
    
            // Handle flower picture update
            if ($request->hasFile('new_picture')) {
                // Delete previous flower picture file if exists
                Storage::delete('public/flower/' . $flower->picture);
                
                // Store the new flower picture file
                $imageName = $request->file('new_picture')->store('public/flower');
                $flower->picture = basename($imageName);
                $flower->save();
            }
    
            // Redirect with success message
            return redirect()->route('flowers.index')->with('success', 'Flower updated successfully');
        
    }
    
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Flower $flower){
        try {
            $flower->delete();
            return redirect()->back()->with('success', 'Flower deleted successfully.');
        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            if($errorCode === 1451) {
                return redirect()->back()->with('error', 'Cannot delete flower because it is in a current order.');
            }
            // Handle other database errors if needed
        }
    }
}
