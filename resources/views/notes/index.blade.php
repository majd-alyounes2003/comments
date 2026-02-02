@extends('layouts.app')

@section('title', 'یادداشت‌های من')

@section('content')
<div class="row mt-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2><i class="bi bi-journal-text"></i> یادداشت‌های من</h2>
            <a href="{{ route('notes.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> یادداشت جدید
            </a>
        </div>

        @if($notes->count() > 0)
            <div class="row">
                @foreach($notes as $note)
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title">{{ Str::limit($note->title, 50) }}</h5>
                                <p class="card-text text-muted">{{ Str::limit(strip_tags($note->content), 100) }}</p>
                                <small class="text-muted">
                                    <i class="bi bi-clock"></i> {{ $note->created_at->format('Y/m/d H:i') }}
                                </small>
                            </div>
                            <div class="card-footer bg-transparent">
                                <div class="btn-group w-100" role="group">
                                    <a href="{{ route('notes.show', $note) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-eye"></i> مشاهده
                                    </a>
                                    <a href="{{ route('notes.edit', $note) }}" class="btn btn-sm btn-outline-warning">
                                        <i class="bi bi-pencil"></i> ویرایش
                                    </a>
                                    <form action="{{ route('notes.destroy', $note) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" 
                                                onclick="return confirm('آیا مطمئن هستید؟')">
                                            <i class="bi bi-trash"></i> حذف
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="d-flex justify-content-center mt-4">
                {{ $notes->links() }}
            </div>
        @else
            <div class="card text-center py-5">
                <div class="card-body">
                    <i class="bi bi-journal-x" style="font-size: 4rem; color: #ccc;"></i>
                    <h4 class="mt-3">یادداشتی وجود ندارد</h4>
                    <p class="text-muted">اولین یادداشت خود را ایجاد کنید</p>
                    <a href="{{ route('notes.create') }}" class="btn btn-primary mt-3">
                        <i class="bi bi-plus-circle"></i> ایجاد یادداشت
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection

