<?php
declare(strict_types=1);

namespace App\TelegramRoutes;


use App\TelegramController\TelegramChannelPostController;
use App\TelegramRouter\Exceptions\RouteExtractionException;
use App\TelegramRouter\RouterUpdateInterface;
use App\TelegramRouter\Rules\ChannelSingleImagePostRule;
use App\TelegramRouter\Rules\ChannelTextPostRule;
use App\TelegramRouter\TelegramRoute;
use App\TelegramRouter\TelegramRouteCollection;

class Message implements RouteSetterInterface
{

    /**
     * @param TelegramRouteCollection $collection
     * @throws RouteExtractionException
     */
    public function register(TelegramRouteCollection $collection): void
    {
        $collection->add(new TelegramRoute(
            RouterUpdateInterface::TYPE_CHANNEL_POST,
            [new ChannelTextPostRule()],
            TelegramChannelPostController::class . '::textPost'
        ))->extract(['post' => 'channelPost']);
        $collection->add(new TelegramRoute(
            RouterUpdateInterface::TYPE_CHANNEL_POST,
            [new ChannelSingleImagePostRule()],
            TelegramChannelPostController::class . '::singleImagePost'
        ))->extract(['post' => 'channelPost']);
    }
}
