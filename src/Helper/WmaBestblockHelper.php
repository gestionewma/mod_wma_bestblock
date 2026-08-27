<?php

/**
 * @package     Wma.Module.WmaBestblock
 * @subpackage  mod_wma_bestblock
 *
 * @author      Team Developer by WMA Web Maker Agency <wmaextension@gmail.com>
 * @copyright   (C) 2026 WMA Web Maker Agency. All rights reserved.
 * @license     GNU General Public License version 2 or later;
 * @link        https://www.wma.ovh
 * @version     1.0.23
 * @date        27/08/2026
 * @file        src/Helper/WmaBestblockHelper.php
 */

namespace Wma\Module\WmaBestblock\Site\Helper;

defined('_JEXEC') or die;

use Joomla\CMS\Router\Route;
use Joomla\Registry\Registry;
use stdClass;

class WmaBestblockHelper
{
    public function getSets(Registry $params): array
    {
        $rawSets = $params->get('sets', []);
        $sets    = [];

        if (empty($rawSets)) {
            return $sets;
        }

        foreach ((array) $rawSets as $group) {
            if (!is_object($group)) {
                continue;
            }

            // Data is nested under 'set' key due to <fields name="set"> in formsource
            $raw = isset($group->set) && is_object($group->set) ? $group->set : $group;
            $sets[] = $this->normalizeSet($raw);
        }

        return $sets;
    }

