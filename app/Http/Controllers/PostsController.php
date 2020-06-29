<?php

namespace App\Http\Controllers;

use App\posts;
use Illuminate\Http\Request;
use App\Http\Resources\Posts as PostsRecource;
use Illuminate\Support\Facades\Validator;
class PostsController extends Controller
{

    use apiTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Allposts = posts::all();
        $posts =   PostsRecource::collection(posts::all());
        $count = count($Allposts);


        return $this->apiResponce([$posts,$count]);

    }

    public function findById($id)
    {


        $post = new PostsRecource(posts::find($id));
        if($post){
            return $this->apiResponce($post);
        }
        else{
            return $this->apiResponce(null , 'not found', 400);
        }

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

        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:posts|max:255',
            'body' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->apiResponce(null , $validator->errors() , 400);
        }

        // Store the blog post...



        if($request->file('input_img')){
        if ($request->hasFile('input_img')) {
            if($request->file('input_img')->isValid()) {
                try {
                    $file = $request->file('input_img');
                    $name = time() . '.' . $file->getClientOriginalExtension();

                    $request->file('input_img')->move("images", $name);

                } catch (Illuminate\Filesystem\FileNotFoundException $e) {

                }
            }
        }
        $data = [
            'title' => $request->title,
            'body' => $request->body,
            'input_img' => $name
        ];
    }else{
        $data = [
            'title' => $request->title,
            'body' => $request->body,

        ];
    }



        $post = posts::create($data);



        if($post){
            return $this->apiResponce($post, null , 200);
        }
        else{
            return $this->apiResponce(null , 'nukwnown error', 400);
        }

    }

    public function update(Request $request , $id)
    {

        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:posts|max:255',
            'body' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->apiResponce(null , $validator->errors() , 400);
        }

        // Store the blog post...


        $post = posts::find($id);
        if(!$post){
            return $this->apiResponce(null , 'not found', 400);
        }


        $post->update($request->all());


        if($post){
            return $this->apiResponce($post, null , 200);
        }
        else{
            return $this->apiResponce(null , 'nukwnown error', 400);
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\posts  $posts
     * @return \Illuminate\Http\Response
     */
    public function show(posts $posts)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\posts  $posts
     * @return \Illuminate\Http\Response
     */
    public function edit(posts $posts)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\posts  $posts
     * @return \Illuminate\Http\Response
     */


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\posts  $posts
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = posts::find($id);



        if(!$post){
            return $this->apiResponce(null , 'not found', 400);
        }else{
            $post->delete();
            return $this->apiResponce($post);
        }




    }
}
