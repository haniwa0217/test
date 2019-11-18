<?php

namespace App\Http\Controllers;

use App\Folder;
use App\Http\Requests\CreateFolder;
use Illuminate\Http\Request;
use App\Http\Requests\Delete;
use Illuminate\Support\Facades\Auth;

class FolderController extends Controller
{
public function showCreateForm()
{
return view('folders/create');
}
public function create(CreateFolder $request)
{
// フォルダモデルのインスタンスを作成する
$folder = new Folder();
// タイトルに入力値を代入する
$folder->title = $request->title;
// ★ ユーザーに紐づけて保存
Auth::user()->folders()->save($folder);
// インスタンスの状態をデータベースに書き込む
$folder->save();
// 一覧にリダイレクト
return redirect()->route('tasks.index', [
'id' => $folder->id,
]);
}
public function delete(int $folder)
{
$folder = Folder::find($folder);
// ★ ユーザーに紐づけて削除
Auth::user()->folders()->delete($folder);
$folder->delete();
if (is_null($folder)) {
    return view('home');
}
// フォルダがあればそのフォルダのタスク一覧にリダイレクトする
return redirect()->route('tasks.index', [
    'id' => $folder->id,
]);
}

}