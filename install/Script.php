<?php

namespace Spear;

use Composer\Script\Event;
use GitWrapper\GitWrapper;

class Script
{
    public static function postCreateProject(Event $event)
    {
        $git = new GitWrapper();
        
        $installator = new Install($event->getIO(), $git);

        $installator->process();
    }
}
