<?php

namespace App\Services;

class HtmlFilterService
{
    /**
     * Filtrare il contenuto dell'articolo per impedire XSS Attack
     *
     * @param string $textContent
     * @return string
     */
    public function sanitize($textContent)
    {
        return htmlspecialchars(trim($textContent), ENT_QUOTES, 'UTF-8');
    }

    /**
     * Decodificare il testo per la visualizzazione corretta
     *
     * @param string $textContent
     * @return string
     */
    public function decode($textContent)
    {
        return html_entity_decode($textContent, ENT_QUOTES, 'UTF-8');
    }

}