<?php

# in der uninstall.php sollten Befehle ausgeführt werden, die alle Änderungen, die mit der Installation kamen, entfernen.

# Konfiguration entfernen
# rex_config::removeNamespace("thumb");

# Installierte Metainfos entfernen
# rex_metainfo_delete_field('art_thumb');
# rex_metainfo_delete_field('cat_thumb');
# rex_metainfo_delete_field('med_thumb');
# rex_metainfo_delete_field('clang_thumb');

# Zusäzliche Verzeichnisse entfernen, z.B.
# rex_dir::delete(rex_path::get('thumb'), true);

# YForm-Tabellen löschen (die YForm-Tabellendefinition wird gelöscht, nicht die Datenbank-Tabellen)
# rex_yform_manager_table_api::removeTable('rex_thumb');

# Weitere Vorgänge
# ...
