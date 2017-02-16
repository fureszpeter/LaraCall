<?php namespace LaraCall\Http\Controllers\Subscriber;

use A2bApiClient\Client;
use Illuminate\Contracts\Auth\Guard;
use LaraCall\Domain\Entities\User;
use LaraCall\Http\Controllers\SubscriberController;

class DashboardController extends SubscriberController
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @var User
     */
    private $user;

    /**
     * @param Client $client
     * @param Guard  $guard
     */
    public function __construct(Client $client, Guard $guard)
    {
        parent::__construct();
        view()->share('type', '');
        $this->client = $client;
        $this->user   = $guard->user();
    }

    public function index()
    {
        $title  = "Dashboard";
        $credit = $this
            ->client
            ->getSubscription()
            ->getByPin($this->user->getSubscription()->getDefaultPin()->getPin())
            ->credit;

//        $news         = Article::count();
//        $newscategory = ArticleCategory::count();
//        $users        = User::count();
//        $photo        = Photo::count();
//        $photoalbum   = PhotoAlbum::count();
        $news         = null;
        $newscategory = null;
        $users        = null;
        $photo        = null;
        $photoalbum   = null;

        return view(
            'admin.dashboard.index',
            compact('news', 'newscategory', 'users', 'photo', 'photoalbum', 'credit', 'title')
        );
    }
}
