<?php
declare(strict_types=1);

namespace App\TelegramRoutes;


use App\TelegramRouter\TelegramRouteCollection;

class Photo implements RouteSetterInterface
{
    /**
     * @param TelegramRouteCollection $collection
     * @throws \App\TelegramRouter\Exceptions\RouteExtractionException
     */
    public function register(TelegramRouteCollection $collection): void
    {
//        $collection->add(new TelegramRoute(
//            RouterUpdateInterface::TYPE_MESSAGE,
//            [new PhotoRule()],
//            TelegramImagePaletteController::class
//        ))
//            ->extract(['photo' => 'min'], PhotoExtractor::class)
//            ->extract(['user' => 'message.from'])
//            ->extract(['chat' => 'message.chat']);
    }
}
