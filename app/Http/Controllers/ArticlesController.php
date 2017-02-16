<?php

namespace LaraCall\Http\Controllers;

use LaraCall\Article;

class ArticlesController extends Controller {

    public function index()
    {
        $articles = Article::paginate(5);
        $articles->setPath('articles/');

        return view('article.index', compact('articles'));
    }

	public function show($slug)
	{
		$article = Article::findBySlugOrId($slug);

		return view('article.view', compact('article'));
	}

}
