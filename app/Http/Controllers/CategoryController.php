<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    //
    public function index(){
        $categories = Category::orderBy('name')->get();
        return view('admin.adminCategory',['categories'=>$categories]);
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.addCategory',['categories'=>$categories]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:categories,name',
        ]);
        Category::create([
            'name'=>$request->name,
            'created_by' => Auth::id(),
        ]);
        return redirect()->route('admin.category')->with('success','เพิ่มหมวดหมู่อุปกรณ์เรียบร้อยแล้ว');
    }

     public function edit(Category $category)
    {
        return view('admin.editCategory',['category'=>$category]);
    }

    public function update(Request $request,Category $category)
    {
     // 1. ตรวจสอบข้อมูล
    $request->validate([
         'name' => 'required|string|unique:categories,name,' . $category->id,
    ]);

    $data = $request->only('name');

    
    // 5. อัปเดตข้อมูลในฐานข้อมูล
   $category->update($data);

    // 6. Redirect กลับไปที่ Dashboard
    return redirect()->route('admin.category')
                     ->with('success', 'แก้ไขเรียบร้อยแล้ว!');
}

public function destroy($id)
{
    $category = Category::findOrFail($id);
    $category->delete();


    return redirect()->route('admin.category')
                     ->with('success', 'ลบประกาศเรียบร้อยแล้ว');
}

}
