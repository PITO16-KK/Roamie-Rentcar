<!-- Theme partial: initializes theme and loads theme script -->
<script>
    (function() {
        const saved = localStorage.getItem('theme') || 'dark';
        document.documentElement.setAttribute('data-theme', saved);
        if (document.body) {
            document.body.setAttribute('data-theme', saved);
        } else {
            document.addEventListener('DOMContentLoaded', () => {
                if (document.body) document.body.setAttribute('data-theme', saved);
            });
        }
    })();
</script>

<!-- Meta theme-color for browsers -->
<meta name="theme-color" content="#0b111e">

<script src="{{ asset('js/theme.js') }}"></script>
