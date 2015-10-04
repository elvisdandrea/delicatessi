<div class="top_bg">
    <div class="wrap">
        <div class="main_top">
            <h2 class="style">Debug</h2>
        </div>
    </div>
</div>
<div class="main_bg">
    <div class="wrap">

            <div id="main" class="main">
                <label>
                <pre>{print_r($mixed, true)}
                    </pre>
                </label>
                <label>
                    <hr>
                    <label>Debug Trace:</label>
                    {foreach from=$trace item="action"}
                        <hr>
                        <ul>
                            <li>File: {$action['file']}</li>
                            <li>Line: {$action['line']}</li>
                            <li>Class: {$action['class']}</li>
                            <li>Function: {$action['function']}</li>
                        </ul>
                    {/foreach}
                </label>
            </div>
    </div>
</div>

