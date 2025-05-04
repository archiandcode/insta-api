<?php

namespace App\Enums;

enum LikeState: string
{
    case Liked = 'liked';
    case AlreadyLiked = 'already_liked';
    case Unliked = 'unliked';
    case AlreadyUnliked = 'already_unliked';
}
