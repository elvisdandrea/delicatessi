{foreach from=$shipping_options key="ship" item="option"}
    <input type="radio" name="shipping_option" value="{$option['Codigo']}" onchange="Main.quickLink('{$smarty.const.BASEDIR}cart/selshipping?id={$ship}')"/>
    <label>{Correios::GetService($option['Codigo'])}</label>
    <label>Valor: {$option['Valor']}</label>
    <label>Prazo: {$option['PrazoEntrega']} dias{if ($option['EntregaSabado'] != 's')} úteis{/if}</label>
{/foreach}