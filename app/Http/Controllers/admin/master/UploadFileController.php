<?php

namespace App\Http\Controllers\admin\master;

use App\Http\Controllers\Controller;
use App\Models\MstUploads;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UploadFileController extends Controller
{
    public function index(Request $request){
        $uploads = MstUploads::paginate($request->limit ? $request->limit : 10);
        return view('admin.master.uploads.index')->with([
            'uploads' => $uploads
        ]);
    }

    public function create(){
        return view('admin.master.uploads.create');
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'upload' => 'required|file',
        ]);
        if($validator->fails()){
            \toastr()->error($validator->errors()->first());
            return redirect()->back()->withErrors($validator)->withInput();
        }
        try {
            $fileNameWithExt = $request->file('upload')->getClientOriginalName();
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('upload')->getClientOriginalExtension();
            $fileNameToStore = $fileName.'_'.time().'.'.$extension;
            $path = $request->file('upload')->storeAs($fileNameToStore);

            MstUploads::create([
                'filename' => $fileName,
                'file_path' => $path
            ]);

            DB::commit();

            \toastr()->success(ucfirst('file successfully uploaded'));
            return redirect()->route('admin.master.upload.file.index');
        } catch (\Exception $e) {
            DB::rollBack();
            \toastr()->error('Error occurred while saving color');
            return redirect()->back();
        }

    }

    public function download($file)
    {
        $filePath = storage_path('files/' . $file);

        if (file_exists($filePath)) {
            return response()->download('files/'.$filePath);
        } else {
            return response()->json(['file does not exist']);
        }
    }

}
