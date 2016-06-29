<?php

class AdminBaseController extends Controller {
    /** @var  画面タイトル */
    protected $title;

    /** @var  メディアのセッション情報 */
    protected $sesMediaObj;

    /**
     * コンストラクタ
     */
    public function __construct()
    {
        $this->beforeFilter(function () {
            // サイドメニューの取得
            $m = new AdminSideMenuManager();
            $menuList = $m->getMenu();
            // サブメニューの取得
            $subMenuList = $m->getSubmenu();
            // テンプレート共通として挿入
            View::share('menuList', $menuList);
            View::share('subMenuList', $subMenuList);
            View::share('title', $this->title);
        });
    }

}
