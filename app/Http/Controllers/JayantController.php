<?php

namespace App\Http\Controllers;
use App\Models\Form;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class JayantController extends Controller
{
public function index($filename = '')   
    {   
        $state = DB::table('states')->pluck("name", "id")->toArray();
        $city = DB::table('cities')->pluck("city", "id")->toArray();
        $languages = DB::table('languages')->pluck("name","id")->toArray();
     
        return view('index', ['states'=>$state, 'cities'=>$city, 'languages'=>$languages, 'filename'=>$filename]);
    }

    public function show()
    {
        //$posts = DB::table('forms')->get();
        $posts = DB::table('forms')
        ->leftJoin('cities', 'forms.city', '=', 'cities.id')
        ->select('forms.*', 'cities.city as city_name')
        ->get();

        return view('show', ['posts'=>$posts]);
    }
    public function edit($id)
    {   
        
        $city = DB::table('cities')->pluck("city", "id")->toArray();;
        $state = DB::table('states')->pluck("name", "id")->toArray();
        $languages = DB::table('languages')->pluck("name","id")->toArray();
        $post = DB::table('forms')->where('id', $id)->first();

        return view('index',['post'=>$post, 'states'=>$state, 'cities'=>$city, 'languages'=>$languages]);
    }

    public function update(Request $request, $id)
    {
       
        $validated =  Validator::make($request->all(),[
            'name' => 'required|max:255',
            'mobile' => 'required',
            'email' => 'required',
            'password' => 'required',
            'address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'zip' => 'required',
        ]);

        
        
        if ($validated->passes()) {
            // Validation rules have passes
          
         

            DB::table('forms')->where('id', $id)->update(array(
                'name' => $request->name,
                'mobile'=> $request->mobile,
                'email' => $request->email,
                'password' => $request->password,
                'address' => $request->address,
                'city' => $request->city,
                'state' => $request->state,
                'zip' => $request->zip,
                'language' => implode(', ', $request->languages)
            ));



            return redirect()->route('show')->with('message', 'Update Successfully');

        } else {
            // Validation rules failed
    
            return back()->withErrors($validated)->withInput()->with('message', 'Either Data Does not exist or have validation error');
        }
    }


    public function store(Request $request)
    {   
        //dd(request()->all());
      

        $validated =  Validator::make($request->all(),[
            'name' => 'required|max:255',
            'mobile' => 'required',
            'email' => 'required',
            'password' => 'required',
            'address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'zip' => 'required|int',
            'languages' =>'required',
            // 'image' =>'required'
        ]);

        if ($validated->passes()) {
            // Validation rules have passed
                
            $post = new Form;
        
            $post->name = $request->name;
            $post->mobile = $request->mobile;
            $post->email = $request->email;
            $post->password = $request->password;
            $post->address = $request->address;
            $post->city = $request->city;
            $post->state = $request->state;
            $post->zip = $request->zip;
            $post->language = implode(', ', $request->languages);
            $post->image = $request->image;
    
            $post->save();
    
            // Your additional logic here
    
            return redirect()->route('show')->with('message', 'Validation and additional logic succeeded.');
        } else {
            // Validation rules failed
    
            return back()->withErrors($validated)->withInput();
        }
        
    }

    public function delete($id)
    {
        DB::table('forms')->where('id', $id)->delete();
        return back();
    }

    public function upload(Request $request)
    {   
        
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/uploads', $filename); // Store in the 'public' disk

            // return view('index', ['filename'=> $filename]);
            if(isset($request->upload_id)){

                // return redirect()->route('edit' ['id'=>$id]);
                DB::table('forms')->where('id', $request->upload_id)->update(array(
                    'image' => $filename,
                    
                ));
                return Redirect::to('edit/'.$request->upload_id);
            }
            return Redirect::to('index/'.$filename);
        }

        return redirect()->route('index')->with('message', 'Image Upload Failed');
    }

}   
