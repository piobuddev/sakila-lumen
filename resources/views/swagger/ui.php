<!-- HTML for static distribution bundle build -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sakila API</title>
    <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/swagger-ui/3.18.1/swagger-ui.css">
    <style>
        html {
            box-sizing: border-box;
            overflow: -moz-scrollbars-vertical;
            overflow-y: scroll;
        }

        *,
        *:before,
        *:after {
            box-sizing: inherit;
        }

        body {
            margin: 0;
            background: #fafafa;
        }
    </style>
</head>

<body>
<div id="swagger-ui"></div>

<script src="//cdnjs.cloudflare.com/ajax/libs/swagger-ui/3.18.1/swagger-ui-bundle.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/swagger-ui/3.18.1/swagger-ui-standalone-preset.js"></script>
<script>
    window.onload = function () {

        function HideTopbarPlugin() {
            // this plugin overrides the Topbar component to return nothing
            return {
                components: {
                    Topbar: function() { return null }
                }
            }
        }

        // Build a system
        const ui = SwaggerUIBundle({
            url: '<?= $openApi ?>',
            dom_id: '#swagger-ui',
            deepLinking: true,
            docExpansion: 'none',
            presets: [
                SwaggerUIBundle.presets.apis,
                SwaggerUIStandalonePreset
            ],
            plugins: [
                SwaggerUIBundle.plugins.DownloadUrl,
                HideTopbarPlugin
            ],
            layout: "StandaloneLayout"
        });

        window.ui = ui
    }
</script>
</body>
</html>
