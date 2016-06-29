<?php

class AdminLoginController extends AdminBaseController
{

    /**
     * コンストラクタ
     */
    public function __construct()
    {
        // POSTの際はトークンチェックを入れる
//        $this->beforeFilter('csrf', ['on' => 'post']);
//            parent::__construct();
    }

    /**
     * 初期表示
     *
     * @return \Illuminate\View\View
     */
    public function getIndex()
    {   
        Session::clear();
         //セッション確認
        $disp['username'] = '';
        $disp['remember'] = null;
        // バリデートの場合
        if (Input::old('username') || Input::old('remember')) {
            $disp['username'] = Input::old('username');
            $disp['remember'] = Input::old('remember');
        } else {
            // Cookie確認
            $disp['username'] = Cookie::get('u');
            $disp['remember'] = Cookie::get('r');
        }
        Log::debug($disp);
        return View::make('admin.login', $disp);
    }

    /**
     * ログイン処理
     *
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function postLogin()
    {
        $post = Input::only('username', 'password', 'remember');
        $model = new AdminLoginManager();
        if ($model->validate($post) === false) {
            // エラーメッセージをテンプレートに渡す
            return Redirect::action('AdminLoginController@getIndex')
                ->withErrors($model->errors())
                ->withInput();
        } else {
            // テンプレート振り分け処理
            $userData = $model->logon($post['username'], $post['password']);
            // 引き当てられなければエラー表示
            if (empty($userData)) {
                $error = [];
                $error['messages'] = 'ユーザー名又はパスワードが間違っています。';
                return Redirect::action('AdminLoginController@getIndex')
                    ->withErrors($error)
                    ->withInput();
            }
            // セッションに上げる
            // 権限によってセッション・cookie有効期限を変更
//            if ($userData->authority_id < 2) {
//                $sesTime = 43200;   // 24h
//                $cookTime = 20160;  // 2週間
//            } else {
//                $sesTime = 7200;    // 12h
//                $cookTime = 10080;  // 1週間
//            }
            
            $sesTime = 43200;   // 24h
            $cookTime = 20160;  // 2週間
            
            Session::put('userData', serialize($userData), $sesTime);
            // ログイン状態維持ならクッキーに登録
            if ($post['remember'] == 1) {
                // 分単位でcookie有効期限を設定
                $cook1 = Cookie::make('u', $post['username'], $cookTime);
                $cook2 = Cookie::make('r', $post['remember'], $cookTime);
                if ($userData->authority_id <= 1) {
                    // PX権限なら総合管理画面へ
                    return Redirect::action('AdminTotalLoginController@getIndex')
                        ->withCookie($cook1)
                        ->withCookie($cook2);
                } else {
                    // 一般権限ならリダイレクト
                    return $this->mediaRedirect($post['username']);
                }
            } else {
                // PX権限ならそのままView表示
//                if ($userData->authority_id <= 1) {
//                    return Redirect::action('AdminTotalLoginController@getIndex');
                      dd('Dang nhap thanh cong');
//                } else {
//                    // 一般権限ならリダイレクト
//                    return $this->mediaRedirect($post['username']);
//                }
            }
        }
    }
//
//    /**
//     * メディア用のリダイレクト処理
//     *
//     * @param $userName
//     *
//     * @return \Illuminate\Http\RedirectResponse
//     */
//    private function mediaRedirect($userName)
//    {
//        $model = new AdminTotalLoginManager();
//        $mediaInfo = $model->getSesData($userName);
//        Session::set('mediaData', $mediaInfo, 7200);
////        $mediaInfo = $model->getMediaInfo($userName);
////        Session::set('mediaData', serialize($mediaInfo), 7200);
//        // 一般権限ならリダイレクト
//        return Redirect::action('AdminTopController@getIndex', $userName);
//    }
}
