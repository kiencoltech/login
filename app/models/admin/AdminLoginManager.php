<?php
/**
 * Created by PhpStorm.
 * User: satak_000
 * Date: 2015/08/07
 * Time: 12:17
 */
class AdminLoginManager extends ModelBase {
    /**
     * @var array バリデートルール
     */
    private static $rules = [
        'username' => ['required', 'max:16', 'min:2', 'regex:/\A[a-z\d|_-]+\z/i'],
        'password' => ['required', 'max:64', 'min:8', 'regex:/\A[a-z\d|!?_-]+\z/i'],
        'remember' => 'sometimes|numeric|min:1|max:1'
    ];

    private static $msg = [
        'username' => 'ユーザー名',
        'password' => 'パスワード'
    ];
    /** @var array エラーオブジェクト(バリデート用) */
    private $errors;

    /**
     * コンストラクタ(ModelBaseのコンストラクタ呼び出し)
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * ログイン出来るかチェック＋引き当てられればメディア情報を返却
     * @param string $id ユーザーID
     * @param string $pass パスワード
     * @throws Exception
     * @return boolean false
     */
    public function logon($id, $pass) {
        // DBにハッシュ値が登録されている。
        $password = hash('sha256', $pass);
        Log::debug('password->'.$password);
        // DB変更
        $this->changeDbName('login');
        $res = $this->table('admin_user_master_tbl')->select('*')->where('username', '=', $id)->where('password', '=', $password)->get();
        $ret = isset($res[0])?$res[0]:null;
        if (!empty($ret)) {
            return $ret;
        } else {
            return false;
        }
    }

    /**
     * 入力項目のバリデートを行う。
     * @param array $post
     * @return bool
     */
    public function validate(array $post) {
        $v = Validator::make($post, self::$rules);
        $v->setAttributeNames(self::$msg);
        if ($v->fails()) {
            $this->errors = $v->errors();
            return false;
        }
        return true;
    }

    /**
     * 入力項目によるエラーを返却する
     * @return mixed
     */
    public function errors() {
        return $this->errors;
    }
}