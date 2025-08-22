@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- Article Card -->
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h2>Article</h2>
                    <a href="{{ route('admin.index') }}" class="btn btn-outline-secondary">Back</a>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <h2 class="article-title">{!! $article->title !!}</h2>
                    <div class="article-content">{!! $article->content !!}</div>
                </div>
            </div>

            <!-- Comments Card -->
            <div class="card">
                <div class="card-header">
                    <h2>Comments</h2>
                </div>
                <div class="card-body">
                    <!-- Comment Form -->
                    <div class="comment-form mb-4">
                        <h4>Add a Comment</h4>
                        <form action="{{ route('comment.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="article_id" value="{{ $article->id }}">
                            <div class="mb-3">
                                <textarea name="comment" class="form-control" rows="3" placeholder="Write your comment here..."></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit </button>
                        </form>
                    </div>

                    <!-- Comments List -->
                    <div class="comments-list">
                        @foreach ($article->comments()->whereNull('parent_id')->get() as $comment)
                            <div class="comment mb-4">
                                <div class="comment-header d-flex justify-content-between align-items-center">
                                    <div class="user-info">
                                        <strong>{{ $comment->user->name }}</strong>
                                        <span class="text-muted ml-2">{{ $comment->created_at->diffForHumans() }}</span>
                                    </div>
                                    <div>
                                        <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#replyComment-{{ $comment->id }}">Reply</button>
                                        @if(auth()->id() == $comment->user_id)
                                            <form action="{{ route('comment.destroy', $comment->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this comment?')">Delete</button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                                <div class="comment-body mt-2">
                                    {{ $comment->comment }}
                                </div>

                                <!-- Reply -->
                                @foreach ($comment->replies as $reply)
                                    <div class="reply mt-3">
                                        <div class="reply-header d-flex justify-content-between align-items-center">
                                            <div class="user-info">
                                                <strong>{{ $reply->user->name }}</strong>
                                                <span class="text-muted ml-2">{{ $reply->created_at->diffForHumans() }}</span>
                                            </div>
                                            @if(auth()->id() == $reply->user_id)
                                                <form action="{{ route('comment.destroy', $reply->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this reply?')">Delete</button>
                                                </form>
                                            @endif
                                        </div>
                                        <div class="reply-body mt-2">
                                            {{ $reply->comment }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Reply Modal -->
                            <div class="modal fade" id="replyComment-{{ $comment->id }}">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Reply to Comment</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('comment.store') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="article_id" value="{{ $article->id }}">
                                                <input type="hidden" name="comment_id" value="{{ $comment->id }}">
                                                <div class="mb-3">
                                                    <textarea name="comment" class="form-control" rows="3" placeholder="Write your reply here..."></textarea>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Submit Reply</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card-header {
        background-color: #f8f9fa;
        border-bottom: none;
    }
    .card {
        border: none;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        margin-bottom: 1.5rem;
    }
    .card-body {
        padding: 1.25rem;
    }
    .article-title {
        font-size: 1.75rem;
        margin-bottom: 1rem;
    }
    .article-content {
        font-size: 1.1rem;
        line-height: 1.6;
    }
    .comment {
        border-bottom: 1px solid #e9ecef;
        padding-bottom: 1rem;
    }
    .comment:last-child {
        border-bottom: none;
    }
    .reply {
        background-color: #f8f9fa;
        border-radius: 0.25rem;
        padding: 1rem;
        margin-left: 2rem;
        border-left: 3px solid #007bff;
    }
    .user-info {
        display: flex;
        align-items: center;
    }
    .user-info strong {
        margin-right: 0.5rem;
    }
    .comment-body, .reply-body {
        margin-top: 0.5rem;
    }
    .btn-outline-primary {
        color: #007bff;
        border-color: #007bff;
    }
    .btn-outline-primary:hover {
        color: #fff;
        background-color: #007bff;
    }
</style>
@endsection