<div class="top_bg">
    <div class="wrap">
        <div class="main_top">
            <h2 class="style">Meu Carrinho</h2>
        </div>
    </div>
</div>
<div class="main_bg">
    <div class="wrap">
        <div id="main" class="main">
            {assign var="orderPrice" value="0"}
            {foreach from=$cartItems item="item"}
                <div class="row">
                    <div class="image_thumb">
                        <img src="{$item['image']}" alt="{$item['product_name']}"/>
                    </div>
                    <div class="item_detail">
                        <label class="title">{$item['product_name']}</label><a href="{$smarty.const.BASEDIR}cart/remove?item_id={$item['id']}" class="link-remove">- Retirar do carrinho</a>
                        <span class="text">{$item['description']}</span>
                    </div>
                    <span class="row_price">{String::convertTextFormat($item['price'], 'currency')}</span>
                </div>
                {assign var="orderPrice" value="{$orderPrice + $item['price']}"}
            {/foreach}
        </div>

        <div class="purchase">
            <h3>Finalizar Compra</h3>
            <div class="registration_form">
                <label>Valor do Pedido:</label><label>{$orderPrice}</label>
                <label>Valor do Frete:</label><label id="shippingprice">(escolha um endereço para entrega)</label>
                <label>Total:</label><label id="totalprice">(escolha um endereço para entrega)</label>
                <form action="{$smarty.const.BASEDIR}cart/purchase" method="post">
                    <select id="addresslist" name="address_id" onchange="Main.quickLink('{$smarty.const.BASEDIR}cart/shippingprice?id=' + this.value)">
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
            <hr>
            <h3>Adicionar um endereço de entrega</h3>
            <div >
                <div class="registration_form">
                    <form method="post" id="newaddress" action="{$smarty.const.BASEDIR}cart/getzipaddress">
                        <label>Digite o CEP e clique em BUSCAR</label>
                        <input type="text" name="cep" placeholder="CEP:"/>
                        <input class="btn" type="submit" value="Buscar"/>
                    </form>
                </div>
                <div id="resultzip" class="">

                </div>
            </div>
        </div>
    </div>
</div>

