# SiMagang Design System

> **Source:** Google Stitch — `projects/14959217058869577270`
> **Project Type:** TEXT_TO_UI_PRO · Desktop
> **Color Mode:** Light
> **Primary Font:** Inter
> **Last Updated:** 2026-06-06T18:41:27Z

---

## Table of Contents

1. [Brand & Style](#brand--style)
2. [Color Palette](#color-palette)
3. [Typography](#typography)
4. [Spacing](#spacing)
5. [Border Radius (Shapes)](#border-radius-shapes)
6. [Elevation & Depth](#elevation--depth)
7. [Component Styles](#component-styles)
8. [Screen Layouts](#screen-layouts)

---

## Brand & Style

The design system is engineered for a **high-trust, institutional environment** catering to Indonesian university students, faculty, and industry partners. The brand personality is authoritative yet accessible, prioritizing clarity and efficiency over decorative flair.

The aesthetic follows a **Modern Corporate** approach, blending the structured reliability of government portals with the refined usability of contemporary SaaS. It utilizes generous white space, a disciplined color application, and a clear information hierarchy to reduce cognitive load during complex administrative tasks.

**Emotional Response:** Confidence, stability, and professional progress.

---

## Color Palette

### Primary Colors

| Token | Hex | Usage |
|:---|:---|:---|
| `primary` | `#003e7e` | Primary brand color — "Patriot Blue." Headings, navigation emphasis |
| `on-primary` | `#ffffff` | Text/icons on primary surfaces |
| `primary-container` | `#1a56a0` | Primary button backgrounds, active sidebar indicator, CTA |
| `on-primary-container` | `#b3cdff` | Text/icons on primary-container |
| `inverse-primary` | `#a9c7ff` | Primary color on inverse (dark) surfaces |

### Secondary Colors

| Token | Hex | Usage |
|:---|:---|:---|
| `secondary` | `#0058be` | "Action Blue" — interactive links, active nav text |
| `on-secondary` | `#ffffff` | Text/icons on secondary surfaces |
| `secondary-container` | `#2170e4` | Secondary button backgrounds, hover states |
| `on-secondary-container` | `#fefcff` | Text/icons on secondary-container |

### Tertiary Colors

| Token | Hex | Usage |
|:---|:---|:---|
| `tertiary` | `#673000` | Warm accent — deadline icons, tertiary emphasis |
| `on-tertiary` | `#ffffff` | Text/icons on tertiary surfaces |
| `tertiary-container` | `#8a4300` | Tertiary container backgrounds |
| `on-tertiary-container` | `#ffbf95` | Text/icons on tertiary-container |

### Surface Colors

| Token | Hex | Usage |
|:---|:---|:---|
| `background` | `#f9f9ff` | Page background |
| `on-background` | `#191c20` | Text on background |
| `surface` | `#f9f9ff` | Main surface color (sidebar, top bar) |
| `on-surface` | `#191c20` | Default text color |
| `on-surface-variant` | `#424751` | Secondary text, labels, metadata |
| `surface-container-lowest` | `#ffffff` | Card backgrounds, input backgrounds |
| `surface-container-low` | `#f3f3fa` | Hover backgrounds, subtle fills |
| `surface-container` | `#ededf4` | Container backgrounds, icon badge fills |
| `surface-container-high` | `#e7e8ef` | Hover state for sidebar items |
| `surface-container-highest` | `#e2e2e9` | Highest elevation container fills |
| `surface-variant` | `#e2e2e9` | Progress bar tracks, subtle backgrounds |
| `surface-bright` | `#f9f9ff` | Bright surface alternative |
| `surface-dim` | `#d9d9e0` | Dimmed surface |
| `surface-tint` | `#265ea8` | Tinted surface overlay |
| `inverse-surface` | `#2e3036` | Dark surface for inverse contexts |
| `inverse-on-surface` | `#f0f0f7` | Text on inverse surfaces |

### Outline / Border Colors

| Token | Hex | Usage |
|:---|:---|:---|
| `outline` | `#737782` | Muted text, timestamp labels |
| `outline-variant` | `#c2c6d3` | Borders on inputs, cards, dividers |

### Error / Feedback Colors

| Token | Hex | Usage |
|:---|:---|:---|
| `error` | `#ba1a1a` | Error states, notification badges |
| `on-error` | `#ffffff` | Text on error surfaces |
| `error-container` | `#ffdad6` | Error container backgrounds |
| `on-error-container` | `#93000a` | Text on error containers |

### Fixed Colors (Accessibility)

| Token | Hex |
|:---|:---|
| `primary-fixed` | `#d6e3ff` |
| `primary-fixed-dim` | `#a9c7ff` |
| `on-primary-fixed` | `#001b3d` |
| `on-primary-fixed-variant` | `#00468c` |
| `secondary-fixed` | `#d8e2ff` |
| `secondary-fixed-dim` | `#adc6ff` |
| `on-secondary-fixed` | `#001a42` |
| `on-secondary-fixed-variant` | `#004395` |
| `tertiary-fixed` | `#ffdcc6` |
| `tertiary-fixed-dim` | `#ffb786` |
| `on-tertiary-fixed` | `#311300` |
| `on-tertiary-fixed-variant` | `#723600` |

### Status Chip Colors (Hardcoded)

| Status | Background | Text | Usage |
|:---|:---|:---|:---|
| **Disetujui** (Approved) | `#DCFCE7` | `#166534` | Green soft badge |
| **Menunggu** (Pending) | `#FEF08A` | `#854D0E` | Yellow soft badge |
| **Revisi** (Revision) | `#FEE2E2` | `#991B1B` | Red soft badge |
| **Ditolak** (Rejected) | `#FEE2E2` | `#991B1B` | Red soft badge (same as Revisi) |
| **Aktif Magang** (Active) | `#DCFCE7` | `#166534` | Pill-shaped status indicator |

---

## Typography

**Font Family:** `Inter` (Google Fonts) — used for all roles: headlines, body, and labels.

**Import:**
```html
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;900&display=swap" rel="stylesheet">
```

### Type Scale

| Token | Size | Weight | Line Height | Letter Spacing | Usage |
|:---|:---|:---|:---|:---|:---|
| `display-lg` | 32px | 700 (Bold) | 40px | -0.02em | Page titles, welcome banners |
| `display-sm` | 24px | 700 (Bold) | 32px | -0.01em | Login title, section hero headings |
| `headline-md` | 20px | 600 (Semi-Bold) | 28px | — | Sidebar branding, stat card values |
| `headline-sm` | 18px | 600 (Semi-Bold) | 24px | — | Card section titles, sidebar active item |
| `body-lg` | 16px | 400 (Regular) | 24px | — | Large body text |
| `body-md` | 15px | 400 (Regular) | 22px | — | Default body text, table content cells |
| `body-sm` | 14px | 400 (Regular) | 20px | — | Secondary body, table date cells, notifications |
| `label-md` | 13px | 600 (Semi-Bold) | 18px | 0.03em | Button text, form labels, column headers |
| `label-sm` | 12px | 500 (Medium) | 16px | — | Metadata, timestamps, sub-labels |

### Tailwind Config Format

```js
fontSize: {
  "display-lg": ["32px", { lineHeight: "40px", letterSpacing: "-0.02em", fontWeight: "700" }],
  "display-sm": ["24px", { lineHeight: "32px", letterSpacing: "-0.01em", fontWeight: "700" }],
  "headline-md": ["20px", { lineHeight: "28px", fontWeight: "600" }],
  "headline-sm": ["18px", { lineHeight: "24px", fontWeight: "600" }],
  "body-lg": ["16px", { lineHeight: "24px", fontWeight: "400" }],
  "body-md": ["15px", { lineHeight: "22px", fontWeight: "400" }],
  "body-sm": ["14px", { lineHeight: "20px", fontWeight: "400" }],
  "label-md": ["13px", { lineHeight: "18px", letterSpacing: "0.03em", fontWeight: "600" }],
  "label-sm": ["12px", { lineHeight: "16px", fontWeight: "500" }],
}
```

### Usage Principles

- **Headlines:** Use Bold (700) or Semi-Bold (600) for section titles and page headers.
- **Body:** Default body size is **15px** for optimal balance between density and readability. Use **14px** for secondary content or sidebars.
- **Labels:** Small, uppercase labels for metadata and category headers.
- **Localization:** All type treatments must support Indonesian grammatical structures, ensuring longer words do not break layout containers.

---

## Spacing

The system uses an **8px linear scale** (`4, 8, 16, 24, 32`) as its spacing rhythm.

| Token | Value | Usage |
|:---|:---|:---|
| `base` | 4px | Minimum unit |
| `xs` | 4px | Tight gaps between label and input |
| `sm` | 8px | Small gaps between inline elements |
| `md` | 16px | Standard padding, grid gaps, input horizontal padding |
| `lg` | 24px | Section padding, main content padding, sidebar padding |
| `xl` | 32px | Large section spacing, login form padding |
| `gutter` | 24px | Grid gutter width |
| `sidebar-width` | 260px | Fixed sidebar width |
| `container-max-width` | 1280px | Maximum content width |

### Tailwind Config Format

```js
spacing: {
  "base": "4px",
  "xs": "4px",
  "sm": "8px",
  "md": "16px",
  "lg": "24px",
  "xl": "32px",
  "gutter": "24px",
  "sidebar-width": "260px",
  "container-max-width": "1280px",
}
```

---

## Border Radius (Shapes)

The shape language is **"Softly Geometric."**

| Token | Value | Usage |
|:---|:---|:---|
| `DEFAULT` | 4px (0.25rem) | Inputs, small buttons, badges |
| `sm` | 4px (0.25rem) | Status chips, tags |
| `lg` | 8px (0.5rem) | Cards, containers, login panel |
| `xl` | 12px (0.75rem) | Large containers |
| `full` | 9999px | Pills, avatar circles, active status badge |

### Component Radius Guidelines

- **Cards & Containers:** `8px` (0.5rem / `rounded-lg`)
- **Buttons & Input Fields:** `6px` for a precise, tool-like character
- **Badges & Tags:** `4px` (0.25rem)
- **Avatars & Pills:** `9999px` (`rounded-full`)

---

## Elevation & Depth

Depth is communicated through **Tonal Layering** and **Subtle Shadows**.

| Level | Surface | Border | Shadow | Usage |
|:---|:---|:---|:---|:---|
| **Level 0 — Background** | `#F8FAFC` | — | — | Page background |
| **Level 1 — Cards** | `#FFFFFF` | `0.5px solid #E2E8F0` | — | Cards, content panels |
| **Level 2 — Interaction** | `#FFFFFF` | `0.5px solid #E2E8F0` | `0px 4px 6px -1px rgba(0,0,0,0.05)` | Card hover states |
| **Level 3 — Modal/Overlay** | `#FFFFFF` | — | `0px 10px 15px -3px rgba(0,0,0,0.1)` + `backdrop-filter: blur(4px)` | Modals, dropdowns |

### CSS Utility Classes

```css
.border-soft {
  border: 0.5px solid #E2E8F0;
}

.shadow-soft {
  box-shadow: 0px 4px 6px -1px rgba(0, 0, 0, 0.05);
}
```

---

## Component Styles

### Buttons

#### Primary Button
```css
background: #1A56A0;       /* primary-container */
color: #ffffff;            /* surface-container-lowest */
font: 13px/18px Inter;     /* label-md */
font-weight: 600;
padding: 10px 18px;
border-radius: 6px;
box-shadow: 0 1px 2px rgba(0,0,0,0.05);
```
- **Hover:** `background: #2170E4` (secondary-container)
- **Active:** `background: #003E7E` (primary)

#### Secondary / Ghost Button
```css
background: transparent;
border: 1px solid #C2C6D3; /* outline-variant */
color: #424751;            /* on-surface-variant */
font: 13px/18px Inter;     /* label-md */
font-weight: 600;
padding: 12px 16px;
border-radius: 8px;
```
- **Hover:** `background: #E2E2E9` (surface-variant)

#### Inverted CTA Button (on gradient background)
```css
background: #ffffff;
color: #1A56A0;            /* primary-container */
font: 13px/18px Inter;     /* label-md */
font-weight: 600;
padding: 12px 24px;
border-radius: 8px;
box-shadow: 0 1px 2px rgba(0,0,0,0.05);
```

### Input Fields

```css
background: #ffffff;       /* surface-container-lowest */
border: 1px solid #C2C6D3; /* outline-variant */
border-radius: 4px;
padding: 10px 16px;
font: 15px/22px Inter;     /* body-md */
color: #191C20;            /* on-surface */
```
- **Placeholder:** `color: #737782` (outline)
- **Focus:** `border-color: #1A56A0; box-shadow: 0 0 0 1px #1A56A0;`
- **Label:** `font: 600 13px/18px Inter; letter-spacing: 0.03em; color: #191C20;`

### Cards

```css
background: #ffffff;
border: 0.5px solid #E2E8F0;
border-radius: 8px;
box-shadow: 0px 4px 6px -1px rgba(0, 0, 0, 0.05);
```
- **Hover:** `box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);`
- **Header divider:** `border-bottom: 1px solid #C2C6D3;`
- **Internal padding:** `20px` (p-5)

### Status Chips (Badges)

```css
/* Disetujui / Approved */
background: #DCFCE7;
color: #166534;
padding: 4px 10px;
border-radius: 9999px;
font: 600 12px/1 Inter;

/* Menunggu / Pending */
background: #FEF08A;
color: #854D0E;

/* Revisi / Rejected */
background: #FEE2E2;
color: #991B1B;
```

### Tables

```css
/* Header row */
background: #F8FAFC;
border-bottom: 1px solid #C2C6D3;
font: 600 13px/18px Inter;     /* label-md */
color: #424751;                /* on-surface-variant */
padding: 12px 20px;

/* Body row */
border-bottom: 1px solid #C2C6D3;
min-height: 56px;
padding: 16px 20px;

/* Hover */
background: #F8FAFC;
```

### Sidebar Navigation

```css
/* Container */
width: 260px;
background: #f9f9ff;          /* surface */
border-right: 1px solid #C2C6D3;
padding: 24px 0;

/* Active item */
border-left: 4px solid #0058BE; /* secondary */
background: rgba(0, 62, 126, 0.05); /* primary at 5% opacity */
color: #0058BE;                /* secondary */
font: 600 18px/24px Inter;    /* headline-sm */
padding: 12px 16px;
border-radius: 0 8px 8px 0;

/* Inactive item */
border-left: 4px solid transparent;
color: #424751;                /* on-surface-variant */
padding: 12px 16px;
border-radius: 8px;
```
- **Hover:** `background: #E7E8EF` (surface-container-high)

### Top Navigation Bar

```css
height: 64px;
background: #f9f9ff;          /* surface */
border-bottom: 1px solid #C2C6D3;
padding: 0 24px;
position: sticky;
top: 0;
z-index: 10;
```

### Avatar

```css
width: 32px;
height: 32px;
border-radius: 9999px;
background: #003E7E;          /* primary */
color: #ffffff;                /* on-primary */
font: 600 13px/18px Inter;    /* label-md */
border: 1px solid #C2C6D3;
```

### Notification Badge (dot)

```css
width: 8px;
height: 8px;
border-radius: 9999px;
background: #BA1A1A;          /* error */
position: absolute;
top: 8px;
right: 8px;
```

### Progress Bar

```css
/* Track */
background: #E2E2E9;          /* surface-variant */
height: 8px;
border-radius: 9999px;

/* Fill */
background: #003E7E;          /* primary */
height: 8px;
border-radius: 9999px;
```

### Gradient CTA Banner

```css
background: linear-gradient(to bottom-right, #1A56A0, #0058BE);
border-radius: 8px;
padding: 24px;
color: #ffffff;
/* Decorative overlay */
background-image: radial-gradient(circle at top right, rgba(255,255,255,0.1), transparent);
```

---

## Screen Layouts

### Icons

All screens use **Material Symbols Outlined** (variable font):
```html
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
```
Default settings: `font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;`

---

### Screen 1: Login — SiMagang

**ID:** `055d264f9776447089fe1d6fc5698d00`
**Dimensions:** 2560 × 2048 (rendered at 1280 × 1024)

#### Layout Structure

```
┌──────────────────────────────────────┐
│           (centered page)            │
│                                      │
│   ┌──────────────────────────────┐   │
│   │         🎓 Icon (32px)       │   │
│   │       "SiMagang" (h1)        │   │
│   │    Subtitle (body-md)        │   │
│   │                              │   │
│   │   ┌──────────────────────┐   │   │
│   │   │  Email Input         │   │   │
│   │   └──────────────────────┘   │   │
│   │   ┌──────────────────────┐   │   │
│   │   │  Password Input  👁  │   │   │
│   │   └──────────────────────┘   │   │
│   │                              │   │
│   │   [ Masuk Button (full) ]    │   │
│   │                              │   │
│   │     "Lupa password?" link    │   │
│   └──────────────────────────────┘   │
│                                      │
│     © 2026 Sistem Informasi Magang   │
└──────────────────────────────────────┘
```

**Key Details:**
- Container: `max-w-[420px]`, white background, `rounded-lg`, `border-soft`, `shadow-sm`
- Header icon: 64×64px container, `surface-container` background, `rounded-lg`
- Material icon: `school` at 32px
- Title: `display-sm` (24px/700), color `primary`
- Subtitle: `body-md` (15px/400), color `on-surface-variant`
- Form fields: `body-md`, `outline-variant` border, `10px 16px` padding
- Primary CTA: Full-width, `primary-container` background, `label-md` font
- Footer: `body-sm`, color `outline`

---

### Screen 2: Dashboard Mahasiswa — SiMagang

**ID:** `edbd9ff9aa5c4a73966ef8392be13f34`
**Dimensions:** 2560 × 2190 (rendered at 1280 × 1092)

#### Layout Structure

```
┌─────────┬────────────────────────────────────────────────────┐
│ Sidebar │  Top Nav Bar (64px, sticky)                        │
│ (260px) ├────────────────────────────────────────────────────┤
│         │                                                    │
│ SM logo │  Welcome Banner                                    │
│ ──────  │  ┌──────────────────────────────────────────────┐  │
│ Dashboard│ │ "Selamat datang, Budi Pratama"               │  │
│ Pengajuan│ │  University info     [● Aktif Magang]        │  │
│ Logbook  │ └──────────────────────────────────────────────┘  │
│ Presensi │                                                   │
│ Dokumen  │  Status Cards (4-col grid)                        │
│ Penilaian│  ┌────────┐ ┌────────┐ ┌────────┐ ┌────────┐     │
│ Profile  │  │Hari    │ │Logbook │ │Presensi│ │Nilai   │     │
│         │  │47/90   │ │3 entri │ │92%     │ │Belum   │     │
│         │  │[===  ] │ │✓ target│ │43 hari │ │        │     │
│         │  └────────┘ └────────┘ └────────┘ └────────┘     │
│         │                                                    │
│         │  ┌──────────────────────┐ ┌──────────────────┐     │
│         │  │ Logbook Terbaru      │ │ Notifikasi       │     │
│         │  │ (2/3 width table)    │ │ (1/3 width)      │     │
│         │  │                      │ │                   │     │
│         │  │ Date | Activity |Stat│ │ ✓ Approved notif  │     │
│         │  │ ──── │ ──────── │────│ │ ℹ Deadline notif  │     │
│         │  │ row  │  row     │chip│ │ ✕ Revision notif  │     │
│         │  │                      │ │                   │     │
│         │  ├──────────────────────┤ ├──────────────────┤     │
│         │  │ Gradient CTA Banner  │ │ Deadline Mendatang│     │
│ [Logout]│  │ "Tulis Logbook"      │ │ • Laporan 20 Oct │     │
│         │  │           [Isi]      │ │ • Evaluasi 25 Oct│     │
│         │  └──────────────────────┘ └──────────────────┘     │
└─────────┴────────────────────────────────────────────────────┘
```

**Key Details:**
- **Sidebar:** Fixed 260px, `surface` background, `border-r border-outline-variant`
  - Logo: 40×40px `primary-container` circle + "SiMagang" (`headline-md`/bold)
  - Nav items: 7 items with Material icons, active = `border-l-4 secondary` + `bg-primary/5`
  - Logout button: Ghost style, full-width at bottom
- **Top bar:** 64px height, sticky, notification bell + avatar
- **Content area:** `ml-[260px]`, padding `24px`, max-width `1280px`
- **Welcome banner:** White card with display-lg title + green pill status
- **Stats grid:** `grid-cols-4`, white cards, icon + value + indicator
- **Two-column layout:** `grid-cols-3` (2:1 ratio)
  - Left: Logbook table + gradient CTA banner
  - Right: Notifications list + Deadline cards

---

### Screen 3: Logbook Harian — SiMagang

**ID:** `64358f41b3e7496eb7d9fbab7796d5b3`
**Dimensions:** 2560 × 2048 (rendered at 1280 × 1024)

#### Layout Structure

```
┌─────────┬────────────────────────────────────────────────────┐
│ Sidebar │  Top Nav Bar                                       │
│ (260px) ├────────────────────────────────────────────────────┤
│         │                                                    │
│         │  Page Header                                       │
│         │  "Logbook Harian" (display-sm)                     │
│         │  Subtitle text                    [+ Tambah Entri] │
│         │                                                    │
│         │  ┌──────────────────────────────────────────────┐  │
│         │  │ Filters / Search Bar                         │  │
│         │  └──────────────────────────────────────────────┘  │
│         │                                                    │
│         │  ┌──────────────────────────────────────────────┐  │
│         │  │ Logbook Table (full width)                   │  │
│         │  │                                              │  │
│         │  │ Date | Activity Summary | Hours | Status     │  │
│         │  │ ──── │ ──────────────── │ ───── │ ──────     │  │
│         │  │ rows with status chips                       │  │
│         │  │                                              │  │
│         │  └──────────────────────────────────────────────┘  │
│         │                                                    │
│         │  Pagination controls                               │
└─────────┴────────────────────────────────────────────────────┘
```

**Key Details:**
- Same sidebar + topbar layout as Dashboard
- Sidebar: "Logbook Harian" is the active nav item
- Page header: `display-sm` title + action button top-right
- Full-width data table with sortable columns
- Status chips for each logbook entry

---

### Screen 4: Dashboard Pembimbing Akademik — SiMagang

**ID:** `3631832116f243a4811ca2d6651799cb`
**Dimensions:** 2560 × 2048 (rendered at 1280 × 1024)

#### Layout Structure

```
┌─────────┬────────────────────────────────────────────────────┐
│ Sidebar │  Top Nav Bar                                       │
│ (260px) ├────────────────────────────────────────────────────┤
│         │                                                    │
│ Advisor │  Welcome Banner                                    │
│ Nav     │  "Selamat datang, Dr. ..." (display-lg)            │
│ Items   │  Faculty info                                      │
│         │                                                    │
│         │  Stats Overview (3–4 col grid)                     │
│         │  ┌────────┐ ┌────────┐ ┌────────┐ ┌────────┐     │
│         │  │Students│ │Pending │ │Reviews │ │Completed│    │
│         │  │Count   │ │Logbooks│ │Done    │ │Interns  │    │
│         │  └────────┘ └────────┘ └────────┘ └────────┘     │
│         │                                                    │
│         │  ┌──────────────────────┐ ┌──────────────────┐     │
│         │  │ Pending Reviews      │ │ Student List     │     │
│         │  │ (Logbook entries     │ │ (sidebar panel)  │     │
│         │  │  awaiting approval)  │ │                  │     │
│         │  │                      │ │ avatar + name    │     │
│         │  │ [Approve] [Revise]   │ │ progress bar     │     │
│         │  └──────────────────────┘ └──────────────────┘     │
└─────────┴────────────────────────────────────────────────────┘
```

**Key Details:**
- Advisor-specific navigation items (Mahasiswa Bimbingan, Review Logbook, Penilaian, etc.)
- Overview cards showing aggregate student data
- Review queue with approve/revise action buttons
- Student list panel with progress indicators

---

### Screen 5: Dashboard Administrator — SiMagang

**ID:** `d79b99483c0e414d82848b5922c0d530`
**Dimensions:** 2560 × 2176 (rendered at 1280 × 1083)

#### Layout Structure

```
┌─────────┬────────────────────────────────────────────────────┐
│ Sidebar │  Top Nav Bar                                       │
│ (260px) ├────────────────────────────────────────────────────┤
│         │                                                    │
│ Admin   │  Admin Overview                                    │
│ Nav     │  "Dashboard Administrator" (display-lg)            │
│ Items   │                                                    │
│         │  Stats Overview (4-col grid)                       │
│         │  ┌────────┐ ┌────────┐ ┌────────┐ ┌────────┐     │
│         │  │Total   │ │Active  │ │Partner │ │Pending │     │
│         │  │Students│ │Interns │ │Companies││Approvals│    │
│         │  └────────┘ └────────┘ └────────┘ └────────┘     │
│         │                                                    │
│         │  ┌──────────────────────┐ ┌──────────────────┐     │
│         │  │ Recent Applications  │ │ System Alerts    │     │
│         │  │ (data table)         │ │ (notification    │     │
│         │  │                      │ │  panel)          │     │
│         │  │ Student | Company    │ │                  │     │
│         │  │ Date    | Status     │ │ Warning/Info     │     │
│         │  │ [View] [Approve]     │ │ messages         │     │
│         │  └──────────────────────┘ └──────────────────┘     │
│         │                                                    │
│         │  ┌──────────────────────────────────────────────┐  │
│         │  │ Charts / Analytics Section                   │  │
│         │  └──────────────────────────────────────────────┘  │
└─────────┴────────────────────────────────────────────────────┘
```

**Key Details:**
- Admin-specific navigation items (Manajemen User, Lowongan Magang, Laporan, Pengaturan, etc.)
- System-wide aggregate statistics cards
- Applications management table with action buttons
- System alerts panel
- Analytics/chart section for program-wide overview

---

## Canvas Positions (Stitch Canvas Map)

| Screen | Canvas X | Canvas Y | Width | Height |
|:---|:---|:---|:---|:---|
| Login | 1024 | 0 | 1280 | 1024 |
| Dashboard Mahasiswa | 0 | 1280 | 1280 | 1092 |
| Logbook Harian | 0 | 2628 | 1280 | 1024 |
| Dashboard Pembimbing | 0 | 3908 | 1280 | 1024 |
| Dashboard Administrator | 0 | 5188 | 1280 | 1083 |
| Design System Card | — | — | 960 | 540 |

---

## Full Tailwind Configuration

Below is the complete Tailwind CSS `extend` configuration as used in the Stitch-generated screens:

```js
tailwind.config = {
  darkMode: "class",
  theme: {
    extend: {
      colors: {
        "primary": "#003e7e",
        "on-primary": "#ffffff",
        "primary-container": "#1a56a0",
        "on-primary-container": "#b3cdff",
        "inverse-primary": "#a9c7ff",
        "secondary": "#0058be",
        "on-secondary": "#ffffff",
        "secondary-container": "#2170e4",
        "on-secondary-container": "#fefcff",
        "tertiary": "#673000",
        "on-tertiary": "#ffffff",
        "tertiary-container": "#8a4300",
        "on-tertiary-container": "#ffbf95",
        "error": "#ba1a1a",
        "on-error": "#ffffff",
        "error-container": "#ffdad6",
        "on-error-container": "#93000a",
        "background": "#f9f9ff",
        "on-background": "#191c20",
        "surface": "#f9f9ff",
        "on-surface": "#191c20",
        "on-surface-variant": "#424751",
        "surface-variant": "#e2e2e9",
        "surface-container-lowest": "#ffffff",
        "surface-container-low": "#f3f3fa",
        "surface-container": "#ededf4",
        "surface-container-high": "#e7e8ef",
        "surface-container-highest": "#e2e2e9",
        "surface-bright": "#f9f9ff",
        "surface-dim": "#d9d9e0",
        "surface-tint": "#265ea8",
        "inverse-surface": "#2e3036",
        "inverse-on-surface": "#f0f0f7",
        "outline": "#737782",
        "outline-variant": "#c2c6d3",
        "primary-fixed": "#d6e3ff",
        "primary-fixed-dim": "#a9c7ff",
        "on-primary-fixed": "#001b3d",
        "on-primary-fixed-variant": "#00468c",
        "secondary-fixed": "#d8e2ff",
        "secondary-fixed-dim": "#adc6ff",
        "on-secondary-fixed": "#001a42",
        "on-secondary-fixed-variant": "#004395",
        "tertiary-fixed": "#ffdcc6",
        "tertiary-fixed-dim": "#ffb786",
        "on-tertiary-fixed": "#311300",
        "on-tertiary-fixed-variant": "#723600",
      },
      borderRadius: {
        "DEFAULT": "0.25rem",
        "lg": "0.5rem",
        "xl": "0.75rem",
        "full": "9999px",
      },
      spacing: {
        "base": "4px",
        "xs": "4px",
        "sm": "8px",
        "md": "16px",
        "lg": "24px",
        "xl": "32px",
        "gutter": "24px",
        "sidebar-width": "260px",
        "container-max-width": "1280px",
      },
      fontFamily: {
        "display-lg": ["Inter"],
        "display-sm": ["Inter"],
        "headline-md": ["Inter"],
        "headline-sm": ["Inter"],
        "body-lg": ["Inter"],
        "body-md": ["Inter"],
        "body-sm": ["Inter"],
        "label-md": ["Inter"],
        "label-sm": ["Inter"],
      },
      fontSize: {
        "display-lg": ["32px", { lineHeight: "40px", letterSpacing: "-0.02em", fontWeight: "700" }],
        "display-sm": ["24px", { lineHeight: "32px", letterSpacing: "-0.01em", fontWeight: "700" }],
        "headline-md": ["20px", { lineHeight: "28px", fontWeight: "600" }],
        "headline-sm": ["18px", { lineHeight: "24px", fontWeight: "600" }],
        "body-lg": ["16px", { lineHeight: "24px", fontWeight: "400" }],
        "body-md": ["15px", { lineHeight: "22px", fontWeight: "400" }],
        "body-sm": ["14px", { lineHeight: "20px", fontWeight: "400" }],
        "label-md": ["13px", { lineHeight: "18px", letterSpacing: "0.03em", fontWeight: "600" }],
        "label-sm": ["12px", { lineHeight: "16px", fontWeight: "500" }],
      },
    },
  },
};
```

---

## CSS Variables (Vanilla CSS Alternative)

For projects not using Tailwind, define the design system as CSS custom properties:

```css
:root {
  /* ── Primary ── */
  --color-primary: #003e7e;
  --color-on-primary: #ffffff;
  --color-primary-container: #1a56a0;
  --color-on-primary-container: #b3cdff;

  /* ── Secondary ── */
  --color-secondary: #0058be;
  --color-on-secondary: #ffffff;
  --color-secondary-container: #2170e4;
  --color-on-secondary-container: #fefcff;

  /* ── Tertiary ── */
  --color-tertiary: #673000;
  --color-on-tertiary: #ffffff;
  --color-tertiary-container: #8a4300;
  --color-on-tertiary-container: #ffbf95;

  /* ── Error ── */
  --color-error: #ba1a1a;
  --color-on-error: #ffffff;
  --color-error-container: #ffdad6;
  --color-on-error-container: #93000a;

  /* ── Surface ── */
  --color-background: #f9f9ff;
  --color-on-background: #191c20;
  --color-surface: #f9f9ff;
  --color-on-surface: #191c20;
  --color-on-surface-variant: #424751;
  --color-surface-variant: #e2e2e9;
  --color-surface-container-lowest: #ffffff;
  --color-surface-container-low: #f3f3fa;
  --color-surface-container: #ededf4;
  --color-surface-container-high: #e7e8ef;
  --color-surface-container-highest: #e2e2e9;
  --color-surface-bright: #f9f9ff;
  --color-surface-dim: #d9d9e0;
  --color-surface-tint: #265ea8;
  --color-inverse-surface: #2e3036;
  --color-inverse-on-surface: #f0f0f7;
  --color-inverse-primary: #a9c7ff;

  /* ── Outline ── */
  --color-outline: #737782;
  --color-outline-variant: #c2c6d3;

  /* ── Status Chips ── */
  --color-status-approved-bg: #dcfce7;
  --color-status-approved-text: #166534;
  --color-status-pending-bg: #fef08a;
  --color-status-pending-text: #854d0e;
  --color-status-rejected-bg: #fee2e2;
  --color-status-rejected-text: #991b1b;

  /* ── Typography ── */
  --font-family: 'Inter', sans-serif;

  /* ── Spacing ── */
  --space-base: 4px;
  --space-xs: 4px;
  --space-sm: 8px;
  --space-md: 16px;
  --space-lg: 24px;
  --space-xl: 32px;
  --space-gutter: 24px;
  --sidebar-width: 260px;
  --container-max-width: 1280px;

  /* ── Radius ── */
  --radius-sm: 0.25rem;
  --radius-default: 0.5rem;
  --radius-md: 0.75rem;
  --radius-lg: 1rem;
  --radius-xl: 1.5rem;
  --radius-full: 9999px;

  /* ── Elevation ── */
  --shadow-soft: 0px 4px 6px -1px rgba(0, 0, 0, 0.05);
  --shadow-hover: 0px 4px 6px rgba(0, 0, 0, 0.1);
  --shadow-modal: 0px 10px 15px -3px rgba(0, 0, 0, 0.1);
  --border-soft: 0.5px solid #e2e8f0;
}
```
