{{--
  Styles for property management (host + admin). Loaded alongside
  jb-auth-styles, which supplies the base tokens, form fields, buttons
  and dashboard shell. Same convention: inline, jb- prefixed, no
  dependency on the template SCSS.

  Badge contrast (text on its own tint):
    pending  #8A5A00 on #FFF4E0 .... 6.42:1
    approved #1E7A4B on #E6F4EC .... 4.72:1
    rejected #B3261E on #FBEAE9 .... 6.02:1
    neutral  #556066 on #F0F1F2 .... 6.31:1
--}}
<style>
    /* ---------- page header ---------- */
    .jb-prop__bar {
        display: flex;
        flex-wrap: wrap;
        align-items: flex-end;
        justify-content: space-between;
        gap: 16px;
        margin-bottom: 28px;
    }

    /* ---------- badges ---------- */
    .jb-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 10px;
        border-radius: 999px;
        font-size: 12.5px;
        font-weight: 600;
        letter-spacing: .01em;
        white-space: nowrap;
    }

    .jb-badge--pending {
        background: #FFF4E0;
        color: #8A5A00;
    }

    .jb-badge--approved {
        background: #E6F4EC;
        color: #1E7A4B;
    }

    .jb-badge--rejected {
        background: #FBEAE9;
        color: #B3261E;
    }

    .jb-badge--neutral {
        background: #F0F1F2;
        color: #556066;
    }

    .jb-badge__dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: currentColor;
    }

    /* ---------- listing rows ---------- */
    .jb-list {
        display: flex;
        flex-direction: column;
        gap: 14px;
    }

    .jb-row {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 18px;
        padding: 16px;
        border: 1px solid var(--jb-border);
        border-radius: 14px;
        background: #fff;
    }

    .jb-row__thumb {
        flex: 0 0 auto;
        width: 108px;
        height: 80px;
        overflow: hidden;
        border-radius: 10px;
        background: #F0F1F2;
    }

    .jb-row__thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .jb-row__main {
        flex: 1 1 260px;
        min-width: 0;
    }

    .jb-row__title {
        margin: 0 0 4px;
        font-size: 17px;
        font-weight: 600;
        color: var(--jb-ink);
    }

    .jb-row__meta {
        margin: 0;
        font-size: 14px;
        color: var(--jb-muted);
    }

    .jb-row__badges {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-top: 8px;
    }

    .jb-row__actions {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-left: auto;
    }

    .jb-btn-sm {
        display: inline-flex;
        min-height: 40px;
        align-items: center;
        padding: 0 14px;
        border: 1px solid var(--jb-border);
        border-radius: 9px;
        background: transparent;
        color: var(--jb-ink);
        font-family: inherit;
        font-size: 14px;
        font-weight: 500;
        text-decoration: none;
        cursor: pointer;
        transition: background-color .2s ease;
    }

    .jb-btn-sm:hover {
        background: rgba(47, 62, 70, .06);
        color: var(--jb-ink);
    }

    .jb-btn-sm--primary {
        border-color: transparent;
        background: var(--jb-cta);
        color: #fff;
    }

    .jb-btn-sm--primary:hover {
        background: var(--jb-cta-hover);
        color: #fff;
    }

    .jb-btn-sm--danger {
        border-color: rgba(179, 38, 30, .35);
        color: var(--jb-error);
    }

    .jb-btn-sm--danger:hover {
        background: rgba(179, 38, 30, .07);
        color: var(--jb-error);
    }

    /* ---------- empty state ---------- */
    .jb-empty {
        padding: 56px 24px;
        border: 1px dashed var(--jb-border);
        border-radius: 14px;
        background: #fff;
        text-align: center;
    }

    .jb-empty h3 {
        margin: 0 0 8px;
        font-size: 19px;
        font-weight: 600;
    }

    .jb-empty p {
        margin: 0 0 20px;
        color: var(--jb-muted);
    }

    /* ---------- form sections ---------- */
    .jb-form {
        max-width: 820px;
    }

    .jb-form__section {
        margin-bottom: 20px;
        padding: 28px;
        border: 1px solid var(--jb-border);
        border-radius: 14px;
        background: #fff;
    }

    .jb-form__legend {
        margin: 0 0 4px;
        font-size: 17px;
        font-weight: 600;
        color: var(--jb-ink);
    }

    .jb-form__hint {
        margin: 0 0 22px;
        font-size: 14px;
        color: var(--jb-muted);
    }

    .jb-form__grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 18px;
    }

    .jb-form__note {
        display: flex;
        gap: 10px;
        padding: 14px 16px;
        border-radius: 10px;
        border-left: 3px solid var(--jb-primary);
        background: var(--jb-tint);
        font-size: 14.5px;
        color: var(--jb-ink);
    }

    .jb-form__actions {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        align-items: center;
    }

    select.jb-auth__input {
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%232F3E46' stroke-width='2' stroke-linecap='round'%3E%3Cpath d='m6 9 6 6 6-6'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 14px center;
        padding-right: 40px;
    }

    textarea.jb-auth__input {
        min-height: 150px;
        resize: vertical;
    }

    /* ---------- photo grid ---------- */
    .jb-photos {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: 14px;
        margin-top: 18px;
    }

    .jb-photo {
        position: relative;
        border: 2px solid var(--jb-border);
        border-radius: 12px;
        overflow: hidden;
        background: #F0F1F2;
    }

    .jb-photo.is-cover {
        border-color: var(--jb-cta);
    }

    .jb-photo__img {
        display: block;
        width: 100%;
        aspect-ratio: 4 / 3;
        object-fit: cover;
    }

    .jb-photo__foot {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 8px;
        padding: 8px 10px;
        background: #fff;
        font-size: 13px;
    }

    .jb-photo__pick {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        color: var(--jb-ink);
        cursor: pointer;
    }

    .jb-photo__pick input {
        width: 16px;
        height: 16px;
        accent-color: var(--jb-cta);
    }

    .jb-photo__flag {
        position: absolute;
        top: 8px;
        left: 8px;
        padding: 3px 8px;
        border-radius: 999px;
        background: var(--jb-cta);
        color: #fff;
        font-size: 11.5px;
        font-weight: 600;
    }

    .jb-photo__drop {
        min-height: 44px;
    }

    /* ---------- gallery (read-only) ---------- */
    .jb-gallery {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
        gap: 12px;
    }

    .jb-gallery img {
        display: block;
        width: 100%;
        aspect-ratio: 4 / 3;
        object-fit: cover;
        border-radius: 12px;
    }

    /* ---------- detail panels ---------- */
    .jb-panel {
        padding: 24px;
        border: 1px solid var(--jb-border);
        border-radius: 14px;
        background: #fff;
        margin-bottom: 20px;
    }

    .jb-panel h2 {
        margin: 0 0 16px;
        font-size: 18px;
        font-weight: 600;
    }

    .jb-defs {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 16px;
        margin: 0;
    }

    .jb-defs dt {
        font-size: 13px;
        font-weight: 600;
        letter-spacing: .04em;
        text-transform: uppercase;
        color: var(--jb-muted);
    }

    .jb-defs dd {
        margin: 4px 0 0;
        font-size: 15.5px;
        color: var(--jb-ink);
    }

    .jb-split {
        display: grid;
        grid-template-columns: minmax(0, 2fr) minmax(260px, 1fr);
        gap: 20px;
        align-items: start;
    }

    @media (max-width: 860px) {
        .jb-split {
            grid-template-columns: 1fr;
        }
    }

    /* ---------- filter tabs ---------- */
    .jb-tabs {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-bottom: 24px;
    }

    .jb-tab {
        display: inline-flex;
        min-height: 42px;
        align-items: center;
        gap: 8px;
        padding: 0 16px;
        border: 1px solid var(--jb-border);
        border-radius: 999px;
        background: #fff;
        color: var(--jb-ink);
        font-size: 14.5px;
        font-weight: 500;
        text-decoration: none;
        transition: background-color .2s ease, border-color .2s ease;
    }

    .jb-tab:hover {
        background: rgba(47, 62, 70, .05);
        color: var(--jb-ink);
    }

    .jb-tab.is-active {
        border-color: transparent;
        background: var(--jb-cta);
        color: #fff;
    }

    .jb-tab__n {
        padding: 1px 7px;
        border-radius: 999px;
        background: rgba(47, 62, 70, .1);
        font-size: 12.5px;
        font-weight: 700;
    }

    .jb-tab.is-active .jb-tab__n {
        background: rgba(255, 255, 255, .24);
    }

    /* ---------- reject dialog ---------- */
    .jb-modal {
        border: 0;
        border-radius: 16px;
        padding: 0;
        max-width: 520px;
        width: calc(100% - 32px);
        /* Setting width/max-width overrides the UA stylesheet's centring,
           so restore it explicitly. */
        margin: auto;
        box-shadow: 0 20px 60px rgba(47, 62, 70, .22);
    }

    .jb-modal::backdrop {
        background: rgba(47, 62, 70, .45);
    }

    .jb-modal__body {
        padding: 28px;
    }

    .jb-modal h2 {
        margin: 0 0 6px;
        font-size: 20px;
        font-weight: 700;
    }

    .jb-modal p {
        margin: 0 0 18px;
        font-size: 14.5px;
        color: var(--jb-muted);
    }
</style>
