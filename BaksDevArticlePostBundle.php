<?php

declare(strict_types=1);

namespace BaksDev\Article\Post;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;

final class BaksDevArticlePostBundle extends AbstractBundle
{
    public const string NAMESPACE = __NAMESPACE__.'\\';

    public const string PATH = __DIR__.DIRECTORY_SEPARATOR;

    public function loadExtension(array $config, ContainerConfigurator $container, ContainerBuilder $builder): void
    {
        $services = $container->services()
            ->defaults()
            ->autowire()
            ->autoconfigure();

        $services->load(self::NAMESPACE, self::PATH)
            ->exclude([
                self::PATH.'{Entity,Resources,Type}',
                self::PATH.'**/*Message.php',
                self::PATH.'**/*DTO.php',
            ]);

    }
}