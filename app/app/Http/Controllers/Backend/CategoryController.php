<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SubCategory;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class CategoryController extends Controller
{
    public function AllCategory(){

        $category = Category::latest()->get();
        return view('admin.backend.category.all-category', compact('category'));

    }

    public function AddCategory(){
        return view('admin.backend.category.add-category');
    }

    public function StoreCategory(Request $request){

        $image = $request->file('image');
        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();

        // Setup ImageManager with the GD driver
        $manager = new ImageManager(new Driver());

        // Read, resize, and save the image
        $img = $manager->read($image);
        $img->resize(370, 246);
        $img->save(public_path('images/admin/category/'.$name_gen));

        $save_url = 'images/admin/category/'.$name_gen;

        Category::insert([
            'category_name' => $request->category_name,
            'category_slug' => strtolower(str_replace(' ', '-', $request->category_name)),
            'image' => $save_url,
        ]);

        $notification = array(
                'message' => 'Category Added Successfully',
                'alert-type' => 'success'
            );

        return redirect()->route('all.category')->with($notification);
    }

    public function EditCategory($id){
        $category = Category::find($id);
        return view('admin.backend.category.edit-category', compact('category'));
    }

    public function DeleteCategory($id){
        $item = Category::find($id);
        $img = $item->image;
        unlink($img);

        Category::find($id)->delete();
        $notification = array(
                'message' => 'Category Deleted Successfully',
                'alert-type' => 'success'
            );
        return redirect()->back()->with($notification);
    }

    /////SubCategory Controllers///////
    public function AllSubCategory(){
        $subcategory = SubCategory::latest()->get();
        return view('admin.backend.subcategory.all-subcategory', compact('subcategory'));
    }

    public function AddSubCategory(){
        $category = Category::latest()->get();
        return view('admin.backend.subcategory.add-subcategory', compact('category'));
    }

    public function StoreSubCategory(Request $request){

        SubCategory::insert([
            'subcategory_name' => $request->subcategory_name,
            'category_id' => $request->category_id,
            'subcategory_slug' => strtolower(str_replace(' ', '-', $request->subcategory_name)),
        ]);

        $notification = array(
                'message' => 'SubCategory Added Successfully',
                'alert-type' => 'success'
            );

        return redirect()->route('all.subcategory')->with($notification);
    }

    public function EditSubCategory($id){

    $subcategory = SubCategory::find($id);
    $category = Category::latest()->get();
    return view('admin.backend.subcategory.edit-subcategory', compact('subcategory', 'category'));
    }

    public function UpdateSubCategory(Request $request, $id){

        $subcat_id = $request->id;
        SubCategory::find($subcat_id)->update([
            'subcategory_name' => $request->subcategory_name,
            'category_id' => $request->category_id,
            'subcategory_slug' => strtolower(str_replace(' ', '-', $request->subcategory_name)),
        ]);

        $notification = array(
                'message' => 'SubCategory Updated Successfully',
                'alert-type' => 'success'
            );

        return redirect()->route('all.subcategory')->with($notification);
    }

    public function DeleteSubCategory($id){
        SubCategory::find($id)->delete();
        $notification = array(
                'message' => 'SubCategory Deleted Successfully',
                'alert-type' => 'success'
            );
        return redirect()->back()->with($notification);
    }
}
