@extends('layouts.app')

@section('title', 'جستجوی یادداشت')

@section('content')
<div class="row mt-4">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('notes.search') }}">
                    <div class="input-group">
                        <input type="text" class="form-control" name="q" 
                               value="{{ $query }}" placeholder="جستجو در یادداشت‌ها (فارسی یا انگلیسی)...">
                        <button class="btn btn-primary" type="submit">
                            <i class="bi bi-search"></i> جستجو
                        </button>
                    </div>
                </form>
            </div>
        </div>

        @if(!empty($query))
            <h4 class="mb-3">نتایج جستجو برای: "{{ $query }}"</h4>
        @endif

        @if(isset($notes) && $notes->count() > 0)
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
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            @if(method_exists($notes, 'links'))
                <div class="d-flex justify-content-center mt-4">
                    {{ $notes->appends(['q' => $query])->links() }}
                </div>
            @endif
        @elseif(!empty($query))
            <div class="card text-center py-5">
                <div class="card-body">
                    <i class="bi bi-search" style="font-size: 4rem; color: #ccc;"></i>
                    <h4 class="mt-3">نتیجه‌ای یافت نشد</h4>
                    <p class="text-muted">لطفا کلمه دیگری را امتحان کنید</p>
                </div>
            </div>
        @else
            <div class="card text-center py-5">
                <div class="card-body">
                    <i class="bi bi-search" style="font-size: 4rem; color: #ccc;"></i>
                    <h4 class="mt-3">جستجو در یادداشت‌ها</h4>
                    <p class="text-muted">لطفا کلمه مورد نظر خود را در کادر بالا وارد کنید</p>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection

