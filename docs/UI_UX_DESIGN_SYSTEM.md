# UI/UX Design System - SkillBridge

Directly synchronized from **Stitch MCP Project**: `projects/4692913134826943320` (**SkillBridge Learning and Career Portal**).

## 1. Brand Philosophy: Corporate Modernism
The SkillBridge interface embodies **Corporate Modernism** with **Structured Momentum**. It creates an authoritative yet energetic learning and hiring environment, utilizing crisp grid layouts, high contrast action triggers, generous section rhythm, and elevated glassmorphism.

---

## 2. Color Palette Tokens

```css
:root {
  /* Brand Primary Accent & Action Colors */
  --color-primary: #b7102a;             /* Primary Red */
  --color-primary-cta: #e63946;         /* Vibrant Action Trigger Red */
  --color-primary-container: #db313f;   /* Elevated Primary Surface */
  --color-on-primary: #ffffff;

  /* Secondary Navy & Branding */
  --color-secondary: #49607c;           /* Slate Secondary */
  --color-secondary-navy: #102a43;      /* Deep Navy Headers & Navigation */
  --color-secondary-container: #c7dfff;

  /* Background & Surface Containers */
  --color-background: #f8f9ff;          /* Light Cool Canvas */
  --color-surface-lowest: #ffffff;      /* Pure White Card Base */
  --color-surface-low: #eff4ff;         /* Low Surface Fill */
  --color-surface-container: #e5eeff;    /* Default Surface Fill */
  --color-surface-high: #dce9ff;        /* High Surface Fill */
  --color-surface-highest: #d3e4fe;     /* Highest Surface Fill */

  /* Text & Border Neutrals */
  --color-on-surface: #0b1c30;         /* Primary Dark Body Text */
  --color-on-surface-variant: #5b403f; /* Muted Secondary Text */
  --color-outline: #8f6f6e;            /* Subtle Divider Outline */

  /* Status Colors */
  --color-error: #ba1a1a;
  --color-error-container: #ffdad6;
}
```

---

## 3. Typography Tokens (Inter)

- `display-lg`: Inter 48px, Weight 800 (ExtraBold), Line Height 56px, Tracking -0.02em (Landing Hero Headers)
- `display-sm`: Inter 36px, Weight 700 (Bold), Line Height 44px, Tracking -0.02em (Section Headers)
- `headline-lg`: Inter 30px, Weight 700 (Bold), Line Height 38px (Page Title)
- `headline-md`: Inter 24px, Weight 600 (SemiBold), Line Height 32px (Card Group Titles)
- `title-lg`: Inter 20px, Weight 600 (SemiBold), Line Height 28px (Course / Job Card Headings)
- `body-lg`: Inter 18px, Weight 400 (Regular), Line Height 28px (Subtitles & Intro Paragraphs)
- `body-md`: Inter 16px, Weight 400 (Regular), Line Height 24px (Standard Body Copy)
- `label-md`: Inter 14px, Weight 500 (Medium), Line Height 20px, Tracking +0.01em (Form Labels / Nav Items)
- `label-sm`: Inter 12px, Weight 600 (SemiBold), Line Height 16px, Tracking +0.05em (Badges / Status Chips)

---

## 4. Spacing, Shapes & Elevation

- **8px Fluid Grid**: All component dimensions, margins, and padding scale strictly on an 8px grid (`8px`, `16px`, `24px`, `32px`, `64px`).
- **Border Radii**:
  - `rounded-md` (`8px` / `0.5rem`): Input fields and action buttons.
  - `rounded-lg` (`16px` / `1.0rem`): Course cards, job cards, and main containers.
  - `rounded-xl` (`24px` / `1.5rem`): Status badges and pill chips.
  - `rounded-full` (`9999px`): Avatars and floating action buttons.
- **Glassmorphism**: Sticky navigation bars and mobile bottom bars utilize `backdrop-filter: blur(12px)` with `rgba(248, 249, 255, 0.85)` opacity.
