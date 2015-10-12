<div class="top_bg">
    <div class="wrap">
        <div class="main_top">
            <h2 class="style">Meus Pedidos</h2>
        </div>
    </div>
</div>
<div class="main_bg">
    <div class="wrap">
        {if (count($orders) == 0)}
            <div id="main" class="main">
                Você não possui pedidos!
            </div>
        {else}

            <div id="main" class="main">
                {assign var="orderPrice" value="0"}
                {foreach from=$orders item="order"}
                    <div class="order">
                        <h3>Pedido #{$order['order']['id']} - {if ($order['order']['date'] == '')}Ainda não Finalizado{else}{String::formatDateTimeToLoad($order['order']['date'])}{/if}</h3>
                        <div class="order-info">
                            <p><label>Valor:</label><label class="value">{String::convertTextFormat($order['order']['price'], 'currency')}</label></p>
                            {if ($order['order']['status_id'] == '1')}
                                <a href="{$smarty.const.BASEDIR}cart/purchasepage?order_id={$order['order']['id']}" class="btn">Finalizar compra</a>
                                <label>Se você já efetuou o pagamento deste pedido, <a href="{$smarty.const.BASEDIR}contact">Contate-nos</a> e informe o número do pedido.</label>
                            {/if}
                            <p><label>Status do Pedido:</label><label class="value">{$order['order']['status']}</label></p>
                            <p><label>Entrega por:</label><label class="value">{$order['shipping']['type']}</label></p>
                            <p><label>Previsão de entrega:</label><label class="value">{$order['shipping']['days']}</label></p>
                        </div>

                        <div class="order-items">
                            {foreach from=$order['products'] item="item"}
                                <div class="order-item">
                                        <div class="image_thumb_small">
                                            <a href="{$smarty.const.BASEDIR}products/{$item['product_id']}" changeurl>
                                                <img src="{$item['image']}" alt="{$item['product_name']}"/>
                                            </a>
                                        </div>
                                    <div class="item_detail">
                                        <label class="title_small"><a href="{$smarty.const.BASEDIR}products/{$item['product_id']}" changeurl>{$item['product_name']}</a></label>
                                        <span class="text">{$item['description']}</span>
                                    </div>
                                </div>
                            {/foreach}
                        </div>
                    </div>
                {/foreach}
            </div>
        {/if}
    </div>
</div>

