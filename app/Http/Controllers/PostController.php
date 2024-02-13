<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    //
    public function postSave(Request $postRaw)
    {

        $postData = $postRaw->validate([
            "theme" => "required",
            "text" => "required",
        ]);

        $postType = ($postRaw->reply_to) ? 2 : 1;
        $postType = ($postRaw->post_type) ? $postRaw->post_type : $postType;

        if (!$postRaw->post_id) {
            $post_id = Post::insertGetId([
                'theme' => $postRaw->theme,
                'text' => $postRaw->text,
                'post_type_id' => $postType,
                'reply_to' => (!empty($postRaw->reply_to)) ? $postRaw->reply_to : null,
            ]);
        } else {
            $post = Post::find($postRaw->post_id)
                ->update([
                    'theme' => $postRaw->theme,
                    'text' => $postRaw->text,
                    'updated_at'
                ]);
            $post_id = $postRaw->post_id;
        }

        return redirect()->route('seePost', ['id' => $post_id]);
    }
    public function allPosts()
    {
        $posts = Post::where('post_type_id', 1)
            ->paginate(3);
        // dd($posts);

        return view("post.forum", compact("posts"));
    }
    public function seePost($id)
    {
        $post = Post::where("posts.id", $id)
            ->first();

        $theme = ['firstPost' => $post];

        if ($post) {
            $replies = optional($post->replies)->toArray();
            $theme += ['replies' => $replies];
        }

        // dd($theme);

        return view("post.only", compact("theme"));
    }
    public function postEditor(Request $request)
    {
        $data['post'] = Post::find($request->id);
        $data['reply_to'] = $request->idToReply;
        $data['ptypes'] = PostType::get();

        return view("post.editor", compact('data'));
    }
    public function postDelete(Request $request)
    {
        $post = DB::table("posts")->where('id', $request->id)->delete();

        return redirect()->route("forum");
    }
}
