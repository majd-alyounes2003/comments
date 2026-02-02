@extends('layouts.app')

@section('title', 'ویرایش یادداشت')

@section('content')
<div class="row justify-content-center mt-4">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-warning text-dark">
                <h4 class="mb-0"><i class="bi bi-pencil"></i> ویرایش یادداشت</h4>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('notes.update', $note) }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="title" class="form-label">عنوان</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" 
                               id="title" name="title" value="{{ old('title', $note->title) }}" required autofocus>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="content" class="form-label">محتوای یادداشت</label>
                        <textarea class="form-control @error('content') is-invalid @enderror" 
                                  id="content" name="content" rows="10" required>{{ old('content', $note->content) }}</textarea>
                        @error('content')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <small class="text-muted">
                            <i class="bi bi-info-circle"></i> ایجاد شده در: {{ $note->created_at->format('Y/m/d H:i') }}
                            @if($note->updated_at != $note->created_at)
                                | آخرین ویرایش: {{ $note->updated_at->format('Y/m/d H:i') }}
                            @endif
                        </small>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle"></i> به‌روزرسانی
                        </button>
                        <a href="{{ route('notes.index') }}" class="btn btn-secondary">
                            <i class="bi bi-x-circle"></i> انصراف
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

