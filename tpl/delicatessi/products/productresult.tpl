<div class="top_main">
    <h2>{$title}</h2>
    <a href="{$smarty.const.BASEDIR}products/">Ver Todos</a>
    <div class="clear"></div>
</div>
<!-- start grids_of_3 -->
<div class="grids_of_3">
    {foreach from=$products item="product"}
        <div class="grid1_of_3">
            <a href="{$smarty.const.BASEDIR}products/{$product['id']}">
                <img width="300" src="{$product['image']}" alt="{$product['product_name']}"/>
                <h3>{$product['product_name']}</h3>
                <span class="price">{String::convertTextFormat($product['price'], 'currency')}</span>
            </a>
        </div>
    {/foreach}
</div>

<div class="clear"></div>
