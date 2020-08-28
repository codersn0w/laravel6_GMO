@extends('layout')

@section('content')
  <div class="container">
    <div class="row">
      <div class="column col-md-6">
        @if(count($folders)==0)
        <div class="panel panel-default">
          <div class="panel-heading">フォルダはまだ作られていません。
          </div>
          <div class="panel-body">
            <center>
            <a href="{{ route('folders.create') }}" class="btn btn-primary">
              フォルダを新規作成
            </a>
          </center>
          </div>
        </div>
        @endif
        @foreach($folders as $folder)
        <div class="panel panel-default">
          <div class="panel-heading">{{ $folder->title }}
            <span class="pull-right">
            <a href="{{ route('tasks.create', ['folder' => $folder->id]) }}">
              <i class="fas fa-plus-circle"></i>
            </a>&nbsp;
            |&nbsp;
            <a href="{{ route('folders.edit', ['folder' => $folder->id]) }}">
              <i class="fas fa-edit"></i>
            </a>&nbsp;
            <a href="{{ route('folders.delete', ['folder' => $folder->id]) }}">
              <i class="fas fa-trash-alt"></i>
            </a>
            </span>
          </div>
          <table class="table">
            <thead>
            <tr>
              <th>更新者</th>
              <th>タイトル</th>
              <th>状態</th>
              <th>期限</th>
              <th></th>
              <th></th>
            </tr>
            </thead>

            <tbody>
            @foreach($array[$folder->id] as $task)
              <tr>
                <td>{{ $task->user_name }}</td>
                <td>{{ $task->title }}</td>
                <td>
                  <span class="label {{ $task->status_class }}">{{ $task->status_label }}</span>
                </td>
                <td>{{ $task->formatted_due_date }}</td>
                <td><a href="{{ route('tasks.edit', ['folder' => $task->folder_id, 'task' => $task->id]) }}"><i class="fas fa-edit"></i></a></td>
                <td><a href="{{ route('tasks.delete', ['folder' => $task->folder_id, 'task' => $task->id]) }}"><i class="fas fa-trash-alt"></i></a></td>
              </tr>
            @endforeach
            </tbody>
          </table>
        </div>
        @endforeach
      </div>
      <div class="column col-md-6">
        <div class="panel panel-default">
          <div class="panel-heading">完了タスク一覧</div>
          <table class="table">
            <thead>
            <tr>
              <th>更新者</th>
              <th>タイトル</th>
              <th>状態</th>
              <th>期限</th>
              <th></th>
              <th></th>
            </tr>
            </thead>

            <tbody>
            @foreach($folders as $folder)
            @foreach($array[$folder->id] as $task)
              @if($task->status==3)
              <tr>
                <td>{{ $task->user_name }}</td>
                <td>{{ $task->title }}</td>
                <td>
                  <span class="label {{ $task->status_class }}">{{ $task->status_label }}</span>
                </td>
                <td>{{ $task->formatted_due_date }}</td>
                <td><a href="{{ route('tasks.edit', ['folder' => $task->folder_id, 'task' => $task->id]) }}"><i class="fas fa-edit"></i></a></td>
                <td><a href="{{ route('tasks.delete', ['folder' => $task->folder_id, 'task' => $task->id]) }}"><i class="fas fa-trash-alt"></i></a></td>
              </tr>
              @endif
            @endforeach
            @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
@endsection