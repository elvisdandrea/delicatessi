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
            {/foreach}
        </div>

        <div class="purchase">
            <h3>Finalizar Compra</h3>
            <div class="registration_form">
                <form action="{$smarty.const.BASEDIR}cart/purchase" method="post">
                    <select name="address_id">
                        <option value="">Selecione o endereço de entrega</option>
                        <a href="{$smarty.const.BASEDIR}client/newaddress">Adicionar Endereço</a>
                    </select>
                    <input type="submit" value="Finalizar Compra" class="btn" />
                </form>
            </div>
        </div>
    </div>
</div>

