@extends('layout')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col col-md-offset-3 col-md-6">
        <nav class="panel panel-default">
          <div class="panel-heading">タスクを削除</div>
          <div class="panel-body">
              <div class="alert alert-danger">
                  <p>本当に削除しますか？</p>
              </div>
              <h5>タスク: {{ $task->title }} (in {{ $folder->title }})</h5>
            <form
                action="{{ route('tasks.delete', ['folder' => $task->folder_id, 'task' => $task->id]) }}"
                method="POST"
            >
              @csrf
              <div class="text-right">
                <a href="{{ route('tasks.index') }}" class="btn">
                  キャンセル
                </a>
                <button type="submit" class="btn btn-primary">削除</button>
              </div>
            </form>
          </div>
        </nav>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
  @include('share.flatpickr.scripts')
@endsection