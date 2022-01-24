<?php
    function showUIMessage( string $messageTitle, string $message, string $color ) {
        echo "
        <div class=\"ui $color message transition fade\">
            <!--
                // FIXME: CLOSE BUTTON NOT WORKING!!!
            -->
            <i class=\"ui close icon\" onclick=\"() => { $(this).closest('.message').transition('fade'); }\"></i>

            <div class=\"header left aligned\">
                {$messageTitle}
            </div>

            <p>{$message}</p>
        </div>";
    }
?>
