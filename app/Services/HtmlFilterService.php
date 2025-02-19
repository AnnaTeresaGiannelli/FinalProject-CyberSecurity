<?php

namespace App\Services;

use DOMDocument;

class HtmlFilterService
{
    // tag HTML permessi
    private $allowedTags = ['a', 'p', 'b', 'i', 'ul', 'ol', 'li', 'strong', 'em', 'br'];

    // attributi permessi
    private $allowedAttributes = ['href', 'title', 'alt'];

    /**
     * Filtrare il contenuto HTML per rimuovere tag e attributi pericolosi.
     *
     * @param string $htmlContent
     * @return string
     */
    public function sanitize($htmlContent)
    {
        $dom = new DOMDocument();
        libxml_use_internal_errors(true);

        $htmlContent = '<!DOCTYPE html>' . $htmlContent;

        $htmlContent = mb_convert_encoding($htmlContent, 'HTML-ENTITIES', 'UTF-8');

        $dom->loadHTML($htmlContent, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        $this->removeDisallowedTags($dom);

        $this->sanitizeAttributes($dom);

        $sanitizedContent = $dom->saveHTML();
        $sanitizedContent = htmlspecialchars($sanitizedContent, ENT_QUOTES, 'UTF-8');

        return $sanitizedContent;
    }



    /**
     * Rimuove tutti i tag non inclusi nella whitelist.
     *
     * @param DOMDocument $dom
     */
    private function removeDisallowedTags(DOMDocument $dom)
    {
        $allElements = $dom->getElementsByTagName('*');

        for ($i = $allElements->length - 1; $i >= 0; $i--) {
            $element = $allElements->item($i);

            // Se il tag non è nella whitelist -> rimozione
            if (!in_array($element->nodeName, $this->allowedTags)) {
                $element->parentNode->removeChild($element);
            }
        }
    }

    /**
     * Rimuove attributi non sicuri o non permessi.
     *
     * @param DOMDocument $dom
     */
    private function sanitizeAttributes(DOMDocument $dom)
    {
        $allElements = $dom->getElementsByTagName('*');

        foreach ($allElements as $element) {
            // Ottieni tutti gli attributi dell'elemento
            if ($element->hasAttributes()) {
                $attributes = $element->attributes;

                // Itera sugli attributi e rimuovi quelli non permessi
                foreach ($attributes as $attr) {
                    if (!in_array($attr->nodeName, $this->allowedAttributes)) {
                        $element->removeAttribute($attr->nodeName);
                    }

                    // Rimuovi qualsiasi attributo che contenga codice JS
                    if (stripos($attr->nodeValue, 'javascript:') !== false) {
                        $element->removeAttribute($attr->nodeName);
                    }
                }
            }
        }
    }
}
