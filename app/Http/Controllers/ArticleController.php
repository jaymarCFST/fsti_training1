<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Traits\RequestValidatorTrait as Validator;
use Lcobucci\JWT\Exception;

class ArticleController extends Controller
{
    use Validator;

    /**
     * Get All Articles
     *
     * @param $request
     * @return article resource collection
     */
    public function index(Request $request)
    {
        $page_limit = $request->page_limit ?? 10;

        $articles = Article::with(['category', 'user'])->paginate($page_limit);

        $article_resource = ArticleResource::collection($articles)->response()->getData();

        return response()->json($article_resource);
    }

    /**
     * Get an Article
     *
     * @param $article_id
     * @returns article resource
     */
    public function get($id)
    {
        $article = Article::with(['category', 'user'])->find($id);

        if(isset($article))
        {
            $article_resource = new ArticleResource($article);

            return response()->json($article_resource);
        }else{
            return response()->json("Article not found.");
        }
    }

    /**
     * Create/Store a new Article
     *
     * @param $request
     * @return article resource
     */
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $requestStatus = Validator::isValidRequest($request, CreateArticleRequest::rules());
            if ($requestStatus) return $requestStatus;

            $input = $request->all();
            $article = Article::create($input);

            $article_resource = new ArticleResource($article->with(['category', 'user'])->find($article->id));

            DB::commit();

            return response()->json($article_resource);
        } catch (Exception $e)
        {
            DB::rollback();

            return response()->json($e->getMessage(), 500);
        }
    }

    /**
     * Update an Article
     *
     * @param $request
     * @returns $article
     */
    public function update(Request $request)
    {
        DB::beginTransaction();

        try {
            $requestStatus = Validator::isValidRequest($request, UpdateArticleRequest::rules());
            if ($requestStatus) return $requestStatus;

            $input = $request->all();
            $article = Article::find($input['id']);
            $article->update($input);

            DB::commit();

            return response()->json($article, 200);
        }catch (Exception $e)
        {
            DB::rollback();

            return response()->json($e->getMessage(), 500);
        }
    }

    /**
     * Delete an Article
     *
     * @param $article_id
     * @return $message
     */
    public function delete($id)
    {
        $article = Article::find($id);
        $article->delete();

        return response()->json("An article has been deleted successfully.", 200);
    }
}
