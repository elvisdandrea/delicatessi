{foreach from=$shipping_options key="ship" item="option"}
    <div class="shipping_option">
        <p><input type="radio" name="shipping_option" value="{$ship}" onchange="Main.quickLink('{$smarty.const.BASEDIR}cart/selshipping?id={$ship}')"/>
        <label class="value">{Correios::GetService($option['Codigo'])}</label></p>
        <p><label>Valor: {$option['Valor']}</label></p>
        <p><label>Prazo: {$option['PrazoEntrega']} dias{if ($option['EntregaSabado'] != 's')} úteis{/if}</label></p>
    </div>
{/foreach}