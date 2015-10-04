{if ($page == 1)}
    <div class="top_main">
        <h2>{$title}</h2>
        {if (isset($see_all) && $see_all)}<a href="{$smarty.const.BASEDIR}products/" changeurl>Ver Todos</a>{/if}
        <div class="clear"></div>
    </div>
{/if}
<!-- start grids_of_3 -->
    <div class="grids_of_3">
        {foreach name="pr" from=$products item="product"}
            {if (($smarty.foreach.pr.iteration - 1) > 0 && ($smarty.foreach.pr.iteration - 1) / 3 === 1)}
        </div>
        <div class="clear"></div>
        <div class="grids_of_3">
            {/if}
            <div class="grid1_of_3">
                <a href="{$smarty.const.BASEDIR}products/{$product['id']}" changeurl>
                    <div class="thumb_img">
                        <img src="{$product['image']}" alt="{$product['product_name']}"/>
                    </div>
                    <h3>{$product['product_name']}</h3>
                    <span class="price">{String::convertTextFormat($product['price'], 'currency')}</span>
                </a>
            </div>
        {/foreach}
    </div>
<div class="clear"></div>
