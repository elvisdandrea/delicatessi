<div class="top_bg">
    <div class="wrap">
        <div class="main_top">
            <h2 class="style">Meus Favoritos</h2>
        </div>
    </div>
</div>
<div class="main_bg">
    <div class="wrap">
        {if (count($favItems) == 0)}
            <div id="main" class="main">
                Você não possui favoritos!
            </div>
        {else}

            <div id="main" class="main">
                {assign var="orderPrice" value="0"}
                {foreach from=$favItems item="item"}
                    <div class="row">
                        <a href="{$smarty.const.BASEDIR}products/{$item['product_id']}" changeurl>
                            <div class="image_thumb">
                                <img src="{$item['image']}" alt="{$item['product_name']}"/>
                            </div>
                        </a>
                            <div class="item_detail">
                                <label class="title"><a href="{$smarty.const.BASEDIR}products/{$item['product_id']}" changeurl>{$item['product_name']}</a></label>
                                <a href="{$smarty.const.BASEDIR}products/addtocart?product_id={$item['product_id']}" class="link-remove" changeurl>-Eu Quero</a>
                                <span class="text">{$item['description']}</span>
                            </div>
                            <span class="row_price">{String::convertTextFormat($item['price'], 'currency')}</span>

                    </div>
                {/foreach}
            </div>
        {/if}
    </div>
</div>

