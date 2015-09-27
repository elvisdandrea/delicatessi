<div class="left_sidebar right">
    <h4>Produtos Similares</h4>
    {if (count($products) > 0)}
        {foreach from=$products item="product"}
            <div class="left_products">
                <div class="left_img">
                    <img src="{$product['image']}" alt="{$product['product_name']}"/>
                </div>
                <div class="left_text">
                    <p><a href="{$smarty.const.BASEDIR}products/{$product['id']}">{$product['product_name']}</a></p>
                    {*<span class="line"></span>*}
                    <span>{String::convertTextFormat($product['price'], 'currency')}</span>
                </div>
                <div class="clear"></div>
            </div>
        {/foreach}
    {else}
    <div class="left_products">
        <div class="left_img">

        </div>
        <div class="left_text">
            <p>Nenhum produto similar :'(</p>
            {*<span class="line"></span>*}
            <span></span>
        </div>
        <div class="clear"></div>
    {/if}
    <h4>Veja Também</h4>
    {foreach from=$featured item="row"}
        <div class="left_products">
            <div class="left_img">
                <img src="{$row['image']}" alt=""/>
            </div>
            <div class="left_text">
                <p><a href="{$smarty.const.BASEDIR}products/{$row['id']}">{$row['product_name']}</a></p>
                {*<span class="line"></span>*}
                <span>{String::convertTextFormat($row['price'], 'currency')}</span>
            </div>
            <div class="clear"></div>
        </div>
    {/foreach}
</div>