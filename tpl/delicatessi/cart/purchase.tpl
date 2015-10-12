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

            <div id="main" class="">
                <div class="cart-content">
                    <div class="purchase">
                        <div class="left_content_small">
                            <img style="margin-top: 10px;" src="https://p.simg.uol.com.br/out/pagseguro/i/banners/pagamento/avista_estatico_550_70.gif" alt="pagseguro"/>
                            <h3>Adicionar um endereço de entrega</h3>
                            <div >
                                <div class="registration_form">
                                    <form method="post" id="newaddress" action="{$smarty.const.BASEDIR}cart/getzipaddress?asoption=1">
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
                        <div id="shipping-info" class="left_content_small">
                            <h3>Finalizar Compra</h3>
                            <div id="purchase_msg"></div>
                            <div class="registration_form purchase_form">
                                <p><label>Valor do Pedido:</label><label class="value" id="totalprice">{String::convertTextFormat($orderPrice, 'currency')}</label></p>
                                <p><label>Valor do Frete:</label><label id="shippingprice" class="value">(escolha um endereço e tipo para entrega)</label></p>
                                <form action="{$smarty.const.BASEDIR}cart/purchase{if ($order_id)}?order_id={$order_id}{/if}" method="post">
                                    <select id="addresslist" class="addresslist" name="address_id" onchange="Main.quickLink('{$smarty.const.BASEDIR}cart/shippingprice?{if ($order_id)}order_id={$order_id}&{/if}id=' + this.value)">
                                        <option value="">Selecione o endereço de entrega</option>
                                        {foreach from=$addresses item="address"}
                                            <option value="{$address['id']}">{$address['street_addr']}, {$address['street_number']} {$address['street_additional']}, {$address['hood']} - {$address['city']}/{$address['state']} ({$address['zip_code']})</option>
                                        {/foreach}
                                    </select>
                                    <div id="shippingoptions">

                                    </div>
                                    {if (!UID::isLoggedIn())}
                                        <a href="{$smarty.const.BASEDIR}client/register" class="btn">Faça o login</a>
                                    {else}
                                        <input type="submit" value="Finalizar Compra" class="btn" />
                                    {/if}
                                </form>
                            </div>
                            <div id="submitmsg" class="alert-error" style="display: none"></div>
                        </div>
                    </div>
                </div>
            </div>
        {/if}
    </div>
</div>

