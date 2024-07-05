<?php

namespace App\Http\Controllers\admin\master;

use App\Http\Controllers\Controller;
use App\Models\MstArticle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $articles = MstArticle::paginate($request->limit ? $request->limit : 10);
        $articleTypes = MstArticle::getArticleType();
        return view('admin.master.article.index', compact('articles','articleTypes'));
    }

    public function create()
    {
        $articleTypes = MstArticle::getArticleType();
        return view('admin.master.article.create', compact('articleTypes'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'article_type_id' => 'required'
        ]);

        if ($validator->fails()) {
            \toastr()->error($validator->errors()->first());
            return redirect()->back()->withErrors($validator)->withInput();
        }
        try {
            DB::beginTransaction();

            if ($request->id) {
                $color = MstArticle::find($request->id);
                $color->update($request->except('_token'));
            } else {
                MstArticle::create($request->except('_token'));
            }

            DB::commit();

            \toastr()->success(ucfirst('Article successfully saved'));
            return redirect()->route('admin.master.article.index');
        } catch (\Exception $e) {
            DB::rollBack();
            \toastr()->error('Error occurred while saving article');
            return redirect()->back();
        }
    }

    public function show($id)
    {
        $article = MstArticle::find($id);
        $articleTypes = MstArticle::getArticleType();
        return view('admin.master.article.create', compact('article', 'articleTypes'));
    }


    public function delete($id)
    {
        $color = MstArticle::find($id);
        $color->delete();

        \toastr()->success(ucfirst('Article successfully deleted'));
        return redirect()->back();
    }
}
