{{--
  Shared styles for the auth screens and the host/admin dashboards.

  Kept in one partial rather than repeated inline in four views, but it
  is still a plain inline <style> block with jb-auth-/jb-dash- prefixed
  classes and ZERO dependency on the template SCSS - same convention as
  layouts/partials/navbar.blade.php.

  Contrast against white:
    #2F3E46 body text ...... 11.06:1  (AA + AAA)
    #B34D33 button / focus .. 5.21:1  (AA)  - white text on it
    #B3261E error text ...... 6.48:1  (AA)
    #E07A5F is used only for non-text accents, never for small text.
--}}
<style>
    .jb-auth,
    .jb-dash {
        --jb-primary: #E07A5F;
        --jb-cta: #B34D33;
        --jb-cta-hover: #8F3D28;
        --jb-ink: #2F3E46;
        --jb-muted: #6C7A80;
        --jb-border: rgba(47, 62, 70, .18);
        --jb-error: #B3261E;
        --jb-tint: rgba(224, 122, 95, .09);
        font-family: 'Poppins', system-ui, -apple-system, 'Segoe UI', Roboto, sans-serif;
        color: var(--jb-ink);
    }

    .jb-auth *,
    .jb-auth *::before,
    .jb-auth *::after,
    .jb-dash *,
    .jb-dash *::before,
    .jb-dash *::after {
        box-sizing: border-box;
    }

    /* ---------- auth page shell ---------- */
    .jb-auth {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: calc(100vh - 73px);
        padding: 48px 16px 64px;
        background: #FAF7F5;
    }

    .jb-auth__card {
        width: 100%;
        max-width: 500px;
        padding: 40px;
        border: 1px solid var(--jb-border);
        border-radius: 16px;
        background: #fff;
        box-shadow: 0 4px 24px rgba(47, 62, 70, .06);
    }

    @media (max-width: 575.98px) {
        .jb-auth {
            padding: 24px 12px 40px;
        }

        .jb-auth__card {
            padding: 24px;
        }
    }

    .jb-auth__title {
        margin: 0;
        font-size: 26px;
        font-weight: 700;
        letter-spacing: -.02em;
        color: var(--jb-ink);
    }

    .jb-auth__sub {
        margin: 8px 0 28px;
        font-size: 15px;
        line-height: 1.5;
        color: var(--jb-muted);
    }

    /* ---------- fields ---------- */
    .jb-auth__field {
        margin-bottom: 18px;
    }

    .jb-auth__label {
        display: block;
        margin-bottom: 6px;
        font-size: 14px;
        font-weight: 600;
        color: var(--jb-ink);
    }

    .jb-auth__req {
        color: var(--jb-error);
    }

    .jb-auth__input {
        display: block;
        width: 100%;
        min-height: 48px;
        padding: 12px 14px;
        border: 1px solid var(--jb-border);
        border-radius: 10px;
        background: #fff;
        font-family: inherit;
        font-size: 15px;
        color: var(--jb-ink);
        transition: border-color .2s ease, box-shadow .2s ease;
    }

    .jb-auth__input::placeholder {
        color: #9AA5AA;
    }

    .jb-auth__input:hover {
        border-color: rgba(47, 62, 70, .32);
    }

    .jb-auth__input:focus {
        outline: none;
        border-color: var(--jb-cta);
        box-shadow: 0 0 0 3px rgba(179, 77, 51, .22);
    }

    .jb-auth__input.is-invalid {
        border-color: var(--jb-error);
    }

    .jb-auth__input.is-invalid:focus {
        box-shadow: 0 0 0 3px rgba(179, 38, 30, .18);
    }

    .jb-auth__error {
        display: block;
        margin-top: 6px;
        font-size: 13.5px;
        font-weight: 500;
        color: var(--jb-error);
    }

    .jb-auth__hint {
        display: block;
        margin-top: 6px;
        font-size: 13px;
        color: var(--jb-muted);
    }

    /* ---------- password reveal ---------- */
    .jb-auth__pw {
        position: relative;
    }

    .jb-auth__pw .jb-auth__input {
        padding-right: 52px;
    }

    .jb-auth__toggle {
        position: absolute;
        top: 0;
        right: 0;
        display: inline-flex;
        width: 48px;
        height: 48px;
        align-items: center;
        justify-content: center;
        padding: 0;
        border: 0;
        border-radius: 10px;
        background: transparent;
        color: var(--jb-muted);
        cursor: pointer;
    }

    .jb-auth__toggle:hover {
        color: var(--jb-ink);
    }

    /* ---------- actions ---------- */
    .jb-auth__btn {
        display: inline-flex;
        width: 100%;
        min-height: 48px;
        align-items: center;
        justify-content: center;
        margin-top: 6px;
        padding: 0 20px;
        border: 0;
        border-radius: 10px;
        background: var(--jb-cta);
        color: #fff;
        font-family: inherit;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: background-color .2s ease;
    }

    .jb-auth__btn:hover {
        background: var(--jb-cta-hover);
        color: #fff;
    }

    .jb-auth__row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        margin-bottom: 18px;
    }

    .jb-auth__check {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 14px;
        color: var(--jb-ink);
        cursor: pointer;
    }

    .jb-auth__check input {
        width: 18px;
        height: 18px;
        accent-color: var(--jb-cta);
    }

    .jb-auth__link {
        color: var(--jb-cta);
        font-size: 14px;
        font-weight: 500;
        text-decoration: none;
    }

    .jb-auth__link:hover {
        color: var(--jb-cta-hover);
        text-decoration: underline;
    }

    .jb-auth__alt {
        margin: 24px 0 0;
        padding-top: 20px;
        border-top: 1px solid var(--jb-border);
        text-align: center;
        font-size: 14.5px;
        color: var(--jb-muted);
    }

    /* ---------- alerts ---------- */
    .jb-auth__alert {
        margin-bottom: 22px;
        padding: 12px 14px;
        border-radius: 10px;
        border-left: 3px solid var(--jb-error);
        background: rgba(179, 38, 30, .07);
        font-size: 14.5px;
        color: var(--jb-error);
    }

    .jb-auth__alert--ok {
        border-left-color: #1E7A4B;
        background: rgba(30, 122, 75, .08);
        color: #1E7A4B;
    }

    /* ---------- dashboards ---------- */
    .jb-dash {
        padding: 48px 16px 72px;
        background: #FAF7F5;
        min-height: calc(100vh - 73px);
    }

    .jb-dash__inner {
        max-width: 1120px;
        margin: 0 auto;
    }

    .jb-dash__eyebrow {
        margin: 0 0 6px;
        font-size: 13px;
        font-weight: 600;
        letter-spacing: .12em;
        text-transform: uppercase;
        color: var(--jb-cta);
    }

    .jb-dash__title {
        margin: 0 0 6px;
        font-size: 30px;
        font-weight: 700;
        letter-spacing: -.02em;
    }

    .jb-dash__sub {
        margin: 0 0 32px;
        font-size: 15px;
        color: var(--jb-muted);
    }

    .jb-dash__grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 20px;
        margin-bottom: 32px;
    }

    .jb-dash__card {
        padding: 24px;
        border: 1px solid var(--jb-border);
        border-radius: 14px;
        background: #fff;
    }

    .jb-dash__stat {
        display: block;
        font-size: 38px;
        font-weight: 700;
        line-height: 1.1;
        color: var(--jb-cta);
    }

    .jb-dash__label {
        display: block;
        margin-top: 6px;
        font-size: 14.5px;
        font-weight: 500;
        color: var(--jb-muted);
    }

    .jb-dash__actions {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 12px;
    }

    .jb-dash__cta {
        display: inline-flex;
        min-height: 48px;
        align-items: center;
        justify-content: center;
        padding: 0 24px;
        border: 0;
        border-radius: 10px;
        background: var(--jb-cta);
        color: #fff;
        font-family: inherit;
        font-size: 15.5px;
        font-weight: 600;
        text-decoration: none;
        cursor: pointer;
        transition: background-color .2s ease;
    }

    .jb-dash__cta:hover {
        background: var(--jb-cta-hover);
        color: #fff;
    }

    .jb-dash__ghost {
        display: inline-flex;
        min-height: 48px;
        align-items: center;
        justify-content: center;
        padding: 0 20px;
        border: 1px solid var(--jb-border);
        border-radius: 10px;
        background: transparent;
        color: var(--jb-ink);
        font-family: inherit;
        font-size: 15.5px;
        font-weight: 500;
        text-decoration: none;
        cursor: pointer;
        transition: background-color .2s ease;
    }

    .jb-dash__ghost:hover {
        background: rgba(47, 62, 70, .06);
        color: var(--jb-ink);
    }

    /* ---------- focus ---------- */
    .jb-auth a:focus-visible,
    .jb-auth button:focus-visible,
    .jb-dash a:focus-visible,
    .jb-dash button:focus-visible {
        outline: 3px solid var(--jb-cta);
        outline-offset: 2px;
    }

    @media (prefers-reduced-motion: reduce) {

        .jb-auth *,
        .jb-dash * {
            transition: none !important;
        }
    }
</style>
