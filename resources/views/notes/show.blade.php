@extends('layouts.app')

@section('title', $note->title)

@section('content')
<div class="row justify-content-center mt-4">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0"><i class="bi bi-journal-text"></i> {{ $note->title }}</h4>
                <div>
                    <a href="{{ route('notes.edit', $note) }}" class="btn btn-sm btn-warning">
                        <i class="bi bi-pencil"></i> ویرایش
                    </a>
                    <form action="{{ route('notes.destroy', $note) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" 
                                onclick="return confirm('آیا مطمئن هستید؟')">
                            <i class="bi bi-trash"></i> حذف
                        </button>
                    </form>
                </div>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <small class="text-muted">
                        <i class="bi bi-clock"></i> ایجاد شده در: {{ $note->created_at->format('Y/m/d H:i') }}
                        @if($note->updated_at != $note->created_at)
                            | آخرین ویرایش: {{ $note->updated_at->format('Y/m/d H:i') }}
                        @endif
                    </small>
                </div>
                <div class="note-content" style="white-space: pre-wrap; line-height: 1.8;">
                    {{ $note->content }}
                </div>
            </div>
            <div class="card-footer bg-transparent">
                <a href="{{ route('notes.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-right"></i> بازگشت به لیست
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

