<?php

namespace App\Services;

use App\SDK\CardStream;

class Stream
{
    public static function createSignature(array $data, $key) {
        // Sort by field name
        ksort($data);
        // Create the URL encoded signature string
        $ret = http_build_query($data, '', '&');
        // Normalise all line endings (CRNL|NLCR|NL|CR) to just NL (%0A)
        $ret = str_replace(array('%0D%0A','%0A%0D','%0D'), '%0A', $ret);
        // Hash the signature string and the key together
        return hash('SHA512', $ret . $key);
    }

    public static function silentPost($url = '?', array $post = null, $target = '_self') {

        $url = htmlentities($url);
        $target = htmlentities($target);
        $fields = '';

        if ($post) {
            foreach ($post as $name => $value) {
                $fields .= CardStream::fieldToHtml($name, $value);
            }
        }

        $ret = "
             <form id=\"silentPost\" action=\"{$url}\" method=\"post\" target=\"{$target}\">
                 {$fields}
                 <noscript><input type=\"submit\" value=\"Continue\"></noscript
             </form>
             <script>
                window.setTimeout('document.forms.silentPost.submit()', 0);
             </script>
        ";

        return $ret;
    }

    public static function show_processing_screen()
    {
        return "
            <!doctype html>
            <html lang=\"en\">
            <head>
                <meta charset=\"UTF-8\">
                <meta name=\"viewport\" content=\"width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0\">
                <meta http-equiv=\"X-UA-Compatible\" content=\"ie=edge\">
                <link rel=\"preconnect\" href=\"https://fonts.gstatic.com\">
                <link href=\"https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&display=swap\" rel=\"stylesheet\">
                <title>We are processing your transaction...</title>
            </head>
            <body style=\"background:100vh;height: 90vh;display: flex;align-items: center;justify-content: center\">
             <div style=\"box-shadow: 0 3px 6px rgba(0,0,0,0.16), 0 3px 6px rgba(0,0,0,0.23);background: #f2f2f2;text-align: center\">
                 <div style=\"padding: 20px 30px 30px\">
                    <img style=\"width: auto;height: auto;max-width: 100%;max-height: 48px;margin-bottom: 30px\" src=\"/assets/images/payment/stream.png\">
                    <p style=\"margin: 10px 0 0;font-size: 15px;font-weight:600;font-family: 'Open Sans', sans-serif;\">We are processing your transaction...</p>
                </div>
                <div style=\"padding-top: 20px\">
                    <a style=\"display: flex;align-items:center;justify-content:center;font-size: 14px;color: #fff;background: #39454f;padding: 8px 10px;text-decoration: none\" target=\"_blank\" href=\"https://yuma-technology.co.uk\">
                        Powered by <img style=\"max-width: 100%;width: auto;height: auto;max-height: 24px;padding-left: 10px\" src=\"/assets/images/powered_by_yuma.png\" alt=\"YUMA Tech - Webdesign, Mobile App, Social media Marketing service, Graphic Design in Luton, Hertfordshire, Buckinghamshire and Bedfordshire.\">
                    </a>
                </div>
            </div>
            </body>
            </html>
        ";
    }
}
