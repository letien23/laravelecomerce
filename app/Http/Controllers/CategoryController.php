<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Product;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    // public function getCategoryList(){
    //     return view('admin.category.category-list');
    // }
    public function getCategoryList()
    {
        $products = product::paginate(20);
        return view('admin.category.category-list', compact('products'));
    }
    // -------------------------------------------- admin
    public function getAdminpage()
    {
        return view('admin/category/category-add');
    }

    public function getIndexAdmin(){
        $products = product ::all();
        return view('admin/category/category-list', compact('products')); 
    }

    public function postAdminAdd(Request $request)
    {
        $product= new Product();
        if ($request->hasFile('inputImage')) {
            $file = $request -> file('inputImage');
            $fileName=$file->getClientOriginalName('inputImage');
            $file->move('source/image/product', $fileName);
        }
        $fileName=null;
        if ($request->file('inputImage')!=null) {
            $file_name=$request->file('inputImage')->getClientOriginalName();
        }
        $product->name=$request->inputName;
        $product->image=$file_name;
        $product->description=$request->inputDescription;
        $product->unit_price=$request->inputPrice;
        $product->promotion_price=$request->inputPromotionPrice;
        $product->unit=$request->inputUnit;
        $product->new=$request->inputNew;
        $product->id_type=$request->inputType;
        $product->save();
        return redirect('admin/category/category-list')->with('success', 'Đăng ký thành công');
    }
// ------------
public function getAdminEdit($id){
    $product = product::find($id);
    return view('admin/category/category-edit')->with('product',$product);
}

public function postAdminEdit(Request $request){
    $id = $request->editId;

    $product = product::find($id);
    if($request->hasFile('editImage')){
        $file = $request -> file ('editImage');
        $fileName=$file->getClientOriginalName('editImage');
        $file->move('source/image/product',$fileName);
    }
    if ($request->file('editImage')!=null){
        $product ->image=$fileName;
    }
    $product->name=$request->editName;
    // $product->image=$file_name;
    $product->description=$request->editDescription;
    $product->unit_price=$request->editPrice;
    $product->promotion_price=$request->editPromotionPrice;
    $product->unit=$request->editUnit;
    $product->new=$request->editNew;
    $product->id_type=$request->editType;
    $product->save();
    return redirect('admin/category/category-list');
}
// ------------
public function postAdminDelete($id){
    $product =product::find($id);
    $product->delete();
    return redirect('admin/category/category-list');
}

// -----

    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}