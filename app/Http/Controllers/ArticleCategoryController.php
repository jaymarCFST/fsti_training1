<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateArticleCategoryRequest;
use App\Http\Requests\UpdateArticleCategoryRequest;
use App\Http\Resources\ArticleCategoryResource;
use App\Models\ArticleCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Traits\RequestValidatorTrait as Validator;
use Lcobucci\JWT\Exception;

class ArticleCategoryController extends Controller
{
    use Validator;

    /**
     * Get all Categories
     *
     * @params $request
     * @returns $categories
     */
    public function index(Request $request)
    {
        $page_limit = $request->page_limit ?? 10;
        $categories = ArticleCategory::paginate($page_limit);

        $categories_resource = ArticleCategoryResource::collection($categories)->response()->getData();

        return response()->json($categories_resource, 200);
    }

    /**
     * Get data of a Category
     *
     * @params $category_id
     * @return $category
     */
    public function get($id)
    {
        $category = ArticleCategory::find($id);

        return response()->json($category);
    }

    /**
     * Create/Store a new Category
     *
     * @params $request
     * @return $category
     */
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $requestStatus = Validator::isValidRequest($request, CreateArticleCategoryRequest::rules());
            if ($requestStatus) return $requestStatus;

            $input = $request->all();
            $input['updated_user_id'] = auth()->user()->id;
            $category = ArticleCategory::create($input);

            DB::commit();

            return response()->json($category);
        }catch (Exception $e)
        {
            DB::rollback();

            return response()->json($e->getMessage(), 500);
        }
    }

    /**
     * Update a Category
     *
     * @params $request
     * @return $category
     */
    public function update(Request $request)
    {
        DB::beginTransaction();

        try {
            $requestStatus = Validator::isValidRequest($request, UpdateArticleCategoryRequest::rules());
            if ($requestStatus) return $requestStatus;

            $input = $request->all();
            $category = ArticleCategory::find($input['id']);
            $category->update($input);

            DB::commit();

            return response()->json($category, 200);
        }catch (Exception $e)
        {
            DB::rollback();

            return response()->json($e->getMessage(), 500);
        }
    }

    /**
     * Delete a Category
     *
     * @params $category_id
     * @return $message
     */
    public function delete($id)
    {
        $category = ArticleCategory::find($id);
        $category->delete();

        return response()->json("A category was deleted successfully.");
    }

}
