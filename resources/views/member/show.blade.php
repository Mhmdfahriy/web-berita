@extends('layouts.app')

@section('content')
<div class="container my-4">
    <div class="row justify-content-center">
        <div class="col-md-8">

            {{-- Artikel --}}
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h2 class="mb-0">{{ $article->title }}</h2>
                </div>
                <div class="card-body">
                    <div class="article-content mb-3">{!! $article->content !!}</div>
                    <a href="{{ route('member.index') }}" class="btn btn-outline-secondary btn-sm mb-3">← Kembali ke Artikel</a>
                </div>
            </div>

            {{-- Komentar --}}
            <div class="card shadow-sm">
                <div class="card-header">
                    <h4>Komentar</h4>
                </div>
                <div class="card-body">
                    {{-- Form komentar baru --}}
                    <form action="{{ route('comment.store') }}" method="POST" class="mb-4">
                        @csrf
                        <input type="hidden" name="article_id" value="{{ $article->id }}">
                        <textarea name="comment" class="form-control mb-2" rows="3" placeholder="Tulis komentar kamu..."></textarea>
                        <button type="submit" class="btn btn-primary btn-sm">Kirim</button>
                    </form>

                    {{-- List komentar & replies --}}
                    @foreach ($article->comments()->whereNull('parent_id')->get() as $comment)
                        <div class="comment mb-3 p-3 border rounded">
                            <div class="comment-header mb-1">
                                <strong>{{ $comment->user->name }}</strong>
                                <span class="text-muted ml-2">{{ $comment->created_at->diffForHumans() }}</span>
                            </div>
                            <div class="comment-body mb-2">{{ $comment->comment }}</div>

                            {{-- Replies --}}
                            @foreach ($comment->replies as $reply)
                                <div class="reply mb-2 p-2 border-left rounded">
                                    <strong>{{ $reply->user->name }}</strong>
                                    <span class="text-muted ml-2">{{ $reply->created_at->diffForHumans() }}</span>
                                    <p class="mb-0">{{ $reply->comment }}</p>
                                </div>
                            @endforeach

                            {{-- Form reply --}}
                            <form action="{{ route('comment.store') }}" method="POST" class="mt-2">
                                @csrf
                                <input type="hidden" name="article_id" value="{{ $article->id }}">
                                <input type="hidden" name="comment_id" value="{{ $comment->id }}">
                                <textarea name="comment" class="form-control mb-2" rows="2" placeholder="Balas komentar..."></textarea>
                                <button type="submit" class="btn btn-outline-primary btn-sm">Balas</button>
                            </form>
                        </div>
                    @endforeach

                </div>
            </div>

        </div>
    </div>
</div>

<style>
.article-content {
    font-size: 1.1rem;
    line-height: 1.6;
}
.comment {
    background: #ffffff;
    transition: box-shadow 0.2s;
}
.comment:hover {
    box-shadow: 0 2px 6px rgba(0,0,0,0.1);
}
.reply {
    background: #f8f9fa;
    border-left: 3px solid #007bff;
    margin-left: 2rem;
    border-radius: 0.25rem;
    transition: box-shadow 0.2s;
}
.reply:hover {
    box-shadow: 0 1px 4px rgba(0,0,0,0.1);
}
@media (max-width: 576px) {
    .reply {
        margin-left: 1rem;
    }
}
</style>
@endsection
