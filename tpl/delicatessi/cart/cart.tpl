<div class="top_bg">
    <div class="wrap">
        <div class="main_top">
            <h2 class="style">Meu Carrinho</h2>
        </div>
    </div>
</div>
<div class="main_bg">
    <div class="wrap">
        {if (count($cartItems) == 0)}
            <div id="main" class="main">
                Você não possui itens no carrinho!
            </div>
        {else}

            <div id="main" class="main">
                {assign var="orderPrice" value="0"}
                {foreach from=$cartItems item="item"}
                    <div class="row">
                        <a href="{$smarty.const.BASEDIR}products/{$item['product_id']}">
                            <div class="image_thumb">
                                <img src="{$item['image']}" alt="{$item['product_name']}"/>
                            </div>
                        </a>
                        <div class="item_detail">
                            <label class="title">
                                <a href="{$smarty.const.BASEDIR}products/{$item['product_id']}">{$item['product_name']}</a>
                            </label><a href="{$smarty.const.BASEDIR}cart/remove?item_id={$item['id']}" class="link-remove">-Retirar</a>
                            <span class="text">{$item['description']}</span>
                        </div>
                        <span class="row_price">{String::convertTextFormat($item['price'], 'currency')}</span>
                    </div>
                    {assign var="orderPrice" value="{$orderPrice + $item['price']}"}
                {/foreach}
            </div>

            <div class="purchase">
                <div id="shipping-info" class="left_content_small">
                    <h3>Finalizar Compra</h3>
                    <div id="purchase_msg"></div>
                    <div class="registration_form purchase_form">
                        <p><label>Valor do Pedido:</label><label class="value">{String::convertTextFormat($orderPrice, 'currency')}</label></p>
                        <p><label>Valor do Frete:</label><label id="shippingprice" class="value">(escolha um endereço e tipo para entrega)</label></p>
                        <p><label>Total:</label><label id="totalprice" class="value">(escolha um endereço e tipo para entrega)</label></p>
                        <form action="{$smarty.const.BASEDIR}cart/purchase" method="post">
                            <select id="addresslist" class="addresslist" name="address_id" onchange="Main.quickLink('{$smarty.const.BASEDIR}cart/shippingprice?id=' + this.value)">
                                <option value="">Selecione o endereço de entrega</option>
                                {foreach from=$addresses item="address"}
                                    <option value="{$address['id']}">{$address['street_addr']}, {$address['street_number']} {$address['street_additional']}, {$address['hood']} - {$address['city']}/{$address['state']} ({$address['zip_code']})</option>
                                {/foreach}
                            </select>
                            <div id="shippingoptions">

                            </div>
                            <input type="submit" value="Finalizar Compra" class="btn" />
                        </form>
                    </div>
                    <div id="submitmsg" class="alert-error" style="display: none"></div>
                </div>

                <div class="left_content_small">
                    <h3>Adicionar um endereço de entrega</h3>
                    <div >
                        <div class="registration_form">
                            <form method="post" id="newaddress" action="{$smarty.const.BASEDIR}cart/getzipaddress">
                                <div class="form-grid">
                                    <div class="col-12">
                                        <label>Digite o CEP e clique em BUSCAR</label>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-6">
                                            <input type="text" name="cep" placeholder="CEP:"/>
                                        </div>
                                        <div class="col-6">
                                            <input class="form-input" type="submit" value="Buscar"/>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div id="resultzip" class="">

                        </div>
                    </div>
                </div>
            </div>
        {/if}
    </div>
</div>

