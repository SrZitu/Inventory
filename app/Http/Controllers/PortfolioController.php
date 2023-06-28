<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;

class PortfolioController extends Controller
{
    public function portfolioPage()
    {
        $portfolio = Portfolio::latest()->get();
        return view('admin.portfolio_page.portfolio_all', compact('portfolio'));
    }
    public function singlePortfolio()
    {
        return view('admin.portfolio_page.portfolio');
    }

    //store portfolio
    public function storePortfolio(Request $request)
    {
        //custom validation
        $request->validate(
            [
                'portfolio_name' => 'required',
                'portfolio_title' => 'required',
                'portfolio_image' => 'required',
                'portfolio_description' => 'required',
            ],
            [
                'portfolio_name.required' => 'Name is required',
                'portfolio_title.required' => 'Title field must  be field',
            ],
        );

        $image = $request->file('portfolio_image');
        $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension(); // 3434343443.jpg

        Image::make($image)
            ->resize(1020, 519)
            ->save('upload/admin_portfolio/' . $name_gen);
        $save_url = 'upload/admin_portfolio/' . $name_gen;

        Portfolio::insert([
            'portfolio_name' => $request->portfolio_name,
            'portfolio_title' => $request->portfolio_title,
            'portfolio_image' => $save_url,
            'portfolio_description' => $request->portfolio_description,
        ]);
        $notification = [
            'message' => 'Portfolio Added Successfully',
            'alert-type' => 'success',
        ];

        return redirect()
            ->route('portfolio_all.page')
            ->with($notification);
    } // End Method

    //edit portfolio
    public function editPortfolio($id)
    {
        $portfolio_id = Portfolio::findOrFail($id);
        return view('admin.portfolio_page.portfolio_edit', compact('portfolio_id'));
    }


    //update portfolio
    public function updatePortfolio(Request $request)
    {
        $portfolio_update_id = $request->id;

        if ($request->file('portfolio_image')) {
            $image = $request->file('portfolio_image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension(); // 3434343443.jpg

            Image::make($image)
                ->resize(1020, 519)
                ->save('upload/admin_portfolio/' . $name_gen);
            $save_url = 'upload/admin_portfolio/' . $name_gen;

            Portfolio::findOrFail($portfolio_update_id)->update([
                'portfolio_name' => $request->portfolio_name,
                'portfolio_title' => $request->portfolio_title,
                'portfolio_image' => $save_url,
                'portfolio_description' => $request->portfolio_description,
            ]);
            $notification = [
                'message' => 'Portfolio Page Updated with Image Successfully',
                'alert-type' => 'success',
            ];

            return redirect()
                ->route('portfolio_all.page')
                ->with($notification);
        } else {
            Portfolio::findOrFail($portfolio_update_id)->update([
                'portfolio_name' => $request->portfolio_name,
                'portfolio_title' => $request->portfolio_title,
                'portfolio_description' => $request->portfolio_description,
            ]);
            $notification = [
                'message' => 'Portfolio Updated without Image Successfully',
                'alert-type' => 'success',
            ];
            return redirect()
                ->route('portfolio_all.page')
                ->with($notification);
        } // end Else
    }

    //delete portfolio
    public function deletePortfolio($id)
    {
        $portfolio = Portfolio::findOrFail($id);
        $img = $portfolio->portfolio_image;
        unlink($img);

        Portfolio::findOrFail($id)->delete();

        $notification = [
            'message' => 'Portfolio Image Deleted Successfully',
            'alert-type' => 'success',
        ];

        return redirect()
            ->back()
            ->with($notification);
    } // End Method

    //portfolio details

    public function detailsPortfolio($id)
    {
        $portfolio = Portfolio::findOrFail($id);
        return view('frontend.portfolio.portfolio_details', compact('portfolio'));
    }

    public function Homeportfolio(){
        $portfolio = Portfolio::paginate(4);
        return view('frontend.portfolio.portfolio_page', compact('portfolio'));
    }
}