    private function normalizeSet(object $raw): stdClass
    {
        $set = new stdClass();

        // ── Colori set ──────────────────────────────────────────────────────
        $set->color_bg        = $this->sanitizeColor($raw->color_bg ?? '#2a2218');
        $set->color_secondary = $this->sanitizeColor($raw->color_secondary ?? '#6b5344');
        $set->color_text      = $this->sanitizeColor($raw->color_text ?? '#ffffff');

        $shadowMap = [
            'none'   => 'none',
            'light'  => '0 1px 4px rgba(0,0,0,0.5)',
            'strong' => '0 1px 8px rgba(0,0,0,0.9), 0 0 3px rgba(0,0,0,0.7)',
        ];
        $shadowKey      = (string) ($raw->text_shadow ?? 'none');
        $set->text_shadow = $shadowMap[$shadowKey] ?? 'none';

        // ── B1 · Hero (col 1-2, righe 1-2) ──────────────────────────────────
        $b1img = $this->parseImageField($raw->b1_image ?? null);
        $set->b1_image_src     = $b1img['src'];
        $set->b1_image_alt     = $b1img['alt'];
        $set->b1_title         = (string) ($raw->b1_title ?? '');
        $set->b1_title_tag     = $this->safeTag((string) ($raw->b1_title_tag ?? 'h2'), ['h1', 'h2', 'h3', 'h4', 'p', 'div']);
        $set->b1_title_size    = $this->normalizeFontSize($raw->b1_title_size ?? '');
        $set->b1_subtitle      = (string) ($raw->b1_subtitle ?? '');
        $set->b1_subtitle_tag  = $this->safeTag((string) ($raw->b1_subtitle_tag ?? 'p'), ['h1', 'h2', 'h3', 'h4', 'p', 'div']);
        $set->b1_subtitle_size = $this->normalizeFontSize($raw->b1_subtitle_size ?? '');
        $set->b1_paragraph     = (string) ($raw->b1_paragraph ?? '');
        $set->b1_link_href     = $this->resolveLink(
            (string) ($raw->b1_link_article ?? ''),
            (string) ($raw->b1_link_url ?? '')
        );

        // ── B2 · Card Testo (col 3, riga 1) ──────────────────────────────────
        $b2img = $this->parseImageField($raw->b2_image ?? null);
        $set->b2_image_src     = $b2img['src'];
        $set->b2_image_alt     = $b2img['alt'];
        $set->b2_title         = (string) ($raw->b2_title ?? '');
        $set->b2_title_tag     = $this->safeTag((string) ($raw->b2_title_tag ?? 'h3'), ['h1', 'h2', 'h3', 'h4', 'p', 'div']);
        $set->b2_title_size    = $this->normalizeFontSize($raw->b2_title_size ?? '');
        $set->b2_subtitle      = (string) ($raw->b2_subtitle ?? '');
        $set->b2_subtitle_tag  = $this->safeTag((string) ($raw->b2_subtitle_tag ?? 'p'), ['h1', 'h2', 'h3', 'h4', 'p', 'div']);
        $set->b2_subtitle_size = $this->normalizeFontSize($raw->b2_subtitle_size ?? '');
        $set->b2_paragraph     = (string) ($raw->b2_paragraph ?? '');
        $set->b2_link_href     = $this->resolveLink(
            (string) ($raw->b2_link_article ?? ''),
            (string) ($raw->b2_link_url ?? '')
        );

        // ── B3 · Immagine + Overlay (col 4, righe 1-2) ──────────────────────
        $b3img = $this->parseImageField($raw->b3_image ?? null);
        $set->b3_image_src     = $b3img['src'];
        $set->b3_image_alt     = $b3img['alt'];
        $set->b3_title         = (string) ($raw->b3_title ?? '');
        $set->b3_title_tag     = $this->safeTag((string) ($raw->b3_title_tag ?? 'h2'), ['h1', 'h2', 'h3', 'h4', 'p', 'div']);
        $set->b3_title_size    = $this->normalizeFontSize($raw->b3_title_size ?? '');
        $set->b3_subtitle      = (string) ($raw->b3_subtitle ?? '');
        $set->b3_subtitle_tag  = $this->safeTag((string) ($raw->b3_subtitle_tag ?? 'p'), ['h1', 'h2', 'h3', 'h4', 'p', 'div']);
        $set->b3_subtitle_size = $this->normalizeFontSize($raw->b3_subtitle_size ?? '');
        $set->b3_paragraph     = (string) ($raw->b3_paragraph ?? '');
        $set->b3_link_href     = $this->resolveLink(
            (string) ($raw->b3_link_article ?? ''),
            (string) ($raw->b3_link_url ?? '')
        );

        // ── B4 · Testo (col 1, riga 3) ───────────────────────────────────────
        $b4img = $this->parseImageField($raw->b4_image ?? null);
        $set->b4_image_src     = $b4img['src'];
        $set->b4_image_alt     = $b4img['alt'];
        $set->b4_title         = (string) ($raw->b4_title ?? '');
        $set->b4_title_tag     = $this->safeTag((string) ($raw->b4_title_tag ?? 'h3'), ['h1', 'h2', 'h3', 'h4', 'p', 'div']);
        $set->b4_title_size    = $this->normalizeFontSize($raw->b4_title_size ?? '');
        $set->b4_subtitle      = (string) ($raw->b4_subtitle ?? '');
        $set->b4_subtitle_tag  = $this->safeTag((string) ($raw->b4_subtitle_tag ?? 'p'), ['h1', 'h2', 'h3', 'h4', 'p', 'div']);
        $set->b4_subtitle_size = $this->normalizeFontSize($raw->b4_subtitle_size ?? '');
        $set->b4_paragraph     = (string) ($raw->b4_paragraph ?? '');
        $set->b4_link_href     = $this->resolveLink(
            (string) ($raw->b4_link_article ?? ''),
            (string) ($raw->b4_link_url ?? '')
        );

        // ── B5 · Immagine (col 2, riga 3) ────────────────────────────────────
        $b5img = $this->parseImageField($raw->b5_image ?? null);
        $set->b5_image_src     = $b5img['src'];
        $set->b5_image_alt     = $b5img['alt'];
        $set->b5_title         = (string) ($raw->b5_title ?? '');
        $set->b5_title_tag     = $this->safeTag((string) ($raw->b5_title_tag ?? 'h3'), ['h1', 'h2', 'h3', 'h4', 'p', 'div']);
        $set->b5_title_size    = $this->normalizeFontSize($raw->b5_title_size ?? '');
        $set->b5_subtitle      = (string) ($raw->b5_subtitle ?? '');
        $set->b5_subtitle_tag  = $this->safeTag((string) ($raw->b5_subtitle_tag ?? 'p'), ['h1', 'h2', 'h3', 'h4', 'p', 'div']);
        $set->b5_subtitle_size = $this->normalizeFontSize($raw->b5_subtitle_size ?? '');
        $set->b5_paragraph     = (string) ($raw->b5_paragraph ?? '');
        $set->b5_link_href     = $this->resolveLink(
            (string) ($raw->b5_link_article ?? ''),
            (string) ($raw->b5_link_url ?? '')
        );

        // ── B6 · Immagine (col 3, righe 2-3) ─────────────────────────────────
        $b6img = $this->parseImageField($raw->b6_image ?? null);
        $set->b6_image_src     = $b6img['src'];
        $set->b6_image_alt     = $b6img['alt'];
        $set->b6_title         = (string) ($raw->b6_title ?? '');
        $set->b6_title_tag     = $this->safeTag((string) ($raw->b6_title_tag ?? 'h3'), ['h1', 'h2', 'h3', 'h4', 'p', 'div']);
        $set->b6_title_size    = $this->normalizeFontSize($raw->b6_title_size ?? '');
        $set->b6_subtitle      = (string) ($raw->b6_subtitle ?? '');
        $set->b6_subtitle_tag  = $this->safeTag((string) ($raw->b6_subtitle_tag ?? 'p'), ['h1', 'h2', 'h3', 'h4', 'p', 'div']);
        $set->b6_subtitle_size = $this->normalizeFontSize($raw->b6_subtitle_size ?? '');
        $set->b6_paragraph     = (string) ($raw->b6_paragraph ?? '');
        $set->b6_link_href     = $this->resolveLink(
            (string) ($raw->b6_link_article ?? ''),
            (string) ($raw->b6_link_url ?? '')
        );

        // ── B7 · Card Testo (col 3, riga 4) ──────────────────────────────────
        $b7img = $this->parseImageField($raw->b7_image ?? null);
        $set->b7_image_src     = $b7img['src'];
        $set->b7_image_alt     = $b7img['alt'];
        $set->b7_title         = (string) ($raw->b7_title ?? '');
        $set->b7_title_tag     = $this->safeTag((string) ($raw->b7_title_tag ?? 'h3'), ['h1', 'h2', 'h3', 'h4', 'p', 'div']);
        $set->b7_title_size    = $this->normalizeFontSize($raw->b7_title_size ?? '');
        $set->b7_subtitle      = (string) ($raw->b7_subtitle ?? '');
        $set->b7_subtitle_tag  = $this->safeTag((string) ($raw->b7_subtitle_tag ?? 'p'), ['h1', 'h2', 'h3', 'h4', 'p', 'div']);
        $set->b7_subtitle_size = $this->normalizeFontSize($raw->b7_subtitle_size ?? '');
        $set->b7_paragraph     = (string) ($raw->b7_paragraph ?? '');
        $set->b7_link_href     = $this->resolveLink(
            (string) ($raw->b7_link_article ?? ''),
            (string) ($raw->b7_link_url ?? '')
        );

        // ── B8 · Immagine + Overlay (col 4, righe 3-4) ───────────────────────
        $b8img = $this->parseImageField($raw->b8_image ?? null);
        $set->b8_image_src     = $b8img['src'];
        $set->b8_image_alt     = $b8img['alt'];
        $set->b8_title         = (string) ($raw->b8_title ?? '');
        $set->b8_title_tag     = $this->safeTag((string) ($raw->b8_title_tag ?? 'h3'), ['h1', 'h2', 'h3', 'h4', 'p', 'div']);
        $set->b8_title_size    = $this->normalizeFontSize($raw->b8_title_size ?? '');
        $set->b8_subtitle      = (string) ($raw->b8_subtitle ?? '');
        $set->b8_subtitle_tag  = $this->safeTag((string) ($raw->b8_subtitle_tag ?? 'p'), ['h1', 'h2', 'h3', 'h4', 'p', 'div']);
        $set->b8_subtitle_size = $this->normalizeFontSize($raw->b8_subtitle_size ?? '');
        $set->b8_paragraph     = (string) ($raw->b8_paragraph ?? '');
        $set->b8_link_href     = $this->resolveLink(
            (string) ($raw->b8_link_article ?? ''),
            (string) ($raw->b8_link_url ?? '')
        );

        // ── B9 · Pulsante Azione (col 1, riga 4) ─────────────────────────────
        $set->b9_label     = (string) ($raw->b9_label ?? 'Scopri di più');
        $set->b9_link_href = $this->resolveLink(
            (string) ($raw->b9_link_article ?? ''),
            (string) ($raw->b9_link_url ?? '')
        );

        // ── B10 · Prev (col 2a, riga 4) ──────────────────────────────────────
        $set->b10_label = (string) ($raw->b10_label ?? '← Precedente');

        // ── B11 · Next (col 2b, riga 4) ──────────────────────────────────────
        $set->b11_label = (string) ($raw->b11_label ?? 'Successivo →');

        return $set;
    }

