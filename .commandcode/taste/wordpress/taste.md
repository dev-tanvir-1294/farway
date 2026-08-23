# WordPress

- Prefers WordPress themes to comply with WordPress.org Theme Review requirements (self-hosted assets, escaped output). Confidence: 0.8
- Self-hosts Google Fonts as local WOFF2 files with `@font-face` rules rather than loading from external `fonts.googleapis.com`. Confidence: 0.85
- Escapes all HTML output per WordPress coding standards (e.g., `esc_attr()` for attribute values). Confidence: 0.85
