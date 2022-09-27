<?php
namespace Grav\Plugin;

use Composer\Autoload\ClassLoader;
use Grav\Common\Plugin;
use Grav\Events\FlexRegisterEvent;
use RocketTheme\Toolbox\Event\Event;

/**
 * Class EventlistPlugin
 * @package Grav\Plugin
 */
class EventlistPlugin extends Plugin
{
    public $features = [
        'blueprints' => 1000,
    ];

    /**
     * @return array
     *
     * The getSubscribedEvents() gives the core a list of events
     *     that the plugin wants to listen to. The key of each
     *     array section is the event that the plugin listens to
     *     and the value (in the form of an array) contains the
     *     callable (or function) as well as the priority. The
     *     higher the number the higher the priority.
     */
    public static function getSubscribedEvents(): array
    {
        return [
            'onPluginsInitialized' => [
                // Uncomment following line when plugin requires Grav < 1.7
                // ['autoload', 100000],
                ['onPluginsInitialized', 0],
            ],
            FlexRegisterEvent::class => [
                ['onRegisterFlex', 0]
            ],
            'onTwigTemplatePaths'       => ['onTwigTemplatePaths', 0],
            'flex.router.events'        => ['createFlexPage', 0],
        ];
    }

    /**
     * Composer autoload
     *
     * @return ClassLoader
     */
    public function autoload(): ClassLoader
    {
        return require __DIR__ . '/vendor/autoload.php';
    }

    /**
     * Initialize the plugin
     */
    public function onPluginsInitialized(): void
    {
        // Don't proceed if we are in the admin plugin
        if ($this->isAdmin()) {
            return;
        }

        // Enable the main events we are interested in
        $this->enable([
            // Put your main events here
        ]);
    }

    /**
     * Auto enable flex-object blueprint
     */
    public function onRegisterFlex($event): void
    {
        $flex = $event->flex;

        $flex->addDirectoryType(
            'events',
            'blueprints://flex-objects/events.yaml'
        );
    }

    /**
     * Add current directory to twig lookup paths.
     */
    public function onTwigTemplatePaths()
    {
        $this->grav['twig']->twig_paths[] = __DIR__ . '/templates';
    }

    public function createFlexPage(Event $event): void
    {
        /** @var array $options */
        $options = $event['options'];

        /** @var Flex $pages */
        $object = $this->grav['flex']->getObject( $event['path'], $options['router'] );

        /** @var Pages $pages */
        $pages = $this->grav['pages'];
        $page = clone $pages->find( $event['base'] );

        if ( $object && $object['published'] === true )
        {
            /** @var array $options */
            $options = $page->header()->flex ?? $options;
            $options['id'] = $event['path'];

            // Update page.
            $object = $object->jsonSerialize();
            $page->title( $object['title'] );
            $page->modifyHeader( 'flex', $options );
            $page->modifyHeader( 'event', $object );
            $page->slug( $event['path'] );
            $page->redirect( null );
            $event['page'] = $page;
        }
        else
        {
            $this->grav->redirect( $page->redirect() );
        }

        $event->stopPropagation();
    }

}