    private function parseImageField(mixed $raw): array
    {
        if (empty($raw)) {
            return ['src' => '', 'alt' => ''];
        }

        if (is_string($raw)) {
            $decoded = json_decode($raw);

            if (json_last_error() === JSON_ERROR_NONE && isset($decoded->imagefile)) {
                $src = $this->normalizeImageSrc((string) $decoded->imagefile);

                return [
                    'src' => $src,
                    'alt' => $this->normalizeAltText((string) ($decoded->alt_text ?? ''), $src),
                ];
            }

            $src = $this->normalizeImageSrc($raw);

            return [
                'src' => $src,
                'alt' => $this->normalizeAltText('', $src),
            ];
        }

        if (is_object($raw)) {
            $src = $this->normalizeImageSrc((string) ($raw->imagefile ?? $raw->src ?? ''));

            return [
                'src' => $src,
                'alt' => $this->normalizeAltText((string) ($raw->alt_text ?? $raw->alt ?? ''), $src),
            ];
        }

        return ['src' => '', 'alt' => ''];
    }

    private function safeTag(string $tag, array $allowed): string
    {
        return in_array($tag, $allowed, true) ? $tag : $allowed[0];
    }

    private function sanitizeColor(string $color): string
    {
        $color = trim($color);

        if (preg_match('/^#([0-9a-fA-F]{3}|[0-9a-fA-F]{6})$/', $color)) {
            return $color;
        }

        return '#2a2218';
    }

