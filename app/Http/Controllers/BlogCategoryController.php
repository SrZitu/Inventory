<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BlogCategory;

class BlogCategoryController extends Controller
{
    public function blogCategoryPage()
    {
        $blogcategory = BlogCategory::latest()->get();
        return view('admin.blog_category.blog_category_all', compact('blogcategory'));
    }
    public function singleBlogCategory()
    {
        return view('admin.blog_category.blog_category');
    }

    public function storeBlogCategory(Request $request)
    {
        //custom validation
  
        BlogCategory::insert([
            'blog_category' => $request->blog_category,
        ]);
        $notification = [
            'message' => 'Blog Category Added Successfully',
            'alert-type' => 'success',
        ];

        return redirect()
            ->route('blog_category_all.page')
            ->with($notification);
    }

    public function editblogCategory($id)
    {
        $blogCategory_id = BlogCategory::findOrFail($id);
        return view('admin.blog_category.blog_category_edit', compact('blogCategory_id'));
    }

    //update category
    public function updateBlogCategory(Request $request, $id)
    {
        BlogCategory::findOrFail($id)->update([
            'blog_category' => $request->blog_category,
        ]);
        $notification = [
            'message' => 'Blog Category Updated Successfully',
            'alert-type' => 'success',
        ];

        return redirect()
            ->route('blog_category_all.page')
            ->with($notification);
    }

    public function deleteBlogCategory($id)
    {
        BlogCategory::findOrFail($id)->delete();

        $notification = [
            'message' => 'Blog Category Deleted Successfully',
            'alert-type' => 'success',
        ];

        return redirect()
            ->route('blog_category_all.page')
            ->with($notification);
    }
}
