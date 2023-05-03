<?php

use Illuminate\Filesystem\Filesystem;
use Illuminate\Translation\FileLoader;
use Illuminate\Translation\Translator;

if (!function_exists('trans')) {
    /**
     * Translate the given message.
     *
     * This code is not really optimal outside of Laravel (without IOC container),
     * but it should not be used in production anyway.
     *
     * @param  string|null  $key
     * @param  array  $replace
     * @param  string|null  $locale
     * @return \Illuminate\Contracts\Translation\Translator|string|array|null
     */
    function trans(string $key = null, array $replace = [], string $locale = null): Translator|array|string|null
    {
        $translationDir = dirname(__DIR__).'/lang';

        $fileLoader = new FileLoader(new Filesystem(), $translationDir);
        $fileLoader->addNamespace('lang', $translationDir);
        $fileLoader->load('en', 'validation', 'lang');
        $translator = new Translator($fileLoader, 'en');
        $translator->setLocale('en');
        $translator->setFallback('en');

        if (is_null($key)) {
            return $translator;
        }

        return $translator->get($key, $replace, $locale);
    }
}
