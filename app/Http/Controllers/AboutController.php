<?php

namespace App\Http\Controllers;

use App\Models\About;
use App\Models\MultiImage;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Intervention\Image\ImageManagerStatic as Image;

class AboutController extends Controller
{
    public function aboutPage()
    {
        $aboutPage = About::find(1);
        return view('admin.about_page.about_page_all', compact('aboutPage'));
    }

    public function UpdateAbout(Request $request)
    {

        $about_id = $request->id;

        if ($request->file('about_image')) {
            $image = $request->file('about_image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();  // 3434343443.jpg

            Image::make($image)->resize(523, 605)->save('upload/home_about/' . $name_gen);
            $save_url = 'upload/home_about/' . $name_gen;

            About::findOrFail($about_id)->update([
                'title' => $request->title,
                'short_title' => $request->short_title,
                'short_description' => $request->short_description,
                'long_description' => $request->long_description,
                'about_image' => $save_url,

            ]);
            $notification = array(
                'message' => 'About Page Updated with Image Successfully',
                'alert-type' => 'success'
            );

            return redirect()->back()->with($notification);
        } else {

            About::findOrFail($about_id)->update([
                'title' => $request->title,
                'short_title' => $request->short_title,
                'short_description' => $request->short_description,
                'long_description' => $request->long_description,

            ]);
            $notification = array(
                'message' => 'About Page Updated without Image Successfully',
                'alert-type' => 'success'
            );

            return redirect()->back()->with($notification);
        } // end Else

    } // End Method

    public function HomeAbout()
    {

        $aboutpage = About::find(1);
        return view('frontend.about_page', compact('aboutpage'));
    } // End Method


    public function multiImagePage()
    {


        return view('admin.about_page.multiImage_page');
    } // End Method




    public function storeMultiImage(Request $request)
    {



        $image = $request->file('multi_image');

        foreach ($image as $multiImage) {

            $name_gen = hexdec(uniqid()) . '.' . $multiImage->getClientOriginalExtension();  // 3434343443.jpg

            Image::make($multiImage)->resize(220, 220)->save('upload/multi/' . $name_gen);
            $save_url = 'upload/home_about/' . $name_gen;
            MultiImage::insert(
                [
                    'multi_image' => $save_url,

                    //this shows current time of created
                    'created_at' => Carbon::now()
                ]
            );
        }
        $notification = array(
            'message' => 'About Page Updated with Image Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.multiImage.page')->with($notification);
    } // End Method

    public function showMultiImage()
    {
        $allMultiImage = MultiImage::all();
        return view('admin.about_page.all_multiImage', compact('allMultiImage'));
    }

    public function editMultiImage($id)
    {
        $multiImage_id = MultiImage::findOrFail($id);
        return view('admin.about_page.multiImage_edit', compact('multiImage_id'));
    }


    public function updateMultiImage(Request $request)
    {

        $multi_image_id = $request->id;

        if ($request->file('multi_image')) {
            $image = $request->file('multi_image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();  // 3434343443.jpg

            Image::make($image)->resize(220, 220)->save('upload/multi/' . $name_gen);
            $save_url = 'upload/multi/' . $name_gen;

            MultiImage::findOrFail($multi_image_id)->update([

                'multi_image' => $save_url,

            ]);
            $notification = array(
                'message' => 'Multi Image Updated Successfully',
                'alert-type' => 'success'
            );

            return redirect()->route('all.multiImage.page')->with($notification);
        }
    } // End Method


    public function DeleteMultiImage($id){

        $multi = MultiImage::findOrFail($id);
        $img = $multi->multi_image;
        unlink($img);

        MultiImage::findOrFail($id)->delete();

         $notification = array(
            'message' => 'Multi Image Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);



     }// End Method 

}
