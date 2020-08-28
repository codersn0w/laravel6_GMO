<?php

namespace App\Http\Controllers;

use App\Folder;
use Illuminate\Http\Request;
use App\Http\Requests\CreateFolder;
use Illuminate\Support\Facades\Auth;
class FolderController extends Controller
{
    public function showCreateForm()
    {
        return view('folders/create');
    }

    public function create(createFolder $request)
	{
	    // フォルダモデルのインスタンスを作成する
	    $folder = new Folder();
	    // タイトルに入力値を代入する
	    $folder->title = $request->title;
	    // ユーザーに紐づけて保存
        Auth::user()->folders()->save($folder);
	    // インスタンスの状態をデータベースに書き込む
	    $folder->save();

	    return redirect()->route('tasks.index');
	}

	/**
     * タスク編集フォーム
     * @param Folder $folder
     * @param Task $task
     * @return \Illuminate\View\View
     */
    public function showEditForm(Folder $folder)
    {
        //$this->checkRelation($folder);

        return view('folders/edit', [
            'folder' => $folder,
        ]);
    }

    /**
     * タスク編集
     * @param Folder $folder
     * @param Task $task
     * @param EditTask $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function edit(Folder $folder, createFolder $request)
    {
        //$this->checkRelation($folder, $task);

        $folder->title = $request->title;
        $folder->save();

        return redirect()->route('tasks.index');
    }

    public function showDeleteForm(Folder $folder)
    {
        //$this->checkRelation($folder, $task);

        return view('folders/delete', [
            'folder' => $folder,
            //'task' => $task,
        ]);
    }

    public function delete(Folder $folder)
    {
        //$this->checkRelation($folder, $task);
        $folder->tasks()->delete();
        $folder->delete();

        return redirect()->route('tasks.index');
    }

    /**
     * フォルダとタスクの関連性があるか調べる
     * @param Folder $folder
     * @param Task $task
     */
    private function checkRelation(Folder $folder, Task $task)
    {
        if ($folder->id !== $task->folder_id) {
            abort(404);
        }
    }
}
