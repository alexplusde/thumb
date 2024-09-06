# Thumb: Generiert nützliche OpenGraph-Bilder für REDAXO-Seiten

Generiert Vorschau-Bilder für Messenger, Soziale Medien, E-Mail-Clients (og:image).

![example](https://user-images.githubusercontent.com/3855487/201556485-b0bd24e1-8c04-43cb-8174-9e99f6ea9ea1.png)

## Features

* Erstellt Vorschau-Bilder anhand der Informationen, die in REDAXO hinterlegt sind
* Mitgelieferte Fragemente in HTML und SVG für einen einfachen Einstieg
* Caching der Bilder für DSGVO-konformen Abruf von Vorschaubildern und Zwischenspeichern, um API-Abrufe zu reduzieren.
* Geplant: Kompatibel zu YRewrite - Verwendet das SEO-Bild von YRewrite, wenn nötig.
* Geplant: Kompatibel zu URL - Verwendet Titel und SEO-Bild von URL-Profilen, wenn nötig.

## Installation

1. Bei der Installation wird ein Bild `thumb_bg.png` in den Medienpool kopiert - dieses kann auf Wunsch in den Einstellungen gegen ein eigenes Hintergrundbild getauscht werden.

2. Erstelle unter <https://www.html2image.net/> oder <https://hcti.io/> ein Konto und hinterlege in den Einstellungen die heweiligen Zugangsdaten. Wähle ggf. den passenden Anbieter aus.

3. Erstelle ein Media Manager Profil, z.B. namens `thumb`, und füge den Effekt `Pfad anpassen` hinzu. Diesem gibst du den Wert `redaxo/cache/addons/thumb/`, denn dort befinden sich die bereits heruntergeladenen generierten Bilder.

4. Verwende in deinem Template im head-Bereich die Methode `thumb::getUrl()` und übergebe die gewünschte URL (z.B. die des aktuellen Artikels oder des aktuellen URL-Profils), zu der ein Bild generiert werden soll. Als Rückgabewert erhältst du einen Pfad für den Medien-Manager (standardmäßig: `/media/thumb/file.png`).

Template:

```php
<?php $og_image_url = thumb::getUrl(rex_getUrl()); ?>
<meta property="og:image" content="<?= $og_image_url ?>"/>
<meta property="og:image:width" content="1200"/>
<meta property="og:image:height" content="630"/>
```

Ausgabe:

```html
<meta property="og:image" content="https://www.example.org/media/thumb/11c04adc200effba3c7479688f20e7da.png"/>
<meta property="og:image:width" content="1200"/>
<meta property="og:image:height" content="630"/>
```

### Vorlagen

Enthält Fragmente für REDAXO im SVG und HTML-Format für einen einfachen Einstieg.

> **Tipp:** Die Fragmente können bspw. über eine Kopie project-Addon überschrieben werden, kopiere dazu aus dem `thumb`-Addon-Verzeichnis das Fragment `redaxo/src/addons/thumb/fragments/thumb/html.php` in das Verzeichnis `redaxo/src/addons/project/fragments/thumb/html.php`

Benutze die Design-Vorlage im Affinity-2-Format `/docs/thumbnail-template.afpub` als Ausgangspunkt für eine eigene SVG-Vorlage mit den Abmaßen 1200x630px.

### Einstellungs-Seite

Wähle, welche API du verwenden möchtest und hinterlege Zugangsdaten für <https://htmlcsstoimage.com/> oder für <https://www.html2image.net/> und wähle ggf. ein anderes Hintergrundbild.

## Lizenz

MIT Lizenz, siehe [LICENSE.md](https://github.com/alexplusde/thumb/blob/master/LICENSE.md)  

## Autoren

**Alexander Walther**  
<http://www.alexplus.de>
<https://github.com/alexplusde>

**Projekt-Lead**  
[Alexander Walther](https://github.com/alexplusde)

## Credits
