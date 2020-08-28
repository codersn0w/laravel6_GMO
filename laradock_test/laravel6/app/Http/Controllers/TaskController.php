<?php

namespace App\Http\Controllers;

use App\Folder;
use App\Http\Requests\CreateTask;
use App\Http\Requests\EditTask;
use App\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * タスク一覧
     * @param Folder $folder
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // ユーザーのフォルダを取得する
        $folders = Auth::user()->folders()->get();

        // 選ばれたフォルダに紐づくタスクを取得する
        //$tasks = $folder->tasks()->get();

        /*for($i=0; $i<count($folders); $i++){
            $tasks1 = $folders[$i]->tasks()->get();
            $offset=$folders[$i];
            $array[$offset]=$tasks1;
        }*/
        $array1=[];
        $done=array();
        foreach($folders as $folder1){
            $tasks1=$folder1->tasks()->get();
            $array2=array();
            foreach($tasks1 as $tasks2){
                $array2[]=$tasks2;
                /*if($task2->status==1){
                    $done[] = $task2;
                }*/
            }
            $array1[$folder1->id]=$array2;
        }
        return view('tasks/index', [
            'folders' => $folders,
            //'current_folder_id' => $folder->id,
            //'tasks' => $tasks,
            'array' => $array1,
            //'done' => $done,
        ]);
    }

    /**
     * タスク作成フォーム
     * @param Folder $folder
     * @return \Illuminate\View\View
     */
    public function showCreateForm(Folder $folder)
    {
        return view('tasks/create', [
            'folder_id' => $folder->id,
            'folder' => $folder,
        ]);
    }

    /**
     * タスク作成
     * @param Folder $folder
     * @param CreateTask $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create(Folder $folder, CreateTask $request)
    {
        $task = new Task();
        $task->title = $request->title;
        $task->due_date = $request->due_date;
        $task->user_name = Auth::user()->name;

        $folder->tasks()->save($task);

        return redirect()->route('tasks.index');
    }

    /**
     * タスク編集フォーム
     * @param Folder $folder
     * @param Task $task
     * @return \Illuminate\View\View
     */
    public function showEditForm(Folder $folder, Task $task)
    {
        $this->checkRelation($folder, $task);

        return view('tasks/edit', [
            'task' => $task,
        ]);
    }

    /**
     * タスク編集
     * @param Folder $folder
     * @param Task $task
     * @param EditTask $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function edit(Folder $folder, Task $task, EditTask $request)
    {
        $this->checkRelation($folder, $task);

        $task->title = $request->title;
        $task->status = $request->status;
        $task->due_date = $request->due_date;
        $task->user_name = Auth::user()->name;
        $task->save();

        return redirect()->route('tasks.index');
    }

    public function showDeleteForm(Folder $folder, Task $task)
    {
        $this->checkRelation($folder, $task);

        return view('tasks/delete', [
            'folder' => $folder,
            'task' => $task,
        ]);
    }

    public function delete(Folder $folder, Task $task)
    {
        $this->checkRelation($folder, $task);
        $task->delete();

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