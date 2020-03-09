<?php

/**
 * Plugin Name:         Code Snippet Block
 * Plugin URI:          https://github.com/ItinerisLtd/code-snippet-block
 * Description:         TODO.
 * Version:             0.0.1
 * Requires at least:   5.3
 * Requires PHP:        7.3
 * Author:              Itineris Limited
 * Author URI:          https://www.itineris.co.uk
 * License:             MIT
 * License URI:         https://opensource.org/licenses/MIT
 * Text Domain:         code-snippet-block
 */

declare(strict_types=1);

namespace Itineris\CodeSnippetBlock;

// If this file is called directly, abort.
if (! defined('WPINC')) {
    die;
}

if (file_exists(__DIR__ . '/vendor/autoload.php')) {
    require_once __DIR__ . '/vendor/autoload.php';
}

// TODO: Move into PHP classes.
function render($attributes): string
{
    $content = (string) ($attributes['content'] ?? '');
    if ('' === $content) {
        return '';
    }

    // TODO!
    $language = (string) ($attributes['language'] ?? 'php');

    $authorization = null;
    if (defined('CODE_SNIPPET_BLOCK_GITHUB_PERSONAL_ACCESS_TOKEN')) {
        $authorization = sprintf(
            'token %s',
            constant('CODE_SNIPPET_BLOCK_GITHUB_PERSONAL_ACCESS_TOKEN')
        );
    }
    
    // TODO: Save into transient cache.
    // TODO: Add TLC Transients.
    // $cacheKey = md5($content);

    // TODO: Allow customizing language.
    $response = wp_remote_post('https://api.github.com/markdown/raw', [
        'headers' => [
            'content-type' => 'text/plain',
            'accept' => 'application/vnd.github.v3+json',
            'authorization' => $authorization,
        ],
        'body' => sprintf("```%s\n%s\n```", $language, $content),
    ]);

    return wp_kses_post($response['body']);
}

// TODO: Move into PHP classes.
add_action('init', function (): void
{
    $jsAssets = include __DIR__ . '/dist/js/editor.asset.php';
    wp_register_script(
        'code-snippet-block-editor-script',
        plugins_url('dist/js/editor.js', __FILE__),
        $jsAssets['dependencies'],
        $jsAssets['version']
    );

    // TODO: cssAssets?
    // $cssAssets = include __DIR__ . '/dist/css/editor.asset.php';
    wp_register_style(
        'code-snippet-block-block-style',
        plugins_url( 'dist/css/block.css', __FILE__ ),
        // $cssAssets['dependencies'],
        // $cssAssets['version']
    );

    register_block_type('code-snippet-block/code-snippet-block', [
        'editor_script' => 'code-snippet-block-editor-script',
        'style' => 'code-snippet-block-block-style',
        'render_callback' => __NAMESPACE__ . '\\render',
    ]);
});
