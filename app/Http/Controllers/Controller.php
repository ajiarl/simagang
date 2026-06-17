<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

abstract class Controller
{
    use AuthorizesRequests;

    /**
     * Sanitize a filename to prevent path traversal and header injection.
     * Keeps only alphanumeric characters, dots, dashes, and underscores.
     */
    protected function sanitizeFilename(string $filename): string
    {
        // Strip directory separators and null bytes
        $filename = basename(str_replace(['\\', '\0'], '', $filename));
        // Replace any character that is not alphanumeric, dot, dash, or underscore
        $filename = preg_replace('/[^\w.\-]/', '_', $filename);
        // Collapse multiple underscores
        return preg_replace('/_{2,}/', '_', $filename) ?: 'document';
    }
}
