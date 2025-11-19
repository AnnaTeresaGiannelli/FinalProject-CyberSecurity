# Cyber Blog – Final Project (Hack & Mitigation)

Cyber Blog è un progetto sviluppato per simulare un ambiente reale composto da una piattaforma di blogging, una rete strutturata su più livelli (Internet, DMZ, Internal Network) e un componente separato dedicato ai dati finanziari (Financial App).

L’obiettivo del progetto è analizzare vulnerabilità comuni, comprenderne gli impatti e implementare relative mitigazioni. Ogni challenge prevede: attacco, mitigazione e verifica finale.

## Architettura

* **DMZ:** ospita il web server principale e i servizi accessibili pubblicamente.
* **Internal Network:** area protetta in cui risiedono dashboard amministrative e risorse sensibili.
* **Financial App:** applicazione separata che fornisce dati finanziari solo al Cyber Blog.

## Funzionalità principali

* Gestione articoli (lettura, scrittura, revisione)
* Sistema ruoli: User, Writer, Revisor, Admin, Super Admin
* Recupero news via NewsAPI
* Accesso ai dati finanziari tramite microservizio dedicato

## Obiettivi del progetto

* Simulare attacchi realistici (DoS, CSRF, SSRF, Stored XSS, Mass Assignment, ecc.)
* Analizzare comportamento del sistema
* Implementare meccanismi di mitigazione
* Documentare l’intero processo

## Stack Tecnologico

* **Laravel 11**, **PHP**, **MySQL**
* Financial App in **PHP nativo** con dati mock JSON
* Gestione ruoli tramite middleware
* Livewire ed editor Tiny per la creazione articoli

## Challenges affrontate

1. Rate Limiting mancante
2. Operazioni critiche gestite in GET (CSRF)
3. Assenza di log su azioni sensibili
4. Manomissione input e SSRF
5. Stored XSS via contenuto articolo
6. Mass Assignment tramite proprietà fillable

Bonus inclusi: limiter login Fortify, test Clickjacking, scan OWASP ZAP, migrazione autorizzazioni con Policies.

---

Questa repository contiene codice, script d’attacco, mitigazioni e documentazione completa del lavoro svolto.
