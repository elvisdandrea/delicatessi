<div class="top_bg">
    <div class="wrap">
        <div class="main_top">
            <h2 class="style">{$title}</h2>
        </div>
    </div>
</div>

<div class="main_bg">
    <div class="wrap">
        <div id="main" class="main" {if (isset($url))}url="{$url}"{/if}>
            {$content}
        </div>
    </div>
</div>