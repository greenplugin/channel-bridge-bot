<?php
declare(strict_types=1);

namespace App\TelegramController;


use App\Entity\Article;
use App\Service\HashTagService;
use App\Service\IncomingImageService;
use App\TelegramRouter\RouterUpdateInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use TgBotApi\BotApiBase\Type\MessageType;

class TelegramChannelPostController
{
    private $em;
    private $tagService;
    private $imageService;

    public function __construct(
        EntityManagerInterface $em,
        HashTagService $tagService,
        IncomingImageService $imageService
    ) {
        $this->em = $em;
        $this->tagService = $tagService;
        $this->imageService = $imageService;
    }

    public function textPost(RouterUpdateInterface $update, MessageType $post): void
    {
        $tags = $this->tagService->getTags($update->getUpdate()->channelPost);
        $article = new Article();
        $article->setContent($post->text);
        $article->addTags($tags);
        $this->em->persist($article);
        $this->em->flush();
    }

    /**
     * @param MessageType $post
     * @throws NonUniqueResultException
     */
    public function singleImagePost(MessageType $post): void
    {
        $tags = $this->tagService->getTags($post);
        $photo = $this->imageService->getImageFromMessage($post);
        $article = new Article();
        $article->setContent($post->caption);
        $article->addTags($tags);
        $article->addPhoto($photo);
        $this->em->persist($article);
        $this->em->flush();
    }
}
