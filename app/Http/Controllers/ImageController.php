<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ImageController extends Controller
{
public function index(){
    try{
        $images = Image::get();
        return view('multiple_imgUpload.index',compact('images'));
    }catch(Exception $e){
        dd($e->getMessage());
    }
}

    public function addFormView()
    {
        try {
            return view('multiple_imgUpload.add');
        }catch (Exception $e) {
            dd($e->getMessage());
        }
    }

    public function imageUpload(Request $request)
    {
        try {
            $request->validate([
                'img_name' => 'required',
                'images' => 'required',
                'images.*' => 'mimes:jpeg,jpg,png,gif,csv,txt,pdf|max:2048'
            ]);

            $imageUpload = new Image();
            $imageUpload->img_name = $request->img_name;

            if ($imgs = $request->file('images')) {
                $destination = '/Images/';
                foreach ($imgs as $img) {
                    $rand = Str::random(5);
                    $imageName = $rand . '-' . time() . '-' . $img->getClientOriginalName();
                    $img->move(public_path() . $destination, $imageName);
                    $imageData[]  = $imageName;
                }

                $imageUpload->images = json_encode($imageData);
                $imageUpload->save();
                return redirect()->route('img.showImages')->with('success', 'Image Upload Successfully Done.');
            }
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }

    public function imageEdit($id){
        try{
            $imageEdit = Image::find($id);
            return view('multiple_imgUpload.edit',compact('imageEdit'));
        }catch(Exception $e){
            dd($e->getMessage());
        }
    }

    public function imageUpdate(Request $request){
        try{ 
            $request->validate([
            'images.*' => 'mimes:jpeg,jpg,png,gif,csv,txt,pdf|max:2048'
        ]);

            $imageUpdate = Image::find($request->id);
            $imageUpdate->img_name = $request->img_name;

            if($reqImg = $request->file('images')){
                $destination = "/Images/";
                $oldImages = json_decode($imageUpdate->images);
                // if(!empty($oldImages)){
                //     foreach($oldImages as $oldImg){
                //         // dd(public_path().$destination.$oldImg);
                //         if(file_exists(public_path().$destination.$oldImg)){
                //             unlink(public_path().$destination.$oldImg);
                //         }
                //     }
                // }
                foreach($reqImg as $img){
                    
                    $rand = Str::random(5);
                    $imgName = $rand.'-'.time().'-'. $img->getClientOriginalName();
                    $img->move(public_path().$destination,$imgName);
                    $imageData[]= $imgName;
                }
                $allimgs = array_merge($oldImages,$imageData);
                $imageUpdate->images = json_encode($allimgs);
            }
            $imageUpdate->update();
            return redirect()->route('img.showImages')->with('success',"Data Update Successfull.");

        }catch(Exception $e){
            dd($e->getMessage());
        }
    }

    public function updateTimeDeleteImg(Request $request){
            $deleteIMG = Image::find($request->id);
            if($reqImg = $request->imagename){
                $destination = "/Images/";
                $oldImages = json_decode($deleteIMG->images);

                // Delete Image on folder
                if(!empty($oldImages)){
                    foreach($oldImages as $oldImg){
                        // dd(public_path().$destination.$oldImg);
                        if($oldImg == $reqImg){
                            if(file_exists(public_path().$destination.$oldImg)){
                                unlink(public_path().$destination.$oldImg);
                            }
                        }
                    }
                }
                // Delete Image on folder End


                if (($key = array_search($reqImg, $oldImages)) !== false) {
                    unset($oldImages[$key]);
                }
                $newArr = array_values($oldImages);
                $deleteIMG->images = json_encode($newArr);
                $deleteIMG->update();
                return response()->json(["msg"=>'success']);
          
            }
            
    }
    

    public function imageDelete($id){
       try{
        Image::find($id)->delete();
        return redirect()->route('img.showImages')->with('delete',"Data Deleted Successfull.");
       }catch(Exception $e){
        dd($e->getMessage());
       }

    }
}
