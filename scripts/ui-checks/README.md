# UI checks

Dev-only tooling. Nothing here is referenced by the app, the build or the test
suite — it is not deployed and can be deleted without consequence.

It exists because eyeballing the hero missed a real bug for months: at
768–991px the hero copy overlaps the photograph, and on the live site the body
copy measured **1.00:1** against its background — white on white. It is
invisible unless you happen to resize to tablet width, and no automated check
in the repo looks at rendered pixels.

## Requirements

- Chrome at `C:\Program Files\Google\Chrome\Application\chrome.exe`
- Node at `D:\node.exe` (uses the global `WebSocket` and `fetch`, so no
  `npm install` — there is no puppeteer dependency)
- PHP 8.3 with GD (`C:\Users\sg\php83\php.exe`) for `score.php`

## Why raw CDP and not `chrome --screenshot`

`--window-size=390,x` does **not** give a 390px layout viewport on Windows —
the window has a ~500px floor, so the page lays out at 512 and the capture is
just cropped. Every mobile screenshot then looks like it has horizontal
overflow that is not there. `Emulation.setDeviceMetricsOverride` is the only
thing that produces a true small viewport here.

Two more things these scripts already handle, both of which otherwise fake a
bug that does not exist:

- The hero copy reveals via CSS transitions gated on the `.active` class Owl
  Carousel adds, and those never settle under automation — the hero
  screenshots blank. The scripts inject a style forcing the **active slide
  only** visible. Forcing every slide stacks all three headlines on top of
  each other.
- `.img1` rides an **8000ms** transform transition. Capture before ~9s and the
  photo is still sliding, which shows up as a phantom seam across the hero.

## Usage

Screenshot a page at a true viewport width:

    D:/node.exe cdp.js shot https://jaipurbnb.com/ 390 out.png --h=720

    --full            capture the whole page instead of one viewport
    --to=<selector>   scroll that element to the top first (for sections
                      below the fold, instead of a giant full-page PNG)
    --pad=<px>        leave px above it when using --to
    --slide=<n>       switch the hero carousel to slide n
    --hide-copy       render the hero with its copy hidden
    --dpr=<n>         device pixel ratio

Read layout geometry (header height, hero boxes, overflow) as JSON:

    D:/node.exe cdp.js eval https://jaipurbnb.com/ 390 probe-hero.js

Measure hero text contrast — one Chrome session, every width × slide:

    D:/node.exe measure.js https://jaipurbnb.com/ prod 390,768,1440 0,1,3
    C:/Users/sg/php83/php.exe score.php manifest-prod.json

`measure.js` captures the hero with the copy hidden plus the copy's real
bounding boxes; `score.php` then reports the **brightest** pixel inside each
box as a contrast ratio against white. Measuring the rendered PNG rather than
modelling the CSS means the number accounts for the photo, the CSS filter,
both scrims, the mask and the decorative overlays at once.

Thresholds: 4.5:1 for the body copy and eyebrow, 3:1 for the headline (it is
≥24px bold, which WCAG 1.4.3 classes as large-scale text).

Known-good as of 2026-09-21: 9.46:1 at 768px and 1440px, 7.88–8.45:1 at 390px
across all three hero photographs.

## The floor worth knowing

The binding worst case for white hero text is a blown-out highlight in the
photograph — against a pure white pixel the scrim alone carries the whole
ratio. Minimum alpha to clear 4.5:1:

| scrim colour      | min alpha |
| ----------------- | --------- |
| `#2F3E46` charcoal | 0.70     |
| `#6B2D0A` warm     | 0.70     |
| `#141A1E` near-black | 0.60   |
| `#000000` black    | 0.54     |

Which is why the hero's contrast now comes from a copy-scoped scrim rather
than from the scrim over the photograph: there is no alpha low enough to let
the photo read properly *and* keep white text legible on top of it.
