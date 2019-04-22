<?php
declare(strict_types=1);

namespace App\TelegramRouter\Rules;


use App\TelegramRouter\RouterUpdateInterface;

class ChannelSingleImagePostRule
{
    /**
     * @param RouterUpdateInterface $update
     * @return mixed
     */
    public function match(RouterUpdateInterface $update): bool
    {
        $post = $update->getUpdate()->channelPost;
        dump($post);
        if (!$post || $post->mediaGroupId || !$post->caption) {
            return false;
        }

        return (bool)$post->photo;
    }
}
