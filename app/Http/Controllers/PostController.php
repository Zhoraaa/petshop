<?php

namespace App\Http\Controllers;

use App\Models\Post;
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
                'author_id' => Auth::id(),
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
        // Подключаем таблицу пользователей и достаём имя автора поста по id записанном в посте
        $posts = Post::join('users', 'posts.author_id', '=', 'users.id')
            ->select('posts.*', 'users.login as author')
            ->where('post_type_id', 1)
            ->paginate(3);

        return view("post.list", compact("posts"));
    }
    public function seePost($id)
    {
        $post = Post::join('users', 'posts.author_id', '=', 'users.id')
            ->select('posts.*', 'users.login as author')
            ->where("posts.id", $id)
            ->first();

        $theme = ['firstPost' => $post];

        // Поиск ответов по id поста
        if ($post) {
            $replies = optional($post->replies)->toArray();
            $theme += ['replies' => $replies];
        }

        return view("post.only", compact("theme"));
    }
    public function postEditor(Request $request)
    {
        $data['oldData'] = Post::find($request->id);

        $data['reply_to'] = $request->idToReply;

        if ($data['reply_to']) {
            return view("post.editor", compact('data'));
        }

        return view("post.editor", compact('data'));
    }
    public function postDelete(Request $request)
    {
        $post = DB::table("posts")->where('id', $request->id)->delete();

        return redirect()->route("forum");
    }
}
