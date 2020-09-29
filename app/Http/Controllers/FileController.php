<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use App\Models\File;

class FileController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    public function upload(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|file|mimes:jpeg,jpg,png,doc,docx,docs,xls,xlsx,pdf',
        ]);

        // after validate 
        $ext = $request->file->extension();
        $name = url()."/uploads/NC-".time().".".$ext; // create filename
        $request->file('file')->move("uploads",$name); //move file to folder

        $add = File::create([ //save to file name to database
            "file_name" => $name
        ]);

        if($add){ // if success after save file to database
            return response()->json([
               "message"=> "Success add File", 
                "data" => $add
                ], 201);
        }else{
            return response()->json([
               "message"=> "Failed add File", 
                "data" => null
                ], 200);
        }
    }

    //
}