    private function resolveLink(string $articleId, string $freeUrl): string
    {
        $articleId = trim($articleId);

        if ($articleId !== '' && (int) $articleId > 0) {
            return Route::_('index.php?option=com_content&view=article&id=' . (int) $articleId);
        }

        $freeUrl = trim($freeUrl);

        if ($freeUrl !== '') {
            if (filter_var($freeUrl, FILTER_VALIDATE_URL)) {
                $scheme = strtolower((string) parse_url($freeUrl, PHP_URL_SCHEME));

                if (in_array($scheme, ['http', 'https', 'mailto', 'tel'], true)) {
                    return $freeUrl;
                }
            }

            if (str_starts_with($freeUrl, '/')) {
                return $freeUrl;
            }
        }

        return '';
    }

    private function normalizeImageSrc(string $src): string
    {
        $src = trim($src);

        if ($src === '') {
            return '';
        }

        // Il campo accessiblemedia può aggiungere il metadato #joomlaImage://...
        $src = strtok($src, '#') ?: $src;
        $src = preg_replace('/\?.*$/', '', $src) ?? $src;

        if (preg_match('#^(?:[a-z][a-z0-9+.-]*:)?//#i', $src) || preg_match('#^[a-z][a-z0-9+.-]*:#i', $src)) {
            return $src;
        }

        return '/' . ltrim($src, '/');
    }

    private function normalizeAltText(string $alt, string $src): string
    {
        $alt = trim($alt);

        if ($alt !== '') {
            return $alt;
        }

        $src = strtok($src, '#') ?: $src;
        $src = strtok($src, '?') ?: $src;
        $name = pathinfo(rawurldecode(basename($src)), PATHINFO_FILENAME);

        return trim(str_replace(['_', '-'], ' ', $name));
    }

    private function normalizeFontSize(mixed $size): string
    {
        $size = trim((string) $size);

        if ($size === '') {
            return '';
        }

        if (!is_numeric($size)) {
            return '';
        }

        $value = (float) $size;

        if ($value <= 0) {
            return '';
        }

        return rtrim(rtrim(number_format($value, 2, '.', ''), '0'), '.');
    }
}
