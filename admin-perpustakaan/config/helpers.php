<?php

/**
 * Set flash message in session.
 */
function setFlash(string $type, string $message): void
{
    $_SESSION['flash'][$type] = $message;
}

/**
 * Retrieve and remove flash message.
 */
function getFlash(string $type): ?string
{
    if (!empty($_SESSION['flash'][$type])) {
        $message = $_SESSION['flash'][$type];
        unset($_SESSION['flash'][$type]);
        return $message;
    }
    return null;
}

/**
 * Render flash alerts.
 */
function displayFlash(): void
{
    if (empty($_SESSION['flash'])) {
        return;
    }

    foreach ($_SESSION['flash'] as $type => $message) {
        $class = $type === 'error' ? 'danger' : $type;
        echo '<div class="alert alert-' . $class . ' alert-dismissible fade show" role="alert">'
            . htmlspecialchars($message, ENT_QUOTES, 'UTF-8')
            . '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>'
            . '</div>';
    }

    unset($_SESSION['flash']);
}

/**
 * Simple redirect helper.
 */
function redirect(string $path): void
{
    header('Location: ' . $path);
    exit;
}

/**
 * Escape output helper.
 */
function e(?string $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

/**
 * Check active menu.
 */
function isActiveMenu(array $targets, string $current): bool
{
    return in_array($current, $targets, true);
}


