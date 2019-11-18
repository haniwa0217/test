<?php
namespace App\Http\Controllers;

use App\Folder;
use App\Task; 
use Illuminate\Http\Request;
use App\Http\Requests\CreateTask;
use App\Http\Requests\EditTask;
use Illuminate\Support\Facades\Auth;


class TaskController extends Controller
{
    public function index(int $id)
    {
        // ★ ユーザーのフォルダを取得する
        $folders = Auth::user()->folders()->get();
        
        // 選ばれたフォルダを取得する
        $current_folder = Folder::find($id);
        // 選ばれたフォルダに紐づくタスクを取得する
        $tasks = $current_folder->tasks()->get();
        return view('tasks/index', [
            'folders' => $folders,
            'current_folder_id' => $current_folder->id,
            'tasks' => $tasks,
        ]);
    }
    public function showCreateForm(int $id)
    {
        return view('tasks/create', [
            'folder_id' => $id
        ]);
    }
    public function create(int $id, CreateTask $request)
    {
        $current_folder = Folder::find($id);
        $task = new Task();
        $task->title = $request->title;
        $task->due_date = $request->due_date;
        $current_folder->tasks()->save($task);
        return redirect()->route('tasks.index', [
            'id' => $current_folder->id,
        ]);
    }
    public function showEditForm(int $id, int $task_id)
    {
        $task = Task::find($task_id);
        return view('tasks/edit', [
            'task' => $task,
        ]);
    }
    public function edit(int $id, int $task_id, EditTask $request)
    {
        $task = Task::find($task_id);
        $task->title = $request->title;
        $task->status = $request->status;
        $task->due_date = $request->due_date;
        $task->save();
        return redirect()->route('tasks.index', [
            'id' => $task->folder_id,
        ]);
    }
    public function delete(int $id,int $task_id )
    {
        $task = Task::find($task_id);
        $task->delete();
        if (is_null(task)) {
            return view('home');
        }
        
        // フォルダがあればそのフォルダのタスク一覧にリダイレクトする
        return redirect()->route('tasks.index', [
            'id' => $task->folder_id,
        ]);
    }
}

?>

<!--
    public function index(int $id) → Route::get('/folders/{id}/tasks') なので、(int $id)で{id}の部分に好きな数字を入力で表示される。
    $folders = Folder::all(); →$foldersに Folder  モデルの all クラスメソッドですべてのフォルダデータをデータベースから取得を代入。
    return view('tasks/index', ['folders' => $folders,'current_folder_id' => $id,] 
    →return view で取得したデータ結果をtasks/indexに返しなさい。　'folders'に$foldersの値を代入。
    ※view 関数の第一引数がテンプレートファイル名で、第二引数がテンプレートに渡すデータです。第二引数には配列を渡す。
    ※「'folders' => $folders,」キー名が変数名になる。
-->

