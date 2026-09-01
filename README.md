# mod_wma_bestblock

Joomla 6 module for configurable bento-style blocks.

This file is intended for the GitHub repository and the release workflow.

## What it does

- Renders multiple sets of blocks.
- Each set includes colors, image fields, text fields, links, and buttons.
- Uses a dedicated backend Information tab with dynamic module metadata.
- Supports set duplication, live badge preview, and versioned updates.

## How it works

1. The backend stores the block sets inside the module params subform.
2. The dispatcher loads the sets and prepares ready-to-render data.
3. The layout renders the frontend bento grid.
4. The Information tab reads the installed manifest metadata.
5. The update server file allows Joomla 6 to detect new releases on GitHub.

The frontend uses only PHP, CSS, and vanilla JS.

## Data model

- Each set contains block content, colors, links, and buttons.
- The badge fields are used for the block labels shown in the backend.
- The Information tab reads author, email, website, version, and release date from the manifest.

## Configuration

### Sets tab

- `sets`: repeatable subform with one record per block set.
- `badge`: text shown in the block header and in the backend badge field.

### Options tab

- `height_value`: wrapper height value.
- `height_unit`: `vh`, `%`, or `px`.
- `autoplay`: enable or disable automatic set switching.
- `delay`: autoplay delay in milliseconds.
- `show_mouse_glow`: show or hide the mouse glow effect.
- `show_block_numbers`: show or hide the block identifiers in the frontend.

### Information tab

Shows the installed module metadata and links.

## Operational notes

- The module follows the WMA Joomla 6 standard.
- The Information tab reads data from the installed manifest.
- The update server is declared in `mod_wma_bestblock.xml`.

## Updates

The module uses a remote update server through `mod_wma_bestblock_update.xml` in the repository root.

## Version

Current version: `1.0.28`

---

# ITALIANO

## mod_wma_bestblock

Modulo Joomla 6 per blocchi bento configurabili.

Questo file e' pensato per il repository GitHub e per il flusso di release.

## Cosa fa

- Renderizza piu set di blocchi.
- Ogni set include colori, campi immagine, campi testo, link e bottoni.
- Usa una tab Informazioni backend dedicata con metadati dinamici del modulo.
- Supporta duplicazione dei set, anteprima live del badge e aggiornamenti versionati.

## Come funziona

1. Il backend salva i set dei blocchi dentro il subform dei parametri del modulo.
2. Il dispatcher carica i set e prepara i dati pronti per il rendering.
3. Il layout renderizza la griglia bento frontend.
4. La tab Informazioni legge i metadati dal manifest installato.
5. Il file update server permette a Joomla 6 di rilevare nuove release su GitHub.

Il frontend usa solo PHP, CSS e JS vanilla.

## Struttura dati

- Ogni set contiene contenuti blocco, colori, link e bottoni.
- I campi badge vengono usati per le etichette dei blocchi nel backend.
- La tab Informazioni legge autore, email, sito, versione e data rilascio dal manifest.

## Configurazione

### Tab Set

- `sets`: subform ripetibile con un record per ogni set di blocchi.
- `badge`: testo mostrato nell'header del blocco e nel campo badge del backend.

### Tab Opzioni

- `height_value`: valore altezza wrapper.
- `height_unit`: `vh`, `%` oppure `px`.
- `autoplay`: abilita o disabilita il cambio automatico dei set.
- `delay`: ritardo autoplay in millisecondi.
- `show_mouse_glow`: mostra o nasconde l'effetto glow del mouse.
- `show_block_numbers`: mostra o nasconde gli identificativi dei blocchi nel frontend.

### Tab Informazioni

Mostra i metadati del modulo installato e i link.

## Note operative

- Il modulo segue lo standard WMA Joomla 6.
- La tab Informazioni legge i dati dal manifest installato.
- L'update server e' dichiarato in `mod_wma_bestblock.xml`.

## Aggiornamenti

Il modulo usa un update server remoto tramite `mod_wma_bestblock_update.xml` nella root del repository.

## Versione

Versione corrente: `1.0.28`
