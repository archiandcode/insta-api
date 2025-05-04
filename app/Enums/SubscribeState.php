<?php

namespace App\Enums;

enum SubscribeState:string {
    case Subscribed = 'subscribed';
    case Unsubscribed = 'unsubscribed';
    case AlreadySubscribed = 'already_subscribed';
    case AlreadyUnsubscribed = 'already_unsubscribed';
}
