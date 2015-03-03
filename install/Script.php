<?php

namespace Spear;

use Composer\Script\Event;

class Script
{
    public static function postCreateProject(Event $event)
    {
        $installator = new Install($event->getIO());

        $installator->process();
    }
}
