<?php
$pdo = dbConnect();

function dbConnect(){
    try {
        $pdo = new PDO('mysql:dbname=product;host=mydbinstance.ccar6ddlrh8f.ap-northeast-1.rds.amazonaws.com', 'root', 'pathcreateroot');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        return $pdo;
    } catch (Exception $e) {
        exit($e->getMessage());
    }
}

/**
 * htmlspecialcharsのラッパー
 * @param $str
 * @return string
 */
function h($str) {
    return htmlspecialchars($str, ENT_QUOTES);
}

/**
 * アカウント名、パスワードの入力チェック
 * @param $account,$password
 * @return boolean
 */
function inputAuth($account,$password) {
    if(!empty($account) && !empty($password)) {
    // ユーザー名チェック
        if(!preg_match('/^[0-9a-zA-Z]{4,24}$/', $account)) {
            $_SESSION['status'] = 'error';
            return false;
        // パスワードチェック
        } elseif (!preg_match('/^[0-9a-zA-Z]{4,24}$/', $password)) {
            $_SESSION['status'] = 'error';
            return false;
        } else {
            return true;
        }
    } else {
        $_SESSION['status'] = 'error';
        return false;
    }
}

/**
 * アカウント名の重複チェック
 * @param $account
 * @return boolean
 */
function accountAuth($account){
    try {
        $pdo = new PDO('mysql:dbname=product;host=mydbinstance.ccar6ddlrh8f.ap-northeast-1.rds.amazonaws.com', 'root', 'pathcreateroot');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    } catch (Exception $e) {
        exit($e->getMessage());
    }
    $statement = $pdo->query('SELECT * FROM accounts');
    while($row = $statement->fetch()) {
        if($row['account'] === $account) {
            return true;
        }
    }
    return false;
}
