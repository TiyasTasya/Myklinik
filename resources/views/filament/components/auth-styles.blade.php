<style>
    /* Center & align logo on all Filament simple/auth pages (Login, Lockscreen, etc.) */
    .fi-simple-header,
    header.fi-simple-header {
        display: flex !important;
        flex-direction: column !important;
        align-items: center !important;
        justify-content: center !important;
        text-align: center !important;
        margin-bottom: 1.25rem !important;
        gap: 0.25rem !important;
    }

    /* Common logo positioning */
    .fi-simple-header .fi-logo,
    .fi-simple-header img.fi-logo,
    .fi-simple-header img,
    header.fi-simple-header img {
        margin-left: auto !important;
        margin-right: auto !important;
        margin-bottom: 0.25rem !important;
        transform: translateX(26px);
    }

    /* Strict Dark/Light mode display switching */
    html.dark .fi-logo-light,
    .dark .fi-logo-light {
        display: none !important;
    }
    html.dark .fi-logo-dark,
    .dark .fi-logo-dark {
        display: block !important;
    }
    html:not(.dark) .fi-logo-light {
        display: block !important;
    }
    html:not(.dark) .fi-logo-dark {
        display: none !important;
    }

    /* Headings */
    .fi-simple-header-heading,
    header.fi-simple-header h1 {
        text-align: center !important;
        margin-top: 0.25rem !important;
        margin-bottom: 0.15rem !important;
        line-height: 1.25 !important;
    }
    .fi-simple-header-subheading,
    header.fi-simple-header p {
        text-align: center !important;
        margin-top: 0.15rem !important;
        margin-bottom: 0.5rem !important;
    }
</style>
