# Thumb

Generiert Vorschau-Bilder für Messenger, Soziale Medien, E-Mail-Clients (og:image). HTCI-API-Schlüssel erforderlich.

## Features

* Erstellt Vorschau-Bilder anhand der Informationen, die in REDAXO hinterlegt sind
* Mitgelieferte Fragemente in HTML und SVG für einen einfachen Einstieg
* Caching der Bilder für DSGVO-konformen Abruf von Vorschaubildern und Zwischenspeichern, um API-Abrufe zu reduzieren.
* Geplant: Kompatibel zu YRewrite - Verwendet das SEO-Bild von YRewrite, wenn nötig.
* Geplant: Kompatibel zu URL - Verwendet Titel und SEO-Bild von URL-Profilen, wenn nötig.

### Verwendung

Übergebe der Methode `thumb::getUrl()` die gewünschte URL (z.B. die des aktuellen Artikels), zu der ein Bild generiert werden soll und erhalte als Rückgabewert einen Media-Manager-Pfad:

```php
<?php $og_image_url = thumb::getUrl(rex_getUrl()); ?>
<meta property="og:image" content="<?= $og_image_url ?>"/>
```

ergibt

```
<meta property="og:image" content="https://www.example.org/media/thumb/11c04adc200effba3c7479688f20e7da.png"/>
```

### Vorlagen

Enthält Fragmente für REDAXO im SVG und HTML-Format für einen einfachen Einstieg. Die Fragmente können bspw. über eine Kopie project-Addon überschrieben werden.

Benutze die Design-Vorlage im Affinity-2-Format `/docs/thumbnail-template.afpub` als Ausgangspunkt für eine eigene SVG-Vorlage mit den Abmaßen 1200x600px.

### Einstellungs-Seite

Hinterlege den API-Schlüssel für <https://htmlcsstoimage.com/>

## Lizenz

MIT Lizenz, siehe [LICENSE.md](https://github.com/alexplusde/thumb/blob/master/LICENSE.md)  

## Autoren

**Alexander Walther**  
<http://www.alexplus.de>
<https://github.com/alexplusde>

**Projekt-Lead**  
[Alexander Walther](https://github.com/alexplusde)

## Credits
