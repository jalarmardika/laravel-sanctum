<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Post;

class PostOwner
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $currentUserId = auth()->user()->id;
        $post = Post::find($request->id);

        if ($post == null) {
            return response()->json(['message' => 'Post Not Found'], 404);
        } elseif ($currentUserId != $post->user_id) {
            return response()->json(['message' => 'Forbidden'], 403);
        } else {
            return $next($request);
        }
    }
}
