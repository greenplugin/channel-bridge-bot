<?php
declare(strict_types=1);

namespace App\Service;


use App\Entity\Tag;
use Doctrine\ORM\EntityManagerInterface;
use TgBotApi\BotApiBase\Type\MessageEntityType;
use TgBotApi\BotApiBase\Type\MessageType;

class HashTagService
{
    private $em;
    private $cachedResult = [];

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param MessageType $message
     * @return Tag[]
     */
    public function getTags(MessageType $message): array
    {
        if (isset($this->cachedResult[$message->messageId])) {
            return $this->cachedResult[$message->messageId];
        }
        $tags = [];
        if ($message->text) {
            $tags = $this->getTagsFromMessage($message->entities, $message->text);
        }
        if ($message->caption) {
            $tags = $this->getTagsFromMessage($message->captionEntities, $message->caption);
        }
        $result = $this->em->getRepository(Tag::class)->getHashTags($tags);

        foreach ($tags as $tag) {
            if (!isset($result[$tag])) {
                $result[$tag] = new Tag();
                $result[$tag]->setValue($tag);
                $this->em->persist($result[$tag]);
            }
        }
        $this->em->flush();

        $this->cachedResult[$message->messageId] = $result;
        return $result;
    }

    /**
     * @param MessageEntityType[] $tags
     * @param string              $content
     * @return string[]
     */
    private function getTagsFromMessage(array $tags, string $content): array
    {
        $result = [];
        foreach ($tags as $tag) {
            $result[] = mb_substr($content, $tag->offset + 1, $tag->length - 1);
        }
        return $result;
    }
}
