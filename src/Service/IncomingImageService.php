<?php
declare(strict_types=1);

namespace App\Service;


use App\Entity\Photo;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use TgBotApi\BotApiBase\Type\MessageType;
use TgBotApi\BotApiBase\Type\PhotoSizeType;

class IncomingImageService
{
    private $em;
    private $hashTagService;

    public function __construct(EntityManagerInterface $em, HashTagService $hashTagService)
    {
        $this->em = $em;
        $this->hashTagService = $hashTagService;
    }

    /**
     * @param MessageType $messageType
     * @return Photo
     * @throws NonUniqueResultException
     */
    public function getImageFromMessage(MessageType $messageType): Photo
    {
        $actualImage = $this->getImageMaxSize($messageType);
        $result = $this->em->getRepository(Photo::class)
            ->findOneByImageId($actualImage->fileId);
        if (!$result) {
            $result = new Photo();
            $result->setFileId($actualImage->fileId);
            $result->setDescription($messageType->caption);
            $result->addTags($this->hashTagService->getTags($messageType));
            $this->em->persist($result);
            $this->em->flush();
        }
        return $result;
    }

    private function getImageMaxSize(MessageType $messageType): PhotoSizeType
    {
        $result = null;
        foreach ($messageType->photo as $photo) {
            if (!$result) {
                $result = $photo;
            }
            if (($result->height + $result->width) < ($photo->height + $photo->width)) {
                $result = $photo;
            }
        }
        return $result;
    }
}
